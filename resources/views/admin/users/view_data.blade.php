@extends('layouts.admin')
@section('title', 'AetherSmart - View Records')
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
                            Records
                        </div>
                        <!-- <a style="color:blue" href="javascript:;" data-bs-toggle="modal"
                            data-bs-target="#ownNotesModal">Click Here</a> -->
                    </div>

                    <!-- Branch Manager Notes Modal -->
                    <div class="modal fade" id="ownNotesModal" tabindex="-1" aria-labelledby="bmNotesModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bmNotesModalLabel">Self Notes</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    @foreach($selfNotes as $bm_note)
                                    <div class="mb-3 p-2 rounded"
                                        style="background-color: rgb(240, 248, 255); border: 1px solid rgb(200, 230, 255);">
                                        <p class="mb-0">{{ $bm_note->notes }}</p>

                                        <span class="time">{{ $bm_note->created_at->format('d-m-Y @ h:i A') }}</span>
                                    </div>
                                    @endforeach

                                    <!-- Form to Update Notes -->
                                    <form action="{{ route('admin.notesStore', $users->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="type" value="self_notes">
                                        <div class="form-group mb-3">
                                            <label for="bm_notes" class="form-label fw-bold">Add or Update
                                                Notes:</label>
                                            <textarea name="notes" id="bm_notes" class="form-control" rows="5"
                                                style="border: 1px solid rgb(220, 220, 220); border-radius: 8px; background-color: rgb(250, 250, 250);"
                                                placeholder="Write your notes here..."></textarea>
                                        </div>
                                        <div class="form-group text-end">
                                            <button type="submit" class="btn btn-info"
                                                style="background-color: rgb(0, 123, 255); color: white; border-radius: 8px; padding: 8px 20px;">
                                                Submit
                                            </button>
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

                    <!--  -->


                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row">
                                    <!-- Left Side: Store, Branch Manager, and Territory Manager Details -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Store Details</h5>
                                                <?php
                                                    $cont = \DB::table('contacts')->where('id', $users->store_location)->first();
                                                    $bm = \DB::table('contacts')->where('id', $users->bm_name)->first();
                                                    $tt = \DB::table('contacts')->where('id', $users->tt_name)->first();
                                                ?>
                                                <p><b>Store Location:</b> {{ @$cont->store_location }}</p>
                                                <p><b>Store State:</b> {{ $users->store_state }}</p>
                                                <p><b>Store Email:</b> {{ $users->store_email }}</p>
                                                <p><b>Store Phone:</b> {{ $users->store_phone }}</p>
                                            </div>
                                        </div>

                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Branch Manager Details</h5>
                                                <p><b>Name:</b> {{ @$bm->store_location }}</p>
                                                <p><b>Email:</b> {{ $users->bm_email }}</p>
                                                <p><b>Phone:</b> {{ $users->bm_phone }}</p>
                                                <p>
                                                    <b>Notes:</b> {{ $users->bm_notes }}
                                                    <a style="color:blue" href="javascript:;" data-bs-toggle="modal"
                                                        data-bs-target="#bmNotesModal">Click Here</a>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Territory Manager Details</h5>
                                                <p><b>Name:</b> {{ @$tt->store_location }}</p>
                                                <p><b>Email:</b> {{ $users->tt_email }}</p>
                                                <p><b>Phone:</b> {{ $users->tt_phone }}</p>
                                                <p>
                                                    <b>Notes:</b> {{ $users->tt_notes }}
                                                    <a style="color:blue" href="javascript:;" data-bs-toggle="modal"
                                                        data-bs-target="#ttNotesModal">Click Here</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Side: Self Notes and Note Form -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Add a Note</h5>
                                                <form method="POST"
                                                    action="{{ route('admin.notesStore', $users->id) }}" enctype="multipart/form-data">
                                                    <input type="hidden" name="type" value="self_notes">
                                                    <input type="hidden" name="contact_id" value="{{@$bm->id}}">
                                                    
                                                    @csrf
                                                    <div class="mb-3">
                                                        <textarea name="notes" class="form-control" rows="4"
                                                            placeholder="Write your note here..."></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control" name="file">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Save Note</button>
                                                </form>
                                            </div>

                                            <div class="card-body scr">

                                                @foreach($selfNotes as $bm_note)
                                                <div class="mb-3 p-2 rounded"
                                                    style="background-color: rgb(240, 248, 255); border: 1px solid rgb(200, 230, 255);">
                                                    <p class="mb-0">{{ $bm_note->notes }}</p>

                                                    @if($bm_note->file)
                                                    <div style="position: relative; display: inline-block;">
                                                        <img src="{{ url('/uploads') }}/{{ $bm_note->file }}"
                                                            style="width:200px;height:106px">

                                                         
                                                        <a href="{{ url('/uploads') }}/{{ $bm_note->file }}" download
                                                            style="position: absolute; top: 80px; left: 1px; background: rgba(0, 0, 0, 0.6); 
                  padding: 5px 10px; border-radius: 50%; color: white; text-decoration: none;">
                                                            ⬇
                                                        </a>
                                                    </div>
                                                    @endif

                                                    <span
                                                        class="time">{{ $bm_note->created_at->format('d-m-Y @ h:i A') }} By: {{@$bm_note->get_name->full_name}}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>

                            <!-- Modals -->
                            <!-- Branch Manager Notes Modal -->
                            <div class="modal fade" id="bmNotesModal" tabindex="-1" aria-labelledby="bmNotesModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bmNotesModalLabel">Branch Manager Notes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Display Existing Notes -->
                                            <!-- <div class="mb-3 p-2 rounded"
                                                style="background-color: rgb(240, 248, 255); border: 1px solid rgb(200, 230, 255);">
                                                <p class="mb-0">{{ $users->bm_notes }}</p>
                                            </div> -->

                                            <?php
                                            $bm_notes = App\Notes::where('contact_id', $bm->id)
                                            ->where('type', 'bm_notes')
                                            // ->where('notes_type', 'one_to_one')
                                            ->get();
                                            ?>

                                            @foreach($bm_notes as $bm_note)
                                            <div class="mb-3 p-2 rounded"
                                                style="background-color: rgb(240, 248, 255); border: 1px solid rgb(200, 230, 255);">
                                                <p class="mb-0">{{ $bm_note->notes }}</p>
                                                <span
                                                    class="time">{{ $bm_note->created_at->format('d-m-Y @ h:i A') }} By: {{@$bm_note->get_name->full_name}}</span>
                                            </div>
                                            @endforeach

                                            <!-- Form to Update Notes -->
                                            <form action="{{ route('admin.notesStore', $users->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="type" value="bm_notes">
                                                <input type="hidden" name="contact_id" value="{{@$bm->id}}">
                                                <div class="form-group mb-3">
                                                    <label for="bm_notes" class="form-label fw-bold">Add or Update
                                                        Notes:</label>
                                                    <textarea name="notes" id="bm_notes" class="form-control" rows="5"
                                                        style="border: 1px solid rgb(220, 220, 220); border-radius: 8px; background-color: rgb(250, 250, 250);"
                                                        placeholder="Write your notes here..."></textarea>
                                                </div>
                                                <div class="form-group text-end">
                                                    <button type="submit" class="btn btn-info"
                                                        style="background-color: rgb(0, 123, 255); color: white; border-radius: 8px; padding: 8px 20px;">
                                                        Submit
                                                    </button>
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

                            <!-- Territory Manager Notes Modal -->
                            <div class="modal fade" id="ttNotesModal" tabindex="-1" aria-labelledby="ttNotesModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ttNotesModalLabel">Territory Manager Notes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Display Existing Notes -->
                                            <!-- <div class="mb-3 p-2 rounded"
                                                style="background-color: rgb(240, 248, 255); border: 1px solid rgb(200, 230, 255);">
                                                <p class="mb-0">{{ $users->tt_notes }}</p>
                                            </div> -->
                                            <?php
                                            $tt_notes = App\Notes::where('contact_id', $tt->id)
                                            ->where('type', 'tt_notes')
                                            // ->where('notes_type', 'one_to_one')
                                            ->get();
                                            ?>
                                            @foreach($tt_notes as $tt_note)
                                            <div class="mb-3 p-2 rounded"
                                                style="background-color: rgb(240, 248, 255); border: 1px solid rgb(200, 230, 255);">
                                                <p class="mb-0">{{ $tt_note->notes }}</p>
                                                <span
                                                    class="time">{{ $tt_note->created_at->format('d-m-Y @ h:i A') }} By: {{@$tt_note->get_name->full_name}}</span>
                                            </div>
                                            @endforeach

                                            <!-- Form to Update Notes -->
                                            <form action="{{ route('admin.notesStore', $users->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="type" value="tt_notes">
                                                <input type="hidden" name="contact_id" value="{{@$tt->id}}">
                                                <div class="form-group mb-3">
                                                    <label for="bm_notes" class="form-label fw-bold">Add or Update
                                                        Notes:</label>
                                                    <textarea name="notes" id="bm_notes" class="form-control" rows="5"
                                                        style="border: 1px solid rgb(220, 220, 220); border-radius: 8px; background-color: rgb(250, 250, 250);"
                                                        placeholder="Write your notes here..."></textarea>
                                                </div>
                                                <div class="form-group text-end">
                                                    <button type="submit" class="btn btn-info"
                                                        style="background-color: rgb(0, 123, 255); color: white; border-radius: 8px; padding: 8px 20px;">
                                                        Submit
                                                    </button>
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
                            <!-- End of Modals -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection