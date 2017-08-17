{{--Incio mensagens de erro--}}
@if (session('status'))
    <ul class="alert-danger">
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
    {{--Fim das mensagens de erro--}}
    <div class="col s12">
        {!! Form::label('titulo', 'Titulo:') !!}
        {!! Form::text('titulo',  null, ['name'=>'titulo','placeholder'=>'Título do sistema, ex: Sistema de emissão de carteiras']) !!}
    </div>
    <div class="col s12">
        {!! Form::label('descricao', 'Orgão:') !!}
        {!! Form::text('descricao',null, ['name'=>'descricao','placeholder'=>'Digite o nome do orgão, ex: Diretório Central de Estudantes','data-length'=>'100']) !!}
    </div>
    <div class="col s3">
        {!! Form::label('valor', 'Valor da carteira:') !!}
        {!! Form::text('valor', null, ['name'=>'valor','class'=>'dinheiro']) !!}
    </div>
    <div class="col s3">
        {!! Form::label('dt_expiracao', 'Data de Expiração:') !!}
        {!! Form::text('dt_expiracao', null, ['placeholder'=>'Ex: 31/03','name'=>'dt_expiracao', 'class'=>'validade-valida']) !!}
    </div>
    <div class="col s6">
        <div class="file-field input-field">
            <div class="btn grey lighten-1 grey-text text-darken-3">
                <span><i class="material-icons left">crop_original</i>Logo</span>
                {!! Form::file('logo_sistema', null, ['name'=>'logo_sistema']) !!}
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="file-field input-field">
            <div class="btn grey lighten-1 grey-text text-darken-3">
                <span><i class="material-icons left">crop_original</i>Carteira frente</span>
                {!! Form::file('img_carteira', null, ['name'=>'img_carteira']) !!}
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
    </div>
</div>