@extends('layouts.front', ['web' => $web])
@section('css')
<style>
    .note-content {
    max-width: 100%;
    height: auto !important;
    font-size: 16px;
    line-height: 27.2px;
    }

@media screen and (max-width: 455px) {
    #ckeditorContent img {
        max-width: 100% !important;
        width: 100% !important;
        height: auto !important;

    }
}
</style>
@endsection
@section('container')
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
@endsection