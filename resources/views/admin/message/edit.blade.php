@extends('layouts.admin')
@section('title', 'AetherSmart - Edit User')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <!-- <h1 class="page-title fw-medium fs-18 mb-2">Data Tables</h1> -->
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
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
                        Edit User
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data" class="row g-3 mt-0">
                        @csrf
                        @method('PUT')

                        <div class="col-md-3">
                            <label class="form-label">Type<code>*</code></label>
                            <select class="form-control" name="type" id="type" required onchange="showFields()"
                                disabled>
                                <option value="">Select</option>
                                <option value="end_user" <?php if($user->type == 'end_user'){ echo 'selected'; } ?>>End
                                    User</option>
                                <option value="service_agent"
                                    <?php if($user->type == 'service_agent'){ echo 'selected'; } ?>>Service Agents
                                </option>
                                <option value="potential_user"
                                    <?php if($user->type == 'potential_user'){ echo 'selected'; } ?>>Potential User
                                </option>
                                <option value="reseller" <?php if($user->type == 'reseller'){ echo 'selected'; } ?>>
                                    Reseller</option>
                                <option value="retailer" <?php if($user->type == 'retailer'){ echo 'selected'; } ?>>
                                    Retailer</option>
                                <option value="distributor"
                                    <?php if($user->type == 'distributor'){ echo 'selected'; } ?>>Distributor</option>
                            </select>
                        </div>

                        <!-- Dynamic Fields Section -->
                        <div id="dynamic-fields" class="row g-3"></div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    var user = @json($user);
    console.log(user);

    $.each(user, function(key, value) {
        // Set value for input, select, and textarea elements
        $('input[name="' + key + '"], select[name="' + key + '"], textarea[name="' + key + '"]').val(
            value);
    });


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