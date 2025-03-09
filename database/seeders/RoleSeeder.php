<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['Super Admin', 'Admin', 'Teacher', 'Parent'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
