<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           
            EmployementSeeder::class,
            SettingSeeder::class,
            WarehouseSeeder::class,
            ExpenseSeeder::class,
            StockSeeder::class,
            UserSeeder::class,
            ReceiptSeeder::class,
            AccountSeeder::class,
            AddressSeeder::class,
            CompanySeeder::class,
            OrderSeeder::class,
            PersonSeeder::class,

            StoreSeeder::class,


        ]);
    }
}
