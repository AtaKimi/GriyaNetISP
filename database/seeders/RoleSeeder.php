<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'agent']);
    }
}
