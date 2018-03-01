<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;

class AdminUserController extends Controller
{
    protected $AuthController;

    public function __construct(AuthController $auth, User $user)
    {
        $this->AuthController = $auth;
        $this->User = $user;
    }


    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {

        $this->validate($request, $this->User->rules);

        $user = $this->AuthController->create($request->all());

        return redirect()->route('usuario.list')->with('status', "Usuário " . $user->name . " cadastrado com sucesso!");
    }

    /*
     * Lista todos os usuários do sistema.
     */
    public function getLists()
    {
        $users = $this->User->orderBy('name', 'asc')->get();

        $relation = $this->User;

        return view('admin.users.list', compact('users', 'relation'));
    }

    /*
     * Retornar um registro de usuário para ser Editado.
     * @param $id
     */
    public function getEdit($id)
    {
        $user = User::find($id);
        if (count($user) > 0):
            return view('admin.users.editar', compact('user'));
        else:
            return back()
                ->withErrors('Usuário não encontrado :(');
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
        $user = User::find($id);

        if ($user):

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => "required|email|max:255|unique:users,email,{$user->email},email",
                'celular' => "required|celular_com_ddd|unique:users,celular,{$user->celular},celular",
                'cpf' => "cpf|required|unique:users,cpf,{$user->cpf},cpf",
                'password' => 'same:confirmpassword|min:6'
            ]);

            $request['user_id'] = Auth()->user()->id;
            $user->update($request->all());
            return redirect()
                ->route('usuario.list')
                ->with('status', 'Usuário'.$user->name.' atualizado com sucesso!');
        else:
            return back()
                ->withErrors('Registro de usuário não encontrado :(');
        endif;

    }

    /*
     * Recupera o usuário através do id, caso esteja com "status" = 1 muda para "status"=0 e vice-versa.
     */
    public function ativarUser($id)
    {
        $user = User::find($id);
        if ($user):
            if ($user->status == 0):
                $user->update(['status' => 1]);
            else:
                $user->update(['status' => 0]);
            endif;
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
        $user = $this->User->find($id);
        if (count($user) > 0):
            if ($user->checkRelUser($id) != null):
                return back()->with('status', 'Este usuário não pode ser deletado enquanto possuir relacionamentos com outros registros.');
            else:
                $user->delete();
                return back()->with('status', 'Usuário deletado com sucesso!!', 10);
            endif;
        else:
            return back();
        endif;

    }
}
