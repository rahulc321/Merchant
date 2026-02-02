@extends('layouts.admin')
@section('title', 'AetherSmart - Devices')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Device List</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Device List</div>
                        <!-- <a style="float:right" href="{{route('admin.deviceOverMap')}}" class="btn btn-info">See Device Over Map</a> -->
                    </div>

                    <div class="card-body">
                        <form id="deviceFilterForm" class="row mb-3">
                            <div class="col-md-3">
                                <input type="text" id="filterDeviceId" class="form-control"
                                    placeholder="Filter by Device ID" name="device_id"
                                    value="<?=@$_REQUEST['device_id']?>">
                            </div>
                            <div class="col-md-3">
                                <select id="filterStatus" class="form-control" name="is_online">
                                    <option value=""
                                        <?php if (!isset($_REQUEST['is_online']) || $_REQUEST['is_online'] === '') echo 'selected'; ?>>
                                        All</option>
                                    <option value="1"
                                        <?php if (isset($_REQUEST['is_online']) && $_REQUEST['is_online'] === '1') echo 'selected'; ?>>
                                        Online</option>
                                    <option value="0"
                                        <?php if (isset($_REQUEST['is_online']) && $_REQUEST['is_online'] === '0') echo 'selected'; ?>>
                                        Offline</option>
                                    <option value="2"
                                        <?php if (isset($_REQUEST['is_online']) && $_REQUEST['is_online'] === '2') echo 'selected'; ?>>
                                        Error</option>
                                </select>
                            </div>
                            <div class="col-md-2" style="display: flex">
                                <button type="submit" class="btn btn-primary w-20">Filter</button>
                                <a href="{{ route('admin.devices') }}" class="btn btn-secondary w-20"
                                    style="margin-left: 5px;">Reset</a>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        <th>Customer Name</th>
                                        <th>Customer Address</th>
                                        <th>Device ID</th>
                                        <th>Model</th>
                                        <th>Install Date</th>

                                        <!-- <th>Product</th> -->
                                        <th>Online Status</th>
                                        <th>Error</th>
                                        <th>Installer Name</th>
                                        <!-- <th>Activation Time</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($devices as $key => $value)
                                    <?php
                                            $code = \DB::table('faults')
                                            ->join('devicelogs', 'devicelogs.code', '=', 'faults.failure_code')
                                            ->join('devices', 'devices.device_id', '=', 'devicelogs.device_id')
                                            ->leftJoin('users as installers', 'installers.id', '=', 'devices.installer_id')
                                            ->leftJoin('users as owners', 'owners.id', '=', 'devices.user_id')
                                            ->select(
                                                'faults.*',
                                                'devicelogs.device_id',
                                                'installers.full_name as installer_name',
                                                'owners.full_name as user_name'
                                            )
                                            ->where('devices.device_id',$value->device_id)
                                            ->pluck('failure_code')->toArray();

                                           // dd($code);
                                        ?>

                                    <tr
                                        class="<?php if($value->is_online ==1){ echo 'greencl'; }else{ echo 'redcl'; } ?>">
                                        <td>{{$key+1}}</td>

                                        <td>
                                            <a class="c_color" style="color:blue"
                                                href="{{route('admin.view_info',@$value->u_name->id ?? 0)}}">{{ @$value->u_name->full_name }}@if(!empty($value->u_name->id))
                                                ({{ $value->u_name->id }}) @endif

                                        </td>
                                        <td>{{@$value->u_name->address}}</td>

                                        <td>{{$value->device_id}}</td>
                                        <td>{{$value->name}}</td>

                                        <td>{{ strtoupper(\Carbon\Carbon::parse($value->created_at)->format('j-M-Y')) }}
                                        </td>
                                        <!-- <td>{{$value->product_id}}</td> -->
                                        <td>
                                            @php
                                            $hasErrorCode = !empty($code);

                                            $badgeClass = match (true) {
                                            $hasErrorCode => 'bg-outline-danger', # Error condition (code present)
                                            (int) $value->is_online === 1 => 'bg-outline-success', # Online
                                            (int) $value->is_online === 0 => 'bg-outline-warning', # Offline
                                            default => 'bg-outline-light', # Fallback
                                            };

                                            $statusText = $hasErrorCode ? 'Error' : '';
                                            $onlineOffline = ((int) $value->is_online === 1 ?
                                            'Online' : 'Offline');
                                            @endphp

                                            <span class="badge {{ $badgeClass }}">{{ $onlineOffline }}</span>
                                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>

                                            <span class="badge bg-outline-danger">{{ implode(', ', $code) }}</span>
                                        </td>
                                        <td>{{@$value->i_name->full_name}}</td>
                                        <!-- <td>{{$value->active_time}}</td> -->
                                        <td>
                                            <a class="" href="{{route('admin.viewLogs',$value->device_id)}}"
                                                title="logs">
                                                <span class="badge bg-outline-info"><i class="fas fa-history"></i>
                                                </span>
                                            </a>

                                            <a href="javascript:void(0);" class="manage-device-btn"
                                                data-device-id="{{ $value->device_id }}">
                                                <span class="badge bg-outline-danger"><i
                                                        class="fas fa-power-off"></i></span>
                                            </a>

                                            <a href="{{route('admin.scheduleDevice',$value->device_id)}}"
                                                class="scheduleTime" data-device-id="{{ $value->device_id }}">
                                                <span class="badge bg-outline-warning"><i
                                                        class="fas fa-clock"></i></span>
                                            </a>
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

<style>
/* tr.redcl td {
        background-color: #ffdddd !important;
    }

    tr.greencl td {
        background-color: rgb(186 217 172) !important;
    } */
</style>

<!-- Bootstrap Modal -->
<div class="modal fade" id="manageDeviceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-cogs"></i> Manage Device</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <form action="{{ route('admin.manageDevice') }}" id="deviceManageForm">
                    @csrf
                    <input type="hidden" name="device_id" id="device_id">

                    <!-- On/Off Toggle -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-power-off text-danger"></i> Device ON/OFF</label>
                        <select name="device_status" id="device_status" class="form-select">
                            <option value="">Select</option>
                            <option value="1">On</option>
                            <option value="2">Off</option>
                        </select>
                    </div>

                    <!-- Set Temperature -->
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-thermometer-half text-warning"></i> Set
                            Temperature</label>
                        <select name="temp_set" id="temp_set" class="form-select">
                            <option value="">Select</option>
                            @for($i=15;$i<=75;$i++) <option value="<?=$i?>"><?=$i?></option>
                                @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>


<!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".manage-device-btn").forEach(button => {
        button.addEventListener("click", function() {
            let deviceId = this.getAttribute("data-device-id");
            document.getElementById("device_id").value = deviceId;

            let modal = new bootstrap.Modal(document.getElementById("manageDeviceModal"));
            modal.show();
        });
    });
});
</script>
<!-- Your existing form -->
<!-- <form id="deviceFilterForm" class="row mb-3">
    <div class="col-md-3">
        <input type="text" id="filterDeviceId" class="form-control"
            placeholder="Filter by Device ID" name="device_id"
            value="<?=@$_REQUEST['device_id']?>">
    </div>
    <div class="col-md-3">
        <select id="filterStatus" class="form-control" name="is_online">
            <option value=""
                <?php if (!isset($_REQUEST['is_online']) || $_REQUEST['is_online'] === '') echo 'selected'; ?>>
                All</option>
            <option value="1"
                <?php if (isset($_REQUEST['is_online']) && $_REQUEST['is_online'] === '1') echo 'selected'; ?>>
                Online</option>
            <option value="0"
                <?php if (isset($_REQUEST['is_online']) && $_REQUEST['is_online'] === '0') echo 'selected'; ?>>
                Offline</option>
            <option value="2"
                <?php if (isset($_REQUEST['is_online']) && $_REQUEST['is_online'] === '2') echo 'selected'; ?>>
                Error</option>
        </select>
    </div>
    <div class="col-md-2" style="display: flex">
        <button type="submit" class="btn btn-primary w-20">Filter</button>
        <a href="{{ route('admin.devices') }}" class="btn btn-secondary w-20" style="margin-left: 5px;">Reset</a>
    </div>
</form> -->

<!-- Add this JavaScript -->
<script>
$(document).ready(function() {
    $('#deviceFilterForm').on('submit', function(e) {
        const status = $('#filterStatus').val();

        // simulate a condition where status=2 (Error) should stop form submission
        if (status === '2') {
            e.preventDefault();

            // Put error message in DataTable global search
            $('div.dataTables_filter input[type="search"]').val("error").trigger('input');

            // Optionally show a warning popup (optional)

        }
    });
});
</script>


@endsection