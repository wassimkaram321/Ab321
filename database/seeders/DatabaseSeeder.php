<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Privacy;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'Admin','guard_name'=>'web']);
        $userRole = Role::create(['name' => 'User','guard_name'=>'web']);

        // Create an admin user and assign the admin role
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@peaklink.com',
            'password' => Hash::make('1234567890')
        ]);
        $adminUser->assignRole('Admin');
        About::create(['content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.']);
        Privacy::create(['content' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.']);
    }
}
