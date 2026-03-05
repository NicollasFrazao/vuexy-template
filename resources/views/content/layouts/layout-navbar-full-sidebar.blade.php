@php
$configData = Helper::appClasses();
$isFlex = true;
$navbarType = 'layout-navbar-full';
@endphp

@extends('layouts.app')

@section('title', 'Navbar Full + Sidebar - Layouts')

@section('content')

<div class="flex-shrink-1 flex-grow-0 w-px-350 border-end container-p-x container-p-y">
  <div class="layout-example-sidebar layout-example-content-inner">Sidebar</div>
</div>

<div class="flex-shrink-1 flex-grow-1 container-p-x container-p-y">
  <!-- Layout Demo -->
  <div class="layout-demo-wrapper">
    <div class="layout-demo-placeholder">
      <img src="{{ asset('assets/img/layouts/layout-content-navbar-and-sidebar-' . $configData['theme'] . '.png') }}"
        class="img-fluid" alt="Layout navbar full + sidebar"
        data-app-light-img="layouts/layout-content-navbar-and-sidebar-light.png"
        data-app-dark-img="layouts/layout-content-navbar-and-sidebar-dark.png">
    </div>
    <div class="layout-demo-info">
      <h4>Layout Navbar Full + Sidebar</h4>
      <p>Full-width navbar layout combined with an inner content sidebar for additional navigation or filters.</p>
      <div class="alert alert-primary mt-6" role="alert">
        <span class="fw-medium">Note:</span> This layout combines a full-width navbar with an inner sidebar,
        useful for pages that require secondary navigation or contextual content panels.
      </div>
    </div>
  </div>
  <!--/ Layout Demo -->
</div>

@endsection
