@extends('layouts.admin')
@section('title', 'CRM - Create Merchant')
@section('content')
<style>
/* Style for the user details box */
.details-box {
    background-color: #e8f5e9;
    /* Light green background */
    border: 1px solid #c8e6c9;
    /* Slightly darker green border */
    border-radius: 8px;
    padding: 15px;
    margin-top: 10px;
    list-style: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    /* Adds shadow */
    font-size: 14px;
}

/* Style for individual list items */
.details-box li {
    margin-bottom: 8px;
    color: #2e7d32;
    /* Dark green text */
}

.details-box li strong {
    color: #1b5e20;
    /* Even darker green for labels */
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
                            <li class="breadcrumb-item active" aria-current="page">Create Merchant</li>
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
                        Create Merchant
                    </div>

                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form action="{{ route('admin.task.store') }}" method="POST" class="row g-3 mt-0">
                        @csrf

                        <!-- Merchant Name -->
                        <div class="col-md-4">
                            <label class="form-label">Merchant Name <code>*</code></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter merchant name"
                                required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label class="form-label">Email <code>*</code></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email address"
                                required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                        </div>

                        <!-- Amount -->
                        <div class="col-md-4">
                            <label class="form-label">Amount <code>*</code></label>
                            <input type="number" step="0.01" name="amount" class="form-control"
                                placeholder="Enter amount" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label class="form-label">Status <code>*</code></label>
                            <select class="form-control" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                Create Merchant
                            </button>
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
    $('#end_user').change(function() {
        // Get selected option
        const selectedOption = $(this).find(':selected');

        // Get 'rel' attribute
        const relData = selectedOption.attr('rel');

        // Parse JSON safely
        try {
            const userData = JSON.parse(relData);

            if (userData) {
                // Update the details in the <ul>
                $('#user_email').text(userData.email || 'N/A');
                $('#user_phone').text(userData.phone_number || 'N/A');
                $('#user_address').text(userData.address || 'N/A');

                // Show the <ul>
                $('#user_details').show();
            }
        } catch (error) {
            console.error("Error parsing user data:", error);
            // Hide the <ul> if parsing fails
            $('#user_details').hide();
        }
    });
});

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