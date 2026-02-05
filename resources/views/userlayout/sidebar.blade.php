<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav flex-column">

        {{-- Switch Back to Admin --}}
        @if(session()->has('superadmin_id'))
        <li class="nav-item px-3 mb-3">
            <a href="{{ route('superadmin.back.to.admin') }}"
               class="btn btn-warning w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-arrow-left-circle"></i>
                <span>Back to Admin</span>
            </a>
        </li>
        @endif

        {{-- Navigation --}}
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               href="{{ route('user.dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title ms-2">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               href="{{ route('user.view.profile') }}">
                <i class="mdi mdi-account-circle menu-icon"></i>
                <span class="menu-title ms-2">Profile</span>
            </a>
        </li>
        <li class="nav-divider my-3"></li>
        
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               href="{{ route('user.payment.send') }}">
                <i class="mdi mdi-bank-transfer menu-icon"></i>
                <span class="menu-title ms-2">Pay / Beneficiaries</span>
            </a>
        </li>


       <li class="nav-item">
            <a class="nav-link d-flex align-items-center
            {{ request()->routeIs('user.payout.*') ? 'active' : '' }}"
            href="{{ route('user.payout.data') }}">
                <i class="mdi mdi-cash-multiple menu-icon"></i>
                <span class="menu-title ms-2">Payout</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               href="{{ route('user.payin.data') }}">
                 <i class="mdi mdi-cash-plus menu-icon"></i>
                <span class="menu-title ms-2">Pay-In</span>
            </a>
        </li>
        

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               href="{{ route('user.fund.request') }}">
                <i class="mdi mdi-credit-card-plus menu-icon"></i>
                <span class="menu-title ms-2">Add Fund Request</span>
            </a>
        </li>

    <li class="nav-divider my-3"></li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center"
               href="{{ route('user.view.kyc.form') }}">
                <i class="mdi mdi-shield-check menu-icon"></i>
                <span class="menu-title ms-2">KYC Verification</span>
            </a>
        </li>

        {{-- Divider --}}
        <li class="nav-divider my-3"></li>

        {{-- Logout --}}
        <li class="nav-item mt-auto px-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center rounded-circle"
                    style="width:40px; height:40px;">
                    <i class="mdi mdi-logout"></i>
                </button>
            </form>
        </li>

    </ul>
</nav>
