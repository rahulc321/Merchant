@extends('layouts.admin')
@section('title', 'AetherSmart - View Info')
@section('content')
<style>
.card {
    box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
}

.time {
    font-size: 10px;
    float: right;
    padding: 9px;
}

.card-body.scr {
    height: 444px;
    overflow: scroll;
}

.card-body.scr {
    height: 446px;
    overflow: scroll;
    scrollbar-color: blue transparent;
    /* For Firefox */
}

/* For Webkit browsers (Chrome, Safari) */
.card-body.scr::-webkit-scrollbar {
    width: 10px;
}

.card-body.scr::-webkit-scrollbar-thumb {
    background-color: blue;
    border-radius: 5px;
}

.card.mt-3 {
    margin-top: 2px !important;
}
</style>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                            All Information
                        </div>
                        <!-- <a style="color:blue" href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#ownNotesModal">Click Here</a> -->
                    </div>




                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row">
                                    <!-- Left Side: Store, Branch Manager, and Territory Manager Details -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">User Details</h5>

                                                <p><b>Name:</b> {{ @$user->full_name }}</p>
                                                <p><b>Contact:</b> {{ $user->phone_number }}</p>
                                                <p><b>Email:</b> {{ $user->email }}</p>
                                                <p><b>Address:</b> {{ $user->address }}</p>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Device Status</h5>

                                                <p><b>Status:</b> @php
                                                    $badgeClass = match((int) $device->is_online) {
                                                    1 => 'bg-outline-success', # Online
                                                    0 => 'bg-outline-danger', # Offline
                                                    default => 'bg-outline-light', # Fallback
                                                    };
                                                    $statusText = (int) $device->is_online === 1 ? 'Online' : 'Offline';
                                                    @endphp

                                                    <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                                </p>
                                                </p>
                                                <p><b>Error:</b> {{$deviceFaults->count()}}</p>

                                                <a class="" href="{{route('admin.viewLogs',$device->device_id)}}"
                                                    title="Device logs">
                                                    <span class="badge bg-outline-info"><i class="fas fa-history"></i>
                                                    </span>
                                                </a>

                                                <a href="javascript:void(0);" class="manage-device-btn"
                                                    data-device-id="{{ $device->device_id }}" title="Device ON/OFF">
                                                    <span class="badge bg-outline-danger"><i
                                                            class="fas fa-power-off"></i></span>
                                                </a>

                                                <a href="{{route('admin.scheduleDevice',$device->device_id)}}"
                                                    title="Schedule Device Time" class="scheduleTime"
                                                    data-device-id="{{ $device->device_id }}">
                                                    <span class="badge bg-outline-warning"><i
                                                            class="fas fa-clock"></i></span>
                                                </a>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Device Info</h5>

                                                <p><b>Model:</b> {{ @$device->name }}</p>
                                                <p><b>Serial:</b> {{ $device->device_id }}</p>
                                                <p><b>Installation Date:</b>
                                                    {{ \Carbon\Carbon::parse($device->created_at)->format('d M Y') }}
                                                </p>
                                                <p><b>Warranty:</b>
                                                    {{ \Carbon\Carbon::parse($device->created_at)->addYears(5)->format('d M Y') }}
                                                </p>


                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Error Logs</h5>

                                                <div class="card-body">

                                                    <div class="table-responsive">
                                                        <table id="datatable-basic"
                                                            class="table table-bordered text-nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Code</th>
                                                                    <th>Description</th>
                                                                    <th>Failure Analysis</th>
                                                                    <th>Solutions</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($deviceFaults as $key => $value)
                                                                <tr>
                                                                    <td>{{$key+1}}</td>
                                                                    <td>{{@$value->failure_code}}</td>
                                                                    <td>{!! nl2br(e($value->description)) !!}</td>
                                                                    <td>{!! nl2br(e($value->failure_analysis)) !!}</td>
                                                                    <td>{{$value->solution}}</td>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    @endsection