<div class="row">
    @include('errors.errors_message')
    <fieldset>
        <legend>Endereço:</legend>

        <div class="col s3">
            <div class="col-md-6">
                {!!Form::label('cep', 'Cep', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('cep', null, ['placeholder'=>'CEP','class'=>'col-md-4 control-label', 'name'=>'cep', 'id'=>'cep']) !!}
            </div>
        </div>
        <div class="col s4">
            <div class="col-md-6">
                {!!Form::label('endereco', 'Endereço', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('endereco',null,['placeholder'=>'Rua Exemplo','class'=>'col-md-4 control-label', 'name'=>'endereco', 'id'=>'endereco']) !!}
            </div>
        </div>
        <div class="col s1">
            <div class="col-md-6">
                {!!Form::label('numero', 'Numero', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('numero', null, ['placeholder'=>'Número','class'=>'col-md-4 control-label', 'name'=>'numero', 'id'=>'numero']) !!}
            </div>
        </div>

        <div class="col s4">
            <div class="col-md-6">
                {!!Form::label('bairro', 'bairro', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('bairro', null, ['placeholder'=>'Bairro','class'=>'col-md-4 control-label', 'name'=>'bairro', 'id'=>'bairro']) !!}
            </div>
        </div>


        <div class="col s4">
            <div class="col-md-6">
                {!!Form::label('cidade', 'Cidade', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('cidade', null, ['placeholder'=>'Cidade','class'=>'col-md-4 control-label', 'name'=>'cidade','id'=>'cidade']) !!}
            </div>
        </div>

        <div class="col s4">
            <div class="col-md-6">
                {!!Form::label('estado', 'UF', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('estado', null, ['placeholder'=>'UF','class'=>'col-md-4 control-label', 'name'=>'estado','id'=>'uf']) !!}
            </div>
        </div>

        <div class="col s4">
            <div class="col-md-6">
                {!!Form::label('complemento', 'Complemento', ['class'=>'col-md-4 control-label']) !!}
                {!!Form::text('complemento', null, ['placeholder'=>'Complemento','name'=>'complemento']) !!}
            </div>
        </div>
    </fieldset>
</div>