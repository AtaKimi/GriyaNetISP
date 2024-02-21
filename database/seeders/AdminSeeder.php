<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_agent = Role::where('name', 'admin')->first();
        
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        $user->assignRole($role_agent);

        $users = User::factory(2)->create();
        
        foreach ($users as $user) {
            if($user->hasRole('admin')) {
                $user->assignRole($role_agent);
                $agent = Agent::factory()->count(1)->for($user)->create();
            }
        }

    }
}
