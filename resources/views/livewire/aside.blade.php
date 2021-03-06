<div>
    <!-- [ Mobile header ] start -->
<div class="pc-mob-header pc-header">
    <div class="pcm-logo">
        <img src="assets/images/logo.svg" alt="" class="logo logo-lg">
    </div>
    <div class="pcm-toolbar">
        <a href="#!" class="pc-head-link" id="mobile-collapse">
            <div class="hamburger hamburger--arrowturn">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
        </a>
        <a href="#!" class="pc-head-link" id="headerdrp-collapse">
            <i data-feather="align-right"></i>
        </a>
        <a href="#!" class="pc-head-link" id="header-collapse">
            <i data-feather="more-vertical"></i>
        </a>
    </div>
</div>
<!-- [ Mobile header ] End -->

<!-- [ navigation menu ] start -->
<nav class="pc-sidebar 
@if (session()->exists('expandedSide'))
    @if (session('expandedSide'))
    mob-sidebar-active
    @endif
@endif">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="index.html" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="assets/images/logo.svg" alt="" class="logo logo-lg">
                <img src="assets/images/logo-sm.svg" alt="" class="logo logo-sm">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Navegación</label>
                </li>
                <li class="pc-item">
                    <a href="/" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">home</i></span><span class="pc-mtext">Inicio</span></a>
                </li>
                <li class="pc-item">
                    <a href="/marcas" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">shopping_bag</i></span><span
                            class="pc-mtext">Marcas</span></a>
                </li>
                <li class="pc-item">
                    <a href="/categorias" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">category</i></span><span
                            class="pc-mtext">Categorias</span></a>
                </li>
                <li class="pc-item">
                    <a href="/productos" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">local_mall</i></span><span
                            class="pc-mtext">Productos</span></a>
                </li>
                <li class="pc-item">
                    <a href="/inventarios" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">receipt_long</i></span><span
                            class="pc-mtext">Inventarios</span></a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('almacenes') }}" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">apartment</i></span><span
                            class="pc-mtext">Almacenes</span></a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('proveedores') }}" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">contacts</i></span><span
                            class="pc-mtext">Proveedores</span></a>
                </li>
                <li class="pc-item">
                    <a href="/tipos-documentos" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">text_snippet</i></span><span
                            class="pc-mtext">Tipos Documentos</span></a>
                </li>
                <li class="pc-item">
                    <a href="/tiendas" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">store</i></span><span
                            class="pc-mtext">Tiendas</span></a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('pedidos') }}" class="pc-link "><span class="pc-micon"><i
                                class="material-icons-two-tone">account_balance_wallet</i></span><span
                            class="pc-mtext">Pedidos </span></a>
                </li>
                @auth
                <li class="pc-item">
                    <a href="{{ route('usuarios') }}" class="pc-link "><span class="pc-micon"><i class="material-icons-two-tone">admin_panel_settings</i></span><span class="pc-mtext">Usuarios</span></a>
                </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
<!-- [ Header ] start -->
<header class="pc-header 
@if (session()->exists('expandedSide'))
    @if (session('expandedSide'))
    expand-with-items
    @endif
@endif">
    <div class="header-wrapper">
        <div class="mr-auto pc-mob-drp">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <div class="pcm-toolbar">
                        <a type="button" class="pc-head-link" id="mobile-collapse-pc" onclick="expandMenu()" wire:click="asideToggle">
                            <div class="hamburger hamburger--arrowturn">
                                <div class="hamburger-box">
                                    <div class="hamburger-inner"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
                {{-- <li class="dropdown pc-h-item">
                    <a class="pc-head-link active dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        Level
                    </a>
                    <div class="dropdown-menu pc-h-dropdown">
                        <a href="#!" class="dropdown-item">
                            <i class="material-icons-two-tone">account_circle</i>
                            <span>My Account</span>
                        </a>
                        <div class="pc-level-menu">
                            <a href="#!" class="dropdown-item">
                                <i class="material-icons-two-tone">list_alt</i>
                                <span class="float-right"><i data-feather="chevron-right" class="mr-0"></i></span>
                                <span>Level2.1</span>
                            </a>
                            <div class="dropdown-menu pc-h-dropdown">
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>My Account</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Support</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Lock Screen</span>
                                </a>
                                <a href="#!" class="dropdown-item">
                                    <i class="fas fa-circle"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                        <a href="#!" class="dropdown-item">
                            <i class="material-icons-two-tone">settings</i>
                            <span>Settings</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="material-icons-two-tone">support</i>
                            <span>Support</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="material-icons-two-tone">https</i>
                            <span>Lock Screen</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="material-icons-two-tone">chrome_reader_mode</i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li> --}}
            </ul>
        </div>
        <div class="ml-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="material-icons-two-tone">search</i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown drp-search">
                        <form class="px-3">
                            <div class="form-group mb-0 d-flex align-items-center">
                                <i data-feather="search"></i>
                                <input type="search" class="form-control border-0 shadow-none"
                                    placeholder="Search here. . .">
                            </div>
                        </form>
                    </div>
                </li>
                <li class="dropdown pc-h-item">
                    @livewire('notifications')
                </li>
                <li class="dropdown pc-h-item">
                    @auth
                    <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar">
                        <span>
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-desc">{{ auth()->user()->email }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
                        <div class=" dropdown-header">
                            <h5 class="text-overflow m-0"><span class="badge bg-light-primary">{{ auth()->user()->email
                                    }}</span></h5>
                        </div>

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}">
                        Iniciar Sesión{{-- <i data-feather="user"></i> --}}
                    </a>
                    @endauth
                </li>
            </ul>
        </div>

    </div>
</header>
@push('scripts')
<script>
    'use strict';

    (function () {
        var sideBarTrigger = @js(session('expandedSide'));
        var selectrHeader = document.querySelector('.page-header');
        if (sideBarTrigger) {
    
            if (!selectrHeader.classList.contains('expand-with-items')) {
                selectrHeader.classList.add('expand-with-items');
            }
            
        } 
    }())

        let expandMenu = () => {
            
                document.querySelector('.pc-sidebar').classList.toggle('mob-sidebar-active')
                document.querySelector('header').classList.toggle('expand-with-items')
                document.querySelector('.page-header').classList.toggle('expand-with-items')
                document.querySelector('.pc-container').classList.toggle('margin-container')                
                /* Livewire.emit('sideBar'); */
            

            
        }  
</script>
@endpush
<!-- [ Header ] end -->
</div>
