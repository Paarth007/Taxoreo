<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="#">
            <img src="{{ url('website/images/logo/header-logo.png') }}" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
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

            {{-- <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#navbar-uac" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-uac">
                  <i class="fas fa-users-cog text-red"></i>
                  <span class="nav-link-text">UAC Policy</span>
                </a>
                <div class="collapse" id="navbar-uac">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('superadmin/uac/role') }}" class="nav-link">Role</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('superadmin/uac/permission') }}" class="nav-link">Permission</a>
                        </li>
                    </ul>
                </div>
            </li> --}}


            <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#document-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="document-examples">
                  <i class="fas fa-stream text-red"></i>
                  <span class="nav-link-text">Masters</span>
                </a>
                <div class="collapse" id="document-examples">
                  <ul class="nav nav-sm flex-column">
                      {{-- <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/period') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Period master</a>
                      </li> --}}
                      <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/document') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Document Master</a>
                      </li>
                      <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/company-type') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Company Type Master</a>
                      </li>
                       <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/category') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Service Category</a>
                      </li>
                      <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/master/service') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Service Master</a>
                      </li>
                  </ul>
                </div>
            </li>

            <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                  <i class="fas fa-users-cog text-red"></i>
                  <span class="nav-link-text">Message Template</span>
                </a>
                <div class="collapse" id="navbar-examples">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item mt--2">
                      <a href="{{ url('superadmin/message-template/email') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Email</a>
                    </li>
                    <li class="nav-item mt--2">
                      <a href="{{ url('superadmin/message-template/sms') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> SMS</a>
                    </li>
                     <li class="nav-item mt--2">
                      <a href="{{ url('superadmin/message-template/whats-app') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Whats App</a>
                    </li>

                  </ul>
                </div>
              </li>


            <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#navbar-website" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-website">
                  <i class="fas fa-users-cog text-red"></i>
                  <span class="nav-link-text">Website Content</span>
                </a>
                <div class="collapse" id="navbar-website">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/website/menu-service') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Menu Services</a>
                    </li>
                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/website/web-page') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Web Pages</a>
                      </li>
                    <li class="nav-item mt--2">
                      <a href="{{ url('superadmin/website/blog') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Blog Management</a>
                    </li>
                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/website/advertise') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Advertise Management</a>
                    </li>
                  </ul>
                </div>
            </li>

            <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#navbar-user-list" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-user-list">
                  <i class="fas fa-users-cog text-red"></i>
                  <span class="nav-link-text">User List</span>
                </a>
                <div class="collapse" id="navbar-user-list">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item mt--2">
                      <a href="{{ url('superadmin/user-list/client') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Clients</a>
                    </li>
                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/user-list/ca') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>CA's</a>
                    </li>
                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/user-list/freelancer') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Freelancer's</a>
                    </li>
                  </ul>
                </div>
            </li>

            <li class="nav-item" style="border-top:1px solid #EAEDED">
                <a class="nav-link" href="#navbar-client-services" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-client-services">
                  <i class="fas fa-users-cog text-red"></i>
                  <span class="nav-link-text">Client Services</span>
                </a>
                <div class="collapse" id="navbar-client-services">
                  <ul class="nav nav-sm flex-column">

                    <li class="nav-item mt--2">
                      <a href="{{ url('superadmin/client-service/newly-added-services') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Client Added</a>
                    </li>

                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/client-service/payment-verification-assign-user') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Assign User</a>
                    </li>

                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/client-service/in-progress') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>In Progess</a>
                    </li>

                    <li class="nav-item mt--2">
                        <a href="{{ url('superadmin/client-service/complete') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i>Complete</a>
                    </li>

                  </ul>
                </div>
            </li>

            <li class="nav-item" style="border-top:1px solid #EAEDED">
              <a class="nav-link" href="#navbar-report" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-report">
                <i class="fas fa-users-cog text-red"></i>
                <span class="nav-link-text">Report</span>
              </a>
              <div class="collapse" id="navbar-report">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item mt--2">
                    <a href="{{ url('superadmin/report/payment-log') }}" class="nav-link"><i class="fa fa-dot-circle" aria-hidden="true"></i> Payment Logs</a>
                  </li>s
                </ul>
              </div>
          </li>

          </ul>
        </div>
      </div>
    </div>
  </nav>
