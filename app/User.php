<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'nivel',
        'celular',
        'email',
        'user_id',
        'password',
        'status'
    ];

    public $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'celular' => 'required|celular_com_ddd|unique:users',
        'cpf' => 'cpf|required|size:14|unique:users',
        'password' => 'required|same:confirmpassword|min:6',
    ];

    public function aluno()
    {
        return $this->hasMany('App\Aluno');
    }

    public function escola()
    {
        return $this->hasMany('App\Escola');
    }

    public function curso()
    {
        return $this->hasMany('App\Curso');
    }

    public function autoRel()
    {
        return $this->hasMany('App\User','user_id');
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Serve apenas para verificar ja existe algum id vi.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
     public function checkRelUser($id)
     {
         if(count(User::find($id)->escola)>0):
             return true;
         elseif(count(User::find($id)->aluno)>0):
             return true;
         elseif(count(User::find($id)->autoRel)>0):
             return true;
         else:
             return null;
         endif;
     }

    public function cpfUnico($cpf)
    {
        $cpf = User::where('cpf', $cpf)->first();
        $cpf = ($cpf ? $cpf : $cpf = false);
        if ($cpf):
            return $cpf->id;
        else:
            return false;
        endif;
    }

    public function emailUnico($email)
    {
        $email = User::where('email', $email)->first();
        $email = ($email ? $email : $email = false);
        if ($email):
            return $email->id;
        else:
            return false;
        endif;
    }

    public function celularUnico($celular)
    {
        $celular = User::where('celular', $celular)->first();
        $celular = ($celular ? $celular : $celular = false);
        if ($celular):
            return $celular->id;
        else:
            return false;
        endif;
    }
}
