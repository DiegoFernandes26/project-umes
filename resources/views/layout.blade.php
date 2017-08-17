<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DCE</title>

    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="{{asset('css/estilo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/carteira.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/all-animation.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/cropper.css')}}">
</head>
<body class="grey lighten-4">

<div class="container-home-princiapal">
    @yield('content')
</div>

<div class="carrega" style="display: none">
    <div class="carrega-box">
        <div class="preloader-wrapper big active ">
            <div class="spinner-layer spinner-red-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->


<!-- Modal Structure -->
<div id="aviso-modal" class="modal">
    <div class="modal-content">
        <h4 class="modal-titulo"></h4>
        <p class="conteudo-modal"></p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>


<!-- Modal Structure -->
<div id="edit-item" class="modal modal-fixed-footer">
    <div class="carregamento">
        Aguarde...
    </div>

    <div class="modal-content">
        <h4 id="titulo-modal">Carregando...</h4>
        <p id="content-edit">Carregando...</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<!-- Modal Structure -->
<div id="excluir" class="modal">
    <div class="modal-content">
        <h4>Confirmar exclusão</h4>
        <p>Ao clicar em confirmar o item <strong><span id="item">...</span></strong> será excluído permanentemente,
            tem certeza que deseja continuar com a exclusão?</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <span id="confirmar-footer"></span>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script type="text/javascript" src="{{asset('js/funcoes.js')}}"></script>
<script type="text/javascript" src="{{asset('js/cropper.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.maskMoney.js')}}"></script>
@yield('scripts')
</body>
</html>