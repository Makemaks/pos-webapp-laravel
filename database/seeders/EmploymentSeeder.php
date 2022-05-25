<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employment;


class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employment::factory(10)->create();
    }
}
