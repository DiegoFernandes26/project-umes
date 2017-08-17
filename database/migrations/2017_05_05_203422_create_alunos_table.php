<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_social')->nullable();
            $table->char('sexo', 1);
            $table->string('rg')->nullable();
            $table->string('cpf',14)->unique();
            $table->string('org_expedidor')->nullable();
            $table->string('celular')->unique()->nullable();
            $table->string('tel_fixo')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('dt_nascimento')->nullable();
            $table->string('mae')->nullable();
            $table->string('numero_carteira')->nullable();
            $table->date('dt_validade');
            $table->string('foto')->nullable();
            $table->string('rg_frente')->nullable();
            $table->string('rg_verso')->nullable();
            $table->string('comp_matricula')->nullable();
            $table->string('matricula');
            $table->string('periodo')->nullable();
            $table->boolean('pago')->nullable();
            $table->float('valor');
            //chaves estrangeiras
            $table->integer('endereco_id')->unsigned();
            $table->foreign('endereco_id')->references('id')->on('enderecos')->onDelete('cascade');
            $table->integer('escola_id')->unsigned();
            $table->foreign('escola_id')->references('id')->on('escolas');
            $table->integer('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alunos');
    }
}
