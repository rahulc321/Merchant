@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Merchant')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Edit Merchant</li>
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
                        {{ isset($merchant) ? 'Edit Merchant' : 'Create Merchant' }}
                    </div>
                </div>

                <div class="card-body">

                    <form
                        action="{{ isset($merchant) ? route('admin.task.update', $merchant->id) : route('admin.task.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="row g-3 mt-0">

                        @csrf
                        @isset($merchant)
                            @method('PUT')
                        @endisset

                        {{-- merchant name --}}
                        <div class="col-md-4">
                            <label class="form-label">Merchant Name <code>*</code></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $merchant->full_name ?? '') }}" required>
                        </div>

                        {{-- email --}}
                        <div class="col-md-4">
                            <label class="form-label">Email <code>*</code></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $merchant->email ?? '') }}" required>
                        </div>

                        {{-- phone --}}
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $merchant->phone_number ?? '') }}">
                        </div>

                        {{-- amount --}}
                        <div class="col-md-4">
                            <label class="form-label">Discount <code>*</code></label>
                            <input type="number"  name="discount" class="form-control"
                                value="{{ old('amount', $merchant->discount ?? '') }}" required>
                        </div>

                        {{-- image upload --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Image {{ isset($merchant) ? '' : '*' }}
                            </label>

                            <input type="file" name="file" class="form-control">

                            {{-- show old image --}}
                            @if(!empty($merchant->image))
                                <div class="mt-2">
                                    <img src="{{ asset('uploads/'.$merchant->image) }}"
                                         width="80"
                                         class="img-thumbnail">
                                </div>
                            @endif
                        </div>

                        {{-- status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status <code>*</code></label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status', $merchant->status ?? 1) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $merchant->status ?? 1) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <?php $categories = \DB::table('categories')->get(); ?>
                            <select name="category" class="form-control">
                                <option value="">Select Category</option>

                                @foreach($categories as $category)
                                <option value="{{ $category->slug }}"
                                    {{ old('category', $merchant->category ?? '') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- submit --}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($merchant) ? 'Update Merchant' : 'Create Merchant' }}
                            </button>

                            <a href="{{ route('admin.task.index') }}" class="btn btn-light">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection