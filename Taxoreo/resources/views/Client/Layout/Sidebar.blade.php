<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="#">
            <img src="{{ url('website/images/logo/header-logo.png') }}" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="navbar-inner">
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ url('client/dashboard') }}">
                <i class="ni ni-archive-2 text-green"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('client/dashboard') }}">
                  <i class="ni ni-archive-2 text-green"></i>
                  <span class="nav-link-text">Current Services</span>
                </a>
             </li>

            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('client/dashboard') }}">
                  <i class="ni ni-archive-2 text-green"></i>
                  <span class="nav-link-text">Services</span>
                </a>
            </li> --}}


          </ul>
        </div>
      </div>
    </div>
  </nav>
