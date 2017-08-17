<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'cpf' => $faker->numberBetween(0,9),
        'nivel' => $faker->numberBetween(1,3),
        'status' => $faker->numberBetween(0,2),
        'celular' => $faker->phoneNumber,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Aluno::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'sexo' => 'm',
        'rg' => $faker->randomNumber(6),
        'cpf' => $faker->randomNumber(9),
        'org_expedidor' => 'ssp',
        'dt_nascimento' => $faker->date(),
        'mae' => $faker->name,
        'matricula' => $faker->randomNumber(9)
    ];
});

$factory->define(App\Escola::class, function (Faker\Generator $faker) {
    return [
        'nome' => $faker->name,
        'cnpj' => $faker->randomNumber(7)
    ];
});

$factory->define(App\Curso::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->randomElement(['1ª série', '2º Série', '3º Série', '4º Série', '5º Série', '6º Série', '7º Série', '8º Série', '2º Série', '9º Série']),
        'nivel' => 1
    ];
});

$factory->define(App\Endereco::class, function (Faker\Generator $faker) {
    return [
        'cep' => '69.909-202',
        'endereco' => $faker->streetName,
        'bairro' => $faker->word,
        'cidade' => $faker->name,
        'estado' => $faker->name,
        'complemento' => $faker->paragraph
    ];
});