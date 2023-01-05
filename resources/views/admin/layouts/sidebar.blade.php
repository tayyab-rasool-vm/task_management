<div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
        <li class="nav-item me-auto">
            <a class="navbar-brand" href="{{url('/')}}">
                <span class="brand-logo">
                </span>
                <h2 class="brand-text">Task Management</h2>
            </a>
        </li>
        <li class="nav-item nav-toggle">
            <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc" data-ticon="disc"></i>
            </a>
        </li>
    </ul>
</div>
<div class="shadow-bottom"></div>
<div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="nav-item {{ \Route::getFacadeRoot()->current()->uri() == '/' ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{url('/')}}">
                <i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboard</span>
            </a>
        </li>
        <li class="navigation-header"><span data-i18n="Attendance">Task Management</span><i data-feather="more-horizontal"></i></li>
        <li class="nav-item {{ \Route::getFacadeRoot()->current()->uri() == 'tasks' || \Route::getFacadeRoot()->current()->uri() == 'tasks/create' || \Route::getFacadeRoot()->current()->uri() == 'tasks/{task}' ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{url('/tasks')}}">
                <i class="fa fa-tasks" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Tasks</span>
            </a>
        </li>
        <li class="nav-item {{ \Route::getFacadeRoot()->current()->uri() == 'occurrences' ? 'active' : '' }}">
            <a class="d-flex align-items-center" href="{{url('/occurrences')}}">
                <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Occurrences</span>
            </a>
        </li>
    </ul>
</div>
