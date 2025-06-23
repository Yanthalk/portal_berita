<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            ['role_id' => 1, 'role_name' => 'user'],
            ['role_id' => 2, 'role_name' => 'admin'],
        ]);
    }
}
