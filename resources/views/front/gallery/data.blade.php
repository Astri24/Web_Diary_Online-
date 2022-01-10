@extends('layouts.front', ['web' => $web])
@section('css')
<link rel="stylesheet" href="{{ asset('assets/lightbox/simple-lightbox.css') }}" />

<style>
        .gallery a img {
          
            cursor: pointer;
        }

</style>
@endsection
@section('container')
<div class="row">
    <div class="col-sm-12">
        <h3 style="font-family: 'Playfair Display', serif; text-align:center;">Gallery</h3>
    </div>
</div>
<div class="row mt-3">
    @foreach($gallery as $galleries)
    <div class="col-sm-4 p-3">
        <div class="gallery" style="overflow:hidden;">
            <a href="{{ Storage::url($galleries->gambar) }}"><img src="{{ Storage::url($galleries->gambar) }}" style="width: 100%; height: 390px; object-fit: cover;" title="{{ $galleries->judul }}" /></a>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mt-5">
    {{ $gallery->links('vendor.pagination.front_custom_pagination') }}
</div> 

@endsection

@section('js')
<script src="{{ asset('assets/lightbox/simple-lightbox.js') }}"></script>
<script>
    let gallery = new SimpleLightbox('.gallery a', {});
</script>
@endsection