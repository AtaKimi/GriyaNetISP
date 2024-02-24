<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            AgentSeeder::class,
            SalesPackageSeeder::class,
            CustomerSeeder::class,
            CustomerTransactionSeeder::class,

            //media seeder
            DeleteMediaSeeder::class,
            SalesPackageMediaSeeder::class,
            CustomerTransactionMediaSeeder::class,
            CustomerMediaSeeder::class,
        ]);
    }
}
