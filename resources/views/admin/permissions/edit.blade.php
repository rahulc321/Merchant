@extends('layouts.admin')
@section('title', 'CRM - Permissions Edit')
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
                            <li class="breadcrumb-item active" aria-current="page">Permissions Edit</li>
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
                                       Edit Permission
                                    </div>
                                    
                                </div>
                                <div class="card-body">
                                <form action='{{ route("admin.permissions.update", [$permission->id]) }}' method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                    <div class="mb-3">
                                        <label for="form-text" class="form-label fs-14 text-dark">Permission</label>
                                        <input name="title" type="text" value="{{ old('title', isset($permission) ? $permission->title : '') }}" class="form-control" id="form-text" placeholder="Permission" required>
                                    </div>
                                    
                                     
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                                </div>  
                                
</div>
</div>
    </div>
</div>

@endsection

