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

            ReceiptSeeder::class,
            EmploymentSeeder::class,
            AddressSeeder::class,
            StockSeeder::class,
            AttendanceSeeder::class,
            WarehouseSeeder::class,
            ExpenseSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
            ReceiptSeeder::class,
            AccountSeeder::class,
            CompanySeeder::class,
            OrderSeeder::class,
            PersonSeeder::class,
            StoreSeeder::class,

        ]);
    }
}
