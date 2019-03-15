<?php

namespace App\Http\Controllers;

use App\carteira_img_frontal;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Aluno $aluno)
    {
        $this->aluno = $aluno;
        $this->escola = new Escola();
    }

    /*
     * Mostra página listando todos os registros de carteiras(alunos)
     */
    public function show()
    {
        $alunos = Aluno::orderBy('id', 'desc')
            ->paginate(10);
        $instituicao = Escola::lists('nome', 'id');

        return view('admin.carteira.listscarteiras', compact('alunos', 'instituicao'));
    }

    /*
     * Mostra todas a instituições cadastradas para que o usuário possa selecionar antes de iniciar os cadastro de alunos.
     */
    public function index()
    {
        $escola = Escola::orderBy('id', 'desc')->get();
        return view('admin.carteira.index', compact('escola'));
    }

//    Mostra a carteira pelo id do aluno com frente e verso(escondido) prontos para impressão.
//    Versão 1 da carteira (antiga)
    public function vercarteira($id)
    {
        $busca = aluno::find($id);
        $verso = Verso::where('status', true)->first();
        $modelo = carteira_img_frontal::where('status', true)->first();
//        $config = Configuracoes::orderBy('id', 'asc')->first();
        $curso = $busca->curso;

        return view('admin.carteira.show', compact('busca', 'curso', 'verso', 'modelo'));


    }

//    Mostra a Versão 2 da carteira, pronta para impressão. Em 12/03/2019 By: Diego F F

    public function vercarteiraVersao2($id)
    {
        $busca = aluno::find($id);
        $verso = Verso::where('status', true)->first();
        $modelo = carteira_img_frontal::where('status', true)->first();
//        $config = Configuracoes::orderBy('id', 'asc')->first();
        $curso = $busca->curso;

        return view('admin.carteira.show-versao2', compact('busca', 'curso', 'verso', 'modelo'));
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
            return view('admin.carteira.create', compact('curso', 'id', 'escola'));
        else:
            return back()
                ->withErrors('Não há cursos vinculados à instituição ' . $escola->nome);
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
//        $endereco = new Endereco();
        $this->validate($request, $this->aluno->rules, $this->aluno->messages);
//        $this->validate($request, $endereco->rules);

        $aluno = new Aluno();
        $busca = $aluno->FormataCarteira($request);

        if ($busca):
            $curso = $busca->curso;
            return redirect()
                ->route('cart.all', compact('busca', 'curso'))
                ->with('status', 'Aluno(a) ' . $busca->name . ' cadastrado(a) com sucesso!');
        else:
            return back()
                ->withErrors('Houve algum erro inesperado ao cadastrar aluno!');
        endif;
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
        $endereco = new Endereco();
        $config = Configuracoes::all()->first();
        if (count($aluno) > 0):
            $escola = $aluno->escola;
            $curso = $escola->cursos->lists('name', 'id');
//
            $endereco = ($aluno->endereco_id > 0 ? $endereco->find($aluno->endereco_id) : $endereco = null);

            return view('admin.carteira.edit', compact('aluno', 'curso', 'endereco', 'config'));
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
//        $endereco = new Endereco();
//        $this->validate($request, $endereco->rules);
        $this->validate($request, $this->aluno->rulesUpdate, $this->aluno->messages);
        $aluno = Aluno::find($id);


        $configuracoes = Configuracoes::all()->first();


        if (count($aluno) > 0):
            $update = $aluno->update($this->aluno->atualizarAluno($aluno, $request, $id));
//            $endereco = $endereco->updateEndereco($request, $aluno->endereco_id);
            if ($request->renovar || $request->atualizarData):
                $aluno->update(['dt_validade' => $configuracoes->dt_expiracao]);
                return redirect()->route('cart.all')->with('status', 'Carteira de ' . $aluno->name . ' renovada com sucesso!');
            else:
                return redirect()->route('cart.all')->with('status', 'Cadastro de ' . $aluno->name . ' atualizado com sucesso');
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
        if (Auth()->user()->nivel <= 1) {
            $carteira = Aluno::find($id);

            if ($carteira) {
                //verifica o "status" antes de deletar
                if (
                    ($carteira->status == "Aguadando pagamento"
                        || $carteira->status == "Em análise"
                        || $carteira->status == "Paga"
                        || $carteira->status == "Disponível"
                        || $carteira->status == "Em disputa"
                    )
                    && $carteira->dt_validade > date('Y-m-d')
                ) {
                    return back()
                        ->withErrors('Você não pode excluir o registro de ' . $carteira->name . ' pois o status atual é - ' . $carteira->status . '.');
                } else {
                    //antes de deletar o registro no banco, deleta os arquivos da pastas.
                    $carteira->delete();
                    File::delete($carteira->foto, $carteira->rg_frente, $carteira->rg_verso, $carteira->comp_matricula);
                    Endereco::find($carteira->endereco_id)->delete();
                    return back()
                        ->with('status', 'Aluno deletado com sucesso!');
                }
            } else {
                return back()
                    ->withErrors('Registro não encontrado :(.');
            }
        } else {
            return back()->withErrors('Desculpe, você não tem permisão para excluir esse arquivo');
        }

    }

    /*
     * Buscar de alunos de acordo com os parâmetros informados.
     */
    public function filtrarAluno(Request $request)
    {


        $paramBusca = $request->except('_token');

        $alunos = $this->aluno->filtrarAluno($paramBusca, 10);
        $instituicao = Escola::lists('nome', 'id');

        return view('admin.carteira.listscarteiras', compact('alunos', 'instituicao', 'paramBusca'));
    }


    /*
     * Busca o aluno de acordo com o nome informado no campo de busca. (implementado em 08/03/2019)
     */
    public function buscarAlunoPorNome(Request $nomedoaluno)
    {

        $alunos = Aluno::where('name', 'like', '%' . $nomedoaluno->name . '%')->paginate(10);
        $instituicao = Escola::lists('nome', 'id');
        if (count($alunos) == 0) {
            return $this->show()->withErrors('Desculpe, não foram encontrados resultados para "' . $nomedoaluno->name . '" :/');
        } else {
            return view('admin.carteira.listscarteiras', compact('alunos', 'instituicao'));
        }

//        dd($alunos);
    }







    ////////////////////////////////////// VERSO DA CARTEIRA \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
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
        $verso = new Verso();

        $this->validate($request, $verso->rules);

        $dir = 'campanhas';

        $dados = $request->all();
        unset($dados['img_verso']);
        unset($dados['_token']);
        $dados['user_id'] = Auth()->user()->id;
        $CreateVerso = $verso->firstOrCreate($dados);

        $CreateVerso->update(['img_verso' => Imagens::saveImage($request->img_verso, $CreateVerso->id, $dir, 600)]);


        return back()->with('status', 'Campanha criada com sucesso!');

    }

    /*
     * Qaundo clicado marca em todos os campos "status" com false
     * e depois marca o campo "status" correspondente ao $id com true.
     */
    public function ativaVerso($id)
    {
//      todos os status ficam como false
        Verso::where('id', '>=', 1)->update(['status' => false]);


//      agora, apenas os ID indicado recebe True.
        $result = Verso::find($id)->update(['status' => true]);
        return Response()->json($result);
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
    /*Método para download de arquivos
     Em 13 de março de 2019 / By. Diego FF
    */

    public function files($id, $file)
    {
        /*Encontra o aluno*/
        $aluno = Aluno::find($id);

        /*verifica qual arquivo está sendo requisitado para baixar*/
        if ($aluno){
            if ($file == 1):
                $image = $aluno->foto;
            elseif ($file == 2):
                $image = $aluno->rg_frente;
            elseif ($file == 3):
                $image = $aluno->rg_verso;
            elseif ($file == 4):
                $image = $aluno->comp_matricula;

                $fileDownload = public_path()."/".$image;
            endif;


            /*realiza o download*/
            return response()->download($fileDownload);
        }
    }

}