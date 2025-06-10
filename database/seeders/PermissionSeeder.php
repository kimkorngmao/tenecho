<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::getRoutes();
        $permissions = [];

        foreach ($routes as $route) {
            $name = $route->getName();
            $action = $route->getActionName(); // e.g. "App\Http\Controllers\UserController@index"

            if ($name && $action !== 'Closure') {
                // Extract controller name
                $controller = class_basename(explode('@', $action)[0]); // e.g. "UserController"

                $permissions[] = [
                    'action_name' => $name,
                    'controller' => $controller,
                    'description' => $name
                ];
            }
        }

        // Avoid duplicates
        $existing = DB::table('permissions')->pluck('action_name')->toArray();
        $newPermissions = array_filter($permissions, fn ($p) => !in_array($p['action_name'], $existing));

        DB::table('permissions')->insert($newPermissions);

        // Assign all permissions to role admin
        $adminRole = Role::where('name', 'admin')->first();
        $permissions = Permission::all();
        $adminRole->permissions()->sync($permissions);
    }
}
