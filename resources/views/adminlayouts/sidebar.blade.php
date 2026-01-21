<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.users.index') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Users</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('superadmin/charges') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">User Fees & Charges</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('superadmin.kyc.data') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">KYC</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('superadmin/payment') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Payment</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ url('superadmin/contact') }}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Contact</span>
        </a>
    </li>


     <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
        <span class="menu-title">Payout </span>
        <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/payout') ? 'active' : '' }}"  href="{{ route('superadmin.payout.index') }}">All Data</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/payout/refund') ? 'active' : '' }}" href="{{ route('superadmin.payout.refund') }}">Refund</a></li>
                 <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/freeze-amount') ? 'active' : '' }}"  href="{{ route('superadmin.freeze.index') }}">Freeze</a></li>
            </ul>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#payin-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
        <span class="menu-title">Payin </span>
        <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="payin-elements">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/payin') ? 'active' : '' }}"  href="{{ route('superadmin.payin.index') }}">Payin data</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('superadmin/settlement') ? 'active' : '' }}"  href="{{ route('superadmin.settlement.index') }}">Settlement</a></li>
                
            </ul>
        </div>
    </li>

    

    
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#role-elements" aria-expanded="false" aria-controls="form-elements">
        <i class="menu-icon mdi mdi-card-text-outline"></i>
        <span class="menu-title">Role & Permissions </span>
        <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="role-elements">
            <ul class="nav flex-column sub-menu">
               
                <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.permissions.index') }}">Permissions</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.roles.index') }}">Roles</a></li>
            </ul>
        </div>
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