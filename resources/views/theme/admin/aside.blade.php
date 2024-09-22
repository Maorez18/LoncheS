<!-- Navbar para pantallas pequeñas -->
<nav class="navbar navbar-expand-lg navbar-dark d-md-none menuDash">
    <div class="container-fluid">
        <div class="navbar-brand"><img src="{{asset('assets/img/logos/LoncheS-Logo.png')}}" class="img-fluid logo-dash" alt="Logo LoncheS"> Administrador</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{route('admin')}}" class="nav-link rounded" aria-current="page" id="homeldash">
                        <div class="row">
                            <div class="col-2 icon"><span class="material-symbols-outlined icon">home</span></div>
                            <div class="col">Inicio</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('ingredients.index')}}" class="nav-link rounded" id="ingredientsldash">
                        <div class="row">
                            <div class="col-2 icon"><span class="material-symbols-outlined">grocery</span></div>
                            <div class="col">Ingredientes</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('recipes.index')}}" class="nav-link rounded" id="recipesldash">
                        <div class="row">
                            <div class="col-2 icon"><span class="material-symbols-outlined">restaurant_menu</span></div>
                            <div class="col">Recetas</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link rounded" id="usersldash">
                        <div class="row">
                            <div class="col-2 icon"><span class="material-symbols-outlined">supervisor_account</span></div>
                            <div class="col">Usuarios</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar para pantallas grandes -->
<div id="sidebar" class="d-none d-md-block">
    <img src="{{asset('assets/img/logos/LoncheS-Logo.png')}}" class="img-fluid logo-dash" alt="Logo LoncheS">
    <hr>
    <a href="{{route('admin')}}" class="nav-link rounded" aria-current="page" id="homeldash">
        <div class="row">
            <div class="col-2 icon"><span class="material-symbols-outlined icon">home</span></div>
            <div class="col">Inicio</div>
        </div>
    </a>
    <a href="{{route('ingredients.index')}}" class="nav-link rounded" id="ingredientsldash">
        <div class="row">
            <div class="col-2 icon"><span class="material-symbols-outlined">grocery</span></div>
            <div class="col">Ingredientes</div>
        </div>
    </a>
    <a href="{{route('recipes.index')}}" class="nav-link rounded" id="recipesldash">
        <div class="row">
            <div class="col-2 icon"><span class="material-symbols-outlined">restaurant_menu</span></div>
            <div class="col">Recetas</div>
        </div>
    </a>
    <a href="{{route('users.index')}}" class="nav-link rounded" id="usersldash">
        <div class="row">
            <div class="col-2 icon"><span class="material-symbols-outlined">supervisor_account</span></div>
            <div class="col">Usuarios</div>
        </div>
    </a>
    <a href="{{ route('logout') }}" class="nav-link rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Cerrar Sesión
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
