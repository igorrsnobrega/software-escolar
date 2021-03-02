<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="{{asset('../css/app.css')}}">
        <link rel="shortcut icon" href="{{'../../favicon.ico'}}" type="image/x-icon">
    </head>
    <body>
        <!-- ##### Pré loading ##### -->
        <div id="preloader">
            <div class="inner">
               <div class="bolas">
                  <div></div>
                  <div></div>
                  <div></div>                    
               </div>
            </div>
        </div>
        <!-- ##### Menu ##### -->
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg  bg-light">
            <a class="navbar-brand" href="#">Start Live</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('index') }}">Início <span class="sr-only">(current)</span></a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cadastros
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('cadastros.alunos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/aluno.svg')}}"> Alunos</a>
                            <a class="dropdown-item" href="{{ route('cadastros.cursos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/curso.svg')}}"> Cursos</a>
                            <a class="dropdown-item" href="{{ route('cadastros.modulos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/modulo.svg')}}"> Módulos</a>
                            <a class="dropdown-item" href="{{ route('cadastros.equipamentos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/equipamento.svg')}}"> Equipamentos</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Listas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('listar.alunos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/aluno.svg')}}"> Alunos</a>
                            <a class="dropdown-item" href="{{ route('listar.cursos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/curso.svg')}}"> Cursos</a>
                            <a class="dropdown-item" href="{{ route('listar.modulos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/modulo.svg')}}"> Módulos</a>
                            <a class="dropdown-item" href="{{ route('listar.equipamentos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/equipamento.svg')}}"> Equipamentos</a>
                            <a class="dropdown-item" href="{{ route('listar.contratos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/contrato.svg')}}"> Contratos</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Vínculos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('vinculos.alunos-cursos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/aluno.svg')}}"> Aluno X Cursos <img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/curso.svg')}}"></a>
                            <a class="dropdown-item" href="{{ route('vinculos.cursos-modulos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/curso.svg')}}"> Cursos X Módulos <img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/modulo.svg')}}"></a>
                            <a class="dropdown-item" href="{{ route('vinculos.modulos-equipamentos') }}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/modulo.svg')}}"> Módulos X Equipamentos <img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/equipamento.svg')}}"></a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gerar
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('gerar.contrato')}}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/contrato.svg')}}"> Contratos </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Financeiro
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('financeiro.caixa')}}"><img class="" style="width: 13px; image-color:#ccc;" src="{{asset('/img/resources/contrato.svg')}}"> Caixa </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Configurações
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('listar.acessos') }}">Acessos</a>
                            <a class="dropdown-item" href="{{ route('listar.parametros') }}">Parâmetros</a>
                            <a class="dropdown-item" href="#">Usúarios</a>
                        </div>
                    </li>
            
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        <section class="content">
            <div class="container">
                

                @yield('action')

                @if(session('success'))
                    <div class="mt-2 alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif  

                @if(session('error'))
                    <div class="mt-2 alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

                @yield('localizar')

            </div>
        </section>

        <div id="app"></div>
        <footer>
            <div class="mt-2 text-center">
                <p>{{ config('app.name') }}</p>
          </div>
        </footer>
        <script src="{{asset('./js/app.js')}}"></script>
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{asset('./js/scripts.js')}}"></script>

        @yield('scripts')

    </body>
</html>
