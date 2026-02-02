@extends('layouts.admin')

@section('title', 'AetherSmart - Category')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Category</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            @forelse($cats as $folderName => $categories)
            <div class="col-md-3 col-sm-6 col-12 mb-4">
                <div class="card text-center shadow-sm border-0 h-100">
                    <a href="{{route('admin.userTraining')}}?category={{ $categories->id }}">
                        <div class="card-body">
                            <img src="https://i.ibb.co/fYvdk8Kn/001-folder.png" alt="Folder Icon" width="100"
                                class="mb-3">
                            <h6 class="fw-bold text-primary mb-1 ">{{ $categories->name }}</h6>

                        </div>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    No categories available.
                </div>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection