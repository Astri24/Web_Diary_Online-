@extends('layouts.back', ['web' => $web])
@section('title', 'Note')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
  .card {
    border-radius: 10px;
  }
  #buttonGroup {
    display: block;
  }

  .card-body .ckeditor-image img {
    width: 200px !important;
  }
</style>
@endsection
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Note</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Note</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <a href="{{ route('note-back.create') }}" class="btn btn-sm btn-primary"><i
                  class="fas fa-plus-circle"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class="row">
                @foreach ($note as $noteAll)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3">{{ Str::limit($noteAll->judul, 30) }}</h6>
                            <img src="{{ Storage::url($noteAll->gambar) }}" class="img-fluid rounded mt-1"
                                style="width:100%; height:300px; object-fit:cover;">
                            <div class="btn-group text-center buttonGroup mt-3" id="buttonGroup">
                                <a href="{{ route('note-back.edit', $noteAll->id) }}" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteConfirm" onclick="deleteThisNote({{$noteAll}})"><i
                                        class="far fa-trash-alt"></i></button>
                                <a href="{{ route('note-back.show', $noteAll->slug) }}" class="btn btn-sm btn-dark" >Preview</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        <div class="d-flex justify-content-center">
          {{ $note->links('vendor.pagination.custom_pagination') }}
      </div>
    </div>
  </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirm">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('note-back.destroy', '') }}" method="post" id="deleteNoteForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> note ini ?
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

const deleteNote = $("#deleteNoteForm").attr('action');

  function deleteThisNote(data) {
    $("#deleteNoteForm").attr('action', `${deleteNote}/${data.id}`);
  }

</script>
@endsection