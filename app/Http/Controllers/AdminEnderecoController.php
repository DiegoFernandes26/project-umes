<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Endereco;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminEnderecoController extends Controller
{
    private $Endereco;

    public function __construct(Endereco $endereco)
    {
        $this->Endereco = $endereco;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create($idEscola)
    {
        $instituicao = \App\Escola::find($idEscola);
        return view('admin.endereco.create', compact('instituicao'));
    }

    /**
     * Valida os dados / -> executa o método createEndereco() que é responsavel por criar o endereço no banco e retornar o id.
     * Depois busca a escola pelo ID da escola que vem do formulário de endereço e atualiza o campo Endereco_Id com o id do
     * endreço criado.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validação
        $this->validate($request, $this->Endereco->rules);
        //cria o endereço e retorna o id.
        $enderecoId = $this->Endereco->createEndereco($request);
        //busca a escola pelo id e atualiza, na tabela escola, o campo Endereço_id.
        $escolaUpade = \App\Escola::find($request->escola_id);
        $escolaUpade->update(['endereco_id' => $enderecoId]);

        return redirect()->action('AdminEscolaController@edit',[$request->escola_id])->with('status', 'Instituição e endereço criados com sucesso, agora vincule cursos a esta institução!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * busca a instituição pelo id informado e retorna todos os dados.*
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idEscola)
    {
        $instituicao = \App\Escola::find($idEscola);
        if(count($instituicao)>0):
            $endereco = Endereco::find($instituicao->endereco_id);
            if(count($endereco)>0):
                return view('admin.endereco.edit', compact('instituicao', 'endereco'));
            else:
                return back()->with('status','Endereço não encontrado :(');
            endif;
        else:           
            return redirect()->route('escola.list')->with('satatus', 'Instituição não encontrada :(');
        endif;
    }

    public function editAluno($id)
    {
        $aluno = \App\Aluno::find($id);
        if(count($aluno)>0):
            $endereco = Endereco::find($aluno->endereco_id);
            if(count($endereco)>0):
                return view('admin.endereco.edit', compact('instituicao', 'endereco'));
            else:
                return back()->with('status','Endereço não encontrado :(');
            endif;
        else:
            return redirect()->route('escola.list')->with('satatus', 'Instituição não encontrada :(');
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
        $this->validate($request, $this->Endereco->rules);
        $this->Endereco->find($id)->update($request->all());
        $instituição = \App\Escola::find($request->escola_id);

        return redirect()->route('escola.list')->with('status', 'Endereço da Instituição ' . $instituição->nome . ' atualizado com sucesso :)');
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
