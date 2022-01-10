<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@700&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dosis&display=swap" rel="stylesheet">
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/icon/site.webmanifest') }}">
    
  @if(count($web))
    @foreach ($web as $webs)
        <title>Preview / {{ $webs->name }}</title>
    @endforeach
  @else
    <title>Preview / MyWeb</title>
  @endif

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
 
        .navbar-brand {
          font-family: 'Ubuntu', sans-serif;
        }

        .overlay {
          height: 0%;
          width: 100%;
          position: fixed;
          z-index: 10000000;
          top: 0;
          left: 0;
          background-color: rgb(0,0,0);
          background-color: rgba(0,0,0, 10);
          overflow-y: hidden;
          transition: 0.5s;
        }

        .overlay-content {
          position: relative;
          top: 25%;
          width: 100%;
          text-align: center;
          margin-top: 30px;
        }

        .overlay a {
          padding: 8px;
          text-decoration: none;
          font-size: 36px;
          color: #818181;
          display: block;
          transition: 0.3s;
          font-family: 'Poppins', sans-serif;
        }

        .overlay a:hover, .overlay a:focus {
          color: #f1f1f1;
        }

        .overlay .closebtn {
          position: absolute;
          top: 20px;
          right: 45px;
          font-size: 60px;
        }

        @media screen and (max-height: 450px) {
          .overlay {overflow-y: auto;}
          .overlay a {font-size: 20px}
          .overlay .closebtn {
          font-size: 40px;
          top: 15px;
          right: 35px;
          }
        }

        body {
            pointer-events: none;
        }

        @media screen and (max-width: 455px) {
          #ckeditorContent img {
              max-width: 100% !important;
              width: 100% !important;
              height: auto !important;
        }
    }
    </style>
    @yield('css')
  </head>
  <body style="background-color: #ffffff">
    <div id="myNav" class="overlay">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('gallery.index') }}">Gallery</a>
        <a href="{{ route('schedule.index') }}">Schedule</a>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light " id="navbar_top" style="background-color:#ffffff !important;height:15vh;">
        <div class="container">
            <a class="navbar-brand" style="color: rgb(13, 30, 45);" href="{{ url('/') }}">
              MyDiary.
            </a>
            <span style="color: rgb(13, 30, 45); cursor: pointer; pointer-events: all;" onclick="backToNote()">
              <i class="fas fa-arrow-left" style="font-size: 25px;"></i>
            </span>
        </div>
    </nav>

    
<div class="container mt-3">
  <div class="row">
    <div class="col-sm-6">
        <h2 style="font-family: 'Playfair Display', serif;">{{ $note->judul }}</h2>
        <p class="text-muted mt-1 text-uppercase" style="font-size: 13px;">BY {{ $note->creators->name }} / {{ $note->updated_at->format('d, M Y') }}</p>
    </div>
  </div>
  <div class="row mt-4">
      <div class="col-sm-12 ">
          <img src="{{ Storage::url($note->gambar) }}" style="max-width: 100%; max-height: 400px; object-fit;">                             
      </div>
      <div class="col-sm-12 mt-4" style="font-size: 16px; line-height: 27.2px;" id="ckeditorContent">
          {!! $note->konten !!}
      </div>
  </div>
  <div class="card" style="margin-top: 20px;">
      <div class="card-body">
          <div class="row">
              @php
                  $web = \App\Models\Web::all();
              @endphp
              @foreach($web as $webs)
              <div class="col-sm-2 d-flex justify-content-center">
                  <div class="photo">
                      @if(isset($webs->photo))
                      <img src="{{ Storage::url($webs->photo) }}" class="gambar"  style="border-radius: 50%; width: 110px; height: 110px; object-fit: cover;">          
                      @else
                      <img src="{{ asset('default_image.png') }}" class="gambar"  style="border-radius: 50%; width: 110px; height: 110px; object-fit: cover;">          
                      @endif
                  </div>
              </div>
              <div class="col-sm-9">
                  <h6 class="text-muted">Penulis</h6>
                  <h6 class="text-uppercase" style="font-weight: bold;">
                      {{ $note->creators->name }}
                  </h6>
                  <div class="note-content">
                      {!! $webs->description !!}
                  </div>
              </div>
              @endforeach
          </div>
      </div>
  </div>
</div>

<!-- Footer -->
<footer class="footer pt-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-sm-6 mt-3">
        <p class="mb-1">© Copyright 
          @if(count($web))
          @foreach ($web as $webs)
            {{ $webs->name }}
          @endforeach
          @else
            MyWeb
          @endif
          . All Rights Reserved</p>
       
      </div>
      <div class="col-sm-6 text-center text-md-end mt-3">
        <a href="#"><span class="fab fa-twitter me-3 text-dark"></span></a>
        <a href="#"><span class="fab fa-facebook me-3 text-dark"></span></a>
        <a href="#"><span class="fab fa-instagram me-3 text-dark"></span></a>
        <a href="#"><span class="fas fa-envelope me-3 text-dark"></span></a>
      </div>
    </div>
  </div>
</footer>
<!-- Footer -->
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
  function backToNote() {
    window.location.href = "{{ route('note-back.index') }}";
  }
  </script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>