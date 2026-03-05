@extends('layouts.app')

@section('title', 'Shepherd tour - Extended UI')

<!-- Vendor Styles -->
@push('vendor-styles')
  @vite('resources/assets/vendor/libs/shepherd/shepherd.scss')
@endpush

<!-- Vendor Scripts -->
@push('vendor-scripts')
  @vite('resources/assets/vendor/libs/shepherd/shepherd.js')
@endpush

<!-- Page Scripts -->
@push('scripts')
  @vite('resources/assets/js/extended-ui-tour.js')
@endpush

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card tour-card">
        <h5 class="card-header">Tour</h5>
        <div class="card-body">
          <button class="btn btn-primary" id="shepherd-example">Start tour</button>
        </div>
      </div>
    </div>
  </div>
@endsection
