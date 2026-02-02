@extends('layouts.admin')
@section('title', 'AetherSmart - Schedule Device Time')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Schedule Device Time</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">List Schedule Device Times</div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <a href="javascript:;" class="btn btn-info manage-device-btn" data-toggle="modal"
                                data-target="#exampleModal">Schedule Device Time</a>
                            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Day</th>
                                        <th>Timezone</th>
                                        <th>ON Time</th>
                                        <th>OFF Time</th>
                                        <th>Temperature</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $key => $value)
                                    <?php
                                      //  dd($value);
                                    ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{@$value['day']}}</td>
                                        <td>{{$value['timezone']}}</td>
                                        <td>{{$value['on_time']}}</td>
                                        <td>{{$value['off_time']}}</td>
                                        <td>{{$value['temperature']}}</td>
                                        <td>
                                            @php
                                            $badgeClass = match((int) $value['status']) {
                                            1 => 'bg-outline-success',
                                            0 => 'bg-outline-danger',
                                            default => 'bg-outline-light',
                                            };
                                            $statusText = (int) $value['status'] === 1 ? 'Active' : 'In-Active';
                                            @endphp

                                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                        </td>

                                        <td>
                                            <a class="" href="javascript:;"
                                                onclick="if(confirm('Are you sure you want to delete this?')) { event.preventDefault(); document.getElementById('deleteFrm<?=$key?>').submit(); }">
                                                <span class="badge bg-outline-secondary">Delete</span>
                                            </a>

                                            <form id="deleteFrm{{$key}}"
                                                action="{{ route('admin.deleteSchedule', $value['id']) }}" method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="badge bg-outline-secondary" value="Delete">
                                            </form>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
             
             
                
                    <form method="POST" action="">
                        @csrf
                        
                       

                        <div class="card shadow rounded-4 p-4">
                            <h4 class="mb-4">Set Timer Schedule</h4>

                            @php
                            $days = ['everyday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday',
                            'saturday'];
                            @endphp

                            <div class="form-group mb-3 col-sm-6">
                            <label><strong>Timezone<strong></label>
                                <select name="timezones" class="form-control">
                                    @foreach($timezones as $timezone)
                                        <option value="{{$timezone->timezone}}">{{$timezone->timezone}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3 col-sm-6">
                                <label><strong>Temperature (°C)<strong></label>
                                <select name="temperature" id="temperature" class="form-select">
                                    <option value="">Select</option>
                                    @for($i=15;$i<=75;$i++)
                                    <option value="<?=$i?>"><?=$i?></option>
                                    @endfor
                                </select>
                            </div>

                            @foreach($days as $day)
                            <div class="form-check mb-3">
                                <input class="form-check-input day-checkbox" type="checkbox" id="{{ $day }}"
                                    name="days[]" value="{{ $day }}">
                                <label class="form-check-label day-label" for="{{ $day }}">
                                    {{ ucfirst($day) }}
                                </label>

                                <div class="time-input" id="time-{{ $day }}">
                                    <div class="time-slots" id="slots-{{ $day }}"></div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary add-slot mt-2"
                                        data-day="{{ $day }}">Add Time Slot</button>
                                </div>
                            </div>
                            @endforeach

                            <button class="btn btn-primary mt-4">Save Timer</button>
                        </div>
                    </form>
                

            
        </div>
    </div>
</div>
<style>
    .time-input { display: none; margin-top: 10px; }
    .time-range { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
    .remove-slot { cursor: pointer; color: red; font-size: 1.5rem; line-height: 1; }
    .day-label { font-weight: 600; font-size: 1.1rem; }
  </style>
<!-- FontAwesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<!-- jQuery, Bootstrap & jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">

<!-- Timepicker Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.14.0/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.14.0/jquery.timepicker.min.css">

<!-- JavaScript -->
<script>
$(document).ready(function() {
    // Initialize timepicker
    $(".timepicker").timepicker({
        timeFormat: "HH:mm",
        interval: 15,
        minTime: "00:00",
        maxTime: "23:59",
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    // Function to initialize the datepicker
    function initializeDatePicker() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            minDate: 0
        });
    }

    // Initialize datepicker when the modal is opened
    $("#exampleModal").on("shown.bs.modal", function() {
        initializeDatePicker();
    });

    // Show modal and set device ID properly
    $(".manage-device-btn").on("click", function() {
        let deviceId = $(this).data("device-id");
        if (deviceId) {
            $("#device_id").val(deviceId);
        }
        $("#exampleModal").modal("show");
    });
});
</script>
<script>
  const allDays = ['everyday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

  document.addEventListener('DOMContentLoaded', () => {
    allDays.forEach(day => {
      const checkbox = document.getElementById(day);
      const timeContainer = document.getElementById(`time-${day}`);

      checkbox.addEventListener('change', function () {
        timeContainer.style.display = this.checked ? 'block' : 'none';

        if (day === 'everyday' && this.checked) {
          document.querySelectorAll('.day-checkbox').forEach(cb => {
            if (cb.id !== 'everyday') {
              cb.checked = false;
              document.getElementById(`time-${cb.id}`).style.display = 'none';
              document.getElementById(`slots-${cb.id}`).innerHTML = '';
            }
          });
        }
      });
    });

    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('add-slot')) {
        const day = e.target.dataset.day;
        const container = document.getElementById(`slots-${day}`);

        const html = `
          <div class="time-range">
            <input type="time" name="start_time[${day}][]" class="form-control" required>
            <input type="time" name="end_time[${day}][]" class="form-control" required>
            <span class="remove-slot">&times;</span>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
      }

      if (e.target.classList.contains('remove-slot')) {
        e.target.closest('.time-range').remove();
      }
    });
  });
</script>

@endsection