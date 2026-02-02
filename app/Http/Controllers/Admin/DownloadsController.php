<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Downloads;
use App\User;

class DownloadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['downloads'] = Downloads::all();
        $this->data['users'] = User::whereIn('type',['end_user','Installer'])->get();
        return view('admin.downloads.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->category);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'file' => 'required',
        ]);

        $file = $request->file('file');
        $originalName = str_replace(' ', '_', $file->getClientOriginalName());
        $filename = time() . '_' . $originalName;
        $mimeType = $file->getMimeType();

        # move to public/uploads
        $file->move(public_path('uploads'), $filename);

        # determine file type category
        if (str_starts_with($mimeType, 'image/')) {
            $type = 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $type = 'video';
        } elseif ($mimeType === 'application/pdf') {
            $type = 'pdf';
        } else {
            $type = 'other';
        }


        $frontImage = $request->file('front_image');
        $frontImageName = time() . '_front_' . str_replace(' ', '_', $frontImage->getClientOriginalName());
        $frontImage->move(public_path('uploads'), $frontImageName);

        # save to DB
        Downloads::create([
            'title' => $request->title,
            'category' => implode(',', $request->category),
            'file_path' => $filename,
            'file_type' => $type,
            'front_image' => $frontImageName, 
        ]);

        session()->flash('success', 'You have successfully uploaded document');
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteFile($id)
    {   
        $delete = Downloads::find($id);
        $delete->delete();
        session()->flash('warning', 'You have successfully deleted document');
        return back();
    }

    // Send attachment to end user and installer with multiple attachmnet
    
    public function sendAttachment(Request $request)
    {   
        //return view('email.attachment');
        $request->validate([
            'users' => 'required|array',
            'attachments' => 'required|array',
           // 'description' => 'nullable|string',
        ]);

        $users = $request->input('users');
        $attachmentIds = $request->input('attachments');
        $description = $request->input('description');

        $attachments = Downloads::whereIn('id', $attachmentIds)->get();

        foreach ($users as $email) {

            $user = User::where('email',$email)->first();
            
            $this->data['full_name'] = $user->full_name ?? 'Dear';

            //return view('email.attachment',$this->data);die;
            \Mail::send("email.attachment", $this->data, function ($message) use ($email, $attachments, $description) {
                
                $body = "";
                $message->to($email)
                    ->subject('Requested Documents from aether Australia')
                    ->html($body); // ✅ Correct way in modern Laravel/Symfony

                foreach ($attachments as $file) {
                    $path = public_path('uploads/' . $file->file_path);
                    if (file_exists($path)) {
                        $message->attach($path, [
                            'as' => $file->title ?? basename($path),
                            'mime' => mime_content_type($path),
                        ]);
                    }
                }
            });
        }

        return back()->with('success', 'Emails with attachments sent successfully!');
    }

}