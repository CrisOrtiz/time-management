<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        @if(auth()->user()->user_type == 3)
            <a href="{{ route('worker.list', ['userId' => auth()->user()->id] )}}" class="nav-link {{ request()->is('*tasks') ? 'active' : '' }}">
                <i class="nav-icon fas fa-fw fa-list"></i>
                <p>
                    Tareas
                </p>
            </a>
            <a href="{{ route('worker.home', ['userId' => auth()->user()->id]) }}" class="nav-link {{ request()->is('*settings') ? 'active' : '' }}">
                <i class="nav-icon fas fa-fw fa-cog"></i>
                <p>
                    Ajustes
                </p>
            </a>
        @else
            <a  class="nav-link active">
                <i class="nav-icon fas fa-fw fa-list"></i>
                <p>
                    Tareas de usuario
                </p>
            </a>           
            <a href="{{ route('admin.list') }}" class="nav-link {{ request()->is('*workers') ? 'active' : '' }}">
                <i class="nav-icon fas fa-fw fa-arrow-left"></i>
                <p>
                    Volver 
                </p>
            </a>
        @endif
    </ul>
</nav>