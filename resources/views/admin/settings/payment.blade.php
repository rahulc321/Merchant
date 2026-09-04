@extends('layouts.admin')
@section('title', 'Payment Settings')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment Settings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Payment Gateway Settings</div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            Add credentials for Pesapal and Selcom. Users can choose either gateway on the subscription payment page.
                        </div>
                        <form action="{{ route('admin.payment-settings.update') }}" method="POST">
                            @csrf

                            <ul class="nav nav-tabs mb-4" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">General</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pesapal" type="button">Pesapal</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#selcom" type="button">Selcom</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="general">
                                    <div class="row">
                                        <div class="col-md-6 mb-3 d-none">
                                            <label class="form-label">Active Gateway</label>
                                            <select name="gateway" class="form-control" required>
                                                <option value="pesapal" {{ $setting->gateway == 'pesapal' ? 'selected' : '' }}>Pesapal</option>
                                                <option value="selcom" {{ $setting->gateway == 'selcom' ? 'selected' : '' }}>Selcom</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Currency</label>
                                            <input type="text" name="currency" class="form-control" value="{{ old('currency', $setting->currency ?: 'TZS') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pesapal">
                                    <div class="alert alert-warning">
                                        Pesapal live API base URL is https://pay.pesapal.com/v3/api/. Use live merchant credentials for production.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Consumer Key</label>
                                            <input type="text" name="pesapal_consumer_key" class="form-control" value="{{ old('pesapal_consumer_key', $setting->pesapal_consumer_key) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Consumer Secret</label>
                                            <input type="text" name="pesapal_consumer_secret" class="form-control" value="{{ old('pesapal_consumer_secret', $setting->pesapal_consumer_secret) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Base URL</label>
                                            <input type="url" name="pesapal_base_url" class="form-control" value="{{ old('pesapal_base_url', $setting->pesapal_base_url) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">IPN URL</label>
                                            <input type="url" name="pesapal_ipn_url" class="form-control" value="{{ old('pesapal_ipn_url', $setting->pesapal_ipn_url ?: url('/subscription-payment/ipn')) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="selcom">
                                    <div class="alert alert-warning">
                                        Selcom live API also requires your server public IP to be whitelisted by Selcom for your vendor/till account.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">API Key</label>
                                            <input type="text" name="selcom_api_key" class="form-control" value="{{ old('selcom_api_key', $setting->selcom_api_key) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">API Secret</label>
                                            <input type="text" name="selcom_api_secret" class="form-control" value="{{ old('selcom_api_secret', $setting->selcom_api_secret) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Base URL</label>
                                            <input type="url" name="selcom_base_url" class="form-control" value="{{ old('selcom_base_url', $setting->selcom_base_url) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Vendor / Till</label>
                                            <input type="text" name="selcom_vendor" class="form-control" value="{{ old('selcom_vendor', $setting->selcom_vendor) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
