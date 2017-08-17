@extends('layout')
@section('content')
    @include('admin.menu')

    <div class="container top__cem">


        <h3 class="grey-text">CADASTRAR <strong>ESCOLA</strong></h3>

        {!! Form::open(['route'=>'escola.store','method'=>'post']) !!}

        @include('admin.escola._form')

        {{--<h4>Cursos</h4>--}}

        {{--@foreach($curso as $cur)--}}
            {{--<ul>--}}
                {{--<li>--}}
                    {{--<div class="col s3">--}}

                        {{--{!! Form::checkbox('curso_id[]',$cur->id, (in_array($cur->id, $cId)?true:false), ['id'=>$cur->name])!!}--}}

                        {{--{!! Form::label($cur->name, $cur->name) !!}--}}

                    {{--</div>--}}
                {{--</li>--}}
            {{--</ul>--}}

        {{--@endforeach--}}

        {!! Form::submit('Próximo passo',['class'=>'waves-effect waves-light btn margin__vinte']) !!}

        {!! Form::close() !!}

    </div>
@stop