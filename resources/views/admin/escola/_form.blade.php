@include('errors.errors_message')

<!--Aqui ficam apenas os campos de formulário para serem extendidos onde precisar-->
<div class="form-group">
    {!! Form::label('nome','Nome:')!!}
    {!! Form::text('nome', null,['class'=>'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('cnpj','Cnpj:') !!}
    {!! Form::text('cnpj', null, ['class'=>'form-control']) !!}
    {{--<input type="text" class="form-control" name="name" value="{{ old('name') }}">--}}
</div>

<div class="row">
    <div class="col s2">
        {!! Form::checkbox('fundamental','fundamental', null, ['id'=>'fundamental'])!!}
        {!! Form::label('fundamental', 'Fundamental') !!}
    </div>
    <div class="col s2">
        {!! Form::checkbox('medio','medio', null, ['id'=>'medio'])!!}
        {!! Form::label('medio', 'Medio') !!}
    </div>
    <div class="col s2">
         {!! Form::checkbox('superior','superior', null, ['id'=>'superior'])!!}
        {!! Form::label('superior', 'Superior') !!}
    </div>
    <div class="col s2">
         {!! Form::checkbox('pre_enem','pre_enem', null, ['id'=>'pre_enem'])!!}
        {!! Form::label('pre_enem', 'Pré-enem') !!}
    </div>
    <div class="col s2">
         {!! Form::checkbox('outros','outros', null, ['id'=>'outros'])!!}
        {!! Form::label('outros', 'Outros') !!}
    </div>

</div>
