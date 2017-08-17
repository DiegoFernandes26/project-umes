<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
            factory('App\User')->create([
                'name' => 'Diego Fernandes',
                'cpf' => 95116052249,
                'nivel' => 1,
                'status' => 1,
                'celular' => 99869962,
                'email' => 'diegotkac@gmail.com',
                'password' => bcrypt(123456),
                'remember_token' =>str_random(10)
            ]);
            factory('App\User')->create([
                'name' => 'Francisco Passos',
                'nivel' => 2,
                'status' => 1,
                'celular' => 999629972,
                'email' => 'passo.27@hotmail.com',
                'password' => bcrypt(123456),
                'remember_token' =>str_random(10)
            ]);

//            $this->call(alunoTableSeeder::class);
            $this->call(cursoTableSeeder::class);
//            $this->call(enderecoTableSeeder::class);
//            $this->call(escolaTableSeeder::class);

        Model::reguard();
    }
}
