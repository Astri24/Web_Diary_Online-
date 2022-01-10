@extends('layouts.back', ['web' => $web])
@section('title', 'Schedule')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
  .card {
    border-radius: 10px;
  }
  #buttonGroup {
    display: block;
  }
</style>
@endsection
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Schedule</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Schedule</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <a href="{{ route('schedule-back.create') }}" class="btn btn-sm btn-primary"><i
                  class="fas fa-plus-circle"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class="row">
                @foreach ($schedule_subject as $schedule_subjects)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body" style="text-align: center !important;">
                            <h6 class="mb-3">{{ Str::limit($schedule_subjects->days->hari, 30) }}</h6>
                            <p class="card-text text-dark">{{ $schedule_subjects->matkul }}</p>
                            @php
                              $count = 0;
                            @endphp
                            @foreach (explode(',', $schedule_subjects->waktu) as $item)
                              
                              <span class="card-text text-dark">{{ $item }} 
                                @if($count == 0)
                                -
                                @endif
                              </span>

                              @php $count++ @endphp
                            @endforeach
                            <div class="btn-group text-center buttonGroup mt-3" id="buttonGroup">
                                <a href="{{ route('schedule-back.edit', $schedule_subjects->id) }}" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteConfirm" onclick="deleteThisSchedule({{$schedule_subjects}})"><i
                                        class="far fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        <div class="d-flex justify-content-center">
          {{ $schedule_subject->links('vendor.pagination.custom_pagination') }}
      </div>
    </div>
  </div>
</section>


@foreach ($schedule_subject as $schedule_subjects)
<div class="modal fade" tabindex="-1" role="dialog" id="more{{$schedule_subjects->id}}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rincian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card"> 
          <div class="card-body"> 
              <h6 class="card-title text-dark" style="font-size: 14px;">{{ $schedule_subjects->days->hari }}</h6>
                
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach

<div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirm">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('schedule-back.destroy', '') }}" method="post" id="deleteScheduleForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> schedule ini ?
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary" id="deleteModalButton">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>

$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

const deleteSchedule = $("#deleteScheduleForm").attr('action');

  function deleteThisSchedule(data) {
    $("#deleteScheduleForm").attr('action', `${deleteSchedule}/${data.id}`);
  }
</script>
@endsection