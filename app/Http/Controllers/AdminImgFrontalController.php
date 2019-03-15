<?php

namespace App\Http\Controllers;

use App\carteira_img_frontal;
use Illuminate\Http\Request;
use File;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminImgFrontalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelosCadastrados = new carteira_img_frontal();
        $modelo = $modelosCadastrados->buscarTodosOsRegistros();

        return view('admin.config_sistema.imgFrontal.index_img_frontal', compact('modelo'));
    }







    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart_models = new carteira_img_frontal();
        $this->validate($request, $cart_models->rules);

//        chama a função que grava os dados no banco!
        $cart_models->store($request);

//      traz todos os registros do banco de dados.
        $modelo = $cart_models->buscarTodosOsRegistros();

        return back()->with('status', 'Campanha criada com sucesso!', compact('modelo'));
    }







    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ativarModelo($id)
    {
//      primeiro marcamos todos com NULL
        carteira_img_frontal::where('id','>=', '1')->update(['status' => false ]);


//      agora marcamos apenas o corresponde ao ID com TRUE
        $ativado = carteira_img_frontal::find($id)->update(['status' => true]);

        return response()->json($ativado);
        dd($id);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(Auth()->user()->nivel <= 1) {

            $modeloAserDestruido = carteira_img_frontal::find($id);
            if ($modeloAserDestruido != null) {
                File::delete($modeloAserDestruido->img_frontal);
                $modeloAserDestruido->delete();

                return back()->with('status', 'Modelo excluído com sucesso!');
            }else{
                return back()->with('status', 'Item não encontrado!');
            }
        }else{
            return back()->with('status', 'Você não tem permissão para excluir este item!');
        }


    }
}
