<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = new Store();
        $store->store_name = 'example store';
        $store->root_store_id = 1;
        $store->store_account_id = 1;
        $store->store_company_id = 1;
        $store->save();
        Store::factory(10)->create();
    }
}
