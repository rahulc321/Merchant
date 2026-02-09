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

.filter-box {
    background: #f8fafc;
    /* soft grey */
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    margin-bottom : 10px;
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

                        {{-- FILTER SECTION --}}
                        <form method="GET" action="{{ url()->current() }}" class="filter-box">
                            <div class="row mb-2">

                                {{-- User Name --}}
                                <div class="col-md-3">
                                    <input type="text" name="user" value="{{ request('user') }}" class="form-control"
                                        placeholder="🔍 Search User">
                                </div>

                                {{-- Merchant Dropdown (Admin Only) --}}
                                @if(auth()->user()->roles()->where('title','Admin')->exists())
                                <div class="col-md-3">
                                    <select name="merchant_id" class="form-control">
                                        <option value="">All Merchants</option>

                                        @foreach($merchants as $merchant)
                                        <option value="{{ $merchant->id }}"
                                            {{ request('merchant_id') == $merchant->id ? 'selected' : '' }}>
                                            {{ $merchant->full_name }}
                                        </option>
                                        @endforeach

                                    </select>
                                </div>
                                @endif

                                {{-- Amount --}}
                                <div class="col-md-2">
                                    <input type="number" name="amount" value="{{ request('amount') }}"
                                        class="form-control" placeholder="Min Amount">
                                </div>

                                {{-- From Date --}}
                                <div class="col-md-2">
                                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                                        class="form-control">
                                </div>

                                {{-- To Date --}}
                                <div class="col-md-2">
                                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                                        class="form-control">
                                </div>

                                {{-- Buttons --}}
                                <div class="col-md-12 mt-3 filter-actions">
                                    <button class="btn btn-primary">
                                        Filter
                                    </button>

                                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                                        Reset
                                    </a>
                                </div>

                            </div>
                        </form>

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
                                            {{ $order->merchant->full_name ?? 'N/A' }}
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