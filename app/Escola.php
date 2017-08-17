<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    protected $fillable = [
        'nome',
        'cnpj',
        'fundamental',
        'medio',
        'superior',
        'pre_enem',
        'outros',
        'endereco_id',
        'user_id'
    ];
    public $rules = [
        'nome' => 'required',
        'cnpj' => 'required|cnpj|unique:Escolas'
    ];

    public function aluno()
    {
        return $this->hasMany('App\Aluno');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function cursos()
    {
        return $this->belongsToMany('App\Curso');
    }

    public function endereco()
    {
        return $this->belongsTo('App\Endereco');
    }

    /*
     * Seleliona a Escola através do ID informado, devolvendo o primeiro registro encontrado.
     */
    public function escola($value)
    {
        $escola = Escola::where('id', '=', $value)->lists('nome', 'id')->first();
        return $escola;
    }

    /*
     * Lista todas as escolas disponíveis;
     */
    public function allEscolas($value)
    {
        $escolas = Escola::where('nome', 'like', $value . '%')->lists('nome', 'id')->all();
        $escolas = ($escolas ? $escolas : $escolas = false);
        return $escolas;
    }

    public function newescola($dados)
    {
        $f = ($dados->input('fundamental') != null ? 1 : $f = 0);
        $m = ($dados->input('medio') != null ? 1 : $m = 0);
        $s = ($dados->input('superior') != null ? 1 : $s = 0);
        $pe = ($dados->input('pre_enem') != null ? 1 : $s = 0);
        $o = ($dados->input('outros') != null ? 1 : $p = 0);
        $dados = [
            'nome' => $dados->input('nome'),
            'cnpj' => $dados->input('cnpj'),
            'fundamental' => $f,
            'medio' => $m,
            'superior' => $s,
            'pre_enem' => $pe,
            'outros' => $o,
            'user_id' => auth()->user()->id
        ];

        return $dados;
    }
    /*
    *Verifica se ha algum registro relacionado com alguma escola
    */
    public function checkRelEscola($id)
    {
        $e = Escola::find($id);
        
        if(count($e->aluno)>0):
            return true;
        else:
            return null;
        endif;

    }

    public function nivelMedioOuFundamental()
    {
        if (nivel == fundamental):
            $fundamental = Curso::where('nivel', 1)->get();
            foreach($fundamental as $curso):
                $cursosId[] = $curso->id;
            endforeach;
            $escoal->cursos->sync($cursosId);
        endif;
    }


    /*serve para verificar se o cnpj já está sendo usado por outra escola*/
    public function cnpjUnico($cnpj)
    {
        $escola = Escola::where('cnpj', $cnpj)->first();
        $escola = ($escola ? $escola : $escola = false);
        if ($escola):
            return $escola->id;
        else:
            return false;
        endif;

    }


}
