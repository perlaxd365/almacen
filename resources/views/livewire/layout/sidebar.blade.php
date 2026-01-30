<div>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="#" class="brand-link">
            <span class="brand-text font-weight-bold">Semmar Manufacturing</span>
        </a>

        <div class="sidebar">
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">
                        <a href=""
                            class="nav-link {{ $menuActivo == 'dashboard' ? 'active' : '' }}"
                            wire:click="$emit('setMenuActivo','dashboard')">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=""
                            class="nav-link {{ $menuActivo == 'productos' ? 'active' : '' }}"
                            wire:click="$emit('setMenuActivo','productos')">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Productos</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=""
                            class="nav-link {{ $menuActivo == 'movimientos' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>Movimientos</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href=""
                            class="nav-link {{ $menuActivo == 'retornables' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Retornables</p>
                        </a>
                    </li>

                    @if ($usuario->rol === 'admin')
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ $menuActivo == 'reportes' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

</div>
