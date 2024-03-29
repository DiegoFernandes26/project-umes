<!--Aqui ficam apenas os campos de formulário para serem extendidos onde precisar-->
<div class="col s3">
    <div class="switch right-align">
        <label>
            Grátis
            {!! Form::checkbox('pago', true, (isset($aluno)?($aluno->pago != false?true:false):true)) !!}
            <span class="lever red accent-1"></span>
            Pago
        </label>
    </div>
</div>

<div class="row">
    <fieldset>
        <legend>Dados pessoais:</legend>
        <div class="col s4">
            {!! Form::label('name','*Nome:')!!}
            {!! Form::text('name', null,['placeholder'=>'Nome do aluno','class'=>'form-control']) !!}
        </div>
        <div class="col s4">
            {!! Form::label('name_social','Nome Social:')!!}
            {!! Form::text('name_social', null,['placeholder'=>'Nome social do aluno','class'=>'form-control']) !!}
        </div>

        <div class="col s4">
            {!! Form::label('dt_nascimento','*Data de Nascimento:') !!}
            {!! Form::date('dt_nascimento', null, ['placeholder'=>'Data de nascimento']) !!}
        </div>

        <div class="col s3">
            {!! Form::label('rg','*RG:') !!}
            {!! Form::text('rg', null, ['placeholder'=>'RG']) !!}
        </div>
        <div class="col s3">
            {!! Form::label('org_expedidor','*Orgão Expedidor:') !!}
            {!! Form::text('org_expedidor', null, ['placeholder'=>'Orgão Expedidor do RG','name'=>'org_expedidor']) !!}
        </div>
        <div class="col s3">
            {!! Form::label('matricula','*Matricula:') !!}
            {!! Form::text('matricula', null, ['placeholder'=>'Matricula','name'=>'matricula']) !!}
        </div>

        <div class="col s3">
            {!! Form::label('cpf','*Cpf:') !!}
            {!! Form::text('cpf', null, ['placeholder'=>'Número do CPF','class'=>'cpf-valida']) !!}
        </div>

        <div class="col s3">
            {!! Form::label('sexo','*Sexo:') !!}
            {!! Form::select('sexo', ['m'=>'masculino','f'=>'feminino'] , null, ['placeholder'=>'Sexo','name'=>'sexo'] )!!}
        </div>

        <div class="col s3">
            {!! Form::label('celular','Celular:') !!}
            {!! Form::text('celular', null, ['placeholder'=>'Número do celular','name'=>'celular', 'class'=>'celular-valida']) !!}
        </div>
        <div class="col s3">
            {!! Form::label('tel_fixo','Telefone Fixo:') !!}
            {!! Form::text('tel_fixo', null, ['placeholder'=>'Número do telefone fixo','name'=>'tel_fixo', 'class'=>'fixo-valida']) !!}
        </div>
        <div class="col s3">
            {!! Form::label('email','Email:') !!}
            {!! Form::email('email', null, ['placeholder'=>'email.exemplo@user.com','name'=>'email']) !!}
        </div>

        <div class="col s4">
            {!! Form::label('mae','*Mãe:') !!}
            {!! Form::text('mae', null, ['placeholder'=>'Nome da Mãe', 'name'=>'mae']) !!}
        </div>

        <div class="col s4">
            {!! Form::label('curso_id','*Curso:') !!}
            {!! Form::select('curso_id', $curso , null, ['placeholder'=>'Selecionar Curso', 'name'=>'curso_id'] )!!}
        </div>

        <div class="col s1">
            {!! Form::label('periodo','Período:') !!}
            {!! Form::text('periodo', null, ['placeholder'=>'Período', 'name'=>'periodo']) !!}
        </div>


        <?php $config = \App\Configuracoes::all()->first()->dt_expiracao ?>
        @if(isset($aluno))
            <div class="col s2">
                <span>Válida até:</span><br>
                <p class="{{(isset($aluno)?(date('Y')!= date('Y',strtotime($aluno->dt_validade))?($aluno->dt_validade < date('Y-m-d')?'red':'blue'):'orange'):'')}}-text">
                    {{date('d-m-Y',strtotime($aluno->dt_validade))}}
                </p>
            </div>
        @else
            <div class="col s2">
                <span>Válida até:</span><br>
                <p class="{{(date('Y')!= date('Y',strtotime($config))?($config <= date('Y-m-d')?'red':''):'orange')}}-text">
                    {{date('d-m-Y',strtotime($config))}}
                </p>
            </div>
        @endif

    </fieldset>
</div>

<div class="row">
    <fieldset>
        <legend>Docs Digitalizados:</legend>

        <div class="row">
            {{--preview da foto principal--}}
            <div class="col s3">
                <div class="fotoPreview fotoPreview-perfil flex-box">
                    <div id="foto-perfil"></div>
                    <div class="arrow-down"></div>
                </div>
            </div>
            {{--preview da foto principal--}}

            {{--preview da foto principal--}}
            <div class="col s3">
                <div class="fotoPreview flex-box rg-frente-preview">
                    <div id="rg-frente-preview"></div>
                    <div class="arrow-down"></div>
                </div>
            </div>
            {{--preview da foto principal--}}

            {{--preview da foto principal--}}
            <div class="col s3">
                <div class="fotoPreview flex-box rg-verso-preview">
                    <div id="rg-verso-preview"></div>
                    <div class="arrow-down"></div>
                </div>
            </div>
            {{--preview da foto principal--}}

            {{--preview da foto principal--}}
            <div class="col s3">
                <div class="fotoPreview flex-box matricula-preview">
                    <div id="matricula-preview"></div>
                    <div class="arrow-down"></div>
                </div>
            </div>
            {{--preview da foto principal--}}
        </div>





        {{--foto da pessoa--}}
        <div class="col s3">
            {{--        {!! Form::label('foto','Foto:') !!}--}}
            <div class="file-field input-field">
                <div class="btn grey lighten-2 grey-text text-darken-4">
                    <span>*Foto do aluno</span>
                    {!! Form::file('foto',['class'=>'form-control', 'id'=>'foto']) !!}
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Foto">
                </div>
            </div>

            {{--Se existir a variavel aluno e se tiver algum aruqivo ele disponibiliza o download--}}
            @if(isset($aluno) && file_exists($aluno->foto))
                <div>
                    {{--<a href="{{asset($aluno->foto   )}}">Baixar</a>--}}
{{--                    {!! Html::link($aluno->foto,'Baixar foto') !!}--}}
                    <a href="{{route('cart.files', ['id'=>$aluno->id, 'file'=>1])}}" class="testo-list">Baixar Arquivo - 1</a>
                </div>
            @endif
        </div>
        {{--foto da pessoa--}}



        {{--foto da rg frente--}}
        <div class="col s3">
            {{--        {!! Form::label('foto','Foto:') !!}--}}
            <div class="file-field input-field">
                <div class="btn grey lighten-2 grey-text text-darken-4">
                    <span>RG Frente</span>
                    {!! Form::file('rg_frente',['class'=>'form-control', 'id'=>'rg-frente']) !!}
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="RG Frente">
                </div>
            </div>

            {{--Se existir a variavel aluno e se tiver algum aruqivo ele disponibiliza o download--}}
            @if(isset($aluno) && file_exists($aluno->rg_frente))
                <div>
                    <a href="{{route('cart.files', ['id'=>$aluno->id, 'file'=>2])}}" class="testo-list">Baixar Arquivo - 2</a>
                </div>
            @endif
        </div>

        {{--foto da rg frente--}}

        {{--foto da rg verso--}}
        <div class="col s3">
            {{--        {!! Form::label('foto','Foto:') !!}--}}
            <div class="file-field input-field">
                <div class="btn grey lighten-2 grey-text text-darken-4">
                    <span>RG Verso</span>
                    {!! Form::file('rg_verso', ['class'=>'form-control', 'id'=>'rg-verso']) !!}
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="RG Verso">
                </div>
            </div>

            {{--Se existir a variavel aluno e se tiver algum aruqivo ele disponibiliza o download--}}
            @if(isset($aluno) && file_exists($aluno->rg_verso))
                <div>
                    <a href="{{route('cart.files', ['file'=>$aluno->rg_verso])}}" class="testo-list">Baixar Arquivo - 3</a>
                </div>
            @endif
        </div>
        {{--foto da rg verso--}}
        {{--foto da rg verso--}}
        <div class="col s3">
            {{--        {!! Form::label('foto','Foto:') !!}--}}
            <div class="file-field input-field">
                <div class="btn grey lighten-2 grey-text text-darken-4">
                    <span>Comp. Matrícula</span>
                    {!! Form::file('comp_matricula', ['class'=>'form-control', 'id'=>'matricula']) !!}
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Comprovante">
                </div>
            </div>

            {{--Se existir a variavel aluno e se tiver algum aruqivo ele disponibiliza o download--}}
            @if(isset($aluno) && file_exists($aluno->comp_matricula))
                <div>
                    <a href="{{asset($aluno->comp_matricula)}}">Baixar</a>
                    {{--{!! Html::link('download/filename.ext','filename') !!}--}}
                    {{--<a target="_blank" href="{{route('cart.files', ['file'=>$aluno->comp_matricula])}}" class="testo-list">Baixar Arquivo - 4</a>--}}
                </div>
            @endif
        </div>
        {{--foto da rg verso--}}


    </fieldset>
</div>



{{--@include('admin.endereco._form')--}}
@if(isset($aluno))
    <div class="row">
        <button class="btn red">

            @if($aluno->endereco_id != 0)
                <a href="{{route('edit.endereco.aluno',$aluno->id)}}">Editar endereço</a>
            @else
                <a href="{{route('create.endereco.aluno',$aluno->id)}}">Informar endereço</a>
            @endif

        </button>
    </div>
@endif
{!! Form::hidden('escola_id', (isset($id) ? $id : $aluno->escola->id)) !!}