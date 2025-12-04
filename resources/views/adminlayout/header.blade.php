 <!--begin::Header-->
 <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Welcome <b style="color:red">({{ Auth::user()->name }})</b> </a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
    <!-- Check if user is authenticated -->
    @auth
        <!-- Display welcome message -->
       
        <!-- Logout Form -->
        <li class="nav-item d-none d-md-block">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link" style="border: none; background: none; padding: 0; cursor: pointer;">
                    {{ __('Log Out') }}
                </button>
            </form>
        </li>
    @endauth
</ul>

          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->