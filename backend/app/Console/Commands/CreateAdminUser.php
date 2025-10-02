<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user with admin role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Check if admin user already exists
        $existingAdmin = User::where('email', 'admin@example.com')->first();
        
        if ($existingAdmin) {
            if (!$existingAdmin->hasRole('admin')) {
                $existingAdmin->assignRole('admin');
                $this->info('Admin role assigned to existing user.');
            } else {
                $this->info('Admin user already exists with admin role.');
            }
            $this->info('Email: admin@example.com');
            $this->info('Password: admin123');
            return;
        }

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'phone' => '1234567890',
            'email_verified_at' => now(),
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        $this->info('Admin user created successfully!');
        $this->info('Email: admin@example.com');
        $this->info('Password: admin123');
        $this->warn('Please change the password after first login.');
    }
}
