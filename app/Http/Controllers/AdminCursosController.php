<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;   

class AdminCursosController extends Controller
{
    private $Curso;

    public function __construct(Curso $curso)
    {
        $this->Curso = $curso;
    }
    public function index()
    {
        $cursos = $this->Curso->orderBy('name','asc')->get();
        $relation = $this->Curso;
        return view('admin.curso.index', compact('cursos', 'relation'));
    }

     public function getCursos($nivel)
    {
        if($nivel == 'fundamental'):
            $nivel = '1';
        endif;
        $cursos = $this->Curso->where('nivel',$nivel)->lists('name','id');
        return Response::json($cursos);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->Curso->rules);
        if($this->Curso->create($this->Curso->createCurso($request))):
            return back()->with(compact('curso'))->with('status',"Curso cadastrado com sucesso!");
        else:
            return back()->with('status','Erro ao criar curso, tente mais tarde!');
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso = $this->Curso->find($id);
        if(count($curso)>0):
            return view('admin.curso.edit', compact('curso'));
        else:
            return back()->with('status','Curso não encontrado!:/');
        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, ['name' => 'required|max:100', 'nivel' => 'required'],
        ['name.required' => 'É necessário informar um nome para o curso!' ]);

        $ifexisteCursoNome = Curso::where('name', $request->name)->where('id','!=', $id)->count();
        if($ifexisteCursoNome > 0):
            return back()->with('status', 'O nome informado já está em uso, escolha outro!');
        else:
            $name = trim(mb_strtolower($request->name));
            $curso = Curso::find($id)->update(['name'=>$name, 'nivel'=>$request->nivel]);
            if($curso):
                return back()->with('status','Curso '. $request->name.' atualizado com sucesso!');
            else:
                return back()->with('status','Erro ao editar curso, tente mais tarde!');
            endif;
        endif;
    }

    /**
     * Só remove o curso se ele ainda não possuir nenhum relacionamento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $curso = $this->Curso->find($id);
       if(count($curso)>0):
            if($curso->checkRelCursos($id) != null):
                return back()->with('status', 'Este curso não pode ser deletado pois possui relacionamentos!');
            else:
                $delete = $curso->delete();
                if($delete):
                    return back()->with('status', 'Curso deletado com sucesso!');
                else:
                    return back()->with('status', 'Erro inesperado ao deletar curso, tende mais tarde!');
                endif;
            endif;
        else:
            return back();
        endif;

    }
}
