<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Carbon\Carbon;
use App\Endereco;
use File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class Aluno extends Model
{
    protected $Endereco;
    protected $Carbon;
    protected $Config;
    protected $Img;

    public function __construct()
    {
        $this->Endereco = new Endereco;
        $this->Carbon = new Carbon();
        $this->Config = new Configuracoes();
        $this->Img = new Imagens();
    }

    protected $fillable = [
        'name',
        'name_social',
        'sexo',
        'rg',
        'cpf',
        'sexo',
        'org_expedidor',
        'dt_nascimento',
        'celular',
        'tel_fixo',
        'email',
        'mae',
        'matricula',
        'endereco_id',
        'curso_id',
        'matricula',
        'periodo',
        'pago',
        'valor',
        'dt_validade',
        'foto',
        'rg_frente',
        're_verso',
        'compo_matricula',
        'user_id'
    ];

    public $rules = [
        'name' => 'required|string',
        'dt_nascimento' => 'date|required',
        'rg' => 'required|unique:alunos|integer',
        'org_expedidor' => 'required',
        'mae' => 'required',
        'sexo' => 'required',
        'celular' => 'required|unique:alunos|celular_com_ddd',
        'email' => 'required|email|unique:alunos',
        'matricula' => 'required',
        'cpf' => 'cpf|required|unique:alunos',
        'foto' => 'required|mimes:jpg,jpeg,png',
        'rg_frente' => 'mimes:jpg,jpeg,png',
        'rg_verso' => 'mimes:jpg,jpeg,png',
        'comp_matricula' => 'mimes:jpg,jpeg,png',
        'curso_id' => 'required'
    ];
    public $rulesUpdate = [
        'name' => 'required|string',
        'dt_nascimento' => 'date|required',
        'rg' => 'required|integer',
        'org_expedidor' => 'required',
        'mae' => 'required|string',
        'sexo' => 'required',
        'celular' => 'required|celular_com_ddd',
        'email' => 'required|email',
        'matricula' => 'required',
        'cpf' => 'cpf|required',
        'foto' => 'mimes:jpg,jpeg,png',
        'rg_frente' => 'mimes:jpg,jpeg,png',
        'rg_verso' => 'mimes:jpg,jpeg,png',
        'comp_matricula' => 'mimes:jpg,jpeg,png',
        'curso_id' => 'required'
    ];

    public $messages = [
        'rg.unique.' => 'Já existe uma pessoa cadastrada com o RG informado!',
        'cpf.unique.' => 'Já existe uma pessoa cadastrada com o CPF informado!'
    ];

    public function endereco()
    {
        return $this->hasOne('App\Endereco');
    }

    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    public function contato()
    {
        return $this->hasMany('App\Contato');
    }

    public function escola()
    {
        return $this->belongsTo('App\Escola');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     * Verifica na tabela configurações, e compara com a data atual,
     * @return string $dt_validade
     */
    public function dtValidade()
    {
        $dtCarbon = $this->Carbon->toDateString();
        //data atual
        $dt_atual = date('d-m-Y', strtotime($dtCarbon));
        $ano = $this->Carbon->year;

        $dt = $this->Config->orderBy('id')->first();
        $dtExp = explode('/', $dt->dt_expiracao);
        //data de validade da carteira
        $dt_find = $dtExp[0] . '-' . $dtExp[1] . '-' . $ano;

        //se data atual for menor que a data de validade acrescenta-se mais um ano, para que a carteira possa vencer no inicio do outro ano.
        if (strtotime($dt_atual) <= strtotime($dt_find)):
            //nesse caso continua a data da validade sem alterações.
            $dt_validade = $dt_find;
        else:
            //já nesse caso, acrescenta-se mais um ano à data de validade.
            $ano = $this->Carbon->addYears(1)->year;
            $dt_validade = $dtExp[0] . '-' . $dtExp[1] . '-' . $ano;
        endif;

        return date('Y-m-d', strtotime($dt_validade));
    }

//    public function getDtNascimentoAttribute($value)
//    {
//        return date('d-m-Y', strtotime($value));
//    }

    public function createCarteira($dados)
    {
        $saveCart = new Aluno();
        //dd($this->Carbon->addYears(1)->year, $dt->dt_expiracao);

        $valor = $this->Config->orderBy('id')->first();

        $busca = Aluno::where('cpf', '=', $dados->input('cpf'))->first();
        $jaExiste = ($busca ? $busca : $jaExiste = false);
        //se não for encontrado aluno com o CPF informado, é criado um novo registro
        if (!$jaExiste):
            $saveCart->name = mb_strtolower(trim($dados->input('name')));
            $saveCart->name_social = mb_strtolower(trim($dados->input('name_social')));
            $saveCart->sexo = ($dados->input('sexo') ? $dados->input('sexo') : 'm');
            $saveCart->dt_nascimento = $dados->input('dt_nascimento');
            $saveCart->mae = mb_strtolower(trim($dados->input('mae') ? $dados->input('mae') : null));
            $saveCart->rg = $dados->input('rg');
            $saveCart->cpf = $dados->input('cpf');
            $saveCart->dt_validade = $this->dtValidade();
            $saveCart->org_expedidor = mb_strtolower(trim($dados->input('org_expedidor') ? $dados->input('org_expedidor') : null));
            $saveCart->celular = ($dados->input('celular') ? $dados->input('celular') : null);
            $saveCart->tel_fixo = ($dados->input('tel_fixo') ? $dados->input('tel_fixo') : null);
            $saveCart->email = mb_strtolower(trim($dados->input('email') ? $dados->input('email') : null));
            $saveCart->matricula = ($dados->input('matricula') ? $dados->input('matricula') : null);
            $saveCart->periodo = ($dados->input('periodo') ? $dados->input('periodo') : null);
            $saveCart->pago = ($dados->input('pago') ? $dados->input('pago') : "nao");
            $saveCart->valor = ($dados->input('pago') ? $valor->valor : 0);

            $endereco = $this->Endereco->createEndereco($dados);
            $saveCart->endereco_id = ($endereco ? $endereco : null);

            $saveCart->escola_id = $dados->input('escola_id');
            $saveCart->curso_id = $dados->input('curso_id');
            $saveCart->user_id = Auth()->user()->id;
            $saveCart->foto = $this->Img->createImagem($dados->foto);

            if (!empty($dados->rg_frente)):
                $saveCart->rg_frente = $this->Img->createImagem($dados->rg_frente);
            endif;
            if (!empty($dados->rg_verso)):
                $saveCart->rg_verso = $this->Img->createImagem($dados->rg_verso);
            endif;
            if (!empty($dados->comp_matricula)):
                $saveCart->comp_matricula = $this->Img->createImagem($dados->comp_matricula);
            endif;
            $saveCart->save();

            //gera o código da carteira apos a criação desta
            $this->gerarCodigoUnico($saveCart->id);
            $busca = $saveCart;

            return $busca;
        else:
            return false;
        endif;

    }

    public function atualizarAluno($aluno, $dados, $id)
    {

        $valor = $this->Config->orderBy('id')->first();

        $update = [
            'name' => mb_strtolower(trim($dados->input('name'))),
            'name_social' => trim($dados->input('name_social')),
            'sexo' => $dados->input('sexo'),
            'rg' => trim($dados->input('rg')),
            'cpf' => trim($dados->input('cpf')),
            'org_expedidor' => mb_strtolower(trim(($dados->input('org_expedidor') ? $dados->input('org_expedidor') : null))),
            'celular' => trim(($dados->input('celular') ? $dados->input('celular') : null)),
            'tel_fixo' => trim(($dados->input('tel_fixo') ? $dados->input('tel_fixo') : null)),
            'email' => trim(($dados->input('email') ? $dados->input('email') : null)),
            'dt_nascimento' => $dados->input('dt_nascimento'),
            'mae' => mb_strtolower(trim(($dados->input('mae') ? $dados->input('mae') : null))),
            'matricula' => trim(($dados->input('matricula') ? $dados->input('matricula') : null)),
            'periodo' => mb_strtolower(trim(($dados->input('periodo') ? $dados->input('periodo') : null))),
            'pago' => ($dados->input('pago') ? $dados->input('pago') : 0),
            'valor' => ($dados->input('pago') ? $valor->valor : 0),
            'curso_id' => $dados->input('curso_id'),
            'user_id' => Auth()->user()->id
        ];
        //apaga a foto da pasta e cria outra no banco.
        if (count($aluno) > 0):
            if (!empty($dados->file('foto'))):
                File::delete($aluno->foto);
                $aluno->update(['foto' => $this->Img->createImagem($dados->foto)]);
            endif;
            if (!empty($dados->file('rg_frente'))):
                File::delete($aluno->rg_frente);
                $aluno->update(['rg_frente' => $this->Img->createImagem($dados->rg_frente)]);
            endif;
            if (!empty($dados->file('rg_verso'))):
                File::delete($aluno->rg_verso);
                $aluno->update(['rg_verso' => $this->Img->createImagem($dados->rg_verso)]);
            endif;
            if (!empty($dados->file('comp_matricula'))):
                File::delete($aluno->comp_matricula);
                $aluno->update(['comp_matricula' => $this->Img->createImagem($dados->comp_matricula)]);
            endif;
        endif;

        return $update;
    }


//    public function image($file)
//    {
//        if (Input::file()):
//            //inicio criação do nome da imagem
//            $data = \Carbon\Carbon::now();
//            $dt = $data->ToDateString();
//            $micro = $data->micro;
//            $hr = $data->format('H-i-s-m');
//            $dtHora = $hr . '-' . $micro;
//
//            //criando diretório
//            $diretorio = 'img/' . $data->year . "/" . $data->month . "/" . $data->day;
//            //se não existir ele cria o diretorio
//            if (!file_exists($diretorio)):
//                mkdir($diretorio, 0777, true);
//            endif;
//
//            //data e hora servem para nomear a imagem de maneira única, concatenada com a extensão do arquivo.
//            $imgName = $dtHora . '.' . $file->getClientOriginalExtension();
//
//            $caminho = $diretorio . '/' . $imgName;
//            //salva a imagem redimensionada no caminho indicado.
//            $redImagem = Image::make($file->getRealpath())->resize(490, 600)->save($caminho);
//            //$img->destroy();
//        endif;
//        return $caminho;

//    }

    /*
     * Através do id passado, busca o aluno, ver se o codigo de carteira ja existe, se não existe ele cria.
     */
    public function gerarCodigoUnico($id)
    {
        $aluno = aluno::find($id);
        $dt = \Carbon\Carbon::now();
        //serão usados esses dados para gerar o identificador único de cada carteira
        //pega apenas os 2 ultimos numeros
        $ano = substr($dt->year, -2);
        //forma um codigo com o ano+id da escola + id do aluno.
        $codUnico = $ano . $aluno->id . $aluno->escola_id . $aluno->curso_id;
        $codigo = str_pad($codUnico, 10, '0', STR_PAD_LEFT);

        $ifexiste = Aluno::where('numero_carteira', $codigo)->first();
        //dd(empt($ifexiste));
        if (empty($ifexiste)):
            $aluno->numero_carteira = $codigo;
            $aluno->save();
        else:
            dd('Erro: O código de carterina ' . $codigo . ' ja esta sendo usado!');
        endif;
        return $codigo;
    }
}
