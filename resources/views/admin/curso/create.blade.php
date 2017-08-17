@if($errors->any())
    <ul class="alert-danger">
        <h5 class="grey-text">Erro :(</h5>
        @foreach($errors->all() as $erro)
            <li>{{$erro}}</li>
        @endforeach
    </ul>
@endif


<!-- Modal Structure -->
{!! Form::open(['route'=>'cursos.store', 'method'=>'post']) !!}
<div id="cad-curso" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4>Cadastrar novo curso</h4>


        <div class="row">
            <div class="col l12">
                @include('admin.curso._form')
            </div>

        </div>


    </div>
    <div class="modal-footer">
        {!! Form::submit('CADASTRAR',['class'=>'btn waves-effect waves-green btn-flat'])!!}
    </div>

    {!! Form::close() !!}
    {{--FORM - fim--}}
</div>