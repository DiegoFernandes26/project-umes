<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracoes', function (Blueprint $table){
            $table->increments('id');
            $table->string('titulo');
            $table->string('descricao', 500)->nulleble();
            $table->float('valor')->nulleble();
            $table->string('dt_expiracao',5);
            $table->string('logo_sistema');
            /*$table->string('img_carteira');Esse campo foi retirado por que pediram para que a carteira passasse a ter vários modelos cadastrados, portanto foi preciso criar
            uma tabela apenas para os modelos.*/
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('configuracoes');
    }
}
