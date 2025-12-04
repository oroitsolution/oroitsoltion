<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
        <span class="menu-title">Role & Permissions </span>
        <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('permissions.index') }}">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">Roles</a></li>
            </ul>
        </div>
    </li>
    
    </ul>
</nav>