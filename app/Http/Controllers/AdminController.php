<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aluno;
use App\Escola;
use Input;
use App\Endereco;
use App\Configuracoes;
use Carbon\Carbon;
use App\Http\Requests;
use App\Imagens;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private $Aluno;
    private $Configuracoes;

    public function __construct(Aluno $aluno)
    {
        $this->Aluno = $aluno;
        $this->Configuracoes = new Configuracoes();
    }

//    public function auth(){
//        $user = \App\User::find(1);
//        Auth::login($user);
//    }

    /**@return \Illuminate\Http\Response */
    public function index()
    {
        $dt = new Carbon();
        $escola = Escola::lists('id');
        $carteira = $this->Aluno->orderBy('id')->get();

        $ontem = $dt->yesterday();
        $amanha = $dt->tomorrow();

        $cartEmitidasHj = $this->Aluno->where('created_at', '>', $ontem)->where('created_at', '<', $amanha)->get();
        $hj = count($cartEmitidasHj);

        $valorHj = number_format($this->Aluno->where('created_at', '>', $ontem)->where('created_at', '<', $amanha)->get()->sum(['valor']), 2, ',', '.');
//        dd(number_format($valorHj,2,',','.'));
        return view('admin.home', compact('escola', 'carteira', 'hj', 'valorHj'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexConfig()
    {
        $config = Configuracoes::orderBy('id')->first();
        if (count($config) > 0):
            return view('admin.config_sistema.edit', compact('config'));
        else:
            return view('admin.config_sistema.create');
        endif;
    }

    public function createConfig()
    {
        return view('admin.config_sistema.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeConfig(Request $request)
    {
        $this->validate($request, $this->Configuracoes->rules);

        $this->Configuracoes->createConfig($request);
        return redirect()->route('admin')->with('status', 'Configurado com sucesso!');
    }

    /**
     * Redireciona para a view edit com os dados a serem editados.
     */
    public function editConfig($id)
    {
        $sistema = Configuracoes::find($id);
        if (count($sistema) > 0):
            return view('admin.config_sistema.edit', compact('sistema'));
        else:
            return back()->with('status', '<sapan class="error">Não foram encontrados dados com o parâmetros informado!</sapan>');
        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateConfig(Request $request, $id)
    {
//        dd($request->all());
        $this->validate($request, $this->Configuracoes->rules);
        $dados = Configuracoes::find($id);
        if($dados):
            $this->Configuracoes->createConfig($request, $dados);
            return back()->withErrors(array('logo_sistema' => 'Atualizado com sucesso!'));
        else:
            return back()->withErrors('Ocorreu um erro inesperado ao tentar atualizar, tente novamente!');
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
