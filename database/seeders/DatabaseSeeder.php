<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employment;
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

            SettingSeeder::class,
            StockSeeder::class,
            ReceiptSeeder::class,
            WarehouseSeeder::class,
            OrderSeeder::class,
            EmploymentSeeder::class,
            AddressSeeder::class,
            AttendanceSeeder::class,
            ExpenseSeeder::class,
            UserSeeder::class,
            ReceiptSeeder::class,
            AccountSeeder::class,
            CompanySeeder::class,
            PersonSeeder::class,
            StoreSeeder::class, 

        ]);
    }
}
