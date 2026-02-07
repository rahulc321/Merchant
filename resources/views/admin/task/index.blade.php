@extends('layouts.admin')
@section('title', 'CRM - Merchant')
@section('content')
<style>
.tooltip-inner {
    max-width: 300px;
    /* Adjust this to set the desired width */
    width: auto;
    /* Allow auto width if needed */
    background-color: #e8f5e9;
    /* Light green background */
    color: #2e7d32;
    /* Dark green text */
    border-radius: 8px;
    /* Rounded corners */
    font-size: 14px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    /* Box shadow for tooltip */
    border: 1px solid #c8e6c9;
    /* Slightly darker border for contrast */
    text-align: left;
    /* Align text to the left */
}

.tooltip-arrow {
    color: #e8f5e9;
    /* Matches the background of the tooltip */
}
</style>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <!-- <h1 class="page-title fw-medium fs-18 mb-2">Data Tables</h1> -->
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Merchant</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            List Merchant
                        </div>
                        @if (Auth::user()->roles->contains('title', 'Admin'))
                        <a class="" href='{{ route("admin.task.create") }}' style="float:right !important"><span
                                class="badge bg-outline-info">Create New Merchant</span></a>
                        @endif
                    </div>

                    <div class="card-body">



                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Merchant Name</th>
                                        <th>Code</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($merchants as $key => $merchant)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>
                                            <strong>{{ $merchant->full_name }}</strong>
                                        </td>
                                        <td>{{ $merchant->code }}</td>
                                        <td>{{ $merchant->email }}</td>

                                        <td>{{ $merchant->phone_number ?? '-' }}</td>

                                        <td>
                                             {{ number_format($merchant->amount, 2) }}
                                        </td>

                                        <td>
                                            @if($merchant->status == 1)
                                            <span class="badge bg-outline-success">Active</span>
                                            @else
                                            <span class="badge bg-outline-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>

                                        <a href="{{ route('admin.marchentAddress', $merchant->id) }}">
                                                <span class="badge bg-outline-info">Add Address</span>
                                            </a>
                                            <!-- Edit -->
                                            <a href="{{ route('admin.task.edit', $merchant->id) }}">
                                                <span class="badge bg-outline-info">Edit</span>
                                            </a>

                                            <!-- Delete -->
                                            <a href="javascript:;" onclick="if(confirm('Are you sure you want to delete this merchant?')) {
                       event.preventDefault();
                       document.getElementById('deleteFrm{{ $merchant->id }}').submit();
                   }">
                                                <span class="badge bg-outline-secondary">Delete</span>
                                            </a>

                                            <form id="deleteFrm{{ $merchant->id }}"
                                                action="{{ route('admin.task.destroy', $merchant->id) }}"
                                                method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
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