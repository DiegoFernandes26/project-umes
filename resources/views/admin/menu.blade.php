{{--{!! dd($pessoa) !!}--}}
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content ">
    <li><a href="#!">Perfil</a></li>
    <li><a href="#!">Suporte</a></li>
    <li class="divider"></li>
    <li><a href="{{route('logout')}}">Sair</a></li>
</ul>
<nav class="menu-home white menu-principal">
    <div class="nav-wrapper">
        <div data-activates="slide-out" class="button-collapse bt-menu"><i
                    class="material-icons grey-text text-darken-4">menu</i></div>


        <ul class="left-align">
            <li class="brand-logo">
                <div class="center-align">
                    <h5><img class="logo-lc pulse" src="{{asset('img/logo.png')}}"></h5>
                </div>

            </li>
        </ul>


        <ul class="right hide-on-med-and-down">

            <li><i class="material-icons grey-text text-darken-4">account_circle</i></li>
            <!-- Dropdown Trigger -->
            <li><a class="dropdown-button grey-text text-darken-4" href="#"
                   data-activates="dropdown1">{{Auth::user()->name}}<i class="material-icons right">arrow_drop_down</i></a>
            </li>
        </ul>
    </div>
</nav>


<!-- // imagem do gravatar -->
<?php
$email = Auth::user()->email;
$default = "https://www.somewhere.com/homestar.jpg";
$size = 100;
$grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
?>
<!-- // imagem do gravatar -->

<!-- menu lateral -->
<ul id="slide-out" class="side-nav" style="display: block">
    <li>
        <div class="userView cyan">
            <div class="background">

            </div>
            <a href="#!user">
                <img class="circle foto-perfil" src="{{ $grav_url }}">
            </a>
            <a href="#!name"><span class="white-text name">{{Auth::user()->name}}</span></a>
            <a href="#!email"><span class="white-text email">{{Auth::user()->email}}</span></a>
        </div>
    </li>

    @if (Request::path() != 'admin')
        <li class="grey lighten-3"><a href="{{route('admin')}}"><i class="material-icons">home</i>Home</a></li>
        <li>
            <div class="divider"></div>
        </li>
    @endif

    @if(Auth()->user()->nivel <= 1)
        <li><a href="{{route('escola.list')}}"><i class="material-icons">business</i>Instituições</a></li>
        <li><a href="{{route('cursos.index')}}"><i class="material-icons">school</i>Cursos</a></li>
        <li><a href="{{route('usuario.list')}}"><i class="material-icons">person</i>Usuários</a></li>
    @endif
    <li>
        <div class="divider"></div>
    </li>
    <li class="grey-text">
        <h5 style="padding-left: 30px; text-transform: uppercase; font-weight: 700">Carteira</h5>
    </li>
    <li><a href="{{route('cart.all')}}"><i class="material-icons">credit_card</i>Carteira</a></li>
    @if(Auth()->user()->nivel <= 1)
    <li><a href="{{route('cart.verso')}}"><i class="material-icons">filter</i>Campanha</a></li>
    @endif
    <li>
        <div class="divider"></div>
    </li>

    @if(Auth()->user()->nivel <= 1)
        <li><a href="{{route('config.index')}}"><i class="material-icons">settings</i>Configurações</a></li>
    @endif

</ul>
<!-- menu lateral -->