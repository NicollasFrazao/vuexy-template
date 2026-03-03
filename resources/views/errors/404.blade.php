@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found :(</h2>
        <p class="mb-4 mx-2">Oops! The page you are looking for doesn't exist.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Back to home</a>
        <div class="mt-3">
            <img src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}"
                 alt="page-misc-error-light"
                 width="500"
                 class="img-fluid"
                 data-app-dark-img="illustrations/page-misc-error-dark.png"
                 data-app-light-img="illustrations/page-misc-error-light.png" />
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .misc-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 10rem);
        text-align: center;
    }
</style>
@endpush
