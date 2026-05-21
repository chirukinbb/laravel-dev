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
                            <a href="{{ route('profile') }}" class="btn btn-success">
                                <i class="fas fa-user"></i> My Profile
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
    </div>
@stop

@section('js')
    <script>
        console.log('Dashboard loaded successfully');
    </script>
@stop
