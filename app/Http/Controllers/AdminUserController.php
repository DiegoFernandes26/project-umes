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


    public function getEdit($id)
    {
        $user = User::find($id);
        if (count($user) > 0):
            return view('admin.users.editar', compact('user'));
        else:
            return back();
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
//        dd($request->all());
//        dd($this->User->cpfUnico($request->cpf));

        $idJaCadastrado = $this->User->cpfUnico($request->cpf);
        $emailJaCadastrado = $this->User->emailUnico($request->email);
        $celularJaCadastrado = $this->User->celularUnico($request->celular);
        if ($idJaCadastrado):
            if ($idJaCadastrado != $id):
                return back()->withInput()->with('status', 'O CPF informado já está em uso!');
            elseif ($emailJaCadastrado != $id):
                return back()->withInput()->with('status', 'O Email informado já está em uso!');
            elseif ($celularJaCadastrado != $id):
                return back()->withInput()->with('status', 'O Celular informado já está em uso!');
            else:
                $this->validate($request, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'celular' => 'required',
                    'cpf' => 'cpf|required',
                    'password' => 'required|same:confirmpassword|min:6'
                ]);
                $user = User::find($id);
                $user->update($request->all());
                return redirect()->route('usuario.list')->with('status', 'Usuário atualizado com sucesso!');
            endif;
        endif;

    }
    /*
     * Recupera o usuário através do id, caso esteja com "status" = 1 muda para "status"=0 e vice-versa.
     */
    public function ativarUser($id)
    {
        $user = User::find($id);
        if ($user):
            if($user->status == 0):
                $user->update(['status'=>1]);
            else:
                $user->update(['status'=>0]);
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
