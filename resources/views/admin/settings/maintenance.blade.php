@extends('layouts.admin')
@section('title', 'Maintenance')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Maintenance</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Run Migration Command</div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            This will run php artisan migrate --force on the current database.
                        </div>

                        <form action="{{ route('admin.maintenance.migrate') }}" method="POST" onsubmit="return confirm('Are you sure you want to run migrations now?')">
                            @csrf
                            <button type="submit" class="btn btn-primary">Run Migrations</button>
                        </form>

                        @if(session('artisan_output'))
                        <div class="mt-4">
                            <h6>Command Output</h6>
                            <pre class="bg-light border rounded p-3 mb-0" style="white-space: pre-wrap;">{{ session('artisan_output') }}</pre>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Run Seeder Command</div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            This will run the selected db:seed command on the current database.
                        </div>

                        <form action="{{ route('admin.maintenance.seed') }}" method="POST" onsubmit="return confirm('Are you sure you want to run this seeder now?')">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-8">
                                    <select name="seeder" class="form-control" required>
                                        <option value="SubscriptionPlansTableSeeder">Subscription Plans Seeder</option>
                                        <option value="PaymentSettingsTableSeeder">Payment Settings Seeder</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary w-100">Run Seeder</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
