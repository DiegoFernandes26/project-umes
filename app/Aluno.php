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

    public function __construct()
    {
        $this->Endereco = new Endereco;
        $this->Carbon = new Carbon();
        $this->Config = new Configuracoes();
    }

    protected $fillable = [
        'name', 'name_social', 'sexo', 'rg', 'cpf', 'org_expedidor',
        'dt_nascimento', 'celular', 'tel_fixo', 'email', 'mae', 'matricula',
        'endereco_id', 'curso_id', 'matricula', 'periodo', 'pago', 'valor',
        'dt_validade', 'foto', 'rg_frente', 're_verso', 'comp_matricula',
        'user_id', 'status', 'view_by', 'status'
    ];

    public $rules = [
        'name' => 'required|string',
        'dt_nascimento' => 'date|required',
        'rg' => 'required|integer|unique:alunos',
        'org_expedidor' => 'required',
        'mae' => 'string',
        'sexo' => 'required',
        'celular' => 'unique:alunos|celular_com_ddd',
        'email' => 'email|unique:alunos',
        'matricula' => 'required',
        'cpf' => 'cpf|required|unique:alunos',
        'foto' => 'mimes:jpg,jpeg,png',
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
        'mae' => 'string',
        'sexo' => 'required',
        'celular' => 'celular_com_ddd',
        'email' => 'email',
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
        return $this->belongsTo('App\Endereco');
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

    public function mensagem()
    {
        return $this->hasOne('App\Mensagens');
    }

    public function emissoes()
    {
        return $this->hasMany('App\Emissoes', 'aluno_id');
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


    public function FormataCarteira($dados)
    {
        $configuracoes = $this->Config->orderBy('id')->first();
        $saveCart = new Aluno();
        $diretorio = 'carteira';

        $busca = Aluno::where('cpf', $dados->input('cpf'))->first();
        $jaExiste = ($busca ? $busca : $jaExiste = false);
        //se não for encontrado aluno com o CPF informado, é criado um novo registro


        if (!$jaExiste):
            $saveCart->name = trim($dados->input('name'));
            $saveCart->name_social = trim($dados->input('name_social'));
            $saveCart->sexo = ($dados->input('sexo') ? $dados->input('sexo') : 'm');
            $saveCart->dt_nascimento = $dados->input('dt_nascimento');
            $saveCart->mae = trim($dados->input('mae') ? $dados->input('mae') : null);
            $saveCart->rg = trim($dados->input('rg'));
            $saveCart->cpf = trim($dados->input('cpf'));
            $saveCart->dt_validade = $configuracoes->dt_expiracao;
            $saveCart->org_expedidor = trim($dados->input('org_expedidor') ? $dados->input('org_expedidor') : null);
            $saveCart->celular = trim($dados->input('celular') ? $dados->input('celular') : null);
            $saveCart->tel_fixo = trim($dados->input('tel_fixo') ? $dados->input('tel_fixo') : null);
            $saveCart->email = mb_strtolower(trim($dados->input('email')));
            $saveCart->matricula = trim($dados->input('matricula') ? $dados->input('matricula') : null);
            $saveCart->periodo = trim($dados->input('periodo') ? $dados->input('periodo') : null);
            $saveCart->pago = ($dados->input('pago') ? $dados->input('pago') : "nao");
            $saveCart->valor = ($dados->input('pago') ? $configuracoes->valor : 0);

//            $endereco = $this->Endereco->createEndereco($dados);
//            $saveCart->endereco_id = ($endereco ? $endereco : null);

            $saveCart->escola_id = $dados->input('escola_id');
            $saveCart->curso_id = $dados->input('curso_id');
            $saveCart->user_id = Auth()->user()->id;
            $saveCart->save();


            $id = $saveCart->id;
            //gera o código da carteira apos a criação desta
            $this->gerarCodigoUnico($saveCart->id);
            $saveCart->foto = Imagens::saveImage($dados->foto, $id, $diretorio, 300);

            if (!empty($dados->rg_frente)):
                $saveCart->rg_frente = Imagens::saveImage($dados->rg_frente, $id, $diretorio, 600);
            endif;
            if (!empty($dados->rg_verso)):
                $saveCart->rg_verso = Imagens::saveImage($dados->rg_verso, $id, $diretorio, 600);
            endif;
            if (!empty($dados->comp_matricula)):
                $saveCart->comp_matricula = Imagens::saveImage($dados->comp_matricula, $id, $diretorio, 600);
            endif;
            $saveCart->save();

            return $saveCart;
        else:
            return false;
        endif;
    }


    public function atualizarAluno($aluno, $dados, $id)
    {

        $valor = $this->Config->orderBy('id')->first();
        $diretorio = 'carteira';

        $update = [
            'name' => trim($dados->input('name')),
            'name_social' => trim($dados->input('name_social')),
            'sexo' => $dados->input('sexo'),
            'rg' => trim($dados->input('rg')),
            'cpf' => trim($dados->input('cpf')),
            'org_expedidor' => trim(($dados->input('org_expedidor') ? $dados->input('org_expedidor') : null)),
            'celular' => trim(($dados->input('celular') ? $dados->input('celular') : null)),
            'tel_fixo' => trim(($dados->input('tel_fixo') ? $dados->input('tel_fixo') : null)),
            'email' => mb_strtolower(trim($dados->input('email'))),
            'dt_nascimento' => $dados->input('dt_nascimento'),
            'mae' => trim(($dados->input('mae') ? $dados->input('mae') : null)),
            'matricula' => trim(($dados->input('matricula') ? $dados->input('matricula') : null)),
            'periodo' => trim(($dados->input('periodo') ? $dados->input('periodo') : null)),
            'pago' => ($dados->input('pago') ? $dados->input('pago') : 0),
            'valor' => ($dados->input('pago') ? $valor->valor : 0),
            'curso_id' => $dados->input('curso_id'),

            //se não tiver sido o atual logado quem criou essa carteira ele permanecerá com o id de quem a criou.
            'user_id' => ($aluno->user_id != Auth()->user()->id ? $aluno->user_id : Auth()->user()->id),
        ];
        //apaga a foto da pasta e cria outra no banco.
        if (count($aluno) > 0):
            if (!empty($dados->file('foto'))):
                File::delete($aluno->foto);
                $aluno->update(['foto' => Imagens::saveImage($dados->foto, $id, $diretorio, 300)]);
            endif;
            if (!empty($dados->file('rg_frente'))):
                File::delete($aluno->rg_frente);
                $aluno->update(['rg_frente' => Imagens::saveImage($dados->rg_frente, $id, $diretorio, 600)]);
            endif;
            if (!empty($dados->file('rg_verso'))):
                File::delete($aluno->rg_verso);
                $aluno->update(['rg_verso' => Imagens::saveImage($dados->rg_verso, $id, $diretorio, 600)]);
            endif;
            if (!empty($dados->file('comp_matricula'))):
                File::delete($aluno->comp_matricula);
                $aluno->update(['comp_matricula' => Imagens::saveImage($dados->comp_matricula, $id, $diretorio, 600)]);
            endif;
        endif;

        return $update;
    }


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

    /*
     * Realiza uma busca de acordo com os parâmetros informados
     */
    public function filtrarAluno(array $data, $resultadosPorPagina = null)
    {

        $resultado = $this->where(function ($query) use ($data) {

            if (isset($data['cpf']) && $data['cpf'] != null)
                $query->where('cpf', $data['cpf']);

            if (isset($data['instituicao']) && $data['instituicao'] != null)
                $query->where('escola_id', $data['instituicao']);

            if (isset($data['data_inicio']) && $data['data_inicio'] != "")
                $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($data['data_inicio'])));

            if (isset($data['data_fim']) && $data['data_fim'] != "")
                $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($data['data_fim'])));

            if (isset($data['status']) && $data['status'] != null) {
                if ($data['status'] == 1)//vencidas
                    $query->where('dt_validade', '<', date('Y-m-d'));
                if ($data['status'] == 2)//não vencidas
                    $query->where('dt_validade', '>', date('Y-m-d'));
            }

        })
            ->orderBy('id', 'desc')
            ->paginate($resultadosPorPagina);


        return $resultado;
    }
}
