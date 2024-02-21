<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeleteMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Storage::disk('media')->exists('')) {
            $directories = Storage::disk('media')->allDirectories();
            for ($i = 0; $i < count($directories); $i++) {
                Storage::disk('media')->deleteDirectory($directories[$i]);
            }
        }
    }
}
