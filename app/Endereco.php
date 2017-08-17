<?php

namespace App;
use App\Aluno;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'cep',
        'endereco',
        'bairro',
        'cidade',
        'estado',
        'complemento'
    ];

    public $rules = [
        'cep' => 'required',
        'endereco' => 'required',
        'cidade' => 'required|string',
        'estado' => 'required',
        'complemento' => 'string'
    ];

    public function aluno(){
        return $this->belongsTo('App\Aluno');
    }

    public function escola(){
        return $this->hasOne('App\Escola');
    }

    /*
     * Cria o Endereço e retorna o ID dessa inserção.
     * Return ID.
     */
    public function createEndereco($dados)
    {
        $endereco = Endereco::create([
            'cep'           => $dados->cep,
            'endereco'      => $dados->endereco,
            'numero'        => $dados->numero,
            'bairro'        => $dados->bairro,
            'cidade'        => $dados->cidade,
            'estado'        => $dados->estado,
            'complemento'   => $dados->complemento
        ]);
        return $endereco->id;
    }
    /*
     * Atualiza o endereço.
     * Return ID.
     */
    public function updateEndereco($dados, $id)
    {
        $endereco = Endereco::find($id);
        $endereco->update([
            'cep'           => $dados->cep,
            'endereco'      => $dados->endereco,
            'numero'        => $dados->numero,
            'bairro'        => $dados->bairro,
            'cidade'        => $dados->cidade,
            'estado'        => $dados->estado,
            'complemento'   => $dados->complemento
        ]);
        return $endereco;
    }

}
