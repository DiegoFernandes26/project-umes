<?php

namespace App\Http\Controllers;

use App\Aluno;
use App\Emissoes;
use App\Mensagens;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class SolicitacaoCarteirasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitacoes = Aluno::where('auto_emissao',true)->get();
        if (count($solicitacoes)>0) {
            return view('admin.solicitacoes.index', compact('solicitacoes'));
        } else {
            return view('admin.solicitacoes.index',compact('solicitacoes'))->withErrors('Não há novas solicitações externas!');
        }
    }


    public function analisar($id)
    {
        $carteira = Aluno::find($id);
        if ($carteira) {
            return view('admin.solicitacoes.carteira', compact('carteira'));
        } else {
            return back()->withErrors('Registro não encontrado com o parâmetro informado.');
        }
    }

    /*
     * Altera o "status" para aprovado
     * Só é aprovada as carteiras solicitadas de fora do site principal, ou seja, as carteiras criadas pelos admins não precisão de aprovação.
     */
    public function aprovar($id)
    {
        $carteira = Aluno::find($id);
        if ($carteira) {
            $carteira->update(['status' => 'aprovado', 'view_by' => Auth()->user()->id]);
            return redirect()->route('solicitacoes.index')->with('status', 'Carteira aprovada!');
        } else {
            return back()->withErrors('Oppss! Ocorreu um erro inesperado na sua ação, tente novamente!');
        }
    }

    /*
     * Altera o "status" para reprovado
     */
    public function reprovar($id)
    {
        $carteira = Aluno::find($id);
        if ($carteira) {
            $carteira->update(['status' => 'reprovado', 'view_by' => Auth()->user()->id]);
            return redirect()->route('solicitacoes.index')->with('status', 'Carteira reprovada!');
        } else {
            return back()->withErrors('Oppss! Ocorreu um erro inesperado na sua ação, tente novamente!');
        }
    }

    /*
     * methodo criado para da o status de pendente novamente atraves da desaprovação
     */
    public function desaprovar($id){
        $carteira = Aluno::find($id);
        if($carteira){
            $carteira->update(['status'=>'pendente','view_by'=>Auth()->user()->id]);
            return back();
        }
    }



    public function aprovadas(){
        $carteiras = Aluno::where('status','aprovado')->get();
        if(count($carteiras)>0){
            return view('admin.solicitacoes.aprovadas',compact('carteiras'));
        }else{
            return view('admin.solicitacoes.aprovadas',compact('carteiras'))->withErrors('Nenhuma carteira aprovadas ainda!');
        }
    }

    public function pendentes(){
        $carteiras = Aluno::where('status','pendente')->get();
        if(count($carteiras)>0){
            return view('admin.solicitacoes.pendentes',compact('carteiras'));
        }else{
            return view('admin.solicitacoes.pendentes',compact('carteiras'))->withErrors('Nenhum carteira pendente ainda!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMensagem(Request $r, $id)
    {

        $this->validate($r, ['conteudo' => 'required']);

        $mensagem = Mensagens::create([
            'conteudo' => $r->conteudo,
            'user_id' => Auth()->user()->id,
            'aluno_id' => $id
        ]);
        return back()->with('status', 'Messagem enviada com sucesso!');
    }

    /*
     * Cria um registro de emissão na tabela "emissao" para efeito de o administrador saber quantas vezes essa carteira foi emitida.
     */
    public function emitir($id){
        $carteira = Aluno::find($id);
        if($carteira){
            $emissao = Emissoes::create(['user_id'=>Auth()->user()->id, 'aluno_id'=>$carteira->id]);//salva um registro de emissão.
            return back();
        }
    }

    /*
     * Retorna o historico de emissões e reemissões por carteria
     */
    public function historicoEmissoesPorCarteira($id){
        $carteira = Aluno::find($id);
        if($carteira){
            $emissoes = $carteira->emissoes()->get();
            if(count($emissoes)>0){
                return view('admin.solicitacoes.historico_emissoes_por_carteira',compact('emissoes','carteira'));
            }else{
                return view('admin.solicitacoes.historico_emissoes_por_carteira')->withErrors('Não há histórico de emissões para esta carteira');
            }
        }

    }
}
