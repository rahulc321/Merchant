@extends('layouts.admin')
@section('title', 'AetherSmart - Send Message')
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
                            <li class="breadcrumb-item active" aria-current="page">Send Message</li>
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
                        Se d Message
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.message.store') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 mt-0">
                        @csrf

                        <div class="col-md-12">
                            <label class="form-label">Users<code>*</code></label>
                            <select class="form-control js-example-basic-multiple" name="user_id[]" id="type" required multiple>
                                <option value="">Select</option>

                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->full_name}}</option>
                                 @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Message<code>*</code></label>
                            <textarea class="form-control" name="message" required placeholder="Type message here....."></textarea>
                        </div>

                        <!-- Dynamic Fields Section -->
                        <div id="dynamic-fields" class="row g-3"></div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Send Message</button>
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
