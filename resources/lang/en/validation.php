<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => '":attribute" deve ser aceito.',
    'active_url'           => '":attribute" não é uma URL válida.',
    'after'                => '":attribute" deve ser uma data depois de :date.',
    'alpha'                => '":attribute" deve conter somente letras.',
    'alpha_dash'           => '":attribute" deve conter letras, números e traços.',
    'alpha_num'            => '":attribute" deve conter somente letras e números.',
    'array'                => '":attribute" deve ser um array.',
    'before'               => '":attribute" deve ser uma data antes de :date.',
    'between'              => [
        'numeric' => '":attribute" deve estar entre :min e :max.',
        'file'    => '":attribute" deve estar entre :min e :max kilobytes.',
        'string'  => '":attribute" deve estar entre :min e :max caracteres.',
        'array'   => '":attribute" deve ter entre :min e :max itens.',
    ],
    'boolean'              => '":attribute" deve ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação de ":attribute" não confere.',
    'date'                 => '":attribute" não é uma data válida.',
    'date_format'          => '":attribute" não confere com o formato :format.',
    'different'            => '":attribute" e :other devem ser diferentes.',
    'digits'               => '":attribute" deve ter :digits dígitos.',
    'digits_between'       => '":attribute" deve ter entre :min e :max dígitos.',
    'email'                => '":attribute" deve ser um endereço de e-mail válido.',
    'exists'               => 'O ":attribute" selecionado é inválido.',
    'filled'               => '":attribute" é um campo obrigatório.',
    'image'                => '":attribute" deve ser uma imagem.',
    'in'                   => '":attribute" é inválido.',
    'integer'              => '":attribute" deve ser do tipo inteiro.',
    'ip'                   => '":attribute" deve ser um endereço IP válido.',
    'json'                 => '":attribute" deve ser um JSON válido.',
    'max'                  => [
        'numeric' => '":attribute" não deve ser maior que :max.',
        'file'    => '":attribute" não deve ter mais que :max kilobytes.',
        'string'  => '":attribute" não deve ter mais que :max caracteres.',
        'array'   => '":attribute" não deve ter mais que :max itens.',
    ],
    'mimes'                => '":attribute" deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => '":attribute" deve ser no mínimo :min.',
        'file'    => '":attribute" deve ter no mínimo :min kilobytes.',
        'string'  => '":attribute" deve ter no mínimo :min caracteres.',
        'array'   => '":attribute" deve ter no mínimo :min itens.',
    ],
    'not_in'               => 'O ":attribute" selecionado é inválido.',
    'numeric'              => '":attribute" deve ser um número.',
    'regex'                => 'O formato de ":attribute" é inválido.',
    'required'             => 'O campo ":attribute" é obrigatório.',
    'required_if'          => 'O campo ":attribute" é obrigatório quando :other é :value.',
    'required_unless'      => 'O ":attribute" é necessário a menos que :other esteja em :values.',
    'required_with'        => 'O campo ":attribute" é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo ":attribute" é obrigatório quando :values estão presentes.',
    'required_without'     => 'O campo ":attribute" é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo ":attribute" é obrigatório quando nenhum destes estão presentes: :values.',
    'same'                 => '":attribute" e ":other" devem ser iguais.',
    'size'                 => [
        'numeric' => '":attribute" deve ser :size.',
        'file'    => '":attribute" deve ter :size kilobytes.',
        'string'  => '":attribute" deve ter :size caracteres.',
        'array'   => '":attribute" deve conter :size itens.',
    ],
    'string'               => ':attribute deve ser uma string',
    'timezone'             => ':attribute deve ser uma timezone válida.',
    'unique'               => 'O ":attribute" informado já está em uso em nosso sistema.',
    'url'                  => 'O formato de ":attribute" é inválido.',
    

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name'              => 'Nome',
        'email'             => 'E-mail',
        'rg'                => 'RG',
        'cpf'               => 'CPF',
        'password'          => 'Senha',
        'confirmpassword'   => 'Confirmar Senha',
        'login'             => 'Login',
        'register'          => 'Cadastrar-se',
        'remember'          => 'Relembre esta senha',
        'forgotpassword'    => 'Esqueci minha senha.',
        'dt_nascimento'     => 'Data de nascimento',
        'foto'              => 'Foto',
        'curso_id'          => 'Curso',
        'dt_expiracao'      => 'Data de Expiração',
        'titulo'            => 'Título',
    ],

];

//Para utilizar a validação agora, basta fazer o procedimento padrão do Laravel.
//
//A diferença é que agora, você terá os seguintes métodos de validação:
//
//celular - Valida um celular através do formato 99999-9999 ou 9999-9999
//
//celular_com_ddd - Valida um celular através do formato (99)99999-9999 ou (99)9999-9999
//
//cnpj - Valida se o CNPJ é valido. Para testar, basta utilizar o site http://www.geradorcnpj.com/
//
//cpf - Valida se o cpf é valido. Para testar, basta utilizar o site http://geradordecpf. org
//
//data - Valida se a data está no formato 31/12/1969
//
//formato_cnpj - Valida se a mascará do CNPJ é válida
//
//formato_cpf - Valida se a mascará do cpf está certo. 999.999.999-99
//
//formato_cep - Valida se a mascará do cep está certa. 99999-999 ou 99.999-999
//
//telefone - Valida um telefone através do formato 9999-9999
//
//telefone_com_ddd - Valida um telefone através do formato (99)9999-9999
