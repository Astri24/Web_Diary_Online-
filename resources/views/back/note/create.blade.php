@extends('layouts.back', ['web' => $web])
@section('title', 'Tambah Note')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
  integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .dropify-wrapper {
    border: 1px solid #e2e7f1;
    border-radius: .3rem;
    height: 100% !important;
  }

  .card {
    border-radius: 10px;
  }
  .cke_chrome {
    border: 1px solid #e9e9e9;
    border-width: thin;
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
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <form method="post" action="{{ route('note-back.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4>Tambah Note</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label>Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" placeholder="Judul"> 
                                @error('judul')
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-8 col-12">
                                <label>Konten</label>
                                <br>
                                <textarea class="form-control @error('konten') is-invalid @enderror" name="konten" id="konten" placeholder="Konten">
                                  {{ old('konten') }}
                                </textarea>
                                @error('konten')
                                  <style>
                                    .cke_chrome {
                                        border: 1px solid #dc3545 !important;
                                        border-width: thin;
                                    }
                                  </style>
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 col-12">
                              <label>Thumbnail</label>
                              <input type="file" class="form-control dropify" name="gambar"
                                  data-allowed-file-extensions="png jpg jpeg" data-show-remove="false">
                                  @error('gambar')
                                  <style>
                                      .dropify-wrapper {
                                          border: 1px solid #dc3545 !important;
                                          border-radius: .3rem !important;
                                          height: 100% !important;
                                      }
                                  </style>
                                  <div class="mt-1">
                                      <span class="text-danger">{{ $message }}</span>
                                  </div>
                                  @enderror
                          </div>
                        </div>
                        <div class="row"> 
                            
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('note-back.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                </form>
            </div>
        </div>
    </div>   
  </div>
</section>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
  integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/ckeditor/ckeditor.js')}}"></script>
  <script>
    $('.dropify').dropify();
  </script>
  <script>
    var options = {
      filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
      filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
      height:['450px']
    };
</script>
<script>
    CKEDITOR.replace('konten', options);
</script>
@endsection