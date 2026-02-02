@extends('layouts.admin')
@section('title', 'CRM - Edit Task')
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
                            <li class="breadcrumb-item active" aria-current="page">Edit Task</li>
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
                    Edit Task
                    </div>

                </div>
                <div class="card-body">
                    <form action="{{ route('admin.task.update',[$task->id]) }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 mt-0">
                        @csrf
                        @method('PUT')

                        <div class="col-md-4">
                            <label class="form-label">Title<code>*</code></label>
                             <input type="text" name="title" value="{{$task->title}}" class="form-control" placeholder="Title">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Assign To<code>*</code></label>
                            <select class="form-control" name="assigned_to" id="type" required >
                                <option value="">Select</option>

                                @foreach($users as $user)
                                <option value="{{$user->id}}" <?php if($task->assigned_to == $user->id){ echo 'selected';} ?>>{{$user->full_name}}</option>
                                 @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Due Date<code>*</code></label>
                             <input type="date" name="due_date" value="{{$task->due_date}}"  class="form-control" placeholder="">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status<code>*</code></label>
                            <select class="form-control" name="status" id="type" required >
                                <option value="pending" <?php if($task->status == 'pending'){ echo 'selected';} ?>>Pending</option>
                                <option value="in_progress" <?php if($task->status == 'in_progress'){ echo 'selected';} ?>>In Progress</option>
                                <option value="completed" <?php if($task->status == 'completed'){ echo 'selected';} ?>>Completed</option>

                                 
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Description<code>*</code></label>
                            <textarea class="form-control" name="description" required placeholder="Type description here.....">{{$task->description}}</textarea>
                        </div>

                        <!-- Dynamic Fields Section -->
                        <div id="dynamic-fields" class="row g-3"></div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Task</button>
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
