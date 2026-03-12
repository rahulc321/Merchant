<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use DB;
use App\{Notes,Merchant,Order, Coupon};
use App\Contacts;
use Gate;
use App\Device;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\V1\Admin\TuyaController;
use Illuminate\Support\Facades\Validator;
use Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
         
        $this->data['users'] = User::whereHas('roles', function ($query) {
            $query->where('title', 'student');
        })
        ->orderBy('id', 'DESC')
        ->get();
 
        return view('admin.users.index',$this->data);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->data['roles'] = Role::all()->pluck('title', 'id');
        $this->data['bms'] = Contacts::where('type', 'bm')->get();
        $this->data['tts'] = Contacts::where('type', 'tt')->get();
        $this->data['stores'] = Contacts::where('type', 'store')->get();
        $this->data['timezones'] = \DB::table('timezone')->get();

        return view('admin.users.create', $this->data);
    }

    public function store(Request $request)
    {    
        error_reporting(0);  
       
        $email = $request->email;

        $this->data['data'] = $request->all();
       // return view('email.installer',$this->data);
        // dd($data);
        
        // $sendCommand = new TuyaController();
        // $data = $sendCommand->createUser($request->all());
        // $tuya_id = @$data['result']['uid'];
        //dd($tuya_id);
        // die;

       // dd($request->all());  
        //try {
            # validate the incoming request data
            // $request->validate([
            //     'email' => 'required',
            // ]);

            
            $roleId = Role::where('title', $request->input('type'))->first();
            # create a new user with the request data
            $request['tuya_id'] = @$tuya_id;
            $user = User::create($request->all());
            
            # sync the user's roles, if any
            if ($request->filled('type')) {
                $user->roles()->sync($roleId->id);
            }


            \Mail::send("email.installer", $this->data, function (
                $message
            ) use ($email) {
                $message
                    ->to($email)
                    ->from("info@gmail.com")
                    ->subject("Account Created");
            });
    

           // dd($user);

            //dd($request->all());
            # set a success message in the session
            session()->flash('success', 'User has been successfully added!');
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     # handle validation errors and flash them to the session
        //     session()->flash('error', implode(' ', $e->validator->errors()->all()));
        //     return redirect()->back()->withInput(); # redirect back with old input
        // } catch (\Exception $e) {
        //     # log the exception and flash a generic error message
        //     //dd($e->getMessage());
        //     \Log::error('Error adding user: ' . $e->getMessage());
        //     session()->flash('error', 'Something went wrong. Please try again.');
        //     return redirect()->back()->withInput(); # redirect back with old input
        // }

        # redirect to the users index page
       // dd(1);
        return redirect()->route('admin.users.index');
    }


    public function edit(User $user)
    {
        //abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        if($user->roles->contains('title', 'Installer')){
            $devicesId = Device::all()->where('installer_id',$user->id)->pluck('device_id');
        }else{
            $devicesId = Device::all()->where('user_id',$user->id)->pluck('device_id');
        }
        
        $user->devices = $devicesId;

        //dd($user);
        $user->load('roles');
        $this->data['bms'] = Contacts::where('type', 'bm')->get();
        $this->data['tts'] = Contacts::where('type', 'tt')->get();
        $this->data['stores'] = Contacts::where('type', 'store')->get();
        $this->data['user'] = $user;
        $this->data['roles'] = $roles;
        $this->data['devices'] = Device::get();
        $this->data['timezones'] = \DB::table('timezone')->get();
        

       // dd($user);

        return view('admin.users.edit',$this->data);
    }

    public function update($id, Request $request)
    {
        //dd($request->role);
       // try {
            # Validate the incoming request
            $request->validate([
                //'name' => 'required|string|max:255',
                //'email' => 'required|email|unique:users,email,' . $id,
                 
            ]);

            # Find the user by ID
            $user = User::findOrFail($id);
 
            if(@$request->devices){
                $oldDevices = Device::where('installer_id', $id)->pluck('device_id')->toArray();

                // get new device list from request (or empty if none selected)
                $newDevices = $request->devices ?? [];

                if($user->roles->contains('title', 'Installer')){
                    // unassign devices that are no longer selected
                    Device::whereIn('device_id', $oldDevices)
                        ->whereNotIn('device_id', $newDevices)
                        ->update(['installer_id' => null]);

                    // assign selected devices to installer
                    Device::whereIn('device_id', $newDevices)
                    ->update(['installer_id' => $id]);
                }else{
                    Device::whereIn('device_id', $oldDevices)
                    ->whereNotIn('device_id', $newDevices)
                    ->update(['user_id' => null]);

                    // assign selected devices to installer
                    Device::whereIn('device_id', $newDevices)
                    ->update(['user_id' => $id]);
                }
            }

            

            # Update the user's information
           

            $roleId = Role::where('title', $request->role)->first();
            
            if ($request->filled('role')) {
                $user->roles()->sync($roleId->id);
            }
            
            $data = $request->except(['devices', 'role']);
            $data['type'] = $request->role;
            
            $user->update($data);

            # Sync the user's roles
            //$user->roles()->sync($request->input('roles', []));

            # Set a success message in the session
            session()->flash('success', 'You have successfully updated the user!');
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     # Flash validation errors to the session
        //     session()->flash('error', implode(' ', $e->validator->errors()->all()));
        // } catch (\Exception $e) {
        //     # Handle any other exceptions
        //     session()->flash('error', 'Something went wrong. Please try again.');
        // }

        // # Redirect to the users index page
             return redirect()->route('admin.users.index');
    }


    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         
        // if(@$user->tuya_id){
        //     $sendCommand = new TuyaController();
        //     $data = $sendCommand->deleteUser($user->tuya_id);
        //     dd($data);
        // }

        // die;
        $user->delete();
        session()->flash('warning', 'You have successfully deleted!');
        return back();

    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

    public function admin(Request $request)
    {
        $this->data['users'] = User::whereHas('roles', function ($query) {
            $query->where('title', 'Admin');
        })->orderBy('id','DESC')->get();
        return view('admin.admin.index',$this->data);
    }

    public function admin_create(Request $request)
    {
        return view('admin.admin.create');
    }

    public function admin_store(Request $request)
    {
        
            $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);

            $roleId = Role::where('title', 'Admin')->first();
            # create a new user with the request data
            $user = User::create($request->all());
            
            $user->roles()->sync($roleId->id);
            
            session()->flash('success', 'Admin has been successfully added!');

            # redirect to the users index page
            return redirect()->route('admin.admin');
    }

    public function admin_edit($id){

        $this->data['user'] = User::find($id);
        return view('admin.admin.edit', $this->data);

    }

    // admin_update
    public function admin_update($id, Request $request)
{
    try {
        # Validate the incoming request
        $request->validate([
            //'name' => 'required|string|max:255', // Uncomment if needed
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        # Find the user by ID
        $user = User::findOrFail($id);

        # Update the user's information with validated data
        $user->update([
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => \Hash::make($request->input('password')),
            'full_name' => $request->input('full_name'), // Uncomment if name is included in the request
        ]);

        # Sync the user's roles if needed
        // $user->roles()->sync($request->input('roles', []));

        # Set a success message in the session
        session()->flash('success', 'You have successfully updated the admin!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        # Flash validation errors to the session
        session()->flash('error', implode(' ', $e->validator->errors()->all()));
    } catch (\Exception $e) {
        # Handle any other exceptions
        session()->flash('error', 'Something went wrong. Please try again.');
    }

    # Redirect to the admin index page
    return redirect()->route('admin.admin');
}


    public function view_data($id){
        error_reporting(0);
        $users = User::findOrFail($id);
        $bm_notes = Notes::where('distributer_id',$id)->where('type','bm_notes')
        // ->where('notes_type','distributor')
        ->get();
        $tt_notes = Notes::where('distributer_id',$id)->where('type','tt_notes')
        // ->where('notes_type','distributor')
        ->get();
        $selfNotes = Notes::where('distributer_id',$id)->where('type','self_notes')->where('notes_type','distributor')->orderBy('id','DESC')->get();
        return view('admin.users.view_data', compact('users','bm_notes','tt_notes','selfNotes'));
    }
    
    
    public function notesStore($id, Request $request){

        $store  = new Notes();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = public_path('uploads');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generate unique filename
            $file->move($destinationPath, $fileName);
            
            # store only file name in database
            $store->file = $fileName;
        }


        
        $store->user_id = \Auth::Id();
        $store->distributer_id = $id;
        $store->type = $request->type;
        $store->notes = $request->notes;
        if($request->contact_id){
            $store->contact_id = $request->contact_id;
        }
         
        if($request->notes_type){
            $store->notes_type = $request->notes_type;
        }
        
        $store->save();
        session()->flash('success', 'Notes successfully added!');
        return back();
    }


    public function contacts(){
        error_reporting(0);
        $contacts = Contacts::orderBy('id','DESC')->get();
        return view('admin.users.contacts', compact('contacts'));
    }

    public function createContact(){
         
        return view('admin.users.createContact');
    }

    public function contactStore(Request $request){

            $data = $request->all();
            $data['phone'] = $request->phone_number;

            unset($data['phone_number']);
            Contacts::create($data);
            session()->flash('success', 'You have successfully added!');
            return redirect()->route('admin.contacts');
    }

    // Contact Views
    public function contact_view($id){
        error_reporting(0);
        $user = Contacts::find($id);
        return view('admin.users.contact_data', compact('user'));
    }

    
    public function contactDelete($id){

        $user = Contacts::find($id);
        $user->delete();
        session()->flash('warning', 'You have successfully deleted!');
        return back();
    }

    public function contactEdit($id){
        
        $user = Contacts::find($id);
        return view('admin.users.contactEdit', compact('user'));
         
    }


    public function contactUpdate($id, Request $request)
    {
        $data = $request->all();
        $data['phone'] = $request->phone;
        $data['store_location'] = $request->name;
        unset($data['phone_number']);
        unset($data['name']);
        //dd($data);
        $contact = Contacts::findOrFail($id); # Find the contact by ID
        $contact->update($data); # Update the contact

        session()->flash('success', 'You have successfully updated the contact!');
        return redirect()->route('admin.contacts');
    }

    // Send email
    public function sendEmail(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $this->data['data'] = [
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        \Mail::send('email.contact', $this->data, function ($mail) use ($request) {
            $mail->to($request->recipient_email)
                ->subject($request->subject);

            # Attach file if provided
            if ($request->hasFile('attachment')) {
                $mail->attach($request->file('attachment')->getRealPath(), [
                    'as' => $request->file('attachment')->getClientOriginalName(),
                    'mime' => $request->file('attachment')->getMimeType(),
                ]);
            }
        });

        return back()->with('success', 'Email sent successfully!');
    }

    // Show user card
    public function view_info($id){
        error_reporting(0);
        $this->data['user'] = User::findOrFail($id);
        $this->data['device'] = Device::where('user_id',$id)->first();
        //dd($this->data['device']);

        $this->data['deviceFaults'] = \DB::table('faults')
        ->join('devicelogs', 'devicelogs.code', '=', 'faults.failure_code')
        ->join('devices', 'devices.device_id', '=', 'devicelogs.device_id')
        ->leftJoin('users as installers', 'installers.id', '=', 'devices.installer_id')
        ->leftJoin('users as owners', 'owners.id', '=', 'devices.user_id')
        ->select(
            'faults.*',
            'devicelogs.device_id',
            'installers.full_name as installer_name',
            'owners.full_name as user_name'
        )
        ->where('devices.device_id',$this->data['device']->device_id)
        ->get();
        
        return view('admin.users.view_info', $this->data);
    }

    #user profile
    public function userProfile(){
         
        $this->data['user'] = User::find(\Auth::Id());
        return view('admin.users.profile',  $this->data);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        # validate input
        $request->validate([
            'full_name' => 'required|string|max:255',
            //'password' => 'nullable|string|min:6|confirmed', // use 'confirmed' if using password confirmation field
        ]);

        # update only name
        $user->full_name = $request->input('full_name');

        # update password only if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }


    public function registerStep(Request $request)
    {
        $step = (int) $request->step;

        $rules = match ($step) {
            1 => [
                'name' => 'required|string|max:255',
                'phone_number' => 'required|digits:9|unique:users,phone_number',
                //'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ],
            2 => [
                'restaurant_id' => 'required|exists:users,id',
                'address' => 'required|string|max:500',
                // 'cashier_code' => [
                //     'required',
                //     function ($attribute, $value, $fail) use ($request) {
                //         $exists =  User::where('id', $request->restaurant_id)
                //             ->where('code', $value)
                //             ->exists();
            
                //         if (!$exists) {
                //             $fail('Invalid cashier verification code for selected restaurant.');
                //         }
                //     }
                // ],
                'amount' => [
                    'required',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {

                        $merchant = User::find($request->restaurant_id);

                        if (!$merchant) {
                            $fail('Please select a valid restaurant.');
                            return;
                        }

                        if ((float) $value < (float) $merchant->amount) {
                            $fail(
                                'Minimum amount is ' . number_format($merchant->amount) . '.'
                            );
                        }
                    }
                ],


            ],
        };

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        # save data in session
        session()->put("register.step{$step}", $request->except('_token', 'step'));

        return response()->json(['status' => true]);
    }

    public function registerComplete()
    {
        $step1 = session('register.step1');
        $step2 = session('register.step2');

        if (!$step1 || !$step2) {
            return response()->json([
                'status' => false,
                'message' => 'Registration data missing'
            ], 400);
        }

        DB::beginTransaction();

         try {

            // 1️⃣ CREATE USER
            $user = User::create([
                'full_name' => $step1['name'],
                'email' => 'uq'.rand().'@yopmail.com',
                'phone_number'=> $step1['phone_number'],
                'password' => bcrypt($step1['password']),
            ]);

            # assign end_user role
            $user->roles()->attach(2);

            // 2️⃣ CREATE ORDER address_id
            Order::create([
                'user_id' => $user->id,
                'restaurant_id' => $step2['restaurant_id'],
                'amount' => $step2['amount'],
                'address' => $step2['address'],
                'address_id' => $step2['address_id'],
                'cashier_code' => $step2['cashier_code'] ?? 000000,
                'status' => 1,
            ]);
            Auth::login($user);
            DB::commit();

            session()->forget(['register.step1', 'register.step2']);

           // Auth::login($user);

            return response()->json([
                'status' => true,
                'redirect' => route('thankyou')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage() // exact error
            ], 500);
        }
    }

    public function orders(Request $request)
    {
        $user = auth()->user();

        $isAdmin = $user->roles()
                        ->where('title','Admin')
                        ->exists();

        $query = Order::with(['user','merchant'])->latest();

        /*
        |------------------------------------------
        | NON ADMIN → Only Their Orders
        |------------------------------------------
        */
        
        if (!$isAdmin) {

            $query->where('user_id', $user->id);

        } 
        /*
        |------------------------------------------
        | ADMIN → Apply Filters
        |------------------------------------------
        */
        else {

            // user filter
            $query->when($request->user, function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('full_name', 'like', '%' . $request->user . '%');
                });
            });

            // merchant filter
            $query->when($request->merchant_id, function ($q) use ($request) {
                $q->where('restaurant_id', $request->merchant_id);
            });

            // amount filter
            $query->when($request->amount, function ($q) use ($request) {
                $q->where('amount', '>=', $request->amount);
            });

            // date range
            if ($request->from_date && $request->to_date) {
                $query->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            }

            // ✅ ONLY admin needs merchant list
            //$this->data['merchants'] = Merchant::orderBy('name')->get();
            $this->data['merchants'] =  User::whereHas('roles', function ($query) {
                $query->where('title', 'merchant');
            })->get();
        }

        /*
        |------------------------------------------
        | ALWAYS paginate (VERY IMPORTANT)
        |------------------------------------------
        */
        $this->data['orders'] = $query->paginate(20)->withQueryString();

        return view('admin.order.index', $this->data);
    }
 

    public function joinMerchant(Request $request)
    {   
        if($request->all()){
            $request->validate([
                'name'   => 'required|string|max:255',
                'email'  => 'required|email|unique:users,email',
                'phone' => 'nullable|digits:9|unique:users,phone_number',
                'amount' => 'required|numeric|min:0',
                 
            ]);

            $user = User::create([
                'full_name'   => $request->name,
                'email'  => $request->email,
                'code'   => strtoupper(substr($request->name, 0, 3)) . rand(100000, 999999),
                'phone_number'  => $request->phone,
                'password'  => \Hash::make($request->password),
                'amount' => $request->amount,
                'status' => 0,
            ]);

            $user->roles()->sync(4);


            /////////////////////////////////////////////////////////////////////////////

            session()->flash(
                'success',
                '🎉 Your merchant account has been created successfully! 
                Your account is currently <strong>pending approval</strong>. 
                Once approved by the admin, you will be able to log in as a merchant. 
                Thank you for registering with us!'
            );
            return back();
        }else{
            return view('merchant');
        }
    }


}