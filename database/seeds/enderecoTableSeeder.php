<?php

use App\Endereco;
use Illuminate\Database\Seeder;

class enderecoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Endereco::truncate();

        factory('App\Endereco', 15)->create();
    }
}
