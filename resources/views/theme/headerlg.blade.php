<header class="row">
    <nav class="navbar navbar-expand-lg px-5 fixed-top" id="navbar-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{url('/')}}"><img class="img-fluid" src="{{asset('assets/img/logos/logo_LoncheS.webp')}}" alt="Logo LoncheS" style="width: 110px"></a>
            <button class="navbar-toggler btn-navbar white-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end rounded-4" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <div class="btn-group bg-dark p-2" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('recipes.index')}}" class="nav-link text-light link-body-emphasis">Recetas</a>
                        @if(Auth::check() && Auth::user()->fk_type==1)
                            <li class="nav-item"><a href="{{route('admin')}}" class="nav-link text-light link-body-emphasis">Dashboard</a></li>
                        @endif
                        <div class="btn-group" role="group">
                            @if (Auth::check())
                                <div class="dropdown text-end">
                                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-light mx-2" data-bs-toggle="dropdown" aria-expanded="false">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="carouselExampleInterval" class="carousel px-0 slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('assets/img/banners/banner1.webp')}}" class="d-block w-100 custom-carousel-img-lg" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('assets/img/banners/banner2.webp')}}" class="d-block w-100 custom-carousel-img-lg" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('assets/img/banners/banner3.webp')}}" class="d-block w-100 custom-carousel-img-lg" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('assets/img/banners/banner4.webp')}}" class="d-block w-100 custom-carousel-img-lg" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</header>
