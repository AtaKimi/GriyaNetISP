<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::all();

        for ($i = 0; $i < count($customer); $i++) {
            $img_number = fake()->numberBetween(1, 8);
            $path = public_path('\\assets\\images\\seeder\\') . $img_number . ".jpg";
            $customer[$i]->addMedia($path)->preservingOriginal()
                ->toMediaCollection('identity_card', 'media');

            $img_number = fake()->numberBetween(1, 8);
            $path = public_path('\\assets\\images\\seeder\\') . $img_number . ".jpg";
            $customer[$i]->addMedia($path)->preservingOriginal()
                ->toMediaCollection('house_picture', 'media');
        }
    }
}
