<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Chat;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    // Show chat page
    public function index($receiverId, Request $request)
    {   

        $unread = Chat::where('task_id', $request->taskId)
              ->where('receiver_id', Auth::id())
              ->where('is_read', 0) // Optional: only update unread chats
              ->get();

        // If you want to mark all as read
        $unread->each(function($chat) {
            $chat->is_read = 1;
            $chat->save();
        });

        $receiver = User::findOrFail($receiverId);
        return view('chat.index', compact('receiverId', 'receiver'));
    }

    // Store chat messages
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
            'file' => 'nullable|file|mimes:jpeg,jpg,png,pdf,mp4'
        ]);

        $chat = new Chat();
        $chat->sender_id = Auth::id();
        $chat->task_id = $request->taskId;
        $chat->receiver_id = $request->receiver_id;
        $chat->message = $request->message;

        // Handle file upload if present
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Define the folder path inside the 'public' directory
            $folderPath = 'chat_files';  // Folder in the public directory
        
            // Ensure the folder exists (if not, create it)
            $folderFullPath = public_path($folderPath);
            if (!file_exists($folderFullPath)) {
                mkdir($folderFullPath, 0755, true); // Create folder with proper permissions
            }
        
            // Get the uploaded file
            $file = $request->file('file');
        
            // Generate a unique filename for the uploaded file
            $fileName = time() . '_' . $file->getClientOriginalName(); // e.g., 1617912345_image.jpg
        
            // Move the file to the public folder
            $file->move($folderFullPath, $fileName);  // Move file to 'public/chat_files/'
        
            // Get the file MIME type
            $fileType = mime_content_type(public_path($folderPath . '/' . $fileName)); // Retrieve MIME type after move
        
            // Store the file path and file type in the database
            $chat->file_path = $folderPath . '/' . $fileName;  // Store path like 'chat_files/filename.jpg'
            $chat->file_type = $fileType;                      // Store file MIME type
        }
        

        $chat->save();
        $url =  Url('/admin/chat').'/'.$request->receiver_id.'?taskId='.$request->taskId;
        return redirect($url);
    }

    // SSE endpoint to send real-time messages to the client
     // app/Http/Controllers/ChatController.php
 // app/Http/Controllers/ChatController.php
 public function sse($receiverId, Request $request)
 {

    $taskId =  $request->taskId;
    
     return new StreamedResponse(function () use ($receiverId,$taskId) {
         
             $messages = Chat::where(function ($query) use ($receiverId,$taskId) {
                 $query->where('sender_id', Auth::id())
                       ->where('receiver_id', $receiverId)
                       ->where('task_id', $taskId);
             })
             ->orWhere(function ($query) use ($receiverId,$taskId) {
                 $query->where('sender_id', $receiverId)
                       ->where('receiver_id', Auth::id())
                       ->where('task_id', $taskId);
             })
            
             ->orderBy('created_at', 'asc')
              
             ->get();

             foreach ($messages as $message) {
                 echo "data: " . json_encode([
                     'id' => $message->id,
                     'sender_id' => $message->sender_id,
                     'message' => $message->message,
                     'file_path' => $message->file_path,
                     'file_type' => $message->file_type,
                     'created_at' => $message->created_at,
                 ]) . "\n\n";

                 ob_flush();
                 flush();
             }

             
         
     }, 200, [
         'Content-Type' => 'text/event-stream',
         'Cache-Control' => 'no-cache',
         'Connection' => 'keep-alive',
     ]);
 }


 public function getUnreadMessageCounts(Request $request)
{
    // Get task IDs from the request (ensure it's an array)
    $taskIds = is_array($request->task_ids) ? $request->task_ids : explode(',', $request->task_ids);
    
    // Fetch unread message counts for the tasks
    $unreadMessagesCounts = Chat::whereIn('task_id', $taskIds)
        ->where('is_read', 0)
        ->where('receiver_id', Auth::id())
        ->groupBy('task_id')
        ->selectRaw('task_id, count(*) as count')
        ->get()
        ->pluck('count', 'task_id')
        ->toArray();

    // Send the counts in a single SSE response
    return response()->stream(function () use ($unreadMessagesCounts) {
        echo "data: " . json_encode($unreadMessagesCounts) . "\n\n";
    }, 200, [
        "Content-Type" => "text/event-stream",
        "Cache-Control" => "no-cache",
        "Connection" => "keep-alive",
        //"Transfer-Encoding" => "chunked",
    ]);
}



}

?>