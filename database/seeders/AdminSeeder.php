<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user in admins table
        Admin::firstOrCreate(
            ['email' => 'admin@smartcart.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin created successfully in admins table!');
        $this->command->info('Email: admin@smartcart.com');
        $this->command->info('Password: admin123');
    }
}
