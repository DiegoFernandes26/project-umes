<?php

use App\Contato;
use Illuminate\Database\Seeder;

class contatoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contato::truncate();

        factory('App\Contato', 15)->create();
    }
}
