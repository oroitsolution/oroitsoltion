<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{asset('admin/dist/assets/img/AdminLTELogo.png')}}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Kotyapay</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <!-- for role and permission -->
              <li class="nav-item {{ request()->is('users*') || request()->is('permissions*') || request()->is('roles*') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ request()->is('users*') || request()->is('permissions*') || request()->is('roles*') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-speedometer"></i>
                      <p>
                          Permissions and Role
                          <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                  </a>
                  <ul class="nav nav-treeview">
                      <li class="nav-item">
                          <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>Users</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('permissions.index') }}" class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>Permissions</p>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a href="{{ route('roles.index') }}" class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>Roles</p>
                          </a>
                      </li>
                  </ul>
              </li>
            <!-- end role and permission -->

           
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->