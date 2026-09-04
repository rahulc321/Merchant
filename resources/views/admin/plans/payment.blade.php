@extends('layouts.admin')
@section('title', 'Subscription Payment')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.plans.browse') }}">Subscriptions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Subscription Payment</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Plan</th>
                                <td>{{ $purchase->plan->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>TZ {{ number_format($purchase->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Days</th>
                                <td>{{ $purchase->days }}</td>
                            </tr>
                            <tr>
                                <th>Uses</th>
                                <td>{{ $purchase->usage_limit }}</td>
                            </tr>
                            <tr>
                                <th>Gateway</th>
                                <td>{{ $purchase->payment_gateway ? ucfirst($purchase->payment_gateway) : 'Not selected' }}</td>
                            </tr>
                            <tr>
                                <th>Reference</th>
                                <td>{{ $purchase->payment_reference }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($purchase->status) }}</td>
                            </tr>
                        </table>

                        @if(app()->environment('local'))
                        <div class="alert alert-info">
                            Local mode is enabled. This page opens for testing and will not redirect to the payment gateway.
                        </div>
                        <form action="{{ route('admin.plans.payNow', $purchase->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="gateway" value="pesapal">
                            <button type="submit" class="btn btn-primary">Choose Pesapal</button>
                        </form>
                        <form action="{{ route('admin.plans.payNow', $purchase->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="gateway" value="selcom">
                            <button type="submit" class="btn btn-success">Choose Selcom</button>
                        </form>
                        <form action="{{ route('admin.plans.localConfirm', $purchase->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary">Confirm Local Payment</button>
                        </form>
                        <a href="{{ route('admin.plans.browse') }}" class="btn btn-outline-secondary">Back</a>
                        @else
                        <form action="{{ route('admin.plans.payNow', $purchase->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="gateway" value="pesapal">
                            <button type="submit" class="btn btn-primary">Pay with Pesapal</button>
                        </form>
                        <form action="{{ route('admin.plans.payNow', $purchase->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="gateway" value="selcom">
                            <button type="submit" class="btn btn-success">Pay with Selcom</button>
                        </form>
                        <a href="{{ route('admin.plans.browse') }}" class="btn btn-outline-secondary">Back</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
