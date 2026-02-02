@extends('layouts.admin')
@section('title', 'AetherSmart - Logs')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <!-- <h1 class="page-title fw-medium fs-18 mb-2">Data Tables</h1> -->
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Logs</li>
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
                            List Devices Logs
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event Name</th>
                                        <th>Event Details</th>
                                        <th>Date and Time</th>
                                         
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $key => $value)
                                    <?php
                                    $timestampSec = $value->event_time / 1000;

                                    // Convert to date-time in GMT+5:30
                                    $dateTime = Carbon::createFromTimestamp($timestampSec, 'UTC')->setTimezone('Asia/Kolkata');

                                    ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                        @if($value->code == 'switch')    
                                            {{"Power"}}
                                        @else
                                            {{$value->code}}
                                        @endif
                                    
                                        </td>
                                        <td>
                                        @if($value->code == 'switch')
                                         
                                            @if($value->value == 'true')
                                                <span class="badge bg-outline-success">ON</span>
                                            @else
                                                <span class="badge bg-outline-danger">OFF</span>
                                            @endif

                                        @else
                                            {{$value->value}}°C
                                        @endif
                                    
                                    </td>
                                        <td>{{ $dateTime->format('Y-m-d H:i:s')}}</td>
                                         

                                         
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