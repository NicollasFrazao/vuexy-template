@php
$configData = Helper::appClasses();
$navbarType = 'layout-navbar-full';
@endphp

@extends('layouts.app')

@section('title', 'Navbar Full - Layouts')

@section('content')

<!-- Layout Demo -->
<div class="layout-demo-wrapper">
  <div class="layout-demo-placeholder">
    <img src="{{ asset('assets/img/layouts/layout-content-navbar-' . $configData['theme'] . '.png') }}"
      class="img-fluid" alt="Layout navbar full"
      data-app-light-img="layouts/layout-content-navbar-light.png"
      data-app-dark-img="layouts/layout-content-navbar-dark.png">
  </div>
  <div class="layout-demo-info">
    <h4>Layout Navbar Full</h4>
    <p>Full-width navbar layout that spans the entire width of the page, including the sidebar area.</p>
    <div class="alert alert-primary mt-6" role="alert">
      <span class="fw-medium">Note:</span> In this layout, the navbar extends across the full width of the viewport,
      providing a consistent top navigation experience.
    </div>
  </div>
</div>
<!--/ Layout Demo -->

@endsection
