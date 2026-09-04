@extends('layouts.admin')
@section('title', 'Edit Plan')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Plan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Edit Plan</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Plan Title</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $plan->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Benefits</label>
                                <textarea name="benefits" class="form-control" rows="5" required>{{ old('benefits', implode("\n", $plan->benefits_list)) }}</textarea>
                                <small class="text-muted">Add one benefit per line.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Price (TZ)</label>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', $plan->price) }}" min="0" step="0.01" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">How Many Days</label>
                                    <input type="number" name="days" class="form-control" value="{{ old('days', $plan->days) }}" min="1" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">How Many Uses</label>
                                    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $plan->usage_limit) }}" min="1" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="1" {{ old('status', $plan->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $plan->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-warning">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
