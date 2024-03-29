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
        'dt_expiracao'
    ];

    public $rules = [
        'titulo' => 'required|string|max:250',
        'descricao' => 'max:500|string',
        'valor' => 'required',
        'dt_expiracao' => 'required',
        'logo_sistema' => 'mimes:img,png,jpeg'
    ];

    /*
     * Só vai existir uma configuração no sistema.
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
        $dir = 'configuracoes';

        $dados->titulo = $titulo;
        $dados->descricao = $descricao;
        $dados->valor = $valor;
        $dados->dt_expiracao = $r->dt_expiracao;
        $dados->user_id = auth()->user()->id;
        $dados->save();

        if($update):
            $this->criaNoBancoEdeletnaPasta($request, $update, $dir);
        else:
            if ($request->logo_sistema):
                $dados->logo_sistema = Imagens::saveImage($request->logo_sistema, $dados->id, $dir, 600);
            endif;
        endif;
        $dados->save();

        return $dados;
    }


//  Caso exista uma imagem de logo ou de "frente" da carteira no BD, esta será subtituida pela que o usuário está tentando atualizar.
    public function criaNoBancoEdeletnaPasta($request, $dados, $dir)
    {
        if($request->logo_sistema):
            $imagem = Imagens::saveImage($request->logo_sistema, $dados->id, $dir, 600);
            $apagar = $dados->logo_sistema;
            $sucesso = $dados->update(['logo_sistema'=>$imagem]);  
            // dd($sucesso, $dados->logo_sistema, $imagem, $apagar);      
            if($sucesso):
                File::delete($apagar);
            endif;
        endif;

    }
}

