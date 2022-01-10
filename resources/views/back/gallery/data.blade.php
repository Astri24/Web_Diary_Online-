@extends('layouts.back', ['web' => $web])
@section('title', 'Gallery')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
  integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .dropify-wrapper {
    border: 1px solid #e2e7f1;
    border-radius: .3rem;
    height: 150px;
  }

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
    <h1>Gallery</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Gallery</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <a href="{{ route('gallery-back.create') }}" class="btn btn-sm btn-primary"><i
                  class="fas fa-plus-circle"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
            <div class="row">
                @foreach ($gallery as $galleryAll)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-3">{{ Str::limit($galleryAll->judul, 30) }}</h6>
                            <img src="{{ Storage::url($galleryAll->gambar) }}" class="img-fluid rounded mt-1"
                                style="width:100%; height:300px; object-fit:cover;">
                            <div class="btn-group text-center buttonGroup mt-3" id="buttonGroup">
                                <a href="{{ route('gallery-back.edit', $galleryAll->id) }}" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteConfirm" onclick="deleteThisGallery({{$galleryAll}})"><i
                                        class="far fa-trash-alt"></i></button>
                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal"
                                    data-target="#more{{ $galleryAll->id }}" onclick="successAlert({{ $galleryAll }})">More</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        <div class="d-flex justify-content-center">
          {{ $gallery->links('vendor.pagination.custom_pagination') }}
      </div>
    </div>
  </div>
</section>


@foreach ($gallery as $galleryAll)
<div class="modal fade" tabindex="-1" role="dialog" id="more{{$galleryAll->id}}">
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
            <h6 class="card-title text-dark mb-3" style="font-size: 14px;">{{ $galleryAll->judul }}</h6>
              <img src="{{ Storage::url($galleryAll->gambar) }}" class="card-img-top" alt="Placeholder" style="width: 300px;"> 
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
      <form action="{{ route('gallery-back.destroy', '') }}" method="post" id="deleteGalleryForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> gallery ini ?
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
  integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $('.dropify').dropify();
</script>

<script>

$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

const deleteGallery = $("#deleteGalleryForm").attr('action');

  function deleteThisGallery(data) {
    $("#deleteGalleryForm").attr('action', `${deleteGallery}/${data.id}`);
  }
</script>
@endsection