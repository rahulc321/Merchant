@extends('layouts.admin')

@section('title','Manage Spinners')

@section('content')
<?php  //error_reporting(0); ?>
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="card custom-card">
            <div class="card-header">
                <h5>

                    Manage Spinners for:

                    <strong>
                        {{ $address->address }}
                    </strong>

                </h5>
            </div>

            <div class="card-body">

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif


                <form method="POST" action="{{ route('admin.addressSpinnseSync',$address->id) }}">

                    @csrf


                    @foreach($spinners as $spinner)

                    <div class="card mb-3 shadow-sm">

                        <div class="card-header d-flex justify-content-between">

                            <div>

                                <input type="checkbox" name="spinners[]" value="{{ $spinner->id }}" >

                                <strong class="ms-2">
                                    {{ $spinner->name }}
                                </strong>

                            </div>

                            <span class="badge bg-info">
                                 
                            </span>

                        </div>


                        {{-- rewards preview --}}
                        <div class="card-body">

                            <div class="row">

                                @foreach($spinner->rewards as $reward)

                                <div class="col-md-3 mb-2">

                                    <div class="border rounded p-2 text-center">

                                        <strong>
                                            {{ $reward->title }}
                                        </strong>

                                        <br>

                                        <small class="text-muted">
                                            Probability:
                                            {{ $reward->probability }}%
                                        </small>

                                    </div>

                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                    @endforeach


                    <button class="btn btn-primary">
                        Save Changes
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection