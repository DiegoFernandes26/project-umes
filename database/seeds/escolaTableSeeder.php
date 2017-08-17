<?php

use App\Escola;
use Illuminate\Database\Seeder;

class escolaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Escola::truncate();

        factory('App\Escola', 15)->create();
    }
}
