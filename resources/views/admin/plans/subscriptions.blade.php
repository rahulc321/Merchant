@extends('layouts.admin')
@section('title', 'Subscriptions')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">All Subscription Purchases</div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="mb-4">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" name="user" value="{{ request('user') }}" class="form-control" placeholder="Search name, email or phone">
                                </div>
                                <div class="col-md-3">
                                    <select name="plan_id" class="form-control">
                                        <option value="">All Plans</option>
                                        @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Plan</th>
                                        <th>Price</th>
                                        <th>Days</th>
                                        <th>Uses</th>
                                        <th>Remaining</th>
                                        <th>Start Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Gateway</th>
                                        <th>Reference</th>
                                        <th>Tracking ID</th>
                                        <th>Paid On</th>
                                        <th>Purchased On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subscriptions as $key => $subscription)
                                    @php
                                        $remainingUses = max(0, (int) $subscription->usage_limit - (int) $subscription->used_count);
                                        $isActive = $subscription->is_active;
                                    @endphp
                                    <tr>
                                        <td>{{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + $key + 1 }}</td>
                                        <td>
                                            <strong>{{ $subscription->user->full_name ?? 'N/A' }}</strong><br>
                                            <span class="text-muted">{{ $subscription->user->email ?? 'N/A' }}</span><br>
                                            <span class="text-muted">{{ $subscription->user->phone_number ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ optional(optional($subscription->user)->roles->first())->title ?? 'N/A' }}</td>
                                        <td>{{ $subscription->plan->title ?? 'N/A' }}</td>
                                        <td>TZ {{ number_format($subscription->price, 2) }}</td>
                                        <td>{{ $subscription->days }}</td>
                                        <td>{{ $subscription->used_count }} / {{ $subscription->usage_limit }}</td>
                                        <td>{{ $remainingUses }}</td>
                                        <td>{{ optional($subscription->starts_at)->format('d M Y') }}</td>
                                        <td>{{ optional($subscription->expires_at)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge {{ $isActive ? 'bg-outline-success' : 'bg-outline-warning' }}">
                                                {{ $isActive ? 'Active' : ucfirst($subscription->status) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($subscription->payment_gateway ?? 'N/A') }}</td>
                                        <td>{{ $subscription->payment_reference ?? 'N/A' }}</td>
                                        <td>{{ $subscription->payment_tracking_id ?? 'N/A' }}</td>
                                        <td>{{ optional($subscription->paid_at)->format('d M Y') ?? 'N/A' }}</td>
                                        <td>{{ optional($subscription->created_at)->format('d M Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="16" class="text-center">No Subscription Purchases Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $subscriptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
