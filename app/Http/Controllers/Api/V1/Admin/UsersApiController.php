<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\User;
use App\Role;
use App\Timezone;
use App\Device;
use Gate;
use Auth;
use App\Devicelogs;
use App\DeviceSchedue;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\V1\Admin\TuyaController;
use DB;

class UsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());

    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));

    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }


    /**
     * @OA\Post(
     *     path="/api/v1/userLogin",
     *     summary="User Login",
     *     tags={"User Side"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="abc2@yopmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="abc2")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your_access_token"),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=31536000)
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     security={}
     * )
     */
    public function userLogin(Request $request)
    {
        try {
            # validate request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            # attempt login
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json([
                'message' => 'Email or password is incorrect',
                'status' => 500,
                'success' => false,
                ],500);
            }

            # get user & create token
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'current_role' =>@$user->user_current_role->title,
                'status' => 200,
                'success' => true,
                'message' => 'Login successful',

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 500,
                'success' => false,
            ],500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/v1/listState",
     *     summary="Get List of States",
     *     tags={"User Side"},
     *     @OA\Response(
     *         response=200,
     *         description="List of states retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="California"),
     *                 @OA\Property(property="code", type="string", example="CA")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=404, description="No states found"),
     *     security={}
     * )
     */


    public function listState(Request $request)
    {
        $states = Timezone::get();
        return response()->json([
            'states' => $states
             
        ], 200);
    }

     /**
     * @OA\Post(
     *     path="/api/v1/sendOtp",
     *     summary="Send OTP to Email",
     *     tags={"User Side"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"state", "email"},
     *             @OA\Property(property="state", type="string", example="California"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="OTP sent successfully"),
     *             @OA\Property(property="expires_in", type="integer", example=600)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input"),
     *     @OA\Response(response=409, description="Email already exists"),
     *     security={}
     * )
     */
    public function sendOtp(Request $request)
    {
        # Validate input
        $request->validate([
            'state' => 'required|string',
            'email' => 'required|email'
        ]);

         $user = \DB::table('users')
        ->where('email', $request->email)
        ->whereNotNull('password')  # Ensure password is not NULL
        ->where('password', '!=', '')  # Ensure password is not empty string
        ->first();

        if ($user) {
            return response()->json(['error' => 'The email has already been taken.'], 500);
        }

        # Generate OTP
        $otp = rand(100000, 999999);

        # Store OTP in users table
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'state' => $request->state,
                'otp' => $otp,
                'is_verified' => 0,
                'type' => 'end_user'
            ]
        );

        $roleId = Role::where('id', 2)->first();

        if ($roleId) {
            $user->roles()->sync($roleId->id);
        }

        // Get timeZone
        $getTimeZone = \DB::table('timezone')->where('state_name',$request->state)->first();

        # Update the OTP if the user already exists
        if (!$user->wasRecentlyCreated) {
            $user->update([
                'otp' => $otp,
                'timezone' => @$getTimeZone->time_zone ?? '',
                'is_verified' => 0
                
            ]);
        }

        # Send OTP via email
        \Mail::raw("Your OTP code is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Your OTP Code');
        });

        return response()->json([
            'message' => 'OTP sent successfully',
            'otp' => $otp
        ],200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/verifyOtp",
     *     summary="Verify OTP",
     *     tags={"User Side"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "otp"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="otp", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="OTP verified successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid or expired OTP"),
     *     security={}
     * )
     */
    public function verifyOtp(Request $request)
    {
        # validate input
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string'
        ]);

        # fetch user record with OTP
        $user = User::where('email', $request->email)->first();

        # check if user exists & OTP is valid
        if (!$user || $user->otp !== $request->otp ) {
            return response()->json(['message' => 'Invalid OTP'], 500);
        }

        # mark user as verified
        $user->update(['is_verified' => 1]);  // Clear OTP after successful verification

        $token = $user->createToken('AuthToken')->accessToken;

        # return success response with user details and token
        return response()->json([
            'message' => 'OTP verified successfully',
            'user' => $user,           // Return user details
            'access_token' => $token,   // Return access token
            'current_role' => $user->user_current_role->title,
        ],200);

    }

     /**
     * @OA\Post(
     * path="/api/v1/setPassword",
     * operationId="setPassword",
     * tags={"User side"},
     * summary="et password for the authenticated user",
     *   security={ {"Bearer": {} }},
     * description="et password for the authenticated user",
     *    @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"client_id"},
     *               @OA\Property(property="password", type="text"),
     *               
     *            ),
     *        ),
     *    ),
     *      @OA\Response(
     *          response=201,
     *          description="Team details",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Team details",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    /**
     * @OA\Put(
     *     path="/api/v1/setPassword",
     *     summary="Set password for the authenticated user",
     *     description="This API allows the user to set their password after OTP verification using Bearer token authentication.",
     *     operationId="setPassword",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"password"},
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="New password",
     *                     example="password"
     *                 ) 
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Password updated successfully."
     *             )
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized: Invalid or missing token.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Unauthorized"
     *             )
     *         )
     *     )
     * )
     */
    public function setPassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'password' => 'required'
        ]);

        // Get the authenticated user
        $user = Auth::user();
 
        // Update the user's password
        $user->password = \Hash::make($request->password);
        $user->save();
 
        return response()->json(['message' => 'Password updated successfully.'],200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/getDeviceLogByID",
     *     summary="Device Log",
     *     tags={"User Side"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id"},
     *             @OA\Property(property="device_id", type="string"),
     *             @OA\Property(property="page", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of Device Logs",
     *         @OA\JsonContent(
     *             @OA\Property(property="total_records", type="integer"),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     security={}
     * )
     */
    public function getDeviceLogByID(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
        // 'per_page' => 'sometimes|integer|min:1',
            'page' => 'sometimes|integer|min:1',
        ]);

        $perPage = $request->input('per_page', 10); // Default to 10 logs per page
        $page = $request->input('page', 1); // Default to page 1 if not provided

        $deviceLogs = Devicelogs::where('device_id', $request->device_id)
            ->orderBy('event_time', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'total_records' => $deviceLogs->total(),
            'per_page' => $deviceLogs->perPage(),
            'current_page' => $deviceLogs->currentPage(),
            'data' => $deviceLogs->items(),
            'status' => 200,
            'success' => true,
            'message' => 'List Device Data.',
        ]);
    }

     /**
     * @OA\Post(
     *     path="/api/v1/signUp",
     *     summary="signUp",
     *     tags={"User Side"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","tuya_id","timezone"},
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="state", type="string", example="Victoria"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string"),
     *             @OA\Property(property="tuya_id", type="string", example="viinhssg"),
     *             @OA\Property(property="timezone", type="string", example="Asia/Kolkata"),
     * 
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="signUp successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="signUp successfully"),
     *             @OA\Property(property="expires_in", type="integer", example=600)
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input"),
     *     @OA\Response(response=409, description="Email already exists"),
     *     security={}
     * )
     */
    public function signUp(Request $request)
    {
        # Validate input
        $request->validate([
            'state' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'tuya_id'  => 'required',
            'timezone'  => 'required',

        ]);

         $user = \DB::table('users')
        ->where('email', $request->email)
       // ->whereNotNull('password')  # Ensure password is not NULL
       // ->where('password', '!=', '')  # Ensure password is not empty string
        ->first();

        if ($user) {
            return response()->json(['error' => 'The email has already been taken.'], 500);
        }
        
        $getTimeZone = \DB::table('timezone')->where('state_name',$request->state)->first();

        # Store OTP in users table
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [   
                'full_name' => $request->name,
                'tuya_id' => $request->tuya_id,
                'state' => $request->state,
                'password' => \Hash::make($request->password),
                'type' => 'end_user',
                'timezone' =>@$request->timezone ?? '',
            ]
        );

        $roleId = Role::where('id', 2)->first();

        if ($roleId) {
            $user->roles()->sync($roleId->id);
        }

        $token = $user->createToken('AuthToken')->accessToken;
  
        return response()->json([
            'message' => 'User account created successfully',
            'token' => $token,
            'data' => $user
        ],200);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/deviceTimeSchedule",
     *     summary="Set Device Timer",
     *     tags={"User Side"},
     *      security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","temperature", "timezones", "schedule"},
     *             @OA\Property(property="device_id", type="string", example="bfb080fc04d5a22ed5epu2"),
     *             @OA\Property(property="temperature", type="integer", example=25),
     *             @OA\Property(property="timezones", type="string", example="Asia/Kolkata"),
     *             @OA\Property(
     *                 property="schedule",
     *                 type="object",
     *                 example={
     *                     "monday": {
     *                         {"start": "08:00", "end": "10:00"},
     *                         {"start": "14:00", "end": "16:00"}
     *                     },
     *                     "friday": {
     *                         {"start": "09:30", "end": "12:00"}
     *                     },
     *                     "everyday": {}
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Schedule created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid input"),
     * )
     */

     public function deviceTimeSchedule(Request $request)
     {
         # validate required inputs
         $request->validate([
             'device_id'   => 'required|string',
             'temperature' => 'required|integer',
             'timezones'   => 'required|string',
             'schedule'    => 'required|array',
         ]);
     
         # this will hold all saved/updated schedules for response
         $savedSchedules = [];
     
         foreach ($request->schedule as $day => $slots) {
             foreach ($slots as $slot) {
                 $onTime = \Carbon\Carbon::createFromFormat('H:i', $slot['start'], $request->timezones)
                                 ->setTimezone('UTC')->format('H:i');
     
                 $offTime = \Carbon\Carbon::createFromFormat('H:i', $slot['end'], $request->timezones)
                                 ->setTimezone('UTC')->format('H:i');
     
                 # try to find an existing record first
                 $existing = DeviceSchedue::where('device_id', $request->device_id)
                             ->where('day', $day)
                             ->where('on_time', $onTime)
                             ->first();
     
                 if ($existing) {
                     # update only if something has changed
                     if (
                         $existing->off_time !== $offTime ||
                         $existing->temperature != $request->temperature ||
                         $existing->timezone !== $request->timezones ||
                         $existing->status != 1
                     ) {
                         $existing->update([
                             'off_time' => $offTime,
                             'temperature' => $request->temperature,
                             'timezone' => $request->timezones,
                             'status' => 1,
                         ]);
                     }
     
                     $savedSchedules[] = $existing;
                 } else {
                     # create new entry
                     $new = DeviceSchedue::create([
                         'device_id' => $request->device_id,
                         'day' => $day,
                         'on_time' => $onTime,
                         'off_time' => $offTime,
                         'temperature' => $request->temperature,
                         'timezone' => $request->timezones,
                         'status' => 1,
                     ]);
     
                     $savedSchedules[] = $new;
                 }
             }
         }
     
         return response()->json([
             'message' => 'Schedule saved successfully',
             'status' => 200,
             'success' => true,
             'schedules' => $savedSchedules, # send all in one array
         ], 200);
     }
     



    /**
     * @OA\Get(
     *     path="/api/v1/profile",
     *     summary="Get profile data",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Profile data",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function profile(Request $request)
    {
        # get the authenticated user
        $user = auth()->user();

        # return user profile data
        return response()->json([
            'data' => $user,
            'status' => 200,
            'success' => true,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="Logout the authenticated user",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        # return logout success message
        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 200,
            'success' => true,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/getDeviceSchedule",
     *     summary="Get device schedule time",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\Parameter(
     *         name="device_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device schedule time",
     *         @OA\JsonContent(
     *             @OA\Property(property="device_id", type="string", example="device_123"),
     *             @OA\Property(
     *                 property="schedule",
     *                 type="object",
     *                 example={
     *                     "Monday": {
     *                         {
     *                             "start": "10:00",
     *                             "end": "12:00",
     *                             "temperature": "22",
     *                             "timezone": "Australia/Sydney",
     *                             "status": 1
     *                         }
     *                     }
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function getDeviceSchedule_old(Request $request)
    {
        # validate input
        $request->validate([
            'device_id' => 'required|string',
        ]);

        # fetch all active schedules for the device
        $schedules = DeviceSchedue::where('device_id', $request->device_id)->get();

        # format schedule grouped by day
        $formatted = [];

        foreach ($schedules as $item) {

            $on_time = date('H:i',strtotime($item->on_time));
            $off_time = date('H:i',strtotime($item->off_time));

            $onTime = \Carbon\Carbon::createFromFormat('H:i', $on_time, 'UTC')
                ->setTimezone($item->timezone)
                ->format('H:i');

            $offTime = \Carbon\Carbon::createFromFormat('H:i', $off_time, 'UTC')
                ->setTimezone($item->timezone)
                ->format('H:i');
                
            $formatted[$item->day][] = [

                'start'       => $onTime,
                'end'         => $offTime,
                'temperature' => $item->temperature,
                'timezone'    => $item->timezone,
                'status'      => $item->status,
            ];
        }

        return response()->json([
            'device_id' => $request->device_id,
            'schedule'  => $formatted,
        ], 200);
    }

    public function getDeviceSchedule(Request $request)
    {
        # validate input
        $request->validate([
            'device_id' => 'required|string',
        ]);

        # fetch all active schedules for the device
        $schedules = DeviceSchedue::where('device_id', $request->device_id)->get();

        # group schedules by day
        $grouped = [];

        foreach ($schedules as $item) {

            $on_time = date('H:i', strtotime($item->on_time));
            $off_time = date('H:i', strtotime($item->off_time));

            $onTime = \Carbon\Carbon::createFromFormat('H:i', $on_time, 'UTC')
                ->setTimezone($item->timezone)
                ->format('H:i');

            $offTime = \Carbon\Carbon::createFromFormat('H:i', $off_time, 'UTC')
                ->setTimezone($item->timezone)
                ->format('H:i');

            # group schedules by day name (e.g., monday, tuesday)
            $grouped[$item->day][] = [
                'id'      => $item->id,
                'start'       => $onTime,
                'end'         => $offTime,
                'temperature' => $item->temperature,
                'timezone'    => $item->timezone,
                'status'      => $item->status,
            ];
        }

        # now prepare final formatted array
        $finalSchedule = [];

        foreach ($grouped as $day => $schedules) {
            $finalSchedule[] = [
                'name'      => strtolower($day), # e.g., 'Monday' -> 'monday'
                //'isActive'  => true,
                'schedules' => $schedules
            ];
        }

        return response()->json([
            'device_id' => $request->device_id,
            'schedule'  => $finalSchedule,
        ], 200);
    }

    


    /**
     * @OA\Post(
     *     path="/api/v1/syncDevice",
     *     summary="Sync device with authenticated user",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id"},
     *             @OA\Property(property="device_id", type="string", example="bfb080fc04d5a22ed5epu2")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device synced successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Device synced successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function syncDevice1(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);
    
        $user = $request->user();
        $role = $user->roles[0]->title ?? '';
    
        $device = \DB::table('devices')->where('device_id', $request->device_id)->first();
    
        if (!$device) {
            return response()->json([
                'message' => 'Device not found',
                'success' => false,
            ], 404);
        }
    
        $field = $role == 'Installer' ? 'installer_id' : 'user_id';
    
        \DB::table('devices')
            ->where('device_id', $request->device_id)
            ->update([$field => $user->id]);
    
        return response()->json([
            'message' => 'Device synced successfully',
            'success' => true,
        ]);
    }
    
    public function syncDevice(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
        ]);
    
        $user = $request->user();
        $role = $user->roles[0]->title ?? '';
    
        $device = \DB::table('devices')->where('device_id', $request->device_id)->first();
    
        if (!$device) {
            return response()->json([
                'message' => 'Device not found',
                'success' => false,
            ], 404);
        }
    
        # determine which field to update in devices table
        $field = $role === 'Installer' ? 'installer_id' : 'user_id';
    
        \DB::table('devices')
            ->where('device_id', $request->device_id)
            ->update([$field => $user->id]);
    
        # prepare data
        $data = [
            'device_id'    => $request->device_id,
            'user_id'      => $role === 'Installer' ? null : $user->id,
            'installer_id' => $role === 'Installer' ? $user->id : null,
            'updated_at'   => now(),
        ];
    
        # check if entry already exists
        $exists = \DB::table('user_devices')
            ->where('device_id', $request->device_id)
            ->first();
    
        if ($exists) {
            # update record
            \DB::table('user_devices')
                ->where('device_id', $request->device_id)
                ->update($data);
        } else {
            # insert new record
            $data['created_at'] = now();
            \DB::table('user_devices')->insert($data);
        }
    
        return response()->json([
            'message' => 'Device synced successfully',
            'success' => true,
        ]);
    }



   /**
     * @OA\Post(
     *     path="/api/v1/enableDisableTime",
     *     summary="Update device schedule",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="string", example="12"),
     *             @OA\Property(property="status", type="integer", example=1, description="1 to enable, 0 to disable")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Schedule update successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Schedule update successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Device or schedule not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function enableDisableTime(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'status' => 'nullable|in:0,1',
        ]);

        $schedule = DeviceSchedue::where('id', $request->id)->first();

        if (!$schedule) {
            return response()->json([
                'message' => 'Device or schedule not found',
                'status' => 404,
                'success' => false,
            ], 404);
        }

        $schedule->status = $request->status;
        $schedule->save();

        return response()->json([
            'message' => 'Schedule update successfully',
            'status' => 200,
            'success' => true,

        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/deleteSchedule",
     *     summary="Delete device schedule",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="string", example="12")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Schedule deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Schedule deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Device or schedule not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */

    public function deleteSchedule(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);

        $schedule = DeviceSchedue::where('id', $request->id)->first();

        if (!$schedule) {
            return response()->json([
                'message' => 'Device or schedule not found',
                'status' => 404,
                'success' => false,
            ], 404);
        }

        // Delete the schedule
        $schedule->delete();

        return response()->json([
            'message' => 'Schedule deleted successfully',
            'status' => 404,
            'success' => true,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/resetPassword",
     *     summary="Reset user password (no old password required)",
     *     tags={"User Side"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","new_password"},
     *              @OA\Property(property="email", type="string", example="abc@gmail.com"),
     *              @OA\Property(property="new_password", type="string", example="newPassword456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password updated successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // $rPassword = new TuyaController();
        // $passData = $rPassword->resetUserPassword($request->all());
        // echo '<pre>';print_r($passData);die;
        // die;

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->password = \Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully'
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/listInstallerInstalledDevices",
     *     summary="Get all devices installed by the logged-in installer",
     *     tags={"Installer"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of devices installed by the authenticated installer",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function listInstallerInstalledDevices()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $devices = Device::where('installer_id', auth()->id())->get();

        $devices->transform(function ($device) {
            $user = $device->u_name; // uses getUNameAttribute()
            
            # add custom attributes
            $device->full_name = $user?->full_name ?? '';
            $device->address = $user?->address ?? '';
        
            return $device;
        });

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'List of devices installed by the logged-in installer',
            'devices' => $devices
        ], 200);
    }


   /**
     * @OA\Get(
     *     path="/api/v1/listInstallerUsers",
     *     summary="Get all users assigned to the logged-in installer",
     *     tags={"Installer"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of users for the installer",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function listInstallerUsers()
    {
        # ensure only authenticated users can access
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        # fetch users where installer_id matches the logged-in user
        $users = User::where('installer_id', auth()->id())->get();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'List of users assigned to the logged-in installer',
            'users' => $users
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/syncDeviceByInstaller",
     *     summary="Sync device by installer",
     *     tags={"Installer"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","user_id"},
     *             @OA\Property(property="device_id", type="string", example="bfb080fc04d5a22ed5epu2"),
     *             @OA\Property(property="user_id", type="string", example="234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device synced successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Device synced successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function syncDeviceByInstaller(Request $request)
    {
        try {
            # validate input
            $request->validate([
                'device_id' => 'required|string',
                'user_id' => 'required',
            ]);
    
            # get authenticated user
            $user = $request->user();
    
            # check if device exists
            $device = \DB::table('devices')
                ->where('device_id', $request->device_id)
                ->first();
    
            if ($device) {
                # update user_id and installer_id
                \DB::table('devices')
                    ->where('device_id', $request->device_id)
                    ->update([
                        'user_id' => $request->user_id,
                        'installer_id' => Auth::id()
                    ]);
    
                return response()->json([
                    'message' => 'Device synced successfully',
                    'status' => 200,
                    'success' => true,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'success' => false,
                    'message' => 'Device not found'
                ], 404);
            }
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            # validation failed
            return response()->json([
                'message' => 'Validation error',
                'status' => 422,
                'success' => false,
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            # unexpected server error
            return response()->json([
                'message' => 'Something went wrong',
                'status' => 500,
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/v1/deleteUserByInstaller",
     *     summary="Delete User By Installer",
     *     tags={"Installer"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="user_id", type="string", example="12")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Schedule deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Schedule deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Device or schedule not found"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */

     public function deleteUserByInstaller(Request $request)
     {
         $request->validate([
             'user_id' => 'required|string',
         ]);
 
         $user = User::where('id', $request->user_id)->first();
 
         if (!$user) {
             return response()->json([
                 'message' => 'User not found',
                 'status' => 404,
                 'success' => false,
             ], 404);
         }
 
         // Delete the schedule
         $user->delete();
 
         return response()->json([
             'message' => 'User deleted successfully',
             'status' => 200,
            'success' => true,
         ], 200);
     }


     /**
     * @OA\Get(
     *     path="/api/v1/listUserDevices",
     *     summary="Get all devices installed by the logged-in user",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of devices installed by the authenticated user",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function listUserDevices()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $devices = Device::where('user_id', auth()->id())->get();

        return response()->json([
            'message' => 'List of devices installed by the logged-in user',
            'devices' => $devices,
            'status' => 200,
            'success' => true,
        ], 200);
    }


     /**
     * @OA\Get(
     *     path="/api/v1/listUserDevicesForIos",
     *     summary="Get all devices installed by the logged-in user",
     *     tags={"User Side"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of devices installed by the authenticated user",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error")
     * )
     */
    public function listUserDevicesForIos_()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }  

        $deviceIds = DB::table('user_devices')->where('user_id',auth()->id())->pluck('device_id')->toArray();
        $devices = Device::whereIn('device_id', $deviceIds)->get();

        return response()->json([
            'message' => 'List of devices installed by the logged-in user',
            'devices' => $devices,
            'status' => 200,
            'success' => true,
        ], 200);
    }
    
    public function listUserDevicesForIos()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = auth()->user();
        $role = $user->roles[0]->title ?? '';
    
        # choose column based on role
        $column = $role === 'Installer' ? 'installer_id' : 'user_id';
    
        # fetch device IDs linked to this user/installer
        $deviceIds = DB::table('user_devices')
            ->where($column, $user->id)
            ->pluck('device_id')
            ->toArray();
    
        # get device details
        $devices = Device::whereIn('device_id', $deviceIds)->get();
    
        return response()->json([
            'message' => 'List of devices linked to the logged-in user',
            'devices' => $devices,
            'status' => 200,
            'success' => true,
        ]);
    }



 
}
