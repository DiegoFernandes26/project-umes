<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'name',
        'escola_id',
        'nivel'
    ];

    public $rules = [
        'name' => 'required|max:100|unique:cursos',
        'nivel' => 'required'
    ];

    public function aluno()
    {
        return $this->hasMany('App\Aluno');
    }

    public function escola()
    {
        return $this->belongsToMany('App\Escola');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /*
     * Trata as strings e as retorna inserção no banco.
     */
    public function createCurso($request)
    {
        //tira espaços antes e depois, converte em minusculas e primeira maiúscula.
        $name = trim(ucwords(mb_strtolower($request->input('name'))));
        $curso = ['name'=>$name,'nivel'=>$request->input('nivel')];

        return $curso;
    }

    /*
    *Verifica se ha algum registro relacionado com algum curso
    */
    public function checkRelCursos($id)
    {
        $e = Curso::find($id);

        if (count($e->aluno) > 0):
            return true;
        elseif (count($e->escola) > 0):
            return true;
        else:
            return null;
        endif;

    }

    /*
    *Verifica se ha algum aluno relacionado com algum curso
    */
    public function checkRelCursosAluno($escId, $curId)
    {   //se existir, na tabela aluno, o id de escola e id de curso retorna resultado.
        $aluno = Aluno::where('escola_id', $escId)->where('curso_id', $curId)->get();
        if (count($aluno) > 0):
            return true;
        else:
            return null;
        endif;

    }
}
