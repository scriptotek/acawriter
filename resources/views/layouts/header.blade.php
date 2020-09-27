<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" data-ga-category="Navbar">
        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}" data-ga-label="AcaWriter">
                <span class="navbar-brand-title">AcaWriter</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation" data-ga-label="Mobile menu">
                <span class="navbar-toggler-icon"></span>
                <span class="sr-only">Toggle navigation</span>
            </button>

            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav ml-auto">
                    @can('manage-documents')
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}" data-ga-label="My documents">My documents</a></li>
                    @endcan

                    @can('view-examples')
                    <li class="nav-item"><a class="nav-link" href="{{ url('example') }}" data-ga-label="Examples">Examples</a></li>
                    @endcan

                    @can('manage-assignments')
                    <li class="nav-item"><a class="nav-link" href="{{ url('assignments') }}" data-ga-label="Assignments">Assignments</a></li>
                    @endcan

                    <li class="nav-item"><a class="nav-link" href="{{ url('help') }}" data-ga-label="Help">Help &amp; Support</a></li>

                    @canany(['administer-users', 'access-reports'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu">
                            @can('administer-users')<a class="dropdown-item" href="{{ url('admin/users') }}">Users</a>@endcan
                            @can('access-reports')<a class="dropdown-item" href="{{ url('admin/reports') }}">Reports</a>@endcan
                        </div>
                    </li>
                    @endcanany
                </ul>

                @if (Auth::check())
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="user-buttond" data-toggle="dropdown" role="button" aria-expanded="false" data-ga-label="User">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg-right" id="user-menu" aria-label="User menu">
                            <div class="user-details">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="h4 text-nowrap">{{ Auth::user()->name }}</span><br>
                                <span class="text-muted text-nowrap">{{ Auth::user()->email }}</span>
                            </div>
                            <a class="btn btn-primary" href="{{ route('logout') }}"
                                data-ga-label="Logout"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;" autocomplete="off">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>
</header>
