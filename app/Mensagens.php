<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensagens extends Model
{
    protected $fillable = [
        'conteudo','status','user_id','aluno_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function aluno(){
        return $this->belongsTo('App\Aluno');
    }

}
