<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\Admin::create([
        //    'name' => 'Super Admin',
        //    'email' => 'super.admin@gmail.com',
        //    'password' => Hash::make('password'),
        //    'email_verified_at' => now() 
        // ]);

        \App\Models\User::create([
            'name' => 'User One',
            'email' => 'userone@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now()
        ]);
    }
}
