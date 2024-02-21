<?php

namespace Database\Seeders;

use App\Models\SalesPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SalesPackageMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales_package = SalesPackage::all();

        for ($i = 0; $i < count($sales_package); $i++) {
            $img_number = fake()->numberBetween(1, 8);
            $path = public_path('\\assets\\images\\seeder\\') . $img_number . ".jpg";
            $sales_package[$i]->addMedia($path)->preservingOriginal()
                ->toMediaCollection('default', 'media');
        }
    }
}
