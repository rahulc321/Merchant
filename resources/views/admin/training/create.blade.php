@extends('layouts.admin')
@section('title', 'AetherSmart - Create Task')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Collection</li>
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
                        Create Collection
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.trainingStore') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <?php
                            $roles = DB::table('roles')->where('id','!=',1)->get();
                        ?>
                        <div class="mb-3">
                            <label for="title" class="form-label">Roles</label>
                             <select class="form-control js-example-basic-multiple" name="roles[]" multiple required>
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->title}}</option>
                                @endforeach
                             </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Category</label>
                            <select class="form-control" name="cat_id" required>
                                @foreach($cats as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ in_array($cat->id, [$training->cat_id]) ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Collection</button>
                        <a href="{{url('/admin/training')}}" class="btn btn-warning">Back</a>
                    </form>

                     
                </div>
            </div>
        </div>
    </div>
</div>

 

@endsection
