@extends('layouts.back', ['web' => $web])
@section('title', 'Dashboard')
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>
  <br>
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon" style="background-color: #444444">
          <i class="fas fa-toolbox"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Note</h4>
          </div>
          <div class="card-body">
            {{ $note }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-user-secret"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Gallery</h4>
          </div>
          <div class="card-body">
            {{ $gallery }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Schedule</h4>
          </div>
          <div class="card-body">
            {{ $schedule }}
          </div>
        </div>
      </div>
    </div>
   
  </div>
</section>
@endsection