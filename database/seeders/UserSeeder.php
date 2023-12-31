<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();

        Schema::enableForeignKeyConstraints();

        $users = [
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'leader',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Approval->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'leader',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Approval->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'leader',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Approval->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'driver',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Driver->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'driver',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Driver->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'driver',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Driver->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'driver',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Driver->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'driver',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Driver->value,
            ],
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'driver',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Driver->value,
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber(),
                'driving_license_number' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'driving_license_due' => date('Y-m-d', strtotime('2025-01-11')),
                'user_type' => UserType::Admin->value,
            ],
        ];

        foreach ($users as $user) {
            $userData = User::create(collect($user)->except(['role'])->toArray());
            $role = Role::findByName($user['role']);
            $userData->assignRole($role);
        }
    }
}
