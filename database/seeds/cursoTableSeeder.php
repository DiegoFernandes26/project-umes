<?php

use App\Curso;
use Illuminate\Database\Seeder;

class cursoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Curso::truncate();
        foreach(range(0,9) as $i):
            Curso::create(['name' => "Curso ".$i, 'nivel'=>'1']);
        endforeach;
//        factory('App\Curso', 9)->create();

    }
}
