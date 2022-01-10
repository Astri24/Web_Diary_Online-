<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @if(count($web))
    @foreach ($web as $webs)
        <title>@yield('title') / {{ $webs->name }}</title>
    @endforeach
  @else
    <title>@yield('title') / MyWeb</title>
  @endif


  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icon/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icon/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('assets/icon/site.webmanifest') }}">
  @if(count($web))
  @foreach ($web as $webs)
      @php 
          $primary_color = $webs->primary_color 
      @endphp
  @endforeach
  @else
    @php 
        $primary_color = "#6777ef";
    @endphp
  @endif
  <style>
    a {
        color: {{$primary_color}};
    }
    .section .section-title::before {
        background-color: {{$primary_color}};
    }

    .card .card-header h4 {
        color: {{$primary_color}};
    }

    #searchResultMenu {
      display: none;
    }
  </style>
  @yield('css')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg" style="background-color: @if(isset($primary_color)) {{$primary_color}} @else #6777ef @endif"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" id="mySearch" type="search" placeholder="Cari Menu..." aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result" id="searchResultMenu">
              <div class="search-header">
                Result
              </div>
              <div class="search-item">
                <a href="{{ route('dashboard.index') }}" style="color: #78828a;">
                  <i class="fas fa-fire mr-1" style="width: 30px"></i>
                  Dashboard
                </a>
              </div>
              <div class="search-item">
                <a href="{{ route('web-profile.index') }}" style="color: #78828a;">
                  <i class="fas fa-id-card mr-1" style="width: 30px"></i>
                  Web Profile
                </a>
              </div>
              <div class="search-item">
                <a href="{{ route('note-back.index') }}" style="color: #78828a;">
                  <i class="fas fa-sticky-note mr-1" style="width: 30px"></i>
                  Note
                </a>
              </div>
              <div class="search-item">
                <a href="{{ route('gallery-back.index') }}" style="color: #78828a;">
                  <i class="fas fa-images mr-1" style="width: 30px"></i>
                  Gallery
                </a>
              </div>
              <div class="search-item">
                <a href="{{ route('schedule-back.index') }}" style="color: #78828a;">
                  <i class="fas fa-clipboard-list" style="width: 30px"></i>
                  Schedule
                </a>
              </div>
            </div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in {{ \Carbon\Carbon::parse(Auth::user()->last_login_at)->diffForHumans() }}</div>
              <a href="{{ route('admin-profile.index') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            @foreach($web as $webs)
            <a href="{{ route('dashboard.index') }}">{{ $webs->name }}</a>
            @endforeach
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard.index') }}"></a>
          </div>
          <ul class="sidebar-menu">
              <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}"><a class="nav-link" @if(request()->routeIs('dashboard.index') && isset($primary_color)) style="color: {{$primary_color}};" @endif href="{{ route('dashboard.index') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
              <li class="{{ request()->routeIs('web-profile.index') ? 'active' : '' }}"><a class="nav-link" @if(request()->routeIs('web-profile.index') && isset($primary_color)) style="color: {{$primary_color}};" @endif href="{{ route('web-profile.index') }}"><i class="fas fa-id-card"></i> <span>Web Profile</span></a></li>
              <li class="{{ request()->routeIs('note-back.index') ? 'active' : '' }}"><a class="nav-link" @if(request()->routeIs('note-back.index') && isset($primary_color)) style="color: {{$primary_color}};" @endif href="{{ route('note-back.index') }}"><i class="fas fa-sticky-note"></i> <span>Notes</span></a></li>
              <li class="{{ request()->routeIs('gallery-back.index') ? 'active' : '' }}"><a class="nav-link" @if(request()->routeIs('gallery-back.index') && isset($primary_color)) style="color: {{$primary_color}};" @endif href="{{ route('gallery-back.index') }}"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
              <li class="{{ request()->routeIs('schedule-back.index') ? 'active' : '' }}"><a class="nav-link" @if(request()->routeIs('schedule-back.index') && isset($primary_color)) style="color: {{$primary_color}};" @endif href="{{ route('schedule-back.index') }}"><i class="fas fa-clipboard-list"></i> <span>Schedule</span></a></li>
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
          @yield('container')
          @yield('modal')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Hak Cipta &copy; 2021 <div class="bullet"></div> <a href="{{ url('/') }}" @if(isset($primary_color)) style="color: {{$primary_color}}" @else style="color: #6777ef;" @endif>
          @foreach($web as $webs)
            {{ $webs->name }}
          @endforeach
          </a>
        </div>
      </footer>
    </div>
  </div>
  @include('sweetalert::alert')
  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
 
  <script src="{{ asset('assets/js/stisla.js') }}"></script>

  <script>
    $(document).ready(function () { 
      $("#mySearch").on("keyup", function () {
            if (this.value.length > 0) {   
              $("#searchResultMenu").css("display", "block");
            $(".search-item").hide().filter(function () {
              return $(this).text().toLowerCase().indexOf($("#mySearch").val().toLowerCase()) != -1;
            }).show(); 
            }  
          else { 
            $("#searchResultMenu").css("display", "none");
          }
      });  
    });
  </script>

  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  @yield('js')
</body>
</html>
