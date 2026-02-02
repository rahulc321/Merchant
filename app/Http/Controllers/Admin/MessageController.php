<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Message;
use App\User;
use Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['messages'] = Message::where(function ($query) {
            
            if (Auth::user()->roles->contains('title', 'Admin')) {
               // $query->whereNotNull('id'); 
            } else {
                 
                $query->where('posted_by', Auth::id());
            }
        })->orderBy('id','DESC')->get();
    
        return view('admin.message.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['users'] = User::whereDoesntHave('roles', function ($query) {
            $query->where('title', 'Admin');
        })->get();
        return view('admin.message.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $data = new Message();
            $data->posted_by = Auth::Id();
            $data->user_id = implode(', ', $request->user_id);
            $data->message = $request->message;
            $data->save();

            // Send email to all users

            $allUsers = User::whereIn('id', $request->user_id)->get();

            // Iterate through users and send emails
            foreach ($allUsers as $user) {
                $email = $user->email; // Get user's email

                // Prepare dynamic data for the email
                $data = [
                    'name' => $user->full_name, // Dynamic user name
                    'message_body' => $request->message,
                ];

                // Send the email
                \Mail::send('email.message', $data, function ($message) use ($email) {
                    $message
                        ->to($email)
                        ->from('info@gmail.com', 'CRM')
                        ->subject('New Message from admin side.');
                });
            }
             
            # set a success message in the session
            session()->flash('success', 'You have successfully send message!');
            return redirect()->route('admin.message.index');
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
    public function destroy($id)
    {
        //
    }
}
