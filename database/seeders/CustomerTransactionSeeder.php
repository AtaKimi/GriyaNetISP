<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\SalesPackage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = Agent::all();
        $sales_package = SalesPackage::get()->random();
        foreach ($agents as $agent) {
            $agent->customerTransactions()->createMany(
                \App\Models\CustomerTransaction::factory(5)->make(
                    [
                        'sales_package_id' => $sales_package->id
                    ]
                )->toArray()
            );
        }
    }
}
