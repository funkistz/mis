<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            {{-- Collapsed Hamburger --}}
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            {{-- Branding Image --}}
            <a class="navbar-brand padding-xs" href="{{ url('/') }}">
                <img class="img-responsive" style="height:40px;" src="{{ asset('images/logo.png') }}">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            {{-- Left Side Of Navbar --}}
            <ul class="nav navbar-nav">
                @role(['admin', 'staff','officer', 'coofficer', 'coach'])
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Menu <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {{ Request::is('dashboard') ? 'class=active' : null }}>{!! HTML::link(url('/dashboard'), 'Dashboard') !!}</li>

                            @role(['admin'])
                            <li {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'class=active' : null }}>{!! HTML::link(url('/users'), Lang::get('titles.adminUserList')) !!}</li>
                            <li {{ Request::is('users/create') ? 'class=active' : null }}>{!! HTML::link(url('/users/create'), Lang::get('titles.adminNewUser')) !!}</li>
                            @endrole

                            @role(['admin', 'staff', 'officer', 'coofficer'])
                            <li {{ Request::is('members') ? 'class=active' : null }}>{!! HTML::link(url('/members'), 'Members') !!}</li>
                            @endrole
                            @role(['admin', 'staff', 'officer'])
                            <li {{ Request::is('courses') ? 'class=active' : null }}>{!! HTML::link(url('/courses'), 'Courses') !!}</li>
                            @endrole
                            @role(['admin', 'coofficer'])
                            <li {{ Request::is('coachs') ? 'class=active' : null }}>{!! HTML::link(url('/coachs'), 'Coach') !!}</li>
                            @endrole
                            @role(['officer'])
                            <li {{ Request::is('report') ? 'class=active' : null }}>{!! HTML::link(route('report.index'), 'Report') !!}</li>
                            <li {{ Request::is('table') ? 'class=active' : null }}>{!! HTML::link(route('table.index'), 'Table') !!}</li>
                            @endrole
                            @role(['staff'])
                            <li {{ Request::is('news') ? 'class=active' : null }}>{!! HTML::link(route('news.index'), 'News') !!}</li>
                            @endrole
                        </ul>
                    </li>
                @endrole
                @role('member')
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          Member <span class="caret"></span>
                      </a>
                      @if(!empty(auth()->user()->activated))
                      <ul class="dropdown-menu" role="menu">
                        @can('create', App\Models\MemberCard::class)
                          <li {{ Request::is('member_card/create') ? 'class=active' : null }}>{!! HTML::link(url('/member_card/create'), 'Member card registration') !!}</li>
                        @else
                          <li {{ Request::is('member_card') ? 'class=active' : null }}>{!! HTML::link(url('/member_card'), 'Member card') !!}</li>
                        @endcan
                        <li {{ Request::is('member_courses') ? 'class=active' : null }}>{!! HTML::link(url('/member_courses'), 'Courses') !!}</li>
                      </ul>
                      @endif
                  </li>
                @endrole
            </ul>

            {{-- Right Side Of Navbar --}}
            <ul class="nav navbar-nav navbar-right">
                {{-- Authentication Links --}}
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">{!! trans('titles.login') !!}</a></li>
                    <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                    <li><a href="{{ route('register_member.index') }}">Member Registration</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">

                            @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                                <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                            @else
                                <div class="user-avatar-nav"></div>
                            @endif

                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'class=active' : null }}>
                                {!! HTML::link(url('/profile/'.Auth::user()->name), trans('titles.profile')) !!}
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {!! trans('titles.logout') !!}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
