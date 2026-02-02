@extends('layouts.admin')
@section('title', 'CRM - Create Task')
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
                            <li class="breadcrumb-item active" aria-current="page">Create Task</li>
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
                        Create Task
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.task.store') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-4">
                            <label class="form-label">Title<code>*</code></label>
                            <input type="text" name="title" class="form-control" placeholder="Title">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">End User<code>*</code></label>
                            <select class="form-control end_user" name="end_user" id="end_user" required>
                                <option value="">Select</option>
                                @foreach($end_users as $end_user)
                                <option value="{{ $end_user->id }}" rel="{{ json_encode($end_user) }}">
                                    {{ $end_user->full_name }}
                                </option>
                                @endforeach
                            </select>

                            <ul id="user_details" style="display: none;" class="details-box">
                                <li><strong>Email:</strong> <span id="user_email"></span></li>
                                <li><strong>Phone:</strong> <span id="user_phone"></span></li>
                                <li><strong>Address:</strong> <span id="user_address"></span></li>
                            </ul>
                        </div>



                        <div class="col-md-4">
                            <label class="form-label">Assign To<code>*</code></label>
                            <select class="form-control" name="assigned_to" id="type" required>
                                <option value="">Select</option>

                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Due Date<code>*</code></label>
                            <input type="date" name="due_date" class="form-control" placeholder="">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Time<code>*</code></label>
                            <input type="time" name="time" class="form-control" placeholder="">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status<code>*</code></label>
                            <select class="form-control" name="status" id="type" required>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>


                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Description<code>*</code></label>
                            <textarea class="form-control" name="description" required
                                placeholder="Type description here....."></textarea>
                        </div>

                        <!-- Dynamic Fields Section -->
                        <div id="dynamic-fields" class="row g-3"></div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Create Task</button>
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