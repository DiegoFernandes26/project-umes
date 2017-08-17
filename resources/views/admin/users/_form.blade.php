@if (session('status'))
    <ul class="alert-danger">
        <h5 class="grey-text">Erro :(</h5>
        <li>{{ session('status') }}</li>
    </ul>
@endif

@if($errors->any())
    <ul class="alert-danger">
        <h5 class="grey-text">Erro :(</h5>
        @foreach($errors->all() as $erro)
            <li>{{$erro}}</li>
        @endforeach
    </ul>
@endif

<div class="row">
    <div class="col s4">
        <div class="col-md-6">
            {!!Form::label('name', 'Nome', ['class'=>'col-md-4 control-label']) !!}
            {!!Form::text('name', null, ['class'=>'col-md-4 control-label', 'name'=>'name']) !!}
        </div>
    </div>
    <div class="col s4">

        <div class="col-md-6">
            {!!Form::label('email', 'Email', ['class'=>'col-md-4 control-label']) !!}
            {!!Form::email('email', null, ['class'=>'col-md-4 control-label', 'name'=>'email']) !!}
        </div>
    </div>
    <div class="col s4">

        <div class="col-md-6">
            {!!Form::label('celular', 'Celular', ['class'=>'col-md-4 control-label']) !!}
            {!!Form::text('celular', null, ['class'=>'col-md-4 control-label celular-valida', 'name'=>'celular']) !!}
        </div>
    </div>


</div>

<div class="row">

    <div class="col s3">
        <div class="col-md-6">
            {!!Form::label('cpf', 'Cpf', ['class'=>'col-md-4 control-label']) !!}
            {!!Form::text('cpf', null, ['class'=>'col-md-4 control-label cpf-valida', 'name'=>'cpf']) !!}
        </div>
    </div>

    <div class="col s3">
        <div class="col-md-6">
            {!!Form::label('password', 'Senha', ['class'=>'col-md-4 control-label']) !!}
            {!!Form::password('password', null, ['class'=>'col-md-4 control-label', 'name'=>'password']) !!}
        </div>
    </div>

    <div class="col s3">
        <div class="col-md-6">
            {!!Form::label('confirmpassword', 'Confirmar Senha', ['class'=>'col-md-4 control-label']) !!}
            {!!Form::password('confirmpassword', null, ['class'=>'col-md-4 control-label', 'name'=>'password_confirmation']) !!}
        </div>
    </div>
    <div class="col s3">
        <div class="col-md-6">
            {!! Form::label('tipo', 'Nível de Usuário') !!}
            {!! Form::select('tipo',['2'=>'Usuário','1' => 'Admin'], (isset($user->nivel) ? ($user->nivel == 1 ? 1 : 2) : null) , ['name'=>'tipo']) !!}
        </div>
    </div>

</div>

