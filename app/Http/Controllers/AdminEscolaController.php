<?php

namespace App\Http\Controllers;

use App\Escola;
use App\Curso;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminEscolaController extends Controller
{
    private $Escola;
    private $Curso;

    public function __construct(Escola $escola, Curso $curso)
    {
        $this->Escola = $escola;
        $this->Curso = $curso;
    }

    /**Lista todas as instituições cadastradas.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $esc = $this->Escola->paginate(5);
        //instacia a classe para que se possa chamar o metodo de verificação de relacionamentos.
        $relation = $this->Escola;

        return view('admin.escola.index', compact('esc', 'relation'));
    }

    //redireciona para o formulário de cadastro de uma nova escola
    public function new()
    {
        return view('admin.escola.create');
    }


    /**Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($this->Escola->newescola($request));
        $this->validate($request, $this->Escola->rules);

        $escola = $this->Escola->create($this->Escola->newescola($request));
        if($escola):           
            $instituicao = $escola;
            return view('admin.endereco.create', compact('instituicao'));
        endif;
    }

    /**Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     *recupera o Id para edição*/

    public function edit($id)
    {
        $EscId = $this->Escola->find($id);
        $relation = $this->Curso;
        //serve apenas para deixar o checkbox marcador caso haja alguma correspondência
        //dd($EscId);
        if ($EscId):
            $cursoId = $EscId->cursos->lists('id');
            $cId = [];
            foreach ($cursoId as $id):
                $cId[] = $id;
            endforeach;
            $dados = [];
            if ($EscId->fundamental == 1 || $EscId->medio == 1 || $EscId->superior == 1 || $EscId->pre_enem == 1 || $EscId->outros == 1):
                if ($EscId->fundamental == 1):
                    $curso[] = $this->Curso->where('nivel', 1)->orderBy('nivel', 'asc')->get();
                endif;
                if ($EscId->medio == 1):
                    $curso[] = $this->Curso->where('nivel', 2)->orderBy('nivel', 'asc')->get();
                endif;
                if ($EscId->superior == 1):
                    $curso[] = $this->Curso->where('nivel', 3)->orderBy('nivel', 'asc')->get();
                endif;
                if ($EscId->pre_enem == 1):
                    $curso[] = $this->Curso->where('nivel', 4)->orderBy('nivel', 'asc')->get();
                endif;
                if ($EscId->outros == 1):
                    $curso[] = $this->Curso->where('nivel', 5)->orderBy('nivel', 'asc')->get();
                endif;
            else:
                $curso = null;
            endif;
            foreach ($curso as $c):
                foreach ($c as $d):
                    $dados[] = $d;
                endforeach;
            endforeach;
            $curso = $dados;
//            dd($curso);
            return view('admin.escola.edit', compact('EscId', 'curso', 'cId', 'relation'));
        endif;
    }


    /**Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //verifica se o CNPJ informado já está em uso por outro registro.
        //se não estive sendo usado procegue com a atualização.
        $cnpjUnico = $this->Escola->cnpjUnico($request->cnpj);
        if ($cnpjUnico && $cnpjUnico != $id):
            return back()->withInput()->with('status', 'O CNPJ informado já está em uso. Tente outro!');
        else:
            $this->validate($request, ['nome' => 'required', 'cnpj' => 'required|cnpj']);
            $escolaUp = $this->Escola->find($id);
            $up = $escolaUp->update($this->Escola->newescola($request));

            //cria o relaciontamento na tabela pivô "curso_escola".
            $cursoId = [];
            if ($request->curso_id):
                foreach ($request->curso_id as $Id):
                    $cursoId[] = Curso::find($Id)->id;
                endforeach;
            endif;
            $escolaUp->cursos()->sync($cursoId);

            return redirect()->route('escola.list')->with('status', 'Escola ' . $request->nome . ' atualizado com sucesso!');
        endif;

    }


    /**Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $escola = $this->Escola->find($id);
        if (count($escola) > 0):
            if ($escola->checkRelEscola($id) != null):
                return back()->with('status', 'Esta instituição não pode se deletada pois possui relacionamentos');
            else:
                $escola->cursos()->detach();
                $escola->delete();

                return back()->with('status', 'Instituição ' . $escola->nome . ' excluida com sucesso!');
            endif;
        else:
            return back();
        endif;
    }

    /*
     * Retorna os cursos de acordo com o nivel de escola
     */
    private function getCursosPorNivel($idEscola)
    {
        $EscId = $this->Escola->find($idEscola);

        if ($EscId->superior == 1 && $EscId->profissionl == 1):
            $curso = $this->Curso->where('nivel', '=>', 3)->get();
        elseif ($EscId->superior == 1 && $EscId->profissionl == 0):
            $curso = $this->Curso->where('nivel', 3)->get();
        else:
            $curso = $this->Curso->where('nivel', 4)->get();
        endif;
    }
}
