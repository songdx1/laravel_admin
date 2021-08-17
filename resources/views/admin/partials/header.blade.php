<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown user-panel">
        <a href="#" class="dropdown-toggle user-panel" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ Admin::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{ Admin::user()->name }}</span>
        </a> 
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                  <img src="{{ Admin::user()->avatar }}" class="img-circle" alt="User Image">

                  <p>
                      {{ Admin::user()->name }}
                      <small>Member since admin {{ Admin::user()->created_at }}</small>
                  </p>
              </li>
              <li class="user-footer">
                  <div class="pull-left">
                      <a href="{{ admin_url('auth/setting') }}" class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
                  </div>
                  <div class="pull-right">
                      <a href="{{ admin_url('auth/logout') }}" class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
                  </div>
              </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->