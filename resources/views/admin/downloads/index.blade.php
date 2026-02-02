@extends('layouts.admin')

@section('title', 'AetherSmart - Downloads')

@section('content')
<style>
.p-2 {
    box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Downloads</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        @can('download_add')
                        <a href="javascript:;" class="btn btn-info manage-device-btn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" style="float:right">Add Doc</a>
                        @endcan

                        @php
                        $categories = [
                        'all' => 'All',
                        'customer' => 'For Customers',
                        'installer' => 'For Installers',
                        'warranty' => 'Warranty Documents',
                        'support' => 'Support Documents'
                        ];
                        $firstKey = array_key_first($categories);
                        @endphp

                        <ul class="nav nav-tabs mb-3" id="scheduleTabs" role="tablist">
                            @foreach($categories as $key => $label)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $key === $firstKey ? 'active' : '' }}" id="{{ $key }}-tab"
                                    data-bs-toggle="tab" href="#{{ $key }}" role="tab" aria-controls="{{ $key }}"
                                    aria-selected="{{ $key === $firstKey ? 'true' : 'false' }}">
                                    {{ $label }}
                                </a>
                            </li>
                            @endforeach

                            <li class="nav-item" role="presentation">
                                <a  class="nav-link"  data-bs-toggle="modal"
                                data-bs-target="#emailModel">
                                    Send Attachment
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="scheduleTabsContent">
                            @foreach($categories as $key => $label)
                            <div class="tab-pane fade {{ $key === $firstKey ? 'show active' : '' }}" id="{{ $key }}"
                                role="tabpanel" aria-labelledby="{{ $key }}-tab">

                                @php
                                $categoryDownloads = $key === 'all'
                                ? $downloads
                                : $downloads->filter(function($download) use ($key) {
                                return in_array($key, explode(',', $download->category));
                                });
                                @endphp

                                @if($categoryDownloads->isEmpty())
                                <p>No files found for {{ $label }}.</p>
                                @else
                                <div class="row">
                                    @foreach($categoryDownloads as $file)
                                    <div class="col-sm-3 mb-3 p-1">
                                        <div class="card border-0 position-relative"
                                            style="display:flex; flex-direction:column; height:350px;">
                                            @can('delete_file')
                                            <form action="{{ route('admin.deleteFile', $file->id) }}" method="POST"
                                                style="position: absolute; top: 5px; right: 5px; z-index: 10;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                    style="border: none; background: transparent; color: red;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan

                                            <a href="{{ asset('uploads/' . $file->file_path) }}" target="_blank"
                                                style="flex-shrink:0; height:250px; width:100%; display:block;">
                                                @if($file->front_image)
                                                <img src="{{ asset('uploads/' . $file->front_image) }}"
                                                    alt="Preview Image" class="card-img-top"
                                                    style="height:250px; width:100%; object-fit:cover;">
                                                @endif
                                            </a>

                                            <div class="card-body p-2 text-center"
                                                style="flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">
                                                <h6 class="card-title mb-2" style="font-size: 14px;">{{ $file->title }}
                                                </h6>

                                                <a href="{{ asset('uploads/' . $file->file_path) }}" download
                                                    class="btn btn-sm btn-primary mt-auto">
                                                    <i class="fa fa-download me-1"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                                @endif

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.download.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card shadow rounded-4 p-4">
                    <h4 class="mb-4">Upload Document</h4>

                    <div class="form-group mb-3">
                        <label class="form-label" for="title"><strong>Title</strong></label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="category"><strong>Category</strong></label>
                        <select name="category[]" class="form-control select2" multiple required>
                            @foreach($categories as $key => $label)
                            @if($key !== 'all') {{-- Exclude 'All' from the form --}}
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="front_image"><strong>Front Image</strong></label>
                        <input type="file" name="front_image" id="front_image" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="file"><strong>Choose File</strong></label>
                        <input type="file" name="file" id="file" class="form-control"
                            accept="application/pdf,image/*,video/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Model -->
<div class="modal fade" id="emailModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.sendAttachment') }}" enctype="multipart/form-data">
                @csrf
                <div class="card shadow rounded-4 p-4">
                    <h4 class="mb-4">Send Attachment</h4>

                    <!-- <div class="form-group mb-3">
                        <label class="form-label" for="title"><strong>Description</strong></label>
                        <textarea class="form-control" name="description"></textarea>
                    </div> -->

                    <div class="form-group mb-3">
                        <label class="form-label" for="category"><strong>Users & Installers</strong></label>
                        <select name="users[]" class="form-control select2" multiple required>
                            @foreach($users as $key => $uData)
                            
                            <option value="{{ $uData->email }}">{{ $uData->full_name }}</option>
                            
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group mb-3">
                        <label class="form-label" for="category"><strong>Attachment</strong></label>
                        <select name="attachments[]" class="form-control select2" multiple required>
                            @foreach($downloads as $key => $at)
                            
                            <option value="{{ $at->id }}">{{ $at->title }}</option>
                            
                            @endforeach
                        </select>
                    </div>

                    

                    <button type="submit" class="btn btn-primary mt-4">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // for select2 inside #exampleModal
    $('#exampleModal .select2').select2({
        dropdownParent: $('#exampleModal')
    });

    // for select2 inside #emailModel
    $('#emailModel .select2').select2({
        dropdownParent: $('#emailModel')
    });
});
</script>
@endsection