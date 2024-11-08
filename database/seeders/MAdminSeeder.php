<?php

namespace Database\Seeders;

use App\Models\AdminModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminModel::create([
            'user_id' => 1,
            'level_id' => 2,
            'opco_id' => 1
        ]);
        AdminModel::create([
            'user_id' => 2,
            'level_id' => 2,
            'opco_id' => 2
        ]);  
        AdminModel::create([
            'user_id' => 3,
            'level_id' => 2,
            'opco_id' => 2
        ]);
    }
}
