<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <a href="{{ route('manager.list') }}" class="nav-link {{ request()->is('*workers') ? 'active' : '' }}">
            <i class="nav-icon fas fa-fw fa-list"></i>
            <p>
                Usuarios
            </p>
        </a>
        <a href="{{ route('manager.home') }}" class="nav-link {{ request()->is('manager') ? 'active' : '' }}">
            <i class="nav-icon fas fa-fw fa-cog"></i>
            <p>
                Ajustes
            </p>
        </a>
    </ul>
</nav>