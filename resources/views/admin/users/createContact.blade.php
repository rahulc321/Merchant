@extends('layouts.admin')
@section('title', 'AetherSmart - Add User')
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
                            <li class="breadcrumb-item active" aria-current="page">Add Contact</li>
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
                    Contact
                    </div>

                </div>
                <div class="card-body">
                <form action="{{ route('admin.contactStore') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-3">
                            <label class="form-label">Type<code>*</code></label>
                            <select class="form-control" name="type" id="type" required onchange="showFields()">
                                <option value="">Select</option>
                                <!-- <option value="store" <?php if(@$_REQUEST['type'] == 'end_user'){ echo 'selected'; } ?>>Store</option> -->
                                <option value="bm" <?php if(@$_REQUEST['type'] == 'service_agent'){ echo 'selected'; } ?>>Branch Manager</option>
                                <option value="tt" <?php if(@$_REQUEST['type'] == 'potential_user'){ echo 'selected'; } ?>>Territory Manager</option>
                                
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
const fieldsData = {
    store: `
            <div class="col-md-3">
                <label class="form-label">Store Location</label>
                <input type="text" name="store_location" class="form-control" placeholder="Store Location" >
            </div>
            <div class="col-md-3">
                <label class="form-label">Store State</label>
                <input type="text" name="store_state" class="form-control" placeholder="Store State" >
            </div>
            <div class="col-md-3">
                <label class="form-label">Store Email</label>
                <input type="text" name="email" class="form-control" placeholder="Store Email" >
            </div>
            <div class="col-md-3">
                <label class="form-label">Store Phone</label>
                 <input type="text" name="phone" class="form-control" placeholder="Store Phone" >
                 <input type="hidden" name="type" class="form-control" value="store">
            </div>     
        `,
    bm: `
            <div class="col-md-3">
                <label class="form-label">Branch Manager Name</label>
                <input type="text" name="store_location" class="form-control" placeholder="Branch Manager Name" >
            </div>
            <div class="col-md-3">
                <label class="form-label">Branch Manager Email</label>
                <input type="text" name="email" class="form-control" placeholder="Branch Manager Email" >
        <span class="email-error" style="color: red; display: none;"></span>
            </div>
             
            <div class="col-md-3">
                <label class="form-label">Branch Manager Phone</label>
                 <input type="text" name="phone_number" class="form-control" placeholder="Branch Manager Phone" >
                 <input type="hidden" name="type" class="form-control" value="bm">
         <span class="phone-error" style="color: red; display: none;"></span>
            </div>

            <div class="col-md-3">
                <label class="form-label">Branch Manager Notes</label>
                <input type="text" name="notes" class="form-control" placeholder="Branch Manager Notes" >
            </div>
        `,
    tt: `
            <div class="col-md-3">
                <label class="form-label">Territory Manager Name</label>
                <input type="text" name="store_location" class="form-control" placeholder="Territory Manager Name" >
            </div>
            <div class="col-md-3">
                <label class="form-label">Territory Manager Email</label>
                <input type="email" name="email" class="form-control" placeholder="Territory Manager Email" >
         <span class="email-error" style="color: red; display: none;"></span>

            </div>
             
            <div class="col-md-3">
                <label class="form-label">Territory Manager Phone</label>
                 <input type="text" name="phone_number" class="form-control" placeholder="Territory Manager Phone" >
                 <input type="hidden" name="type" class="form-control" value="tt">
         <span class="phone-error" style="color: red; display: none;"></span>
            </div>

            <div class="col-md-3">
                <label class="form-label">Territory Manager Notes</label>
                <input type="text" name="notes" class="form-control" placeholder="Territory Manager Notes" >
            </div>
        `
};

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
