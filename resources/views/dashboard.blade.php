@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>
        <i class="fas fa-tachometer-alt"></i> Dashboard
        <small>Welcome back, {{ Auth::user()->name }}!</small>
    </h1>
@stop

@section('content')
    <div class="container-fluid">
        {{-- Info boxes --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>User Profile</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ Auth::user()->email }}</h3>
                        <p>Email Address</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ Auth::user()->created_at->format('M d, Y') }}</h3>
                        <p>Member Since</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Account Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Active</h3>
                        <p>Account Status</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Status Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Main content cards --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Welcome to Your Dashboard
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="lead">You have successfully logged in to your account.</p>

                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-info"></i> Information</h5>
                            This is a protected page. Only authenticated users can access this area.
                        </div>

                        <h5>Quick Actions:</h5>
                        <p>Use the sidebar navigation to access different features of the application.</p>

                        <div class="mt-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </a>
                            @can('view users')
                                <a href="{{ route('users.index') }}" class="btn btn-info">
                                    <i class="fas fa-users"></i> User Management
                                </a>
                            @endcan
                            <a href="#" class="btn btn-secondary">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- User details card --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-circle"></i>
                            Account Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Name:</th>
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ Auth::user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Registered:</th>
                                <td>{{ Auth::user()->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Update:</th>
                                <td>{{ Auth::user()->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Email Verified:</th>
                                <td>
                                    @if(Auth::user()->email_verified_at)
                                        <span class="badge badge-success">Verified</span>
                                    @else
                                        <span class="badge badge-warning">Not Verified</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-shield-alt"></i>
                            Security & Roles
                        </h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Roles:</strong></p>
                        @if(Auth::user()->roles->count() > 0)
                            <div class="mb-3">
                                @foreach(Auth::user()->roles as $role)
                                    <span class="badge badge-primary mr-1">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No roles assigned</p>
                        @endif

                        <p><strong>Permissions:</strong></p>
                        @if(Auth::user()->permissions->count() > 0)
                            <div>
                                @foreach(Auth::user()->permissions->take(10) as $permission)
                                    <span class="badge badge-info mr-1">{{ $permission->name }}</span>
                                @endforeach
                                @if(Auth::user()->permissions->count() > 10)
                                    <span class="badge badge-secondary">+{{ Auth::user()->permissions->count() - 10 }} more</span>
                                @endif
                            </div>
                        @else
                            <p class="text-muted">No permissions assigned</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .small-box-footer {
            text-align: center;
            padding: 10px 0;
            display: block;
            background: rgba(0, 0, 0, 0.05);
            color: inherit;
        }

        .small-box-footer:hover {
            background: rgba(0, 0, 0, 0.1);
            color: inherit;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Dashboard loaded successfully');
    </script>
@stop
