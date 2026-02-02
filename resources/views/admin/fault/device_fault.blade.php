@extends('layouts.admin')
@section('title', 'AetherSmart - Faults')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Faults</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Device with Active Faults</div>
                        <!-- <a style="float:right" href="{{route('admin.deviceOverMap')}}" class="btn btn-info">See Device Over Map</a> -->
                    </div>

                    <div class="card-body">
                    
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Failure Analysis</th>
                                        <th>Solutions</th>
                                        <th>Device Id</th>
                                        <th>Installer Info</th>
                                        <th>Documents</th>
                                        
                                         
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deviceFaults as $key => $value)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><a class="c_color"  target="_blank" href="{{route('admin.view_info',$value->oid)}}" style="color:blue">{{$value->user_name}}</td>
                                        <td>{{@$value->failure_code}}</td>
                                        <td>{!! nl2br(e($value->description)) !!}</td>
                                        <td>{!! nl2br(e($value->failure_analysis)) !!}</td>
                                        <td>{{$value->solution}}</td>
                                        <td>{{$value->device_id}}</td>
                                        <td>{{$value->installer_name}}</td>
                                        <td>
                                        <a class="c_color" href="{{ asset('uploads/' . $value->file_path) }}" target="_blank"
                                        style="color:blue">{{$value->title}}</a>
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
                        <label class="form-label"><i class="fas fa-thermometer-half text-warning"></i> Set Temperature</label>
                        <select name="temp_set" id="temp_set" class="form-select">
                            <option value="">Select</option>
                            @for($i=15;$i<=75;$i++)
                            <option value="<?=$i?>"><?=$i?></option>
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
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".manage-device-btn").forEach(button => {
            button.addEventListener("click", function () {
                let deviceId = this.getAttribute("data-device-id");
                document.getElementById("device_id").value = deviceId;

                let modal = new bootstrap.Modal(document.getElementById("manageDeviceModal"));
                modal.show();
            });
        });
    });
</script>

@endsection
