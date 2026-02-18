<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Task;
use App\{User, Merchant, MerchantAddress};
use App\Training;
use App\Role;
use App\VideoView;
use Auth;
use App\Product;
use App\Device;
use App\Devicelogs;
use App\DeviceSchedue;
use App\Content;
use App\McqAnswer;
use App\Category;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\Api\V1\Admin\TuyaController;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchants = User::whereHas('roles', function ($query) {
            $query->where('title', 'merchant');
        })
        ->orderBy('id', 'DESC')
        ->get();

        return view('admin.task.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->data['users'] = User::whereDoesntHave('roles', function ($query) {
        //     $query->where('title', 'Admin');
        // })->get();

        $this->data['users'] = User::where('type','service_agent')->get();
        $this->data['end_users'] = User::where('type','end_user')->get();
        
        return view('admin.task.create',$this->data);
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:merchants,email',
            'phone'  => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        $user = User::create([
            'full_name'   => $request->name,
            'email'  => $request->email,
            'code'   => strtoupper(substr($request->name, 0, 3)) . rand(100000, 999999),
            'phone_number'  => $request->phone,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);

        $user->roles()->sync(4);


        /////////////////////////////////////////////////////////////////////////////

        session()->flash('success', 'You have successfully added!');
        return redirect()->route('admin.task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function marchentAddress($id)
    {
        $merchant = User::with('addresses')->findOrFail($id);

        return view('admin.merchant.merchant_address', compact('merchant'));
    }

    public function addAddress($id)
    {
         
        return view('admin.merchant.create', compact('id'));
    }


    public function addAddressStore(Request $request, $merchantId)
    {
        $request->validate([
            'address' => 'required'
        ]);

        MerchantAddress::updateOrCreate(
            [
                'id' => $request->address_id,
                'merchant_id' => $merchantId
            ],
            [
                'address' => $request->address,
                'city'    => $request->city,
                'state'   => $request->state,
                'pincode' => $request->pincode
            ]
        );

        return redirect()
            ->route('admin.marchentAddress', $merchantId)
            ->with('success', 'Address saved successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['merchant'] = User::find($id);
        
        return view('admin.task.edit',$this->data);
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
        $merchant = User::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:merchants,email,' . $merchant->id,
            'phone'  => 'nullable|string|max:20',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $merchant->update([
            'full_name'   => $request->name,
            'email'  => $request->email,
            'phone_number'  => $request->phone,
            'amount' => $request->amount,
            'status' => $request->status,
        ]);
        session()->flash('success', 'You have successfully update!');
        return redirect()->route('admin.task.index');
    }


    
    public function mAddressDelete($id)
    {   
        $task = MerchantAddress::find($id);
         $task->delete();
        session()->flash('warning', 'You have successfully deleted!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $task = User::find($id);
         $task->delete();
        session()->flash('warning', 'You have successfully deleted!');
        return back();
    }
    
    public function task_detail($id)
    {   
        error_reporting(0);
        $this->data['task'] = Task::find($id);
        return view('admin.task.task_detail',$this->data); 
    }

    public function changeStatus($id,Request $request)
    {   
        $task = Task::find($id);
        $task->status = $request->status;
        $task->save();
        session()->flash('success', 'You have successfully update task status!');
        return back();
    }

    // Training module
    public function training(){
 
            // Get the current user's ID
        $currentUserId = Auth::id();

        // Fetch trainings with the video view count for the current user

        if (Auth::user()->roles->contains('title', 'Admin')){
            $query = Training::with('viewedByUser');

            if (!empty($_REQUEST['category'])) {
                $query->where('cat_id', $_REQUEST['category']);
            }

            $this->data['trainings'] = $query->get();
        }else{
            $this->data['trainings'] = Training::with('viewedByUser')->where('role',Auth::user()->type)->get();
 
        }
        
        return view('admin.training.index',$this->data); 
    }

    public function trainingCreate(){
        error_reporting(0);
        $this->data['cats'] = Category::orderBy('id','desc')->get();
        $this->data['roles'] = Role::all();
        return view('admin.training.create',$this->data); 
    }

    public function trainingEdit($id){
        $this->data['cats'] = Category::orderBy('id','desc')->get();
        $this->data['training'] = Training::find($id);
        return view('admin.training.edit',$this->data);
    }
    
    public function trainingStore(Request $request)
    {
        
       

        // Handle video file upload
        $videoPath = null;
        if ($request->hasFile('file')) {
            $video = $request->file('file');

            // Check the file size (optional step for additional security)
            

            // Create a unique file name and specify the destination path
            $videoName = time() . '_' . $video->getClientOriginalName();
            $destinationPath = public_path('videos'); // Direct path to public/videos folder

            // Move the uploaded file to the public/videos directory
            $video->move($destinationPath, $videoName);

            // Store the relative path of the video
            $videoPath = 'videos/' . $videoName;
        }

         
        // Create a new training record and save it to the database
        $training = new Training();
        $training->title = $request->title;
        $training->description = $request->description;
        $training->role = implode(',', $request->roles);
        // $training->video_url = $videoPath; // Save the public path of the video
        // $training->role = $request->role;
        // $training->status = $request->status;
        // $training->video_time = $request->video_time;
        $training->cat_id = $request->cat_id;
        $training->save();

        // Set success message and redirect back
        session()->flash('success', 'You have successfully added the training!');
        return redirect()->route('admin.training');
    }

    public function markVideoWatched(Request $request)
    {

       
        // Check if the user has already watched the video
        $viewRecord = VideoView::firstOrCreate(
            [
                'video_id' => $request['video_id'],
                'user_id' => $request['user_id'],
            ],
            [
                'view_count' => 1,
            ]
        );

        // if (!$viewRecord->wasRecentlyCreated) {
        //     $viewRecord->increment('view_count');
        // }

        return response()->json(['success' => true, 'message' => 'Video marked as watched successfully!']);
    }

    // Delete trainings
    public function trainingDelete($id,Request $request)
    {   
        $trainingDelete = Training::find($id);
        
        $trainingDelete->delete();
        session()->flash('warning', 'You have successfully Deleted!.');
        return back();
    }

    // get products
    public function products()
    {
        $this->data['allProducts'] = Product::all();
        return view('admin.products.index',$this->data); 
    }


    // get Devices
    public function devices(Request $request)
    {
        $user = Auth::user();
        $devices = collect();  // default empty collection
        $type = null;
        $id = null;

        if ($user->roles->contains('title', 'Installer')) {
            $type = 'installer_id';
            $id = $user->id;
        } elseif ($request->has('user_id')) {
            $type = 'user_id';
            $id = $request->user_id;
        } elseif ($request->has('installer')) {
            $type = 'installer_id';
            $id = $request->installer;
        }

        # start query builder
        $query = Device::orderBy('is_online','DESC');

        if ($type && $id) {
            $query->where($type, $id);
        }

        # apply filter for is_online if passed
        if ($request->filled('is_online')) {
            $query->where('is_online', (int) $request->is_online);
        }

        # apply filter for device_id if passed
        if ($request->filled('device_id')) {
            $query->where('device_id', 'like', '%' . $request->device_id . '%');
        }

        $devices = $query->get();

        $this->data['devices'] = $devices;
        return view('admin.devices.index', $this->data);
    }

    

    public function viewLogs($deviceId){
         
        //$this->data['logs'] = Devicelogs::where('device_id',$deviceId)->orderBy('event_time', 'desc')->get();
        $this->data['deviceId'] = $deviceId;
        return view('admin.devices.logs',$this->data); 
    }

    public function manageDevice(Request $request){

        //echo '<pre>';print_r($request->all());
        $sendCommand = new TuyaController();
        $data = $sendCommand->deviceControl($request->all());

        $status = 'ON';
        if($request->device_status == 2){
            $status = 'OFF';
        }

        session()->flash('success', 'You have successfully updated device status');
        return back();

    }

    public function scheduleDevice($deviceId){

        $this->data['timezones'] = \DB::table('timezones')->get();
        $this->data['deviceId'] = $deviceId;

        $schedules = DeviceSchedue::where('device_id', $deviceId)->get()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'device_id' => $schedule->device_id,
                'schedule_date' => $schedule->schedule_date,
                'timezone' => $schedule->timezone,
                'on_time' => \Carbon\Carbon::parse($schedule->on_time, 'UTC')->setTimezone($schedule->timezone)->format('H:i'),
                'off_time' => \Carbon\Carbon::parse($schedule->off_time, 'UTC')->setTimezone($schedule->timezone)->format('H:i'),
                'temperature' => $schedule->temperature,
                'status' => $schedule->status,
                'day' => $schedule->day
            ];
        });


        $this->data['schedules'] = $schedules;
        return view('admin.schedule.index',$this->data);
    }

    // Device schedule create
    public function scheduleCreate($deviceId, Request $request){

       // dd($request->all());
        $onTimeUTC = \Carbon\Carbon::createFromFormat('H:i', $request->on_time, $request->timezones)->setTimezone('UTC')->format('H:i');
        $offTimeUTC = \Carbon\Carbon::createFromFormat('H:i', $request->off_time, $request->timezones)->setTimezone('UTC')->format('H:i');

        DeviceSchedue::create([
            'device_id' => $deviceId,
            'schedule_date' => $request->schedule_date,
            'timezone' => $request->timezones,
            'on_time' => $onTimeUTC,  # Store UTC time
            'off_time' => $offTimeUTC, # Store UTC time
            'temperature' => $request->temperature,
            'status' => $request->status,
        ]);

        session()->flash('success', 'Device schedule successfully created!');
        return back();
         
    }

    // Delete Schedule
    public function deleteSchedule($id){

        $scDelete = DeviceSchedue::find($id);
        $scDelete->delete();
        session()->flash('warning', 'You have successfully Deleted!');
        return back();
    }

    // Show all devices over map
    public function deviceOverMap(Request $request)
    {
        # get installers
        $this->data['I_U'] = User::whereHas('roles', function ($query) {
            $query->where('title', 'Installer');
        })->get();

        # get end users
        $this->data['E_U'] = User::whereHas('roles', function ($query) {
            $query->where('title', 'end_user');
        })->get();

        # get products
        $this->data['products'] = Product::get();

        # start device query
        $query = Device::query();

        # if current user is Installer, limit to their devices only
        if (Auth::user()->roles->contains('title', 'Installer')) {
            $query->where('installer_id', Auth::id());
        }

        # apply filters from request
        if ($request->filled('installer_id')) {
            $query->where('installer_id', $request->installer_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('is_online') && $request->is_online != '') {
            if ($request->is_online == 2) {
                # filter devices that have related fault codes (regardless of is_online)
                $query->whereIn('device_id', function ($subquery) {
                    $subquery->select('devices.device_id')
                        ->from('devices')
                        ->join('devicelogs', 'devices.device_id', '=', 'devicelogs.device_id')
                        ->join('faults', 'devicelogs.code', '=', 'faults.failure_code')
                        ->distinct();
                });
            } else {
                # filter by is_online status only
                $query->where('is_online', (int)$request->is_online);
            }
        }
        

        $devices = $query->get();

        foreach ($devices as $device) {
            $device->error_codes = \DB::table('faults')
                ->join('devicelogs', 'devicelogs.code', '=', 'faults.failure_code')
                ->join('devices', 'devices.device_id', '=', 'devicelogs.device_id')
                ->leftJoin('users as installers', 'installers.id', '=', 'devices.installer_id')
                ->leftJoin('users as owners', 'owners.id', '=', 'devices.user_id')
                ->where('devices.device_id', $device->device_id)
                ->pluck('faults.failure_code')
                ->unique()
                ->values()
                ->toArray();
        }

        # select only required fields
        $this->data['devices'] = $devices;;

        return view('admin.devices.map', $this->data);
    }

    public function viewLogsDatatable(Request $request, $deviceId)
    {
        if ($request->ajax()) {
            $logs = Devicelogs::where('device_id', $deviceId)->orderBy('event_time', 'desc');

            return DataTables::of($logs)
                ->addIndexColumn()
                ->editColumn('code', function ($log) {
                    return $log->code === 'switch' ? 'Power' : $log->code;
                })
                ->editColumn('value', function ($log) {
                    if ($log->code === 'switch') {
                        return $log->value === 'true'
                            ? '<span class="badge bg-outline-success">ON</span>'
                            : '<span class="badge bg-outline-danger">OFF</span>';
                    }
                    return $log->value . '°C';
                })
                ->editColumn('event_time', function ($log) {
                    $timeZone = session('timeZone', 'UTC');
                    $timestampSec = is_numeric($log->event_time) ? $log->event_time / 1000 : null;
                    if ($timestampSec) {
                        return Carbon::createFromTimestamp($timestampSec, 'UTC')
                            ->setTimezone($timeZone)
                            ->format('Y-m-d H:i:s');
                    }
                    return 'Invalid Date';
                })
                ->rawColumns(['value'])
                ->make(true);
        }

        return view('admin.devices.logs', compact('deviceId'));
    }


    public function addContent($id){
        error_reporting(0);
        $this->data['training'] = Training::find($id);
        $this->data['roles'] = Role::all();
        $this->data['content'] = DB::table('contents')->where('collection_id',$id)->orderBy('sort_order')->get();
       
        return view('admin.training.list_content',$this->data); 
    }

    // Add content in collection
    public function addTrainingContent($id){
        $this->data['collection'] = Training::find($id);
        
        
        return view('admin.training.add_collection_content',$this->data); 
    }

    
    public function contentsStore(Request $request, $id)
    {
        //dd($request->options);
        $collection = Training::findOrFail($id);

        $dataPath = null;

        //dd($request->hasFile('file'));

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
        
            # move file to public/uploads
            $file->move(public_path('uploads'), $filename);
        
            # set path to be used in DB or frontend
            $dataPath = 'uploads/' . $filename;
        }


        //dd($request->type);

        $content = $collection->contents()->create([
            'content' => $request->title,
            'type' => $request->type,
            'file' => $dataPath,
            'text_content' => $request->text_content,
            //'step' => @$request->step
        ]);
        

        if ($request->type === 'mcq' && $request->question) {
            $question = $content->mcqQuestions()->create([
                'question' => $request->question
            ]);
            

            $options = $request->input('options'); // this gives you the array
            $correctIndex = $request->input('correct_option'); // this gives index of correct one
           // dd($options);
            foreach ($options as $index => $optionText) {
                if ($optionText !== null && $optionText !== '') {
                    $question->options()->create([
                        'option' => $optionText,
                        'is_correct' => ($index == $correctIndex) ? 1 : 0
                    ]);
                }
            }
        }

      //  dd(1);    
        
        return redirect()->route('admin.addContent', [$id])->with('success', 'Content added!');
    }


    public function collectionCondentDelete($id)
    {   
        DB::table('contents')->where('id', $id)->delete();
        session()->flash('warning', 'You have successfully deleted!');
        return back();
    }

    public function viewContant($id, $collectionId)
    {
        $this->data['collection'] = Training::find($collectionId);
        $this->data['content'] = DB::table('contents')->where('id', $id)->first();

        if ($this->data['content'] && $this->data['content']->type === 'mcq') {
            // fetch question
            $question = DB::table('questions')->where('content_id', $id)->first();
            $this->data['question'] = $question;

            // fetch options if question exists
            if ($question) {
                $this->data['options'] = DB::table('question_options')
                    ->where('question_id', $question->id)
                    ->orderBy('id')
                    ->get();
            }
        }
        //dd($this->data['options']);
        return view('admin.training.edit_collection_content', $this->data);
    }


    public function updateContent(Request $request, $contentId)
    {
        ini_set('upload_max_filesize', '-1');    // unlimited upload size
        ini_set('post_max_size', '-1');          // unlimited post size
        ini_set('max_file_uploads', '50'); 
        $content = Content::findOrFail($contentId);

        $dataPath = $content->file;

        # if new file uploaded, update it
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
        
            # move file to public/uploads
            $file->move(public_path('uploads'), $filename);
        
            # set path to be used in DB or frontend
            $dataPath = 'uploads/' . $filename;
        }

        //dd($_FILES);

        # update content info
        $content->update([
            'content' => $request->title,
            'type' => $request->type,
            'file' => $dataPath,
            'text_content' => $request->text_content,
        ]);

        # if content type is mcq, update or create question and options
        if ($request->type === 'mcq' && $request->question) {
            $question = $content->mcqQuestions()->first();

            if ($question) {
                # update existing question
                $question->update([
                    'question' => $request->question
                ]);

                # delete old options
                $question->options()->delete();
            } else {
                # create new question
                $question = $content->mcqQuestions()->create([
                    'question' => $request->question
                ]);
            }

            # re-create options
            $options = $request->input('options');
            $correctIndex = $request->input('correct_option');

            foreach ($options as $index => $optionText) {
                if (!empty($optionText)) {
                    $question->options()->create([
                        'option' => $optionText,
                        'is_correct' => ($index == $correctIndex) ? 1 : 0
                    ]);
                }
            }
        }

        return redirect()->route('admin.viewContant', [$content->id, $content->collection_id])->with('success', 'Content updated!');
    }

    public function userTraining_old(){
 
        $roleId = Auth::user()->roles->pluck('id')->toArray();

        $this->data['trainings'] = Training::with('viewedByUser')
            ->where(function ($query) use ($roleId) {
                foreach ($roleId as $id) {
                    $query->orWhereRaw("FIND_IN_SET(?, role)", [$id]);
                }
            })
            ->get();
        
        
        return view('admin.training.user_training',$this->data); 
    }

    public function userTraining_back()
    {  

        //session()->put('confetti',1);
        $roleIds = Auth::user()->roles->pluck('id')->toArray();
        $userId = Auth::id();

        $trainings = Training::with([
                'viewedByUser',
                'contents.mcqQuestions.options'
            ])
            ->where(function ($query) use ($roleIds) {
                foreach ($roleIds as $id) {
                    $query->orWhereRaw("FIND_IN_SET(?, role)", [$id]);
                }
            })
            ->get();

            foreach ($trainings as $training) {
                # flag for completed
                $training->is_completed = McqAnswer::where('user_id', $userId)
                    ->where('training_id', $training->id)
                    ->exists();
            
                $hasAnyAnswer = false; // flag to track if any question is answered
            
                foreach ($training->contents as $content) {
                    foreach ($content->mcqQuestions as $question) {
                        # get selected answer as text
                        $selectedAnswer = McqAnswer::where('user_id', $userId)
                            ->where('training_id', $training->id)
                            ->where('question_id', $question->id)
                            ->value('selected_answer');
            
                        $question->user_selected_text = $selectedAnswer;
            
                        # set flag on question
                        $question->is_ans = $selectedAnswer !== null ? 1 : 0;
            
                        # if answered, mark training-level flag
                        if ($question->is_ans === 1) {
                            $hasAnyAnswer = true;
                        }
                    }
                }
            
                # set training-level is_ans
                $training->is_ans = $hasAnyAnswer ? 1 : 0;
            }
            

        return view('admin.training.user_training', ['trainings' => $trainings]);
    }

    public function saveMcqAnswers(Request $request)
    {
        # get the authenticated user id
        $userId = auth()->id();
    
        # get training id
        $trainingId = $request->input('training_id');
    
        # get all mcq answers
        $answers = $request->input('mcq_answers');
        if($answers){
            foreach ($answers as $questionId => $answerArray) {
        
                # make sure we have a non-empty array with at least one element
                if (!is_array($answerArray) || empty($answerArray[0])) {
                    continue;
                }
        
                # decode the first element which is a JSON string
                $answerData = json_decode($answerArray[0], true);
        
                # if decoding fails or not an array, skip
                if (!is_array($answerData)) {
                    continue;
                }
        
                # store or update the answer
                McqAnswer::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'training_id' => $trainingId,
                        'question_id' => $questionId,
                    ],
                    [
                        'selected_answer' => $answerData['option'] ?? null,
                        'is_correct' => $answerData['is_correct'] ?? null,
                    ]
                );
            }
        }else{
            McqAnswer::updateOrCreate(
                [
                    'user_id' => $userId,
                    'training_id' => $trainingId,
                ],
                [
                    'selected_answer' =>  null,
                    'is_correct' =>  null,
                ]
            );
        }
        session()->put('confetti', true);
        return response()->json([
            'status' => 'success',
            'message' => 'Answers saved successfully.'
        ]);
    }


    public function trainingUpdate(Request $request,$id)
    {
        
        // Create a new training record and save it to the database
        $training = Training::find($id);
        $training->title = $request->title;
        $training->description = $request->description;
        $training->role = implode(',', $request->roles);
        $training->cat_id = $request->cat_id;
        $training->save();

        // Set success message and redirect back
        session()->flash('success', 'You have successfully updated the training!');
        return redirect()->route('admin.training');
    }


    # list category
    public function listCategory(){

        $this->data['cats'] = Category::orderBy('id','desc')->get();
        return view('admin.training.list_cat',$this->data);

        
    }

    # list cat for users
    public function listCategoryUser(){

        $this->data['cats'] = Category::orderBy('id','desc')->get();
        return view('admin.training.list_cat_user',$this->data);

    }

    public function userTraining(Request $request)
    {  

        //session()->put('confetti',1);
        $roleIds = Auth::user()->roles->pluck('id')->toArray();
        $userId = Auth::id();

        $trainings = Training::with([
            'viewedByUser',
            'contents' => function ($q) {
                $q->orderBy('sort_order');
            },
            'contents.mcqQuestions.options'
        ])
            ->where(function ($query) use ($roleIds) {
                foreach ($roleIds as $id) {
                    $query->orWhereRaw("FIND_IN_SET(?, role)", [$id]);
                }
            });

           # apply category filter if present
            if (!empty($_REQUEST['category'])) {
                $trainings->where('cat_id', $_REQUEST['category']);
            }

            # execute the query
            $trainings = $trainings->get();

            foreach ($trainings as $training) {
                # flag for completed
                $training->is_completed = McqAnswer::where('user_id', $userId)
                    ->where('training_id', $training->id)
                    ->exists();
            
                $hasAnyAnswer = false; // flag to track if any question is answered
            
                foreach ($training->contents as $content) {
                    foreach ($content->mcqQuestions as $question) {
                        # get selected answer as text
                        $selectedAnswer = McqAnswer::where('user_id', $userId)
                            ->where('training_id', $training->id)
                            ->where('question_id', $question->id)
                            ->value('selected_answer');
            
                        $question->user_selected_text = $selectedAnswer;
            
                        # set flag on question
                        $question->is_ans = $selectedAnswer !== null ? 1 : 0;
            
                        # if answered, mark training-level flag
                        if ($question->is_ans === 1) {
                            $hasAnyAnswer = true;
                        }
                    }
                }
            
                # set training-level is_ans
                $training->is_ans = $hasAnyAnswer ? 1 : 0;
            }

        //echo '<pre>';print_r($trainings[0]->contents);die;
            

        return view('admin.training.user_training', ['trainings' => $trainings]);
    }


    public function reorderTrainingContent(Request $request)
    {
        foreach ($request->order as $item) {
            Content::where('id', $item['id'])->update([
                'sort_order' => $item['position']
            ]);
        }
        session()->flash('success', 'You have successfully updated the order!');
        return response()->json(['success' => true]);
    }
    






    

}