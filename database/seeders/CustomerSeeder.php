<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = Agent::get();

        foreach ($agents as $agent) {
            $agent->customers()->createMany(Customer::factory(10)->make()->toArray());
        }
    }
}
