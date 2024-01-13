<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom p-1">
    <div class="container-fluid">
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav align-items-center ml-md-auto">
            <li class="nav-item d-xl-none">
                <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav align-items-right ml-auto ml-md-0">
          <li class="nav-item dropdown">

            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle p-0" style="height:25px;width:25px">
                  <img alt="Image placeholder" src="{{ url('backend_template/images/user.png')}}" >
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm font-weight-bold">
                        Parth Patel
                  </span>
                </div>
              </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>

            <div class="dropdown-divider"></div>
                <form  id="logout_form" method="POST" action="{{ url('superadmin/login/1') }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                </form>
                <button type="button" class="dropdown-item font-weight-bold text-red"
                onclick="document.getElementById('logout_form').submit();"
                >
                    <i class="ni ni-user-run"></i>
                    Logout
                </button>

                {{-- <a href="{{ url('superadmin/logout') }}" class="dropdown-item font-weight-bold text-red">
                    <i class="ni ni-user-run"></i>
                    <span>Logout</span>
                </a> --}}
            </div>

          </li>
        </ul>
      </div>
    </div>
    </nav>
