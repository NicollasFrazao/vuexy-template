@extends('layouts.app')

@section('title', 'Checkout - Front Pages')

<!-- Vendor Styles -->
@push('vendor-styles')
@vite([
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
'resources/assets/vendor/libs/raty-js/raty-js.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endpush

<!-- Page Styles -->
@push('styles')
@vite(['resources/assets/vendor/scss/pages/wizard-ex-checkout.scss'])
@endpush

<!-- Vendor Scripts -->
@push('vendor-scripts')
@vite([
'resources/assets/vendor/libs/jquery/jquery.js',
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
'resources/assets/vendor/libs/raty-js/raty-js.js',
'resources/assets/vendor/libs/cleave-zen/cleave-zen.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endpush

<!-- Page Scripts -->
@push('scripts')
@vite([
'resources/assets/js/modal-add-new-address.js',
'resources/assets/js/wizard-ex-checkout.js'
])
@endpush


@section('content')
<section class="section-py bg-body first-section-pt">
  <div class="container">
    <!--/ Checkout Wizard -->
    @include('_partials/wizard-ex-checkout')

    <!-- Add new address modal -->
    @include('_partials/_modals/modal-add-new-address')
  </div>
</section>
@endsection