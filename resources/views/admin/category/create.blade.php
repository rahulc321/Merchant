@extends('layouts.admin')
@section('title', 'AetherSmart - Create Category')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Category</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">
                        Create Category
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <?php
                            $roles = DB::table('roles')->where('id','!=',1)->get();
                        ?>
                        <div class="mb-3">
                            <label for="title" class="form-label">Status</label>
                            <select class="form-control" name="status" required>

                                <option value="1">Active</option>
                                <option value="0">In-Active</option>

                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{url('/admin/training')}}" class="btn btn-warning">Back</a>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


@endsection