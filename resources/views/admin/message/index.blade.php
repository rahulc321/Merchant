@extends('layouts.admin')
@section('title', 'AetherSmart - Messages')
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
                            <li class="breadcrumb-item active" aria-current="page">Messages</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            List Messages
                        </div>

                        <a class="" href='{{ route("admin.message.create") }}' style="float:right !important"><span
                                class="badge bg-outline-info">Send Message</span></a>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Posted By</th>
                                        <th>Users</th>
                                        <th>Messge</th>
                                        <!-- <th>Role</th>
                                        <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $key => $value)
                                     
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><span class="badge bg-outline-success">{{@$value->postedBy->full_name}}</span></td>
                                         
                                        <td>

                                        @foreach(@$value->receivers as $receiver)
                                        <span class="badge bg-outline-success">{{$receiver->full_name}}</span>
                                        @endforeach

                                        </td>
                                        <td>{{$value->message}}</td>
                                        <!-- <td><span class="badge bg-outline-info">{{$value->type}}</span></td>
                                        <td>
                                            <a class="" href="{{ route('admin.users.edit', $value->id) }}">
                                                <span class="badge bg-outline-info">Edit</span>
                                            </a>

                                            <a class="" href="javascript:;"
                                                onclick="if(confirm('Are you sure you want to delete this?')) { event.preventDefault(); document.getElementById('deleteFrm<?=$key?>').submit(); }">
                                                <span class="badge bg-outline-secondary">Delete</span>
                                            </a>

                                            <form id="deleteFrm{{$key}}"
                                                action="{{ route('admin.users.destroy', $value->id) }}" method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="badge bg-outline-secondary" value="Delete">
                                            </form>

                                        </td> -->
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