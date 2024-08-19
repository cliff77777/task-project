<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::factory()->count(1)->create([
            'role_name' => "admin",
            'role_control' => "all_control",
            'role_descript' =>'DB Seeder Admin',
        ]);
    }
}
