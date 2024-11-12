<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin GHOPO',
            'email' => 'adminghopo@gmail.com',
            'password' => Hash::make('adminghopo123'),
        ]);
        User::create([
            'name' => 'Admin SG',
            'email' => 'adminsg@gmail.com',
            'password' => Hash::make('adminsg123'),
        ]);
        User::create([
            'name' => 'Admin SBI Tuban',
            'email' => 'adminsbitub@gmail.com',
            'password' => Hash::make('adminsbitub123'),
        ]);
        User::create([
            'name' => 'Admin Semen Tonasa',
            'email' => 'adminsementonasa@gmail.com',
            'password' => Hash::make('adminsementonasa123'),
        ]);
        User::create([
            'name' => 'Admin Semen SBI Narogong',
            'email' => 'adminsbinara@gmail.com',
            'password' => Hash::make('adminsbinar123'),
        ]);
        
    }
}
