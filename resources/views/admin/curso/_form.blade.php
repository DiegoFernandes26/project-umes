<div class="col s8">
    {!! Form::label('name', 'Nome do Curso')!!}
    {!! Form::text('name', null) !!}
</div>
<div class="col s8">
        {!! Form::label('nivel', 'Nivel de ensino') !!}
        {!! Form::select('nivel',['1'=>'Fundamental', '2'=>'Médio', '3'=>'Superior', '4'=>'Pré-Enem','5'=>'Outros'], null , ['name'=>'nivel', 'class'=>'active']) !!}
</div>

