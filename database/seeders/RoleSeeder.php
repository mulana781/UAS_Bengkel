<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all features'
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Can manage services, customers, and view reports'
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Can manage services and view basic reports'
            ],
            [
                'name' => 'customer',
                'display_name' => 'Customer',
                'description' => 'Can view their own services and profile'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        // Create default admin user
        $adminRole = Role::where('name', 'admin')->first();
        User::create([
            'name' => 'Admin',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // Create default manager user
        $managerRole = Role::where('name', 'manager')->first();
        User::create([
            'name' => 'Manager',
            'email' => 'manager@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id
        ]);

        // Create default staff user
        $staffRole = Role::where('name', 'staff')->first();
        User::create([
            'name' => 'Staff',
            'email' => 'staff@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $staffRole->id
        ]);

        // Create default customer user
        $customerRole = Role::where('name', 'customer')->first();
        User::create([
            'name' => 'Customer',
            'email' => 'customer@bengkel.com',
            'password' => Hash::make('password'),
            'role_id' => $customerRole->id
        ]);
    }
}
