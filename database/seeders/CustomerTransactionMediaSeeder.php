<?php

namespace Database\Seeders;

use App\Models\CustomerTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerTransactionMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer_transactions = CustomerTransaction::all();

        for ($i = 0; $i < count($customer_transactions); $i++) {
            $img_number = fake()->numberBetween(1, 8);
            $path = public_path('\\assets\\images\\seeder\\') . $img_number . ".jpg";
            $customer_transactions[$i]->addMedia($path)->preservingOriginal()
                ->toMediaCollection('identity', 'media');

            $img_number = fake()->numberBetween(1, 8);
            $path = public_path('\\assets\\images\\seeder\\') . $img_number . ".jpg";
            $customer_transactions[$i]->addMedia($path)->preservingOriginal()
                ->toMediaCollection('house', 'media');
        }
    }
}
