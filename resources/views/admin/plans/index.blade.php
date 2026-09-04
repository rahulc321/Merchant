@extends('layouts.admin')
@section('title', 'Plans')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Plans</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0 rounded">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">Plan List</h5>
                        <a href="{{ route('admin.plans.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-2"></i>Create New Plan
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-hover table-bordered text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Benefits</th>
                                        <th>Price</th>
                                        <th>Days</th>
                                        <th>Uses</th>
                                        <th>Status</th>
                                        <th>Purchases</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($plans as $key => $plan)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-medium text-dark">{{ $plan->title }}</td>
                                        <td class="text-start">
                                            @foreach($plan->benefits_list as $benefit)
                                                <div>{{ $benefit }}</div>
                                            @endforeach
                                        </td>
                                        <td>TZ {{ number_format($plan->price, 2) }}</td>
                                        <td>{{ $plan->days }}</td>
                                        <td>{{ $plan->usage_limit }}</td>
                                        <td>
                                            <span class="badge {{ $plan->status == 1 ? 'bg-outline-success' : 'bg-outline-warning' }}">
                                                {{ $plan->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $plan->purchases_count }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.plans.show', $plan->id) }}">
                                                    <span class="badge bg-outline-info">Edit</span>
                                                </a>
                                                <a href="javascript:;" onclick="if(confirm('Are you sure you want to delete this?')) { document.getElementById('deletePlan{{ $key }}').submit(); }">
                                                    <span class="badge bg-outline-danger">Delete</span>
                                                </a>
                                                <form id="deletePlan{{ $key }}" action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Plans Found</td>
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
