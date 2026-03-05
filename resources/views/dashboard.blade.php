@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    {{-- Statistics Cards - using x-stat-card component --}}
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <x-stat-card
            title="Total Users"
            :value="number_format($stats['users'])"
            icon="tabler-users"
            color="primary"
            trend="+12%"
            subtitle="Last month analytics"
        />
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <x-stat-card
            title="Total Revenue"
            value="{{ '$' . number_format($stats['revenue']) }}"
            icon="tabler-currency-dollar"
            color="success"
            trend="+28%"
            subtitle="Last month analytics"
        />
    </div>

    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
        <x-stat-card
            title="Total Orders"
            :value="number_format($stats['orders'])"
            icon="tabler-shopping-cart"
            color="info"
            trend="-8%"
            trend-type="down"
            subtitle="Last month analytics"
        />
    </div>
</div>

{{-- Additional Content Row --}}
<div class="row">
    <div class="col-12 col-lg-8 mb-4">
        <x-card title="Recent Activity">
            <x-slot:headerActions>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="recentActivity" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="recentActivity">
                        <a class="dropdown-item" href="javascript:void(0);">View All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    </div>
                </div>
            </x-slot:headerActions>
            <ul class="timeline ms-2">
                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-1">
                            <h6 class="mb-0">New user registered</h6>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                        <p class="mb-2">A new user has successfully registered to the platform.</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-success"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-1">
                            <h6 class="mb-0">Payment received</h6>
                            <small class="text-muted">5 hours ago</small>
                        </div>
                        <p class="mb-2">Payment of $450 has been received from client.</p>
                    </div>
                </li>
                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-info"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-1">
                            <h6 class="mb-0">New order placed</h6>
                            <small class="text-muted">8 hours ago</small>
                        </div>
                        <p class="mb-0">Order #12345 has been placed successfully.</p>
                    </div>
                </li>
            </ul>
        </x-card>
    </div>

    <div class="col-12 col-lg-4 mb-4">
        <x-card title="Quick Stats">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column">
                    <span class="fw-medium">Active Sessions</span>
                    <small class="text-muted">Current active users</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">142</h6>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column">
                    <span class="fw-medium">Pending Orders</span>
                    <small class="text-muted">Awaiting processing</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">23</h6>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex flex-column">
                    <span class="fw-medium">Support Tickets</span>
                    <small class="text-muted">Open tickets</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-1">
                    <h6 class="mb-0">8</h6>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection
