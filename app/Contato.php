<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'telefone',
        'email',
        'fk_alunos_id'
    ];

    public function aluno(){
        return $this->belongsTo('App\Aluno');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
