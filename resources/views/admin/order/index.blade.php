@extends('layouts.admin')
@section('title', 'CRM - Orders')
@section('content')

<style>
.tooltip-inner {
    max-width: 300px;
    width: auto;
    background-color: #e8f5e9;
    color: #2e7d32;
    border-radius: 8px;
    font-size: 14px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border: 1px solid #c8e6c9;
    text-align: left;
}

.tooltip-arrow {
    color: #e8f5e9;
}
</style>

<div class="main-content app-content">
    <div class="container-fluid">

```
    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header">
                    <div class="card-title">
                        Order List
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Merchant</th>
                                    <td>Address</td>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>

                                    <td>
                                        {{ $order->user->full_name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $order->merchant->name ?? 'N/A' }} 
                                    </td>

                                    <td>
                                        {{ $order->address ?? 'N/A' }} 
                                    </td>

                                    <td>
                                        {{ number_format($order->amount, 2) }}
                                    </td>

                                    <td>
                                        @if($order->status == 1)
                                            <span class="badge bg-outline-success">Completed</span>
                                        @else
                                            <span class="badge bg-outline-warning">Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No Orders Found
                                    </td>
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
```

</div>

@endsection
