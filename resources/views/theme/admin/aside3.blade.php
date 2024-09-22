<div class="sidebar col-md-3 col-lg-2 p-0 menuDash">
    <div class="offcanvas-md offcanvas-end menuDash" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="height: 100vh;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-light" id="sidebarMenuLabel">LoncheS</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="{{route('admin')}}">
                        <span class="material-symbols-outlined">home</span>
                        Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 text-light" href="{{route('ingredients.index')}}">
                        <span class="material-symbols-outlined">grocery</span>
                        Ingredientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 text-light" href="{{route('recipes.index')}}">
                        <span class="material-symbols-outlined">restaurant_menu</span>
                        Recetas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 text-light" href="{{route('users.index')}}">
                        <span class="material-symbols-outlined">supervisor_account</span>
                        Usuarios
                    </a>
                </li>
            </ul>

            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 text-light" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="material-symbols-outlined">door_open</span>
                        Cerrar Sesion
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
