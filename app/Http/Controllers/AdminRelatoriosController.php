<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Escola;
use App\Curso;
use App\Aluno;
use App\Configuracoes;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminRelatoriosController extends Controller
{
    protected $Aluno;
    protected $Configuracoes;
    public function __construct()
    {
        $this->Configuracoes = Configuracoes::orderBy('id')->first();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGanhosPorInst()
    {
        return view('admin.relatorios.index_ganhos_inst');
    }

    public function indexCarteiraPorInst()
    {
        return view('admin.relatorios.index_carteira_instituicao');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ganhosPorInst(Request $request)
    {
        if($request->dt_inicio && $request->dt_fim):
            $inst = Escola::where('created_at','>=',$request->dt_inicio)
                ->where('created_at','<=',$request->dt_fim)->get();
        elseif($request->dt_inicio):
           $inst = Escola::where('created_at','>=',$request->dt_inicio)->get();
        elseif($request->dt_fim):
            $inst = Escola::where('created_at','<=',$request->dt_fim)->get();
        else:
            $inst = Escola::orderBy('id','asc')->get();
        endif;
        
        $instituicao = (count($inst)>0 ? $inst : $inst = null);
        $config = $this->Configuracoes;


        if(count($instituicao)>0):        
            foreach($instituicao as $i):
                    $relatorio[] = [
                    'valor' => number_format(Aluno::where('escola_id', $i->id)->get()->sum('valor'),2,',','.'),
                    'created_at' => date('d/m/Y',strtotime($i->created_at)),
                    'valor' => number_format(Aluno::where('escola_id', $i->id)->get()->sum('valor'),2,',','.'),
                    'nome' => $i->nome
                    ];                
            endforeach;
            else:
                return back()->withErrors('Não foram encotrados dados com os paramentros informados');
            
        endif;

           $dt_inicio = date('d/m/Y',strtotime(($request->dt_inicio?$request->dt_inicio:Escola::orderBy('created_at','asc')->first()->created_at)));
           $dt_fim = date('d/m/Y',strtotime(($request->dt_fim?$request->dt_fim:date('Y-m-d'))));
        if($config):
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.relatorios.ganhos_instituicao', compact('relatorio', 'config','dt_inicio', 'dt_fim'));
        return $pdf->stream();
        endif;
    }


    public function carteiraPorInst(Request $request)
    {
        if($request->dt_inicio && $request->dt_fim):
            $inst = Escola::where('created_at','>=',$request->dt_inicio)
                ->where('created_at','<=',$request->dt_fim)->get();
        elseif($request->dt_inicio):
           $inst = Escola::where('created_at','>=',$request->dt_inicio)->get();
        elseif($request->dt_fim):
            $inst = Escola::where('created_at','<=',$request->dt_fim)->get();
        else:
            $inst = Escola::orderBy('id','asc')->get();
        endif;

        $inst = Escola::all();
        $instituicao = (count($inst)>0 ? $inst : $inst = null);

        $config = $this->Configuracoes;


        if(count($instituicao)>0):
            foreach($instituicao as $i):
                    $relatorio[] = [
                    'carteiras' => count(Aluno::where('escola_id', $i->id)->get()),
                    'created_at' => date('d/m/Y',strtotime($i->created_at)),
                    'nome' => $i->nome
                    ];                
            endforeach;
        else:
            return back()->withErrors('Não foram encotrados dados com os paramentros informados');            
        endif; 

        $dt_inicio = date('d/m/Y',strtotime(($request->dt_inicio?$request->dt_inicio:Escola::orderBy('created_at','asc')->first()->created_at)));
        $dt_fim = date('d/m/Y',strtotime(($request->dt_fim?$request->dt_fim:date('Y-m-d'))));  

        if($config):
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.relatorios.carteira_instituicao', compact('relatorio', 'config', 'dt_inicio', 'dt_fim'));
        return $pdf->stream();
        endif;
    }


    public function allInst()
    {
        $inst = Escola::orderBy('id')->get();
        $relatorio = (count($inst)>0 ? $inst : $inst = null);

        $config = $this->Configuracoes;  
             

        if($config):
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.relatorios.all_instituicao', compact('relatorio', 'config'));
        return $pdf->stream();
        endif;
    }

    public function allCursos()
    {
        $inst = Curso::orderBy('id')->get();
        $relatorio = (count($inst)>0 ? $inst : $inst = null);

        $config = $this->Configuracoes;  
             

        if($config):
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.relatorios.all_cursos', compact('relatorio', 'config'));
        return $pdf->stream();
        endif;
    }

    public function cartIsentas()
    {
        $inst = Aluno::where('pago', 0)->get();
        $relatorio = (count($inst)>0 ? $inst : $inst = null);

        $config = $this->Configuracoes;  
             

        if($config):
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.relatorios.carteiras_isentas', compact('relatorio', 'config'));
        return $pdf->stream();
        endif;
    }

    public function cartVencidas()
    {
        $dt_atual = date('Y-m-d');
        $inst = Aluno::where('dt_validade','<=', $dt_atual)->get();
        $relatorio = (count($inst)>0 ? $inst : $inst = null);

        $config = $this->Configuracoes;  
             

        if($config):
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('admin.relatorios.all_cart_vencidas', compact('relatorio', 'config'));
        return $pdf->stream();
        endif;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
