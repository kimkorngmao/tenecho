<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name'=> 'web'
        ]);

        Role::firstOrCreate([
            'name' => 'editor',
            'guard_name'=> 'web'
        ]);

        Role::firstOrCreate([
            'name' => 'author',
            'guard_name'=> 'web'
        ]);
    }
}
