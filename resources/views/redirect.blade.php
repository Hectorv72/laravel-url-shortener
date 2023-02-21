@extends('base')

@section('title')
    Shorty - redirect
@endsection

@section('head')
    <style>
        .image {
            width: 45%;
            height: auto;
        }
    </style>
@endsection

@section('body')
    <div>
        <img src="{{ asset('images/shorty_splash.png') }}" class="image position-absolute top-50 start-50 translate-middle" />
    </div>
@endsection

@section('script')
    <script>
        setTimeout(() => {
            document.location.replace("{{ $urldir }}")
        }, 1000);
    </script>
@endsection
