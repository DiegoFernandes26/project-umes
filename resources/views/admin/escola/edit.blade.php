@extends('layout')
@section('content')
    @include('admin.menu')
    <div class="container top__cem">
        <div class="chip">Editar</div>
        <h3 class="grey-text"> Instituição: <strong>{{$EscId->nome}}</strong></h3>

        {{--Estamos utilizando aqui o form model bind--}}
        {!! Form::model($EscId,['route'=>['admin.escola.update', $EscId->id],'method'=>'put']) !!}

        @include('admin.escola._form')
        <div>            
            <div class="row">
                <div class="col s12">

                    <h5 class="grey-text margin__vinte">Cursos</h5>

                    @if(isset($curso))
                        @foreach($curso as $cur)

                            <ul>
                                <li>
                                    <div class="col s3" id="cursos">

                                       {!! Form::checkbox('curso_id[]',$cur->id, (in_array($cur->id, $cId)?true:false), ['id'=>$cur->name, ($relation->checkRelCursosAluno($EscId->id, $cur->id)!=null? 'disabled' : '')])!!}

                                        {!! Form::label($cur->name, $cur->name) !!}

                                    </div>
                                </li>
                            </ul>

                        @endforeach
                        @else
                        <h4 class="grey-text">Selecione um nível de ensino para a instituição para poder vincular a um curso.</h4>
                    @endif
                </div>
            </div>

            {{--seleciona o curso de acordo com o checkbox marcado--}}
            {{--<script type="text/javascript">--}}
            {{--$(document).ready(function () {--}}
        {{----}}
                {{--$("input[type=checkbox][name='fundamental']:checked").change(function(){--}}
                    {{--var nivel = $(this).val();--}}

                    {{--$.get('/admin/cursos/get_cursos_jquery/'+nivel, function (cursos){--}}
                        {{--$('#cursos').empty();--}}
                        {{--$.each(cursos, function (key, value){--}}
                            {{--$('#cursos').append('<li><div class="col s3" ><input type="checkbox" name="'+value+'" value="'+key+'">' + value+ '</div></li>');--}}
                        {{--});--}}
                    {{--});--}}
                {{--});--}}
            {{--});--}}
            {{--</script>--}}

        </div>
        <div class="row">
            {!! Form::submit('Salvar Alterações',['class'=>'btn btn-primary']) !!}
            @if($EscId->endereco_id)
                <a href="{{route('endereco.edit', ['id' =>$EscId->id])}}"
                   class="waves-effect waves-light btn  red darken-3">Editar endereço</a>
            @else
                <a href="{{route('endereco.add', ['id' =>$EscId->id])}}"
                   class="waves-effect waves-light btn cyan">Add endereço</a>
            @endif
        </div>

        {!! Form::close() !!}
    </div>
@stop