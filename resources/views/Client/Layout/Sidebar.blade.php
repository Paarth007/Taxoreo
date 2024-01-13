<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="#">
            <img src="{{ url('backend_template/images/aiat.jpg') }}" class="navbar-brand-img" alt="...">
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
              <a class="nav-link" href="{{ url('superadmin/dashboard') }}">
                <i class="ni ni-archive-2 text-green"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('superadmin/dashboard') }}">
                  <i class="ni ni-archive-2 text-green"></i>
                  <span class="nav-link-text">Current Services</span>
                </a>
             </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('superadmin/dashboard') }}">
                  <i class="ni ni-archive-2 text-green"></i>
                  <span class="nav-link-text">Services</span>
                </a>
            </li>

            <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#document-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="document-examples">
                  <i class="fas fa-stream text-red"></i>
                  <span class="nav-link-text">Masters</span>
                </a>
                <div class="collapse" id="document-examples">
                  <ul class="nav nav-sm flex-column">
                       <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/period') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Period master</a>
                      </li>
                      <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/document') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Document Master</a>
                      </li>
                      <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/service') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Service Master</a>
                      </li>
                  </ul>
                </div>
            </li>


          </ul>
        </div>
      </div>
    </div>
  </nav>
