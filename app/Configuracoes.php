<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Configuracoes;
use File;

class Configuracoes extends Model
{
    private $Config;
    private $Img;

    public function __construct()
    {
        $this->Img = new Imagens;
    }

    protected $fillable = [
        'titulo',
        'descricao',
        'valor',
        'logo_sistema',
        'img_carteira',
        'dt_expiracao'
    ];

    public $rules = [
        'titulo' => 'required|string|max:250',
        'descricao' => 'max:500|string',
        'valor' => 'required',
        'dt_expiracao' => 'required',
        'logo_sistema' => 'mimes:img,png,jpeg',
        'img_carteira' => 'mimes:img,png,jpeg'
    ];

    /*
     * Só vai existir uma configuração no sistem.
     * portanto, se não existir configuração, cria-se, e se existir apenas atualiza.
     * @param $update = null, traz o resultado da busca em caso de atualização.
     */
    public function createConfig($request, $update = null)
    {
        $r = $request;

        if ($update):
            //traz os dados da busca do item a ser atualizado.
            $dados = $update;
        else:
            //apenas cria um instância para que seja criado o primeiro registro no banco.
            $dados = $this->Config = new Configuracoes();
        endif;

        $titulo = trim($r->titulo);
        $descricao = trim(ucwords(mb_strtolower($r->descricao)));
        $valor = str_replace(',', '.', str_replace('.', '', trim(str_replace('R$', '', $r->valor))));

        //diretorio onde será salva a imagem.
        $dir = 'img/img';

        $dados->titulo = $titulo;
        $dados->descricao = $descricao;
        $dados->valor = $valor;
        $dados->dt_expiracao = $r->dt_expiracao;

        if($update):
            $this->criaNoBancoEdeletnaPasta($request, $update, $dir);
        else:
            if ($request->logo_sistema):
                $dados->logo_sistema = $this->Img->createImagem($request->logo_sistema, $dir);
            endif;
            if ($request->img_carteira):
                $dados->img_carteira = $this->Img->createImagem($request->img_carteira, $dir);
            endif;
        endif;

        $dados->user_id = auth()->user()->id;
        $dados->save();
        return $dados;
    }

    //falta configurar para excluir as imagens da pasta.

    public function updateConfig($request, $id)
    {

    }

    public function criaNoBancoEdeletnaPasta($request, $dados, $dir)
    {
        if($request->logo_sistema):
            $imagem = $this->Img->createImagem($request->logo_sistema, $dir);
            $apagar = $dados->logo_sistema;
            $sucesso = $dados->update(['logo_sistema'=>$imagem]);  
            // dd($sucesso, $dados->logo_sistema, $imagem, $apagar);      
            if($sucesso):
                File::delete($apagar);
            endif;
        endif;

        if($request->img_carteira):
            $apagar = $dados->img_carteira;
            $sucesso = $dados->update(['img_carteira'=>$this->Img->createImagem($request->img_carteira, $dir)]);
            if($sucesso):
                File::delete($apagar);
            endif;
        endif;
    }
}

