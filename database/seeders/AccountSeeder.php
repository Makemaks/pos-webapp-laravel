<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $account = new Account();
        $account->account_system_id = 1;
        $account->accountable_id = 1;
        $account->accountable_type = 'Person';
        $account->account_type = 2;
        $account->account_description = 'lorem ipsum';
        $account->save();
        Account::factory(50)->create();
    }
}
