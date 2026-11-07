<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama'     => 'Administrator',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        Admin::create([
            'nama'     => 'Kasir Menu',
            'email'    => 'kasirmenu@gmail.com',
            'password' => Hash::make('menu123'),
            'role'     => 'kasir_menu',
        ]);

        Admin::create([
            'nama'     => 'Kasir Wahana',
            'email'    => 'kasirwahana@gmail.com',
            'password' => Hash::make('wahana123'),
            'role'     => 'kasir_wahana',
        ]);

        Admin::create([
            'nama'     => 'Kasir Oleh-Oleh',
            'email'    => 'kasiroleholeh@gmail.com',
            'password' => Hash::make('oleh123'),
            'role'     => 'kasir_oleholeh',
        ]);
    }
}