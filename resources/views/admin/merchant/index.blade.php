@extends('layouts.admin')
@section('title', 'Merchant Addresses')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="page-header-breadcrumb mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.task.index') }}">Merchant</a>
                </li>
                <li class="breadcrumb-item active">Addresses</li>
            </ol>
        </div>

        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">
                    Addresses of <strong>{{ $merchant->name }}</strong>
                </h5>

                <a href="{{ route('admin.addAddress', $merchant->id) }}"
                   class="badge bg-outline-info">
                    + Add New Address
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Pincode</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($merchant->addresses as $key => $address)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $address->address }}</td>
                                    <td>{{ $address->city ?? '-' }}</td>
                                    <td>{{ $address->state ?? '-' }}</td>
                                    <td>{{ $address->pincode ?? '-' }}</td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('admin.mAddressDelete', $address->id) }}"
                                              onsubmit="return confirm('Delete this address?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="badge bg-outline-danger border-0">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No addresses found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('admin.task.index') }}"
                   class="btn btn-sm btn-secondary mt-3">
                    ← Back to Merchant List
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
