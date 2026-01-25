<nav class="navbar navbar-expand fixed-top be-top-header">
    <div class="container">
        <div class="be-navbar-header"><a class="navbar-brand" href="index.html"></a>
        </div>
        <div class="page-title"><span>Warehouse Monitoring System</span></div>
        <div class="be-right-navbar">
            <ul class="nav navbar-nav float-right be-user-nav">
                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                        role="button" aria-expanded="false"><img src="{{ asset('assets/img/avatar.png') }}"
                            alt="Avatar"><span class="user-name">{{ Auth::user()->name ?? 'Null' }}</span></a>
                    <div class="dropdown-menu" role="menu">
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name ?? 'Null' }}</div>
                            <div class="user-position online">Connected</div>
                        </div>

                        {{-- Styled logout item in dropdown --}}
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="icon mdi mdi-power"></span>Logout
                        </a>

                        {{-- Hidden logout form (POST) --}}
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>
            </ul>
            <ul class="nav navbar-nav float-right be-icons-nav">
                {{-- @include('top-header.nav-item-settings') --}}
                {{-- @include('top-header.nav-item-notifications') --}}
                {{-- @include('top-header.nav-item-apps') --}}
            </ul>
        </div>
    </div>
</nav>
