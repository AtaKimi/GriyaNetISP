<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\CustomerTransaction;
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
        $agents = Agent::get();

        foreach ($agents as $agent) {
            $customers = $agent->customers;

            $customer_transactions = $agent->customerTransactions()->createMany(
                [
                    CustomerTransaction::factory()->make([
                        'customer_id' => $customers->random()->id,
                        'sales_package_id' => SalesPackage::first()->id,
                    ])->toArray(),
                ]                
            );
        }
    }
}
