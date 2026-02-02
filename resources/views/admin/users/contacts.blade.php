@extends('layouts.admin')
@section('title', 'AetherSmart - List Contacts')
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
</style>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Contacts
                        </div>
                        <a class="" href='{{ route("admin.createContact") }}' style="float:right !important"><span
                                class="badge bg-outline-info">Add Contacts</span></a>
                    </div>

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="datatable-basic">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Location</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Notes</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($contacts as $key=>$user)
                                                <tr
                                                    style="background-color: 
                                                     {{ $user->type == 'store' ? 'rgb(230, 245, 255)' : ($user->type == 'bm' ? 'rgb(245, 230, 255)' : 'rgb(230, 255, 230)') }};">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>
                                                        @if($user->type == 'store')
                                                        Store
                                                        @elseif($user->type == 'bm')
                                                        Branch Manager
                                                        @elseif($user->type == 'tt')
                                                        Territory Manager
                                                        @endif
                                                    </td>
                                                    <td>{{ $user->store_location }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>
                                                        @if($user->type == 'bm' || $user->type == 'tt')
                                                        {{ $user->notes }}
                                                        <!-- <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#notesModal-{{ $user->id }}"
                                                            style="color: blue;">Click Here</a> -->
                                                        @else
                                                        &nbsp;
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class=""
                                                            href="{{ route('admin.contact_view', $user ->id) }}">
                                                            <span class="badge bg-outline-info">View</span>
                                                        </a>

                                                        <a class="" href="{{ route('admin.contactEdit', $user->id) }}">
                                                            <span class="badge bg-outline-info">Edit</span>
                                                        </a>

                                                        <a class="" href="javascript:;"
                                                            onclick="if(confirm('Are you sure you want to delete this?')) { event.preventDefault(); document.getElementById('deleteFrm<?=$key?>').submit(); }">
                                                            <span class="badge bg-outline-secondary">Delete</span>
                                                        </a>

                                                        <form id="deleteFrm{{$key}}"
                                                            action="{{ route('admin.contactDelete', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                            style="display: inline-block;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <input type="submit" class="badge bg-outline-secondary"
                                                                value="Delete">
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

                        <!-- Dynamic Modals -->
                        @foreach($contacts as $user)
                        @if($user->type == 'bm' || $user->type == 'tt')
                        <div class="modal fade" id="notesModal-{{ $user->id }}" tabindex="-1"
                            aria-labelledby="notesModalLabel-{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="notesModalLabel-{{ $user->id }}">
                                            {{ ucfirst($user->type) }} Notes
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Display Existing Notes -->
                                        <?php 
                                    $bm_notes = App\Notes::where('contact_id', $user->id)
                                    ->where('type', $user->type.'_notes')
                                    // ->where('notes_type', 'one_to_one')
                                    ->get();
                                     ?>
                                        @foreach($bm_notes as $note)
                                        <div class="mb-3 p-2 rounded" style="background-color: rgb(240, 248, 255); 
                                        border: 1px solid rgb(200, 230, 255);">
                                            <p class="mb-0">{{ $note->notes }}</p>
                                            @if($note)
                                            <span class="time">{{ $note->created_at->format('d-m-Y @ h:i A') }} By:
                                                {{@$note->get_name->full_name}}</span>
                                            @endif
                                        </div>
                                        @endforeach

                                        <!-- Form to Add or Update Notes -->
                                        <form action="{{ route('admin.notesStore', $user->id) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="type" value="{{ $user->type }}_notes">
                                            <input type="hidden" name="notes_type" value="one_to_one">
                                            <input type="hidden" name="contact_id" value="{{@$user->id}}">
                                            <div class="form-group">
                                                <label for="notes-{{ $user->id }}" class="form-label fw-bold">Add or
                                                    Update Notes:</label>
                                                <textarea name="notes" id="notes-{{ $user->id }}" class="form-control"
                                                    rows="5" placeholder="Write your notes here..."></textarea>
                                            </div>
                                            <div class="form-group text-end mt-2">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <!-- End of Modals -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection