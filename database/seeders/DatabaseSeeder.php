<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use APP\Models\User;
use APP\Models\School;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{



    public function run()
    {
        $this->call([
            RoleSeeder::class,
            // ClassroomSeeder::class,
            // NoteSeeder::class,
            // StudentSeeder::class,
            // ParentSeeder::class,
            // TeacherSeeder::class,
            // SchoolSeeder::class,
        ]);
    }

}



