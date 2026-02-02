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
                            <table id="basic1" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event Name</th>
                                        <th>Event Details</th>
                                        <th>Date and Time</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and DataTables scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#basic1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/admin/viewLogs1/' . $deviceId) }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'code', name: 'code' },
                { data: 'value', name: 'value' },
                { data: 'event_time', name: 'event_time' },
            ],
            language: {
                paginate: {
                    previous: '<i class="fa fa-arrow-left"></i>',
                    next: '<i class="fa fa-arrow-right"></i>',
                }
            }
        });
    });
</script>

<!-- Include Font Awesome for pagination arrows -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Add custom CSS for styling pagination buttons -->
<style>
    .dataTables_paginate {
        text-align: center;
    }
    .dataTables_paginate a {
        padding: 5px 10px;
        margin: 0 2px;
        background-color: #f1f1f1;
        border-radius: 3px;
        color: #333;
        text-decoration: none;
    }
    .dataTables_paginate a:hover {
        background-color: #ddd;
    }
    .dataTables_paginate .current {
        background-color: #007bff;
        color: #fff;
    }
</style>
@endsection
