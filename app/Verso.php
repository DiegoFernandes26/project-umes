<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verso extends Model
{
    protected $fillable = [
        'name',
        'img_verso',
        'status'
    ];

    public $rules = [
        'name' => 'required|string',
        'img_verso' => 'required|mimes:png,jpg,jpeg'
    ];

    //o methodo responsável por cadastrar verso é o storeCartVerso(Request $request) em CarteiraController.
}
