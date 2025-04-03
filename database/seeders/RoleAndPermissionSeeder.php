<?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;
    use Spatie\Permission\PermissionRegistrar;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;

    class RoleAndPermissionSeeder extends Seeder
    {
    public function run(): void{// Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // create permissions
            Permission::create(['name' => 'mengelola User']);
            Permission::create(['name' => 'halaman admin']);
            Permission::create(['name' => 'halaman penyewa']);
            Permission::create(['name' => 'mengelola Penyewa']);
            Permission::create(['name' => 'mengelola Room']);
            Permission::create(['name' => 'mengelola Transaksi']);


            $admin = Role::create(['name' => 'Admin']);
            $admin->givePermissionTo([
                'halaman admin',
                'mengelola User',
                'mengelola Penyewa',
                'mengelola Room',
                'mengelola Transaksi',
            ]);

            $pelanggan = Role::create(['name' => 'Penyewa']);
            $pelanggan->givePermissionTo([
                'halaman penyewa',
                'mengelola Transaksi',
            ]);
        }
    }