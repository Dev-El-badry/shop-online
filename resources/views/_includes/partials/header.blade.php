 <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>P</span>
      <!-- logo for regular state and mobile devices -->
       @php
          $store_title_info = \DB::table('store_information')->orderBy('id', 'desc')->
          first()->store_title;
          
        @endphp
      <span class="logo-lg">{{ unserialize($store_title_info)[LaravelLocalization::getCurrentLocale()] }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Language website supportted -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-globe"></i>
              
            </a>
            <ul class="dropdown-menu">
              <li class="header">{{ trans('main.globe_title') }}</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $key=>$value)
                  <li>
                    <a href="{{ LaravelLocalization::getLocalizedUrl($key) }}">
                      <i class="fa fa-arrow-right"></i> {{ $value['native'] }}
                    </a>
                  </li>

                @endforeach
                 

                </ul>
              </li>
              
            </ul>
          </li>

          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">۱۰</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
              @php
                $admin_info = \DB::table('admins')->orderBy('id', 'desc')->first();
                $admin_name = $admin_info->name; 
                $admin_job_title = $admin_info->job_title; 
                $admin_created_at = $admin_info->created_at; 
              @endphp
              <span class="hidden-xs">{{ $admin_name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                <p>
                 {{ $admin_name }} - {{  $admin_job_title }}
                  <small>{{ trans('main.member') }} {{ $admin_created_at }}</small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{ route('admins.view', $admin_info->id) }}" class="btn btn-default btn-flat">{{ trans('main.profile') }}</a>
                </div>
                <div class="pull-left">
                  <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ trans('main.signout') }}</a>
                </div>
              </li>
            </ul>
          </li>
         
        </ul>
      </div>
    </nav>
  </header>