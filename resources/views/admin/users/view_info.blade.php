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



                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="container">

                                {{-- Customer Details Section --}}
                                <h5 class="mb-4 text-secondary border-bottom pb-2">
                                    <i class="bi bi-person-lines-fill me-2 text-primary"></i>Customer Details
                                </h5>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-hash me-1"></i>Customer No
                                            </label>
                                            <p class="mb-0">#{{ @$user->id }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-person-fill me-1"></i>Customer Name
                                            </label>
                                            <p class="mb-0">{{ @$user->full_name }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-envelope-fill me-1"></i>Email
                                            </label>
                                            <p class="mb-0">{{ @$user->email }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-telephone-fill me-1"></i>Phone
                                            </label>
                                            <p class="mb-0">{{ @$user->phone_number ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-geo-alt-fill me-1"></i>Address
                                            </label>
                                            <p class="mb-0">{{ @$user->address ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Separator --}}
                                <div class="my-4">
                                    <hr class="border border-secondary border-2 opacity-50">
                                </div>

                                {{-- Device Details Section --}}
                                <h5 class="mb-4 text-secondary border-bottom pb-2">
                                    <i class="bi bi-phone-vibrate-fill me-2 text-primary"></i>Device Details
                                </h5>

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-phone me-1"></i>Model
                                            </label>
                                            <p class="mb-0">{{ @$device->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-upc-scan me-1"></i>Serial No
                                            </label>
                                            <p class="mb-0">{{ @$device->device_id ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-calendar-check me-1"></i>Install Date
                                            </label>
                                            <p class="mb-0">
                                                {{ @$device->created_at ? strtoupper(\Carbon\Carbon::parse($device->created_at)->format('j-M-Y')) : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-person-badge-fill me-1"></i>Installer Name
                                            </label>
                                            <p class="mb-0">{{ @$device->i_name->full_name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Separator --}}
                                <div class="my-4">
                                    <hr class="border border-secondary border-2 opacity-50">
                                </div>

                                {{-- Split layout: left info and right table --}}
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        {{-- Left side custom details --}}
                                        <div class="p-3 border rounded shadow-sm h-100"
                                            style="background-color: rgb(240, 240, 240);">
                                            <label class="form-label fw-bold text-primary">
                                                <i class="bi bi-info-circle me-1"></i>Other Details
                                            </label>

                                            <div class="mb-3">
                                                <p class="mb-0">Status</p>
                                                @php
                                                $badgeClass = match((int) $device->is_online) {
                                                1 => 'bg-outline-success', // Online
                                                0 => 'bg-outline-danger', // Offline
                                                default => 'bg-outline-light', // Fallback
                                                };
                                                $statusText = (int) $device->is_online === 1 ? 'Online' : 'Offline';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                            </div>

                                            <div class="mb-3">
                                                <p class="mb-0">Faults</p>
                                                <span>{{ $deviceFaults->count() }}</span>
                                            </div>

                                            <div class="mb-3 hide">
                                                <p class="mb-0">Actions</p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.viewLogs', $device->device_id) }}"
                                                        title="Device logs" class="badge bg-outline-info">
                                                        <i class="fas fa-history"></i>
                                                    </a>

                                                    <a href="javascript:void(0);"
                                                        class="manage-device-btn badge bg-outline-danger"
                                                        data-device-id="{{ $device->device_id }}" title="Device ON/OFF">
                                                        <i class="fas fa-power-off"></i>
                                                    </a>

                                                    <a href="{{ route('admin.scheduleDevice', $device->device_id) }}"
                                                        title="Schedule Device Time"
                                                        class="badge bg-outline-warning scheduleTime"
                                                        data-device-id="{{ $device->device_id }}">
                                                        <i class="fas fa-clock"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        {{-- Right side table --}}
                                        <div class="table-responsive">
                                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
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
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ @$value->failure_code }}</td>
                                                        <td>{!! nl2br(e($value->description)) !!}</td>
                                                        <td>{!! nl2br(e($value->failure_analysis)) !!}</td>
                                                        <td>{{ $value->solution }}</td>
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