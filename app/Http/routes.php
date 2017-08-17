<?php
use App\User;

Route::get('home', 'AdminController@index');
Route::get('/', 'Auth\AuthController@getLogin');

// Authentication routes...
Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Password reset link request routes...
Route::get('forgot', ['as' => 'password/email', 'uses' => 'Auth\PasswordController@getEmail']);
Route::post('forgot', ['as' => 'password/email', 'uses' => 'Auth\PasswordController@postEmail']);
// Password reset routes...

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('vercarteira/{id}', 'CarteiraController@vercarteiraindividual');

//Routes administrativas

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('', ['as' => 'admin', 'uses' => 'AdminController@index']);
            Route::group(['middleware' => 'auth.nivel:1'], function () {

                Route::group(['prefix' => 'config'], function () {
                    Route::get('index', ['as' => 'config.index', 'uses' => 'AdminController@indexConfig']);
                    Route::get('create', ['as' => 'config.create', 'uses' => 'AdminController@createConfig']);
                    Route::post('store', ['as' => 'config.store', 'uses' => 'AdminController@storeConfig']);
                    Route::get('edit/{id}', ['as' => 'config.edit', 'uses' => 'AdminController@editConfig']);
                    Route::put('update/{id}', ['as' => 'config.update', 'uses' => 'AdminController@updateConfig']);
                });
                Route::group(['prefix' => 'escola'], function () {
                    Route::get('', ['as' => 'escola.list', 'uses' => 'AdminEscolaController@index']);
                    Route::get('create', ['as' => 'escola.create', 'uses' => 'AdminEscolaController@new']);
                    Route::post('store', ['as' => 'escola.store', 'uses' => 'AdminEscolaController@create']);
                    Route::get('edit/{id}', ['as' => 'admin.escola.edit', 'uses' => 'AdminEscolaController@edit']);
                    Route::put('update/{id}', ['as' => 'admin.escola.update', 'uses' => 'AdminEscolaController@update']);
                    Route::get('destroy/{id}', ['as' => 'admin.escola.destroy', 'uses' => 'AdminEscolaController@destroy']);
                });

                Route::group(['prefix' => 'usuarios'], function () {
                    Route::get('register', ['as' => 'register', 'uses' => 'AdminUserController@getRegister']);
                    Route::post('register', ['as' => 'register', 'uses' => 'AdminUserController@postRegister']);
                    Route::get('list', ['as' => 'usuario.list', 'uses' => 'AdminUserController@getLists']);
                    Route::get('edit/{id}', ['as' => 'usuario.edit', 'uses' => 'AdminUserController@getEdit']);
                    Route::put('update/{id}', ['as' => 'usuario.update', 'uses' => 'AdminUserController@update']);
                    Route::get('delete/{id}', ['as' => 'usuario.delete', 'uses' => 'AdminUserController@destroy']);
                    Route::get('ativa_user/{id}', ['as' => 'usuario.ativar', 'uses' => 'AdminUserController@ativarUser']);
                });

                Route::group(['prefix' => 'cursos'], function () {
                    Route::get('list', ['as' => 'cursos.index', 'uses' => 'AdminCursosController@index']);
                    Route::post('store', ['as' => 'cursos.store', 'uses' => 'AdminCursosController@store']);
                    Route::get('edit/{id}', ['as' => 'cursos.edit', 'uses' => 'AdminCursosController@edit']);
//                    Route::get('get_cursos_jquery/{id}', ['as' => 'get_cursos_jquery', 'uses' => 'AdminCursosController@getCursos']);
                    Route::put('update/{id}', ['as' => 'cursos.update', 'uses' => 'AdminCursosController@update']);
                    Route::get('destroy/{id}', ['as' => 'cursos.destroy', 'uses' => 'AdminCursosController@destroy']);
                });

                Route::group(['prefix' => 'endereco'], function () {
                    Route::get('add/{id}', ['as' => 'endereco.add', 'uses' => 'AdminEnderecoController@create']);
                    Route::get('edit/{id}', ['as' => 'endereco.edit', 'uses' => 'AdminEnderecoController@edit']);
                    Route::put('update/{id}', ['as' => 'endereco.update', 'uses' => 'AdminEnderecoController@update']);
                    Route::post('add', ['as' => 'endereco.store', 'uses' => 'AdminEnderecoController@store']);
                });

                Route::group(['prefix' => 'relatorios'], function () {
                    // Rotas para as views
                    Route::get('ganhos_por_instituicao.index', ['as' => 'index.ganhos.por.inst', 'uses' => 'AdminRelatoriosController@indexGanhosPorInst']);
                    Route::get('carteiras_por_instituicao.index', ['as' => 'index.cart.por.inst', 'uses' => 'AdminRelatoriosController@indexCarteiraPorInst']);

                    Route::get('ganhos_por_instituicao', ['as' => 'ganhos.por.inst', 'uses' => 'AdminRelatoriosController@ganhosPorInst']);
                    Route::get('carteira_por_instituicao', ['as' => 'cart.por.inst', 'uses' => 'AdminRelatoriosController@carteiraPorInst']);
                    Route::get('total_de_instituicao', ['as' => 'all.inst', 'uses' => 'AdminRelatoriosController@allInst']);
                    Route::get('total_cursos', ['as' => 'all.cursos', 'uses' => 'AdminRelatoriosController@allCursos']);
                    Route::get('carteiras_com_isencao', ['as' => 'cart.isentas', 'uses' => 'AdminRelatoriosController@cartIsentas']);
                    Route::get('carteiras_vencidas', ['as' => 'cart.vencidas', 'uses' => 'AdminRelatoriosController@cartVencidas']);
                });

                Route::get('cart_config_verso', ['as' => 'cart.verso', 'uses' => 'CarteiraController@createCartVerso']);
                Route::post('cart_config_verso/store', ['as' => 'cart.verso.store', 'uses' => 'CarteiraController@storeCartVerso']);
                Route::get('cart/verso/delete/{id}', ['as' => 'cart.verso.excluir', 'uses' => 'CarteiraController@excluirCartVerso']);
                Route::get('ativa_verso/{id}', ['as'=>'cart.verso.ativa', 'uses'=>'CarteiraController@ativaVerso']);
            });
    });
    Route::group(['prefix' => 'user', 'middleware' => 'auth.nivel:2'], function () {
        Route::group(['prefix' => 'cart', 'middleware' => 'config'], function () {
            Route::get('list_cad', ['as' => 'cart.all', 'uses' => 'CarteiraController@show']);
            Route::get('buscar_escola', ['as' => 'cart.index', 'uses' => 'CarteiraController@index']);
            Route::get('ver_individual/{id}', ['as' => 'cart.ver_individual', 'uses' => 'CarteiraController@vercarteira']);
            Route::get('list/{name}', ['as' => 'cart.list.escola', 'uses' => 'CarteiraController@escola']);

            Route::get('create/{id}', ['as' => 'cart.create', 'uses' => 'CarteiraController@create']);
            Route::post('store', ['as' => 'cart.store', 'uses' => 'CarteiraController@store']);
            Route::get('edit/{id}', ['as' => 'cart.edit', 'uses' => 'CarteiraController@edit']);
            Route::put('update/{id}', ['as' => 'cart.update', 'uses' => 'CarteiraController@update']);
            Route::get('destroy/{id}', ['as' => 'cart.destroy', 'uses' => 'CarteiraController@destroy']);

            Route::get('cursos/{id}', 'CarteiraController@cursos');

            Route::get('pdf/{id}', ['as' => 'cart.pdf', 'uses' => 'CarteiraController@geraPDF']);
        });
    });
});
