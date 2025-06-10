<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => "kimkorngmao",
            'first_name' => "Kimkorng",
            'last_name' => "Mao",
            'bio' => "Founder of Tenecho",
            'email' => "kiimkorngmao@gmail.com",
            'password' => "admin123"
        ]);

        $role = Role::where('name', "admin")->first();
        $user->roles()->attach($role);
    }
}
