@extends('layouts.admin')
@section('title', 'AetherSmart - View Records')
@section('content')
<style type="text/css">
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
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Records</li>
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
                            View Records
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="card" style="">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    @if($user->type == 'store')
                                                    Store Details
                                                    @elseif($user->type == 'bm')
                                                    Branch Manager Details
                                                    @elseif($user->type == 'tt')
                                                    Territory Manager Details
                                                    @else
                                                    User Details
                                                    @endif
                                                </h5>

                                                <p><b>Location:</b> {{ $user->store_location ?? 'N/A' }}</p>
                                                <p><b>State:</b> {{ $user->store_state ?? 'N/A' }}</p>

                                                <!-- Email with popup -->
                                                <!-- Email Link -->
                                                <p><b>Email:</b>
                                                    <a style="color:blue; cursor:pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#emailModal">
                                                        ✉️ {{ $user->store_email ?? $user->email }}
                                                    </a>
                                                </p>

                                                <!-- Bootstrap Email Modal -->
                                                <div class="modal fade" id="emailModal" tabindex="-1"
                                                    aria-labelledby="emailModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="emailModalLabel">Send Email
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="emailForm"
                                                                    action="{{ route('admin.sendEmail') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="recipient_email"
                                                                        value="{{ $user->email }}">

                                                                    <!-- Subject -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Subject</label>
                                                                        <input type="text" class="form-control"
                                                                            name="subject" required>
                                                                    </div>

                                                                    <!-- Message -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Message</label>
                                                                        <textarea class="form-control" name="message"
                                                                            rows="4" required></textarea>
                                                                    </div>

                                                                    <!-- Attachment -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Attachment</label>
                                                                        <input type="file" class="form-control"
                                                                            name="attachment">
                                                                    </div>

                                                                    <!-- Submit Button -->
                                                                    <button type="submit" class="btn btn-primary">Send
                                                                        Email</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Email with popup -->

                                                <p><b>Phone:</b> <a style="color:blue"
                                                        href="tel:{{ $user->phone ?? $user->phone }}">📞{{ $user->phone ?? $user->phone }}</a>
                                                </p>
                                                <?php
                                                    $distributorName = DB::table('users');
                                                    if($user->type == 'bm'){
                                                        $distributorName = $distributorName->where('bm_name',$user->id);
                                                    }elseif($user->type == 'tt'){
                                                        $distributorName = $distributorName->where('tt_name',$user->id);
                                                    }elseif($user->type == 'store'){
                                                        $distributorName = $distributorName->where('store_location',$user->id);
                                                    }

                                                    $distributorName = $distributorName->get()->pluck('full_name')->toArray();

                                                    $disName = "";
                                                    if($distributorName){
                                                        $disName = implode(', ',$distributorName);
                                                    }
                                                   // dd($distributorName);
                                                ?>
                                                <p><b>Distributor Name:</b> {{$disName}}</p>
                                                @if($user->type == 'bm' || $user->type == 'tt')
                                                <!-- <p>
                                                    <b>Notes:</b> {{ $user->notes ?? 'No notes available' }}
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#notesModal" style="color: blue;">View
                                                        Details</a>
                                                </p> -->
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <?php 
                                    $bm_notes = App\Notes::where('contact_id', $user->id)
                                    ->where('type', $user->type.'_notes')
                                      ->orderBy('id', 'DESC')
                                    ->get();
                                     ?>

                                    <!-- Right side -->
                                    <div class="col-md-6 mb-4">
                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <h5 class="card-title">Add a Note</h5>
                                                <form method="POST" action="{{ route('admin.notesStore', $user->id) }}"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="type" value="{{ $user->type }}_notes">
                                                    <input type="hidden" name="notes_type" value="one_to_one">
                                                    <input type="hidden" name="contact_id" value="{{@$user->id}}">

                                                    @csrf
                                                    <div class="mb-3">
                                                        <textarea name="notes" class="form-control" rows="4"
                                                            placeholder="Write your note here..." required></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <input type="file" class="form-control" name="file">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save Note</button>
                                                </form>
                                            </div>

                                            <div class="card-body scr">

                                                @foreach($bm_notes as $bm_note)
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
                                                        class="time">{{ $bm_note->created_at->format('d-m-Y @ h:i A') }}
                                                        By: {{@$bm_note->get_name->full_name}}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>



                                    </div>

                                </div>
                            </div>


                        </div>
                        @endsection