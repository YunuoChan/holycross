{{-- <nav class="navbar navbar-expand-md navbar-dark mb-0" style="background-color: #100b3a;">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('landing-welcome') }}" class="navbar-brand white-color" title="Holy Cross College">
                <div class="d-flex">
                    <div class="mr-2">
                        <img src="/img/logo1.jpg"  style="width: 50px; height: 50px" />
                    </div>
                    <div class="d-flex justify-content-center flex-column">
                        <h4 style="font-size: 2.5rem;">Holy Cross College</h4>
                    </div>
                </div>
                </a>
        </div>
        
        <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#main-nav">
            <span class="menu-icon-bar"></span>
            <span class="menu-icon-bar"></span>
            <span class="menu-icon-bar"></span>
        </button>
        
        <div id="main-nav" class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
              
                <li style="display: flex !important; flex-direction: column; justify-content: center;"><a href="{{ url('/') }}" class="nav-item nav-link">Home</a></li>
                 <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                @else
                    <li class="dropdown" style="display: flex !important; flex-direction: column; justify-content: center; margin-right: 30px; ">
                        <a href="{{ route('home') }}" class="nav-item nav-link" data-toggle="dropdown">Dashboard</a>
                        <div class="dropdown-menu">
                            <a href="{{ route('subject') }}" class="dropdown-item">Subject</a>
                            <a href="{{ route('professor') }}" class="dropdown-item">Professor</a>
                            <a href="{{ route('generate.schedule') }}" class="dropdown-item">Generate Schedule</a>
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
</nav> --}}


{{-- <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">WebSiteName</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">Home</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Page 1-1</a></li>
              <li><a href="#">Page 1-2</a></li>
              <li><a href="#">Page 1-3</a></li>
            </ul>
          </li>
          <li><a href="#">Page 2</a></li>
          <li><a href="#">Page 3</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
      </div>
    </div>
  </nav> --}}

  <nav class="navbar navbar-expand-md navbar-dark mb-0" style="background-color: #100b3a;">
    <div class="container">
      
        <div class="d-flex">
            <a href="{{ route('landing-welcome') }}" class="navbar-brand white-color" title="Holy Cross College">
                <div class="d-flex">
                    <div class="mr-2">
                        <img src="/img/logo1.jpg"  style="width: 50px; height: 50px" />
                    </div>
                </div>
                </a>
        </div>

        <ul class="nav navbar-right">
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" style="font-size: 1.3rem;">{{ __('Login') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link " style="text-transform:uppercase; font-size: 1.3rem;" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                         <img src="/img/img_avatar.png" alt="{{ Auth::user()->name }}" style="margin-right: 10px; vertical-align: middle; width: 50px; height: 50px; border-radius: 50%" class="avatar"> {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                       
                        <a href="{{ route('subject') }}" class="dropdown-item">Subject</a>
                        <a href="{{ route('professor') }}" class="dropdown-item">Professor</a>
                        <a href="{{ route('generate.schedule') }}" class="dropdown-item">Generate Schedule</a>
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
</nav>