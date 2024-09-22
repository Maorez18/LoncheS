<div class="row">
    <header class="d-flex flex-wrap justify-content-center p-3 px-5 menuDash align-items-center sticky-top">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img class="img-fluid" src="{{asset('assets/img/logos/logo_LoncheS.webp')}}" alt="Logo LoncheS" style="width: 100px">
        </a>
        <ul class="nav nav-pills bg-dark rounded p-2">
            <li class="nav-item"><a href="/" class="nav-link text-light link-body-emphasis">Inicio</a></li>
            <li class="nav-item"><a href="{{route('recipes.index')}}" class="nav-link text-light link-body-emphasis">Recetas</a></li>
            @if(Auth::check() && Auth::user()->fk_type==1)
                <li class="nav-item"><a href="{{route('admin')}}" class="nav-link text-light link-body-emphasis">Dashboard</a></li>
            @endif
            <li class="nav-item">
                @if (Auth::check())
                    <div class="dropdown text-end">
                        <a href="{{route('profile')}}" class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-light mx-2" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="mx-2">{{Auth::user()->nickname}}</span>
                            <img src="{{ auth()->user()->photo ? asset('uploads/users/' . auth()->user()->photo) : 'https://via.placeholder.com/150' }}" alt="mdo" width="45" height="45" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="{{route('profile')}}">Perfil</a></li>
                            @if(Auth::user()->fk_type==3)
                                <li><a class="dropdown-item" href="{{route('inventory.index')}}">Inventario</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Cerrar sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link d-flex align-items-center gap-2 text-light">Iniciar Sesión <span class="material-symbols-outlined">login</span></a>
                @endif
            </li>
        </ul>
    </header>
</div>
