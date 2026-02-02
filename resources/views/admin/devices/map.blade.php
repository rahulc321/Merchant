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
                        <li class="breadcrumb-item active" aria-current="page">Device Map</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Device Map</div>
                    </div>

                    <div class="card-body">
                    <form id="deviceFilterForm" class="row mb-3">
                            <div class="col-md-2">
                                <label>Installer</label>
                                <select id="filterStatus" class="form-control" name="installer_id">
                                <option value="" <?php if(@$_REQUEST['installer_id'] == ''){ echo 'selected'; } ?>>All</option>
                                    @foreach($I_U as $ins)
                                    <option value="<?=$ins->id?>" <?php if(@$_REQUEST['installer_id'] == $ins->id){ echo 'selected'; } ?>><?=$ins->full_name?></option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>User</label>
                                <select id="filterStatus" class="form-control" name="user_id">
                                <option value="" <?php if(@$_REQUEST['user_id'] == ''){ echo 'selected'; } ?>>All</option>
                                    @foreach($E_U as $ins)
                                    <option value="<?=$ins->id?>" <?php if(@$_REQUEST['user_id'] == $ins->id){ echo 'selected'; } ?>><?=$ins->full_name?></option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Products</label>
                                <select id="filterStatus" class="form-control" name="product_id">
                                <option value="" <?php if(@$_REQUEST['product_id'] == ''){ echo 'selected'; } ?>>All</option>
                                    @foreach($products as $product)
                                    <option value="<?=$product->product_id?>" <?php if(@$_REQUEST['product_id'] == $product->product_id){ echo 'selected'; } ?>><?=$product->name?></option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Status</label>
                                <?php $is_online = isset($_REQUEST['is_online']) ? $_REQUEST['is_online'] : ''; ?>
                                <select id="filterStatus" class="form-control" name="is_online">
                                    <option value="" <?php if($is_online === '') echo 'selected'; ?>>All</option>
                                    <option value="1" <?php if($is_online === '1') echo 'selected'; ?>>Online</option>
                                    <option value="0" <?php if($is_online === '0') echo 'selected'; ?>>Offline</option>
                                    <option value="2" <?php if($is_online === '2') echo 'selected'; ?>>Error</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end" style="display: flex">
                                <button type="submit" class="btn btn-primary w-20">Filter</button>
                                <a href="{{ route('admin.deviceOverMap') }}" class="btn btn-secondary w-20" style="margin-left: 5px;">Reset</a>    
                            </div>
                        </form>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #map { height: 500px; width: 100%; }
</style>

<!-- Load Google Maps API (Replace YOUR_GOOGLE_MAPS_API_KEY) -->
<script src="https://maps.googleapis.com/maps/api/js?key={{env('MAPKEY')}}&callback=initMap" async defer></script>

<script>
    var devices = @json($devices); // Pass PHP data to JavaScript
    console.log(devices);

    function initMap() {
        // Default center (Melbourne, AU)
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: { lat: -37.8136, lng: 144.9631 }
        });

        // Loop through devices and add markers
        devices.forEach(function(device) {
            if (device.lat && device.lon) {
                // Determine marker color based on is_online status
                var iconColor;

                if (device.error_codes && device.error_codes.length > 0) {
                    // show red if there are any error codes
                    iconColor = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                } else if (device.is_online === "1" || device.is_online === 1) {
                    iconColor = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
                } else if (device.is_online === "0" || device.is_online === 0) {
                    iconColor = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                } else {
                    iconColor = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                }

                // Create marker
                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(device.lat),
                        lng: parseFloat(device.lon)
                    },
                    map: map,
                    title: device.name,
                    icon: iconColor
                });

                // Create InfoWindow content
                var contentString = `
                    <div style="
                        max-width: 220px;
                        padding: 10px;
                        border-radius: 8px;
                        background-color: #fff;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                        font-family: Arial, sans-serif;
                        font-size: 13px;
                        color: #333;
                    ">
                        <div style="text-align: center;">
                            <img src="{{url('/')}}/tank.png" alt="device image" style="width: 48px; height: auto; margin-bottom: 8px;">
                            <h6 style="margin: 5px 0; font-size: 14px; color: #2c3e50;">${device.name}</h6>
                            <h6 style="margin: 5px 0; font-size: 14px; color: #2c3e50;">${device.device_id}</h6>
                        </div>
                        <p style="margin: 4px 0;"><strong>Latitude:</strong> ${device.lat}</p>
                        <p style="margin: 4px 0;"><strong>Longitude:</strong> ${device.lon}</p>
                    </div>
                `;

                // Create InfoWindow
                var infoWindow = new google.maps.InfoWindow({
                    content: contentString
                });

                // Show info window on marker click
                marker.addListener("click", function () {
                    infoWindow.open(map, marker);
                });
            }
        });
    }
</script>


@endsection
