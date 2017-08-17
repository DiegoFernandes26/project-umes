<?php
use App\Aluno;
use Illuminate\Database\Seeder;

class alunoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aluno::truncate();
        factory('App\Aluno', 15)->create();
    }
}
