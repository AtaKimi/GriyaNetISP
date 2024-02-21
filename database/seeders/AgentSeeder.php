<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_agent = Role::where('name', 'agent')->first();
        
        $user = User::factory()->create([
            'name' => 'Agent',
            'email' => 'agent@agent.com',
        ]);

        $user->assignRole($role_agent);

        $users = User::factory(10)->create();
        
        foreach ($users as $user) {
            $user->assignRole($role_agent);
            if($user->hasRole('agent')) {
                $agent = Agent::factory()->count(1)->for($user)->create();
            }
        }
    }
}
