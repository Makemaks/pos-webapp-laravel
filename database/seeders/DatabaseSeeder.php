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
            
            StockSeeder::class,
            AccountSeeder::class,
            SettingSeeder::class,
            ReceiptSeeder::class,
            
            OrderSeeder::class,
            WarehouseSeeder::class,
            EmploymentSeeder::class,
            AddressSeeder::class,
            AttendanceSeeder::class,
            ExpenseSeeder::class,
            UserSeeder::class,
            ReceiptSeeder::class,
            CompanySeeder::class,
            PersonSeeder::class,
            StoreSeeder::class, 

        ]);
    }
}
