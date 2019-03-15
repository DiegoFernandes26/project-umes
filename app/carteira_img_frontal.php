<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class carteira_img_frontal extends Model
{
    protected $fillable = [
        'name',
        'img_frontal',
        'status',
    ];

    public $rules = [
        'name' => 'required|string',
        'img_frontal' => 'required|mimes:png,jpg,jpeg'
    ];

    public function store($request)
    {
//      Os dados já estão validados no CONTROLLER


        $dados = $request->all();
        unset($dados['_token']);
        unset($dados['img_frontal']);

        $dados['user_id'] = Auth()->user()->id;
        $dados['status'] = 0;

//      Pasta de armazenamento dos arquivos.
        $dir = 'modelos';

        $CreateModel = carteira_img_frontal::firstOrCreate($dados);

//      Após gravar no BD faz uma atualização salvando o caminho do arquivo
        $CreateModel->update(['img_frontal' => Imagens::saveImage($request->img_frontal, $CreateModel->id,$dir, 600)]);



        return TRUE;

    }

//  Retorna todos os registros da tabela CARTEIRA_IMG_FRONTALS
    public function buscarTodosOsRegistros()
    {
        $TodosOsModelos = self::orderBy('created_at','desc')->paginate(9);


        return $TodosOsModelos;
    }



}
