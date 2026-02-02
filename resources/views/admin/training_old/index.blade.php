@extends('layouts.admin')
@section('title', 'CRM - Training')
@section('content')

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Training</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card shadow-sm border-0 rounded">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">Training List</h5>
                        @if (Auth::user()->roles->contains('title', 'Admin'))
                        <a href="{{ route('admin.trainingCreate') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus-circle me-2"></i>Create New Training
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-hover table-bordered text-center w-100">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Video</th>
                                        @if (Auth::user()->roles->contains('title', 'Admin'))
                                        <th>Role</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainings as $key => $value)

                                    <?php
                                         //echo '<pre>';print_r($value->viewedByUser);
                                        $is_view = 0;
                                         if($value->viewedByUser){
                                            $is_view = 1;
                                         }
                                    ?>
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="fw-medium text-dark">{{ $value->title }}</td>
                                        <td>
                                            <div class="video-container position-relative">
                                                <video class="video-player shadow-sm rounded <?php if($is_view == 1){ echo 'watch-g'; }else{ echo 'watch-r'; }  ?>" width="320" height="180"
                                                    controls id="videoPlayer_{{ $value->id }}"
                                                    video_time="{{ $value->video_time }}"
                                                    onplay="trackPlayTime('{{ $value->id }}')"
                                                    onended="markVideoAsWatched('{{ $value->id }}', '{{ Auth::id() }}')">
                                                    <source src="{{ asset($value->video_url) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                                <div class="mt-2">
                                                    <input type="text" id="playTime_{{ $value->id }}" readonly
                                                        class="form-control play-time text-center"
                                                        placeholder="Play Time">
                                                </div>
                                                <div id="animation_{{ $value->id }}" class="flower-animation">
                                                    🌸
                                                </div>
                                            </div>
                                        </td>
                                        @if (Auth::user()->roles->contains('title', 'Admin'))
                                        <td class="text-capitalize">{{ $value->role }}</td>
                                        @endif
                                        <td>
                                            <span class="badge {{ match($value->status) {
                                                'inactive' => 'bg-warning text-dark',
                                                'reject' => 'bg-danger',
                                                'active' => 'bg-success',
                                                'in_progress' => 'bg-info text-dark',
                                                default => 'bg-secondary',
                                            } }}">
                                                {{ ucfirst($value->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if (Auth::user()->roles->contains('title', 'Admin'))
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-danger shadow-sm"
                                                    onclick="if(confirm('Are you sure you want to delete this?')) { document.getElementById('deleteFrm{{ $key }}').submit(); }">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                                <form id="deleteFrm{{ $key }}"
                                                    action="{{ route('admin.trainingDelete', $value->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>

                                            @else
                                                @if($is_view ==0)
                                                    <p style="color:red">Please watch full video!</p>

                                                    @else
                                                    <p class="text-success">Video Watched</p>
                                                @endif
                                            @endif
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
/* General Styling */
body {
    background-color: #f8f9fa;
}

.card {
    background-color: #fff;
}

.card-header {
    background-color: #e9ecef;
}

.card-title {
    font-size: 18px;
}

/* Table Styling */
.table {
    border-radius: 5px;
    overflow: hidden;
}

.table thead th {
    text-transform: uppercase;
    font-size: 14px;
    background: #343a40;
    color: #fff;
}

.table tbody tr {
    transition: background-color 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Video Player */
.video-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
}

.video-player {
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
}

.play-time {
    width: 150px;
}

/* Flower Animation */
.flower-animation {
    display: none;
    font-size: 50px;
    animation: bloom 1.5s ease-in-out forwards;
}

/* Keyframes */
@keyframes bloom {
    0% {
        transform: scale(0);
        opacity: 0;
    }

    50% {
        transform: scale(1.2);
        opacity: 1;
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}
.text-success {
    color: green;
    font-weight: bold; /* Optional for emphasis */
}

.watch-g {
    border: 5px solid green !important;
}

.watch-r {
    border: 5px solid red !important;
}

/* Buttons */
.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
</style>

<script>
function trackPlayTime(videoId) {
    const videoPlayer = document.getElementById(`videoPlayer_${videoId}`);
    const playTimeInput = document.getElementById(`playTime_${videoId}`);

    videoPlayer.ontimeupdate = function() {
        const currentTime = videoPlayer.currentTime;
        playTimeInput.value = formatTime(currentTime);
    };
}

function markVideoAsWatched(videoId, userId) {
    const videoPlayer = document.getElementById(`videoPlayer_${videoId}`);
    const animationDiv = document.getElementById(`animation_${videoId}`);
    const totalDuration = parseFloat(videoPlayer.getAttribute('video_time'));

    if (videoPlayer.currentTime >= totalDuration) {
        fetch('/admin/mark-video-watched', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    video_id: videoId,
                    user_id: userId,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    animationDiv.style.display = 'block';
                    setTimeout(() => {
                        animationDiv.style.display = 'none';
                    }, 1500);
                }
            })
            .catch(console.error);
    }
}

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes}m ${remainingSeconds}s`;
}
</script>
@endsection