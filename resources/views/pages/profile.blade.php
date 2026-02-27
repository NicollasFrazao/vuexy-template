@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="row">
    <!-- User Profile Header -->
    <div class="col-12">
        <div class="card mb-4">
            <div class="user-profile-header-banner">
                <img src="https://via.placeholder.com/1920x300/696cff/ffffff?text=Profile+Banner" alt="Banner image" class="rounded-top" style="width: 100%; height: 250px; object-fit: cover;">
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img src="https://ui-avatars.com/api/?name=John+Doe&size=120&background=696cff&color=fff" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" style="width: 120px; height: 120px; margin-top: -60px; border: 5px solid #fff;">
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4>John Doe</h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item">
                                    <i class="ti ti-palette"></i> UX Designer
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti ti-map-pin"></i> San Francisco, CA
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti ti-calendar"></i> Joined April 2021
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('pages.account-settings') }}" class="btn btn-primary">
                            <i class="ti ti-settings me-1"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- About User -->
    <div class="col-xl-4 col-lg-5 col-md-5">
        <div class="card mb-4">
            <div class="card-body">
                <small class="card-text text-uppercase">About</small>
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-user"></i>
                        <span class="fw-medium mx-2">Full Name:</span>
                        <span>John Doe</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-check"></i>
                        <span class="fw-medium mx-2">Status:</span>
                        <span>Active</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-crown"></i>
                        <span class="fw-medium mx-2">Role:</span>
                        <span>Developer</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-flag"></i>
                        <span class="fw-medium mx-2">Country:</span>
                        <span>USA</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-language"></i>
                        <span class="fw-medium mx-2">Languages:</span>
                        <span>English, Spanish</span>
                    </li>
                </ul>
                <small class="card-text text-uppercase">Contacts</small>
                <ul class="list-unstyled mb-4 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-phone-call"></i>
                        <span class="fw-medium mx-2">Contact:</span>
                        <span>(123) 456-7890</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-mail"></i>
                        <span class="fw-medium mx-2">Email:</span>
                        <span>john.doe@example.com</span>
                    </li>
                </ul>
                <small class="card-text text-uppercase">Teams</small>
                <ul class="list-unstyled mb-0 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-brand-angular text-danger me-2"></i>
                        <div class="d-flex flex-wrap">
                            <span class="fw-medium me-2">Backend Developer</span>
                            <span>(126 Members)</span>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ti ti-brand-react text-info me-2"></i>
                        <div class="d-flex flex-wrap">
                            <span class="fw-medium me-2">React Developer</span>
                            <span>(98 Members)</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Social Links -->
        <div class="card mb-4">
            <div class="card-body">
                <small class="card-text text-uppercase">Social Links</small>
                <ul class="list-unstyled mb-0 mt-3">
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-brand-twitter text-info me-2"></i>
                        <span class="fw-medium mx-2">Twitter:</span>
                        <span>@johndoe</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-brand-facebook text-primary me-2"></i>
                        <span class="fw-medium mx-2">Facebook:</span>
                        <span>john.doe</span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="ti ti-brand-linkedin text-primary me-2"></i>
                        <span class="fw-medium mx-2">LinkedIn:</span>
                        <span>john-doe</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ti ti-brand-github me-2"></i>
                        <span class="fw-medium mx-2">GitHub:</span>
                        <span>johndoe</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Activity Timeline & Projects -->
    <div class="col-xl-8 col-lg-7 col-md-7">
        <!-- Activity Timeline -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Activity Timeline</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="timelineDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="timelineDropdown">
                        <a class="dropdown-item" href="javascript:void(0);">View All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="timeline ms-2">
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">12 Invoices have been paid</h6>
                                <small class="text-muted">12 min ago</small>
                            </div>
                            <p class="mb-2">Invoices have been paid to the company</p>
                            <div class="d-flex">
                                <a href="javascript:void(0)" class="me-3">
                                    <img src="https://via.placeholder.com/28x28/696cff/ffffff?text=PDF" alt="invoice.pdf" width="28" class="rounded">
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-warning"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Client Meeting</h6>
                                <small class="text-muted">45 min ago</small>
                            </div>
                            <p class="mb-2">Project meeting with john @10:15am</p>
                            <div class="d-flex flex-wrap">
                                <div class="avatar me-3">
                                    <img src="https://ui-avatars.com/api/?name=John+Smith&size=32&background=ff9f43&color=fff" alt="Avatar" class="rounded-circle">
                                </div>
                                <div>
                                    <h6 class="mb-0">John Smith (Client)</h6>
                                    <span>CEO of Pixinvent</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-info"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Create a new project for client</h6>
                                <small class="text-muted">2 day ago</small>
                            </div>
                            <p class="mb-2">5 team members in a project</p>
                            <div class="d-flex align-items-center avatar-group">
                                <div class="avatar pull-up">
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?name=User+1&size=32&background=696cff&color=fff" alt="Avatar">
                                </div>
                                <div class="avatar pull-up">
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?name=User+2&size=32&background=ff9f43&color=fff" alt="Avatar">
                                </div>
                                <div class="avatar pull-up">
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?name=User+3&size=32&background=28c76f&color=fff" alt="Avatar">
                                </div>
                                <div class="avatar pull-up">
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?name=User+4&size=32&background=ea5455&color=fff" alt="Avatar">
                                </div>
                                <div class="avatar pull-up">
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?name=User+5&size=32&background=00cfe8&color=fff" alt="Avatar">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                        <span class="timeline-point timeline-point-success"></span>
                        <div class="timeline-event">
                            <div class="timeline-header mb-1">
                                <h6 class="mb-0">Design Review</h6>
                                <small class="text-muted">5 days ago</small>
                            </div>
                            <p class="mb-0">Weekly review of freshly prepared design for our new app.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Projects -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Projects</h5>
                <a href="javascript:void(0);" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border shadow-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="ti ti-brand-react ti-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">React Project</h6>
                                        <small class="text-muted">React Dashboard</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-label-primary">React</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=A&size=24&background=696cff&color=fff" alt="Avatar">
                                            </div>
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=B&size=24&background=ff9f43&color=fff" alt="Avatar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card border shadow-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class="ti ti-brand-vue ti-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Vue Project</h6>
                                        <small class="text-muted">Vue Admin Template</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-label-success">Vue</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=C&size=24&background=28c76f&color=fff" alt="Avatar">
                                            </div>
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=D&size=24&background=ea5455&color=fff" alt="Avatar">
                                            </div>
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=E&size=24&background=00cfe8&color=fff" alt="Avatar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-md-0 mb-4">
                        <div class="card border shadow-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class="ti ti-brand-angular ti-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Angular Project</h6>
                                        <small class="text-muted">Angular Dashboard</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-label-info">Angular</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=F&size=24&background=00cfe8&color=fff" alt="Avatar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border shadow-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded bg-label-warning">
                                            <i class="ti ti-brand-laravel ti-md"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Laravel Project</h6>
                                        <small class="text-muted">Laravel API</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-label-warning">Laravel</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-group">
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=G&size=24&background=ff9f43&color=fff" alt="Avatar">
                                            </div>
                                            <div class="avatar avatar-xs pull-up">
                                                <img class="rounded-circle" src="https://ui-avatars.com/api/?name=H&size=24&background=696cff&color=fff" alt="Avatar">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
