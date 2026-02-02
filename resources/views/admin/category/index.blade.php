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
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0 rounded">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">Category List</h5>
                        @can ('training_category')
                        <a href="{{ route('admin.category.create') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-2"></i>Create New Category
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-hover table-bordered text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cats as $key => $value)


                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-medium text-dark">{{ $value->name }}</td>
                                        <td class="fw-medium text-dark">{{ $value->description }}</td>

                                        <td>
                                            <span
                                                class="badge {{ $value->status == 1 ? 'bg-outline-success' : 'bg-outline-warning' }}">
                                                {{ $value->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
 
                                            <div class="d-flex justify-content-center gap-2">

                                                 
                                                <a href="{{route('admin.category.show',[$value->id])}}">
                                                    <span class="badge bg-outline-info">Edit</span>
                                                </a>
                                                <a href="javascript:;"
                                                    onclick="if(confirm('Are you sure you want to delete this?')) { document.getElementById('deleteFrm{{ $key }}').submit(); }">
                                                    <span class="badge bg-outline-danger">Delete</span>
                                                </a>



                                                <form id="deleteFrm{{ $key }}"
                                                    action="{{ route('admin.category.destroy', $value->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
@endsection