<nav class="navbar navbar-expand-md navbar-dark mb-0" style="background-color: #100b3a;">
    <div class="container">
        <a href="#" class="navbar-brand">HCCians</a>
        
        <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#main-nav">
            <span class="menu-icon-bar"></span>
            <span class="menu-icon-bar"></span>
            <span class="menu-icon-bar"></span>
        </button>
        
        <div id="main-nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
              
                <li style="display: flex !important; flex-direction: column; justify-content: center;"><a href="{{ url('/') }}" class="nav-item nav-link">Home</a></li>
                 <!-- Authentication Links -->
                 @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    {{-- @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif --}}
                @else
                    <li class="dropdown" style="display: flex !important; flex-direction: column; justify-content: center; margin-right: 30px; ">
                        <a href="#" class="nav-item nav-link" data-toggle="dropdown">Dashboard</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">Subject</a>
                            <a href="#" class="dropdown-item">Teacher</a>
                            <a href="#" class="dropdown-item">Generate Schedule</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" style="text-transform:uppercase;" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}<img src="/img/img_avatar.png" alt="{{ Auth::user()->name }}" style="margin-left: 10px; vertical-align: middle; width: 50px; height: 50px; border-radius: 50%" class="avatar">  
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>