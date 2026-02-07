@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Merchant')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <!-- <h1 class="page-title fw-medium fs-18 mb-2">Data Tables</h1> -->
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Merchant</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Edit Merchant
                    </div>

                </div>
                <div class="card-body">
                    <form
                        action="{{ isset($merchant) ? route('admin.task.update', $merchant->id) : route('admin.task.store') }}"
                        method="POST" class="row g-3 mt-0">
                        @csrf
                        @isset($merchant)
                        @method('PUT')
                        @endisset

                        {{-- ===== Merchant Name ===== --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Merchant Name <code>*</code>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="Enter merchant name"
                                value="{{ old('name', $merchant->full_name ?? '') }}" required>
                        </div>

                        {{-- ===== Email ===== --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Email <code>*</code>
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address"
                                value="{{ old('email', $merchant->email ?? '') }}" required>
                        </div>

                        {{-- ===== Phone ===== --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Phone
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number"
                                value="{{ old('phone', $merchant->phone_number ?? '') }}">
                        </div>

                        {{-- ===== Amount ===== --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Amount <code>*</code>
                            </label>
                            <input type="number" step="0.01" name="amount" class="form-control"
                                placeholder="Enter amount" value="{{ old('amount', $merchant->amount ?? '') }}"
                                required>
                        </div>

                        {{-- ===== Status ===== --}}
                        <div class="col-md-4">
                            <label class="form-label">
                                Status <code>*</code>
                            </label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status', $merchant->status ?? 1) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $merchant->status ?? 1) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        {{-- ===== Submit ===== --}}
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function showFields() {
    const type = document.getElementById('type').value;
    const dynamicFields = document.getElementById('dynamic-fields');
    dynamicFields.innerHTML = fieldsData[type] || '';
}
</script>

<script>
$(document).ready(function() {
    // Handle Select All checkbox change
    $('#select-all').on('change', function() {
        const isChecked = $(this).is(':checked');

        $('#permissions1 option').prop('selected', isChecked);
        $('#permissions1').trigger('change'); // Trigger change to update any plugins
    });

    // Update Select All checkbox based on individual selections
    $('#permissions1').on('change', function() {
        const allSelected = $('#permissions1 option').length === $('#permissions1 option:selected')
            .length;
        $('#select-all').prop('checked', allSelected);
    });
});
</script>
@endsection