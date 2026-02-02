@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Category')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
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
                        Edit Category
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update',[$cat->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" required value="{{$cat->name}}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required>{{$cat->description}}</textarea>
                        </div>
                        <?php
                            $roles = DB::table('roles')->where('id','!=',1)->get();
                        ?>
                        <div class="mb-3">
                            <label for="title" class="form-label">Status</label>
                            <select class="form-control" name="status" required>

                                <option value="1" <?php if($cat->status ==1){ echo 'selected';} ?>>Active</option>
                                <option value="0" <?php if($cat->status ==0){ echo 'selected';} ?>>In-Active</option>

                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{route('admin.category.index')}}" class="btn btn-warning">Back</a>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>


@endsection