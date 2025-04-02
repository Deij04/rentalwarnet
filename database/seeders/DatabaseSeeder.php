<?php

namespace Database\Seeders;

use App\Models\Penyewa;
use App\Models\Transaksi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

  public function run(): void{$this->call([RoleAndPermissionSeeder::class,UserSeeder::class,PenyewaSeeder::class,RoomSeeder::class,TransaksiSeeder::class,]);}
}