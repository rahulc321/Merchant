@extends('layouts.admin')
@section('title', 'CRM - Chats')
@section('content')
<style type="text/css">
    #messages {
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow-y: auto;
    max-height: 400px;
}

.message {
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
    word-wrap: break-word;
}

.message-left {
    align-self: flex-start;
    background-color: #f1f1f1;
}

.message-right {
    align-self: flex-end;
    background-color: #d1f7d6;
}

ul#messages {
    overflow: scroll;
    height: 310px;
}
.message-time{
    font-size: 10px;
}

</style>
 <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-2">Chat</h1>
                        <div class="">
                             
                        </div>
                    </div>
                     
                </div>
                <!-- Page Header Close -->
                
                <div class="main-chart-wrapper gap-lg-2 gap-0 mb-2 d-lg-flex">
                     
                    <div class="main-chat-area border">
                        <div class="d-flex align-items-center border-bottom main-chat-head flex-wrap">
                            <div class="me-2 lh-1">
                                <span class="avatar avatar-md online p-1 bg-primary-transparent avatar-rounded chatstatusperson">
                                    {{ ucfirst(substr($receiver->full_name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-fill">
                                <p class="mb-0 fw-medium fs-14 lh-1">
                                    <a href="javascript:void(0);" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" class="chatnameperson responsive-userinfo-open">{{$receiver->full_name}}</a>
                                </p>
                                <p class="text-muted mb-0 chatpersonstatus">online</p>
                            </div>
                              
                        </div>
                        <div class="chat-content" id="main-chat-content">
                            <ul class="list-unstyled" id="messages">
                                 
                                 
                            </ul>
                        </div>
                         <form action="{{ url('/admin/chat') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="chat-footer">
                                
                                <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                                <input type="hidden" name="taskId" value="{{ @$_REQUEST['taskId'] }}">

                                <!-- Message input field with form-group -->
                                 
                                    <a aria-label="anchor" class="btn btn-light me-2 btn-icon btn-send d-flex align-items-center justify-content-center fileclick" href="javascript:void(0)">
                                        <i class="ri-attachment-line"></i>
                                    </a>
                                    <input name="message" class="form-control chat-message-space" placeholder="Type your message here..." type="text" required="">
                                 

                                
                                    <input type="file" name="file" class="form-control " style="display:none" id="fileInput">
                                

                                <!-- Submit button with form-group -->
                                <div class="form-group mb-2">
                                    <button type="submit" class="btn btn-primary mt-2">Send</button>
                                </div>

                            </div>
                        </form>

                    </div>
                    
                </div>
            </div>
        </div>

<script>

 document.querySelector('.fileclick').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });


const receiverId = "{{ $receiverId }}"; // Pass from Blade
const taskId = "{{ @$_REQUEST['taskId'] }}"; // Pass from Blade
const eventSource = new EventSource(`/admin/chat/sse/${receiverId}?taskId=${taskId}`);

 

// Event Listener for receiving messages
eventSource.onmessage = function (event) {
    const message = JSON.parse(event.data);
    const messagesDiv = document.getElementById('messages');

    // Create a new message element or find the existing one
    let messageElement = document.getElementById(`message-${message.id}`);
    if (!messageElement) {
        // If the message doesn't exist, create a new one
        messageElement = document.createElement('div');
        messageElement.id = `message-${message.id}`; // Assign unique ID to the message element

        // Determine if the message is from the current user or the other user
        const isCurrentUser = message.sender_id === parseInt("{{ Auth::id() }}");

        // Add classes for left or right alignment
        messageElement.classList.add('message', isCurrentUser ? 'message-right' : 'message-left');

        // Format the created_at timestamp into a readable date and time
        const timestamp = new Date(message.created_at); // assuming created_at is in a format accepted by Date
        const formattedDate = timestamp.toLocaleDateString('en-US', {
            weekday: 'short', year: 'numeric', month: 'short', day: 'numeric',
        });
        const formattedTime = timestamp.toLocaleTimeString('en-US', {
            hour: '2-digit', minute: '2-digit', second: '2-digit',
        });

        // Add the message content with date and time
        messageElement.innerHTML = 
            `<span>${isCurrentUser ? 'You' : 'User ' + message.sender_id}: ${message.message || ''}</span>
            <div class="message-time">${formattedDate}  ${formattedTime}</div>`;

        // Check if there's a file attached and add it
        if (message.file_path) {
            const fileUrl = `/${message.file_path}`;
            const fileType = message.file_type;

            if (fileType.startsWith('image')) {
                messageElement.innerHTML += `<br><img src="${fileUrl}" alt="Image" style="max-width: 300px;">`;
            } else if (fileType.startsWith('video')) {
                messageElement.innerHTML += `<br><video controls style="max-width: 300px;"><source src="${fileUrl}" type="video/mp4"></video>`;
            } else {
                messageElement.innerHTML += `<br><a href="${fileUrl}" target="_blank">Download File</a>`;
            }
        }

        // Append the message if it's newly created
        messagesDiv.appendChild(messageElement);

        // Scroll to the bottom of the messages
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
};

 

// Optional: Check if the connection to the server is closed or disconnected
eventSource.onclose = function () {
    console.log("SSE connection closed.");
};


</script>
@endsection
