<?php

namespace App\Http\Controllers;

use App\Configuracoes;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Escola;
use App\Curso;
use App\Aluno;
use App\Endereco;
use App\Imagens;
use App\Verso;
use File;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CarteiraController extends Controller
{
    protected $aluno;
    protected $escolas;
    protected $endereco;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Aluno $aluno)
    {
        $this->aluno = $aluno;
        $this->escola = new Escola();
        $this->endereco = new Endereco();
    }

    /*
     * Mostra página listando todos os registros de carteiras(alunos)
     */
    public function show()
    {
        $alunos = $this->aluno->orderBy('id', 'desc')->get();
        return view('admin.carteira.listscarteiras', compact('alunos'));
    }

    /*
     * Mostra todas a instituições cadastradas para que o usuário possa selecionar antes de iniciar os cadastro de alunos.
     */
    public function index()
    {
        $escola = Escola::orderBy('id', 'desc')->get();
        return view('admin.carteira.index', compact('escola'));
    }

    //Mostra a carteira pelo id do aluno com frente e verso(escondido) prontos para impressão.
    public function vercarteira($id)
    {
        $busca = aluno::find($id);
        $verso = Verso::where('status', true)->first();
        $config = Configuracoes::orderBy('id', 'asc')->first();
        $curso = $busca->curso;
        return view('admin.carteira.show', compact('busca', 'curso', 'verso', 'config'));
    }

    /*
     * Esse método vai mostrar os dados publicos do aluno, quando for feito leitura via qrcode
     */
    public function vercarteiraindividual($numeroQr)
    {
        $busca = aluno::where('numero_carteira', $numeroQr)->first();
        $curso = $busca->curso;

        return view('admin.carteira.vercarteira', compact('busca', 'curso'));
    }

    public function cursos(Request $request, $id)
    {
        if ($request->ajax()) {

            $cursos = Curso::where('escola_id', '=', $id)->get();
            return Response()->json($cursos);
        }
//        $cursos = Curso::where('escola_id', '=', $id)->get();
//        return Response()->json($cursos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $escola = $this->escola->find($id);

        $cursos = $escola->cursos->lists('name', 'id');

        $curso = (count($cursos) > 0 ? $cursos : $curso = false);
        if ($curso):
            return view('admin.carteira.create', compact('cursos', 'id', 'escola'));
        else:
            return back()->with('status', 'Não há cursos vinculados à instituição ' . $escola->nome);
        endif;

    }

    /**
     * Insere os dados do aluno no banco...disponibilizando para a nova carteira.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        //usa a classe Aluno
        $this->validate($request, $this->aluno->rules, $this->aluno->messages);
        $this->validate($request, $this->endereco->rules);

        $aluno = new Aluno();
        $busca = $aluno->createCarteira($request);
        if ($busca):
            $curso = $busca->curso;
            return redirect()->route('cart.all', compact('busca', 'curso'))->with('status', 'Aluno(a) ' . $busca->name . ' cadastrado(a) com sucesso!');
        else:
            return back()->with('status', 'Houve algum erro inesperado ao cadastrar aluno!');
        endif;
    }

    /*
     * Cria o verso da carteira
     */
    public function createCartVerso()
    {
        $objeto = new Verso();
        $versos = $objeto->orderBy('created_at', 'desc')->get();
        $verso = (count($versos) > 0 ? $versos : $verso = null);

        return view('admin.carteira.verso', compact('verso'));
    }

    /*
     * grava no banco o verso da carteira.
     */
    public function storeCartVerso(Request $request)
    {
//        dd($request->all());
        $imagem = new Imagens();
        $verso = new Verso();

        $this->validate($request, $verso->rules);

        $dir = 'img/img';

        $name = trim(ucwords(mb_strtolower($request->input('name'))));
        $verso->name = $name;
        $verso->img_verso = $imagem->createImagem($request->img_verso, $dir);
        $verso->user_id = Auth()->user()->id;
        $verso->save();

        return back()->with('status', 'Campanha criada com sucesso!');

    }
    /*
     * Qaundo clicado marca em todos os campos "status" com false
     * e depois marca o campo "status" correspondente ao $id com true.
     */
    public function ativaVerso($id)
    {
        Verso::where('id','>=',1)->update(['status'=>false]);
        $result = Verso::find($id)->update(['status'=>true]);
        return Response()->json($result);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aluno = $this->aluno->find($id);
        if (count($aluno) > 0):
            $cursos = $aluno->curso->lists('name', 'id');
            $endereco = ($this->endereco->find($aluno->endereco_id) ? $this->endereco->find($aluno->endereco_id) : $endereco = null);
            return view('admin.carteira.edit', compact('aluno', 'cursos', 'endereco'));
        else:
            return back()->with('status', 'Aluno não encontrado!');
        endif;


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $this->validate($request, $this->aluno->rulesUpdate, $this->aluno->messages);
        $this->validate($request, $this->endereco->rules);
        $aluno = Aluno::find($id);
        if (count($aluno) > 0):
            $update = $aluno->update($this->aluno->atualizarAluno($aluno, $request, $id));
            $endereco = $this->endereco->updateEndereco($request, $aluno->endereco_id);
            if($request->renovar):
                $aluno->update(['dt_validade'=>$this->aluno->dtValidade()]);
                return redirect()->route('cart.all')->with('status', 'Carteira de '.$aluno->name.' renovada com sucesso!');
            else:
                return redirect()->route('cart.all')->with('status', 'Cadastro de '.$aluno->name.' atualizado com sucesso');
            endif;           
        else:
            return redirect()->route('cart.index')->with('status', 'Aluno não encontrado :/');
        endif;

    }

    /**
     * Deleta primeiramente as imagens das pastas referentes ao registro em questão.
     * Apos, deleta o registro em sí, e depois deleta endereço referente esse registro.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carteira = Aluno::find($id);
        //antes de deletar o registro no banco, deleta os arquivos da pastas.        
        $carteira->delete();
        File::delete($carteira->foto, $carteira->rg_frente, $carteira->rg_verso, $carteira->comp_matricula);
        Endereco::find($carteira->endereco_id)->delete();
        return back()->with('status', 'Aluno deletado com sucesso!');
    }

    /*
     * Excluir verso de carteiras
     * Exclui também todas a imagem ligado a esse verso.
     */
    public function excluirCartVerso($id)
    {
        $verso = Verso::find($id);
        File::delete($verso->img_verso);
        $verso->delete();

        return back()->with('status', 'Campanha excluída com sucesso!');
    }


    public function geraPDF($id)
    {

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.carteira.pdf', compact('id'));
        return $pdf->stream();
    }
}
