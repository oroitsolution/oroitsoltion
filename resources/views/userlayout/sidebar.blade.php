<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('payment.send') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Payment Send</span>
        </a>
    </li>

    

    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
        @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="ms-2">Logout</span>
            </a>
        </form>
    </li>
    
    </ul>
</nav>