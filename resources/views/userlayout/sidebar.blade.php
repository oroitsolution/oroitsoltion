<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
         @if(session()->has('superadmin_id'))
        <a class="nav-link" href="{{route('superadmin.back.to.admin')}}">
            <a href="{{ route('superadmin.back.to.admin') }}" class="btn w-100 btn-warning">
                <i class="bi bi-arrow-left-circle"></i> Back to Admin
            </a>
          </a>
          @endif

       
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.view.profile') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.payment.send') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Payment Send</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.payin.data') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Payin</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.view.kyc.form') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Kyc</span>
            </a>
        </li>



        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="mdi mdi-grid-large menu-icon"></i>
                    <span class="ms-2">Logout</span>
                </a>
            </form>
        </li>

    </ul>
</nav>