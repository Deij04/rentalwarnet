<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

  public function run(): void{// Buat user Admin$admin = User::factory()->create(['name' => 'Admin','email' => 'admin@example.com',]);$admin->assignRole('Admin');

        // Buat user Pegawai
        $Admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $Admin->assignRole('Admin');

        // Buat beberapa pegawai tambahan menggunakan factory
        User::factory(5)->create();
    }
}