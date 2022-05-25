<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employement;


class EmployementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employement::factory(10)->create();
    }
}
