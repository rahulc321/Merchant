@extends('layouts.admin')
@section('title', 'AetherSmart - Edit Training')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Training</li>
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
                        Edit Training
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.trainingUpdate',[$training->id]) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required
                                value="{{$training->title}}">
                        </div>
                        <?php
                            $roles = DB::table('roles')->where('id','!=',1)->get();
                        ?>
                        @php
                        $selectedRoles = explode(',', $training->role); // convert comma-separated string to array
                        @endphp

                        <div class="mb-3">
                            <label for="title" class="form-label">Roles</label>
                            <select class="form-control js-example-basic-multiple" name="roles[]" multiple required>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, $selectedRoles) ? 'selected' : '' }}>
                                    {{ $role->title }}
                                </option>
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
                            <textarea name="description" id="description"
                                class="form-control">{{$training->description}}</textarea>
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