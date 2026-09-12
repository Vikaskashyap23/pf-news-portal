@extends('adminlte::page')

@section('title', 'Super Admin Dashboard')

@section('content_header')
    <h1>NewsHub CMS Dashboard</h1>
@stop

@section('content')

<div class="row">

    {{-- Total Users --}}
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>

            <div class="icon">
                <i class="fas fa-users"></i>
            </div>

            <a href="{{ route('users.index') }}" class="small-box-footer">
                Manage Users
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Super Admins --}}
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalSuperAdmins }}</h3>
                <p>Super Admins</p>
            </div>

            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>

            <a href="{{ route('users.index') }}" class="small-box-footer">
                View Users
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Admins --}}
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalAdmins }}</h3>
                <p>Admins</p>
            </div>

            <div class="icon">
                <i class="fas fa-user-cog"></i>
            </div>

            <a href="{{ route('users.index') }}" class="small-box-footer">
                View Admins
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>


<div class="row">

    {{-- Websites --}}
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalWebsites }}</h3>
                <p>Total Websites</p>
            </div>

            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>

            <a href="{{ route('websites.index') }}" class="small-box-footer">
                Manage Websites
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- News --}}
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $totalNews }}</h3>
                <p>Total News</p>
            </div>

            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>

            <a href="{{ route('news.index') }}" class="small-box-footer">
                Manage News
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Categories --}}
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>{{ $totalCategories }}</h3>
                <p>Total Categories</p>
            </div>

            <div class="icon">
                <i class="fas fa-list"></i>
            </div>

            <a href="{{ route('categories.index') }}" class="small-box-footer">
                Manage Categories
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>


{{-- Welcome Card --}}
<div class="card mt-3">

    <div class="card-header">
        <h3 class="card-title">
            Welcome, {{ auth()->user()->name }}
        </h3>
    </div>

    <div class="card-body">

        <p class="mb-0">
            You are logged in as
            <strong>
                {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
            </strong>.
        </p>

    </div>

</div>

@stop