@extends('layouts.front', ['web' => $web])
@section('css')
    <style>
        .gambar {
            transition: transform .2s;
            cursor: pointer;
        }
        .gambar:hover {
            transform: scale(1.2); 
        }
        @media screen and (max-width: 455px) {
           .row .distance {
               padding-right: 17px !important;
               padding-left: 17px !important;
            }
        }
</style>
@endsection
@section('container')
    <div class="row">
        @foreach($note as $notes)
        <div class="col-sm-4 distance" style="padding-right: 30px; padding-bottom: 50px;">
            <a href="{{ route('note.show', $notes->slug) }}">
                <div class="img-container" style="overflow: hidden;">
                    <img src="{{ Storage::url($notes->gambar) }}" class="gambar"  style="width: 100%; height: 350px; object-fit: cover;">                 
                </div>
            </a>
            <a href="{{ route('note.show', $notes->slug) }}" class="text-dark" style="text-decoration: none;"><h5 style="font-family: 'Playfair Display', serif; text-align: center; margin-top: 14px; padding:17px; line-height: 30px;">{{ Str::limit($notes->judul, 67) }}</h5></a>
            <p class="text-muted mt-1 text-center text-uppercase" style="font-size: 13px;">BY {{ $notes->creators->name }} / {{ $notes->updated_at->format('d, M Y') }}</p>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $note->links('vendor.pagination.front_custom_pagination') }}
    </div>
@endsection