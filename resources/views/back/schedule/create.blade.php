@extends('layouts.back', ['web' => $web])
@section('title', 'Tambah Schedule')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
  .card {
    border-radius: 10px;
  }

  label.error {
    color: #f1556c;
    font-size: 13px;
    font-size: .875rem;
    font-weight: 400;
    line-height: 1.5;
    margin-top: 5px;
    padding: 0;
  }

  input.error {
    color: #f1556c;
    border: 1px solid #f1556c;
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
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('schedule-back.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Tambah Schedule</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label>Hari</label>
                                @if(count($schedule_day))
                                <select class="form-control" name="day_id">
                                  @foreach($schedule_day as $schedule_days)
                                    <option value="{{ $schedule_days->id }}">{{ $schedule_days->hari }}</option>
                                  @endforeach
                                </select>
                                @else
                                <input type="text" class="form-control @error('day_id') is-invalid @enderror" name="day_id" placeholder="Hari" disabled> 
                                @endif
                                @error('day_id')
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                @enderror
                                <button type="button" data-toggle="modal" data-target="#hari" class="btn btn-sm btn-outline-secondary mt-3" style="border-color: #e2e7f1; color:  rgb(73, 80, 87); font-size: 12px; font-weight: 400;">+ Hari</button>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Matkul</label>
                                <input type="text" class="form-control @error('matkul') is-invalid @enderror" name="matkul" value="{{ old('matkul') }}" placeholder="Matkul"> 
                                @error('matkul')
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Waktu</label>
                                <p>Dari</p>
                                <input type="time" class="form-control @error('waktu') is-invalid @enderror" name="waktu[]" value="00:00" placeholder="Dari"> 
                                @error('waktu')
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6 col-12 d-flex flex-column justify-content-end">
                              <p>Sampai</p>
                              <input type="time" class="form-control @error('waktu') is-invalid @enderror" name="waktu[]" value="00:00" placeholder="Sampai"> 
                                @error('waktu')
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('schedule-back.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>   
  </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="hari">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hari</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <button type="button" data-toggle="modal" data-target="#tambahHari" id="tambahModalButton" class="btn btn-sm btn-primary mb-3"><i class="fas fa-plus-circle"></i></button>
            @foreach ($schedule_day as $item)
                <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between">
                          <div class="day">
                              {{ $item->hari }}
                          </div>
                          <div class="edit_day">
                            <button type="button" data-toggle="modal" data-target="#editHari{{ $item->id }}" onclick="editFunction({{$item->id}})" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteConfirm" onclick="deleteThisScheduleDay({{ $item }})"><i
                                        class="far fa-trash-alt"></i></button>
                          </div>
                      </div>
                  </div>
                </div>
            @endforeach
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-secondary">Kembali</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="tambahHari">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Hari</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form action="{{ route('schedule-day.store') }}" method="post" id="addScheduleForm">
                @csrf
                <div class="form-group">
                  <input type="text" class="form-control @error('hari') is-invalid @enderror" name="hari" placeholder="Hari">
                  @error('hari')
                    <div class="mt-1">
                      <span class="text-danger">{{ $message }}</span>
                    </div>
                  @enderror
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-secondary">Kembali</button>
          <button type="submit" class="btn btn-primary">Simpan Hari</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($schedule_day as $item)
<div class="modal fade" tabindex="-1" role="dialog" id="editHari{{ $item->id }}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Hari</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form action="{{ route('schedule-day.update', $item->id) }}" method="post" id="editScheduleForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="checkHari" value="{{ $item->hari }}">
                <div class="form-group">
                  <input type="text" class="form-control @error('edit_hari') is-invalid @enderror" name="edit_hari" value="{{ $item->hari }}" placeholder="Hari">
                  @error('edit_hari')
                    <div class="mt-1">
                      <span class="text-danger">{{ $message }}</span>
                    </div>
                  @enderror
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn btn-secondary">Kembali</button>
          <button type="submit" class="btn btn-primary">Simpan Hari</button>
        </div>
      </form>
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
      <form action="{{ route('schedule-day.destroy', '') }}" method="post" id="deleteScheduleForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> hari ini ?
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

<script>
  const deleteSchedule = $("#deleteScheduleForm").attr('action');

  function deleteThisScheduleDay(data) {
    $("#deleteScheduleForm").attr('action', `${deleteSchedule}/${data.id}`);
    $("#deleteConfirm").on('hidden.bs.modal', function () {
      $('#hari').modal('show');
    });
    $('#hari').modal('hide');
  }

  function editFunction(id){
    $('#editHari' + id).on('hidden.bs.modal', function () {
      $('#hari').modal('show');
    });
    $('#hari').modal('hide');
  }

  $('#tambahModalButton').click(function() {
    $('#hari').modal('hide');
  });

  $('#tambahHari').on('hidden.bs.modal', function () {
    $('#hari').modal('show');
  });

  $.ajaxSetup({
    headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $("#addScheduleForm").validate({
    rules: {
      hari:{
            required: true,
            remote: {
                      url: "{{ route('checkHari') }}",
                      type: "post",
            }
        },
    },
    messages: {
      hari: {
              required: "Hari harus di isi",
              remote: "Hari sudah tersedia"
        }
    },
  });
  
  $("#editScheduleForm").validate({
    rules: {
      edit_hari:{
            required: true,
            remote: {
                      param: {
                            url: "{{ route('checkHari') }}",
                            type: "post",
                      },
                      depends: function(element) {
                        // compare name in form to hidden field
                        return ($(element).val() !== $('#checkHari').val());
                      },
                    }
        },
    },
    messages: {
      edit_hari: {
              required: "Hari harus di isi",
              remote: "Hari sudah tersedia"
        }
    },
  });
</script>
@endsection