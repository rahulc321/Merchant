@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Role')
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
                            <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-xl-6">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Edit Role
                                    </div>
                                    
                                </div>
                                <div class="card-body">
                                <form action='{{ route("admin.roles.update", [$role->id]) }}' method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="mb-3">
                                        <label for="form-text" class="form-label fs-14 text-dark">Role</label>
                                        <input name="title" type="text" value="{{ old('title', isset($role) ? $role->title : '') }}" class="form-control" id="form-text" placeholder="Role" required>
                                    </div>
                                    <div class="mb-3">
                                    <label for="form-text" class="form-label fs-14 text-dark">
                                        Permissions 
                                        <input type="checkbox" id="select-all"> Select All
                                    </label>
                                    <select name="permissions[]" id="permissions1" class="form-control js-example-basic-multiple" multiple="multiple" required>
                                        @foreach($permissions as $id => $permissions)
                                            <option value="{{ $id }}" 
                                                {{ (in_array($id, old('permissions', [])) || (isset($role) && $role->permissions->contains($id))) ? 'selected' : '' }}>
                                                {{ $permissions }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                    
                                     
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                                </div>  
                                
</div>
</div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function () {
    // Handle Select All checkbox change
    $('#select-all').on('change', function () {
        const isChecked = $(this).is(':checked');
        
        $('#permissions1 option').prop('selected', isChecked);
        $('#permissions1').trigger('change'); // Trigger change to update any plugins
    });

    // Update Select All checkbox based on individual selections
    $('#permissions1').on('change', function () {
        const allSelected = $('#permissions1 option').length === $('#permissions1 option:selected').length;
        $('#select-all').prop('checked', allSelected);
    });
});



</script>
@endsection
 

