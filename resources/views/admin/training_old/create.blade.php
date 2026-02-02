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
                            <li class="breadcrumb-item active" aria-current="page">Create Training</li>
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
                        Create Training
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.trainingStore') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-4">
                            <label class="form-label">Title<code>*</code></label>
                            <input type="text" name="title" class="form-control" placeholder="Title">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Video<code>*</code></label>
                            <input type="file" id="videoInput" name="file" class="form-control" placeholder="Title"
                                accept="video/*">
                            <input type="text" id="videoTime" name="video_time" class="video_time"
                                placeholder="Video Duration" readonly>
                            <div id="errorMessage" style="color: red; display: none;">Video should be greater than 0
                                seconds.</div>
                        </div>



                        <div class="col-md-4">
                            <label class="form-label">Role<code>*</code></label>
                            <select class="form-control end_user" name="role" id="end_user" required>
                                <option value="">Select</option>
                                @foreach($roles as $key=>$role)
                                @if($key != 0)
                                <option value="{{ $role->title }}">
                                    {{ $role->title }}
                                </option>
                                @endif
                                @endforeach
                            </select>

                        </div>



                        <div class="col-md-4">
                            <label class="form-label">Status<code>*</code></label>
                            <select class="form-control" name="status" id="type" required>
                                <option value="active">Active</option>
                                <option value="inactive">In Active</option>

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
document.getElementById('videoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const errorMessage = document.getElementById('errorMessage');
    const videoTimeInput = document.getElementById('videoTime');

    errorMessage.style.display = 'none'; // Hide error message initially
    videoTimeInput.value = ''; // Clear previous value

    if (file) {
        const videoElement = document.createElement('video');
        videoElement.preload = 'metadata';

        videoElement.onloadedmetadata = function() {
            window.URL.revokeObjectURL(videoElement.src); // Free memory
            const duration = videoElement.duration; // Duration in seconds

            if (duration > 0) {
                // Format duration as HH:MM:SS
                const hours = Math.floor(duration / 3600);
                const minutes = Math.floor((duration % 3600) / 60);
                const seconds = Math.floor(duration % 60);
                const formattedTime =
                    (hours > 0 ? hours.toString().padStart(2, '0') + ':' : '') +
                    minutes.toString().padStart(2, '0') + ':' +
                    seconds.toString().padStart(2, '0');

                videoTimeInput.value = formattedTime; // Set the video duration
            } else {
                errorMessage.style.display = 'block'; // Show error message
            }
        };

        videoElement.onerror = function() {
            errorMessage.style.display = 'block'; // Show error message for invalid files
        };

        videoElement.src = URL.createObjectURL(file);
    }
});
</script>


@endsection