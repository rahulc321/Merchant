@extends('layouts.admin')
@section('title', 'CRM - Coupon')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

.filter-box {
    background: #f8fafc;
    /* soft grey */
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    margin-bottom: 10px;
}

/* better input look */
.filter-box .form-control {
    height: 45px;
    border-radius: 6px;
}

/* spacing for button row */
.filter-actions {
    border-top: 1px solid #eee;
    padding-top: 15px;
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
                        <li class="breadcrumb-item active">Coupon</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">

                    <div class="card-header">
                        <div class="card-title">
                            Coupon List
                        </div>
                    </div>

                    <div class="card-body">



                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Coupon ID</th>
                                        @if (Auth::user()->roles->contains('title', 'Admin'))
                                        <th>User Name</th>
                                        @endif
                                        <th>Merchant</th>
                                        <th>Coupon Code</th>
                                        <th>Discount</th>
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

                                        @if (Auth::user()->roles->contains('title', 'Admin'))
                                            <td>
                                                {{ $order->user->full_name ?? 'N/A' }}
                                            </td>
                                        @endif


                                        <td>
                                            {{ $order->merchant->full_name ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $order->coupon_code ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $order->discount ?? 'N/A' }}%
                                        </td>

                                        <td>
                                            @if($order->is_used == 0)
                                            <span class="badge bg-outline-success">Active</span>
                                            @else
                                            <span class="badge bg-outline-warning">Expired</span>
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