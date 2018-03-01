<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emissoes extends Model
{
    protected $fillable = [
      'user_id','aluno_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function aluno(){
        return $this->belongsTo('App\Aluno','aluno_id');
    }
}
