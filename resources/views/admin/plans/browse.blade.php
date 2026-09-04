@extends('layouts.admin')
@section('title', 'Subscription Plans')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscription Plans</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($activePurchase)
        <div class="alert alert-success">
                            Current Subscription: <strong>{{ $activePurchase->plan->title ?? 'Plan' }}</strong>
                            valid till <strong>{{ $activePurchase->expires_at->format('d M Y') }}</strong>.
        </div>
        @endif

        <div class="row">
            @forelse($plans as $plan)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <div class="card-title">{{ $plan->title }}</div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h3 class="fw-bold mb-2">TZ {{ number_format($plan->price, 2) }}</h3>
                        <p class="text-muted mb-3">{{ $plan->days }} days access - {{ $plan->usage_limit }} uses</p>

                        <ul class="mb-4 ps-3">
                            @foreach($plan->benefits_list as $benefit)
                                <li class="mb-2">{{ $benefit }}</li>
                            @endforeach
                        </ul>

                        <form action="{{ route('admin.plans.purchase', $plan->id) }}" method="POST" class="mt-auto" onsubmit="return confirm('Purchase this plan?')">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body text-center">No active plans available.</div>
                </div>
            </div>
            @endforelse
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">My Subscription History</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plan</th>
                                        <th>Price</th>
                                        <th>Days</th>
                                        <th>Uses</th>
                                        <th>Start Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchases as $key => $purchase)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $purchase->plan->title ?? 'N/A' }}</td>
                                        <td>TZ {{ number_format($purchase->price, 2) }}</td>
                                        <td>{{ $purchase->days }}</td>
                                        <td>{{ $purchase->used_count }} / {{ $purchase->usage_limit }}</td>
                                        <td>{{ optional($purchase->starts_at)->format('d M Y') }}</td>
                                        <td>{{ optional($purchase->expires_at)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge {{ $purchase->is_active ? 'bg-outline-success' : 'bg-outline-warning' }}">
                                                {{ $purchase->is_active ? 'Active' : ucfirst($purchase->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($purchase->status == 'pending')
                                            <a href="{{ route('admin.plans.payment', $purchase->id) }}" class="badge bg-outline-info">Pay</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Subscription Purchased Yet</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
