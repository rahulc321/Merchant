<?php
namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Device;
use App\Role;
use App\User;
use App\Devicelogs;
use Carbon\Carbon;
use Auth;

class TuyaController extends Controller
{
    private $clientID = 'f94dsgkt4duhnsac5qwc';
    private $secret = '644427fe07854ad89183f2c50b32c4c2';
    private $baseUrl = 'https://openapi.tuyaeu.com';

    /**
     * @OA\Get(
     *     path="/api/v1/getToken",
     *     summary="Get Access token from Tuya",
     *     tags={"Tuya APIs"},
     *     @OA\Response(
     *         response=200,
     *         description="Get Access token",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=404, description="No states found"),
     *     security={}
     * )
     */
    public function getToken()
    {
        $nonce = '';
        $timestamp = round(microtime(true) * 1000);
        $uri = '/v1.0/token?grant_type=1';
        $body = '';
        $header = [];

        $content = hash("sha256", $body);
        $sigHeader = '';

        $stringToSign = "GET\n" . $content . "\n" . $sigHeader . "\n" . $uri;
        $str = $this->clientID . $timestamp . $nonce . $stringToSign;
        $sign = strtoupper(hash_hmac("sha256", $str, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'method: GET',
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
        $result = json_decode($response, true);

        return isset($result['success']) && $result['success'] === true && isset($result['result']['access_token'])
            ? $result['result']['access_token']
            : null;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/getAllProducts",
     *     summary="Get All Products from Tuya",
     *     tags={"Tuya APIs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of products",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error"),
     *     security={}
     * )
     */
    public function getAllProducts()
    {
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }

        $uri = "/v1.0/products/own/list";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $stringToSign = "GET\n" . hash("sha256", '') . "\n\n" . $uri;
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            'method: GET',
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
        $result = json_decode($response, true);


        foreach ($result['result']['datas'] as $item) {
            //echo '<pre>'; print_r($result['result']['datas']);
            Product::updateOrCreate(
                ['product_id' => $item['id']],  # Unique identifier
                [
                    'uid' => $item['uid'] ?? null,
                    'name' => $item['name'] ?? null,
                    'category' => $item['category'] ?? null,
                    'category_code' => $item['category_code'] ?? null,
                    'create_uid' => $item['create_uid'] ?? null,
                    'desc' => $item['desc'] ?? null,
                    'dev_model' => $item['dev_model'] ?? null,
                    'develop_attribute' => $item['develop_attribute'] ?? null,
                    'develop_status' => $item['develop_status'] ?? null,
                    'gmt_create' => $item['gmt_create'] ?? null,
                    'gmt_modified' => $item['gmt_modified'] ?? null,
                    'icon' => $item['icon'] ?? null,
                    'is_debug' => $item['is_debug'] ?? 0,
                    'model' => $item['model'] ?? null,
                    'oem_type' => $item['oem_type'] ?? null,
                    'power_type' => $item['power_type'] ?? null,
                    'support_group' => $item['support_group'] ?? false,
                    'type' => $item['type'] ?? null,
                    'ui_id' => $item['ui_id'] ?? null,
                    'attribute' => $item['attribute'] ?? null,
                    'biz_attribute' => $item['biz_attribute'] ?? null,
                    'capability' => $item['capability'] ?? null,
                    'product_json' => json_encode($item),  # Store full JSON data
                    'product_details_json' => json_encode($item),  # Store full JSON data
                ]
            );
        }

        return isset($result['success']) && $result['success'] === true
            ? response()->json($result['result'])
            : response()->json(['error' => 'Failed to fetch products'], 500);
    }



    /**
     * @OA\Get(
     *     path="/api/v1/getAllDevices",
     *     summary="Get All Devices from Tuya",
     *     tags={"Tuya APIs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of Devices",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Server error"),
     *     security={}
     * )
     */
    public function getAllDevices()
    {
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }

        $uri = "/v2.0/cloud/thing/device?page_size=20";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $stringToSign = "GET\n" . hash("sha256", '') . "\n\n" . $uri;
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            'method: GET',
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
        $result = json_decode($response, true);

        //dd($result);

       return $this->storeDevices($result['result']);
    }

    public function storeDevices_old($datas)
    {       
        error_reporting(0);
        foreach ($datas as $data) {

            //echo '<pre>';print_r($data);

            if($data['isOnline'] == 'true'){
                $onlineStatus = true;
            }else{
                $onlineStatus = false;
            }

            //$this->deviceLogs($data['id']);

            $device = Device::updateOrCreate(
                ['device_id' => $data['id'] ?? null], # Ensure uniqueness
                [
                    'bind_space_id' => $data['bindSpaceId'] ?? null,
                    'category' => $data['category'] ?? null,
                    'custom_name' => $data['customName'] ?? null,
                    'icon' => $data['icon'] ?? null,
                    'ip' => $data['ip'] ?? null,
                    'is_online' => $onlineStatus,
                    'lat' => isset($data['lat']) ? (float) $data['lat'] : null,
                    'lon' => isset($data['lon']) ? (float) $data['lon'] : null,
                    'local_key' => $data['localKey'] ?? null,
                    'model' => $data['model'] ?? null,
                    'name' => $data['name'] ?? null,
                    'product_id' => $data['productId'] ?? null,
                    'product_name' => $data['productName'] ?? null,
                    'sub' => $data['sub'] ?? false,
                    'time_zone' => $data['timeZone'] ?? null,
                    'active_time' => isset($data['activeTime']) ? date('Y-m-d H:i:s', $data['activeTime']) : null,
                    'create_time' => isset($data['createTime']) ? date('Y-m-d H:i:s', $data['createTime']) : null,
                    'update_time' => isset($data['updateTime']) ? date('Y-m-d H:i:s', $data['updateTime']) : null,
                    'uuid' => $data['uuid'] ?? null,
                    //'device_logs' => isset($data['device_logs']) ? json_encode($data['device_logs']) : json_encode([])
                ]
            );

            $this->deviceLogs($data['id']);

        }
        

        return response()->json(['message' => 'Device stored successfully', 'device' => $datas]);
    }

    public function storeDevices($datas)
    {
        error_reporting(0);

        # collect incoming device ids
        $incomingIds = collect($datas)->pluck('id')->filter()->toArray();

        # get all existing device ids from the database
        $existingIds = Device::pluck('device_id')->toArray();

        # find device_ids that are missing in the incoming array
        $missingIds = array_diff($existingIds, $incomingIds);

        # mark missing devices as offline
        if (!empty($missingIds)) {
            Device::whereIn('device_id', $missingIds)->update(['is_online' => false]);
        }

        foreach ($datas as $data) {
            if($data['isOnline'] == 'true'){
                $onlineStatus = true;
            }else{
                $onlineStatus = false;
            }

           
            Device::updateOrCreate(
                ['device_id' => $data['id'] ?? null],
                [
                    'bind_space_id' => $data['bindSpaceId'] ?? null,
                    'category' => $data['category'] ?? null,
                    'custom_name' => $data['customName'] ?? null,
                    'icon' => $data['icon'] ?? null,
                    'ip' => $data['ip'] ?? null,
                    'is_online' => $onlineStatus,
                    'lat' => isset($data['lat']) ? (float) $data['lat'] : null,
                    'lon' => isset($data['lon']) ? (float) $data['lon'] : null,
                    'local_key' => $data['localKey'] ?? null,
                    'model' => $data['model'] ?? null,
                    'name' => $data['name'] ?? null,
                    'product_id' => $data['productId'] ?? null,
                    'product_name' => $data['productName'] ?? null,
                    'sub' => $data['sub'] ?? false,
                    'time_zone' => $data['timeZone'] ?? null,
                    'active_time' => isset($data['activeTime']) ? date('Y-m-d H:i:s', $data['activeTime']) : null,
                    'create_time' => isset($data['createTime']) ? date('Y-m-d H:i:s', $data['createTime']) : null,
                    'update_time' => isset($data['updateTime']) ? date('Y-m-d H:i:s', $data['updateTime']) : null,
                    'uuid' => $data['uuid'] ?? null,
                ]
            );

            $this->deviceLogs($data['id']);
        }

        return response()->json(['message' => 'Devices processed successfully', 'device' => $datas,'status' => 200,
            'success' => true]);
    }



    public function deviceLogs($deviceId){
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }

        $start_time = Carbon::today()->timestamp * 1000;
        $end_time = Carbon::now()->timestamp * 1000;

        // Construct the URI dynamically
        $uri = "/v2.0/cloud/thing/".$deviceId."/logs?end_time={$end_time}&query_type=1&size=20&start_time={$start_time}&type=1,2,3,4,5,6,7";

        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $stringToSign = "GET\n" . hash("sha256", '') . "\n\n" . $uri;
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            'method: GET',
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
        $result = json_decode($response, true);

        foreach($result['result']['logs'] as $log){

            $existingLog = Devicelogs::where('event_time', $log['event_time'])->first();

            if (!$existingLog) {
                 
                $devicelg = new Devicelogs();
                $devicelg->device_id = $deviceId;
                $devicelg->code = $log['code'];
                $devicelg->value = $log['value'];
                $devicelg->status = $log['status'];
                $devicelg->event_id = $log['event_id'];
                $devicelg->event_from = $log['event_from'];
                $devicelg->event_time = $log['event_time'];
                $devicelg->save();

               // echo '<pre>';print_r($devicelg);die;
            }
        }
    

    }



    /**
     * cURL helper function to send HTTP requests
     */
    private function sendCurlRequest($url, $method, $headers, $body = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($body) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
        }

        curl_close($ch);

        return $response;
    }

    public function deviceControl($requestData)
    {   
        $deviceStatus =  $requestData['device_status'];
       // dd($requestData);
        $status = false;
        if($deviceStatus == 1){
            $status = true;
        }

        //dd($status);

        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }
        $uri = "/v1.0/iot-03/devices/".$requestData['device_id']."/commands";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        if(isset($requestData['temp_set'])){
            $data = [
                "commands" => [
                    [
                        "code" => "temp_set",
                        "value" => (int)$requestData['temp_set']
                    ]
                ]
            ];

        }else{

            $data = [
                "commands" => [
                    [
                        "code" => "switch",
                        "value" => $status
                    ]
                ]
            ];

        }

        // Convert data to JSON format
        $payload = json_encode($data);

        // Generate the string to sign for POST requests
        $stringToSign = "POST\n" . hash("sha256", $payload) . "\n\n" . $uri;
        
        // Generate HMAC-SHA256 signature
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        // Send the POST request with JSON payload
        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'POST', $headers, $payload);
        
        return json_decode($response, true);
    }

    // Manage from cron
    public function deviceControlFromCron($device,$status,$type)
    {      

        if($type == 'on'){
            $status = true;
        }

        if($type == 'off'){
            $status = false;
        }

        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }
        $uri = "/v1.0/iot-03/devices/".$device['device_id']."/commands";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        if($type == 'on'){
            $data = [
                "commands" => [
                    [
                        "code" => "switch",
                        "value" => $status
                    ],
                    [
                        "code" => "temp_set",
                        "value" => (int)$device['temperature']
                    ]
                    
                ]
            ];

        }else{

            $data = [
                "commands" => [
                    [
                        "code" => "switch",
                        "value" => $status
                    ]
                ]
            ];

        }

        // Convert data to JSON format
        $payload = json_encode($data);

        // Generate the string to sign for POST requests
        $stringToSign = "POST\n" . hash("sha256", $payload) . "\n\n" . $uri;
        
        // Generate HMAC-SHA256 signature
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        // Send the POST request with JSON payload
        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'POST', $headers, $payload);
        
        return json_decode($response, true);
    }

    // Create User
    public function createUser($allData)
    {   

        $timezoneData = \DB::table('timezone')->where('state_name',@$allData['state'])->first();
        //dd($timezoneData->time_zone);
        
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }
       // $uri = "/v1.0/iot-02/users";
        $uri = "/v1.0/apps/aetheraethersmart/user";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';
        

        $data = [
            //"country_code" => @$timezoneData->country_code,
            "country_code" => '+61',
            "username" => $allData['email'],
            "password" => md5($allData['password']), // Use the hashed password
            "username_type" => 2,
            "time_zone_id" => @$timezoneData->time_zone
        ];

        // Convert data to JSON format
        $payload = json_encode($data);

        // Generate the string to sign for POST requests
        $stringToSign = "POST\n" . hash("sha256", $payload) . "\n\n" . $uri;
        
        // Generate HMAC-SHA256 signature
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        // Send the POST request with JSON payload
        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'POST', $headers, $payload);
        
        return json_decode($response, true);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/createUserOverTuya",
     *     summary="Create User Over Tuya",
     *     tags={"Installer"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"country_code","full_name", "email", "password", "phone_number","time_zone"},
     *             @OA\Property(property="country_code", type="string", example="+61"),
     *             @OA\Property(property="full_name", type="string", example="John"),
     * *           @OA\Property(property="address", type="string", example="1645 phase 8 mohali"),
     *             @OA\Property(property="email", type="string", example="abc@yopmail.com"),
     *             @OA\Property(property="phone_number", type="string", example="9876543210"),
     *             @OA\Property(property="password", type="string", example="123456", description="User password (will be hashed)"),
     *             @OA\Property(property="time_zone", type="string", example="Australia/Sydney", description="IANA time zone")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="tuya_payload", type="object")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function createUserOverTuya(Request $request)
    {
        
         
        try {
            
            # validate
            $validated = $request->validate([
                'country_code' => 'required|string',
                'full_name'    => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email',
                'password'     => 'required|string|min:6',
                'phone_number' => 'required|string',
                'time_zone'    => 'required|string',
            ]);
             

            # create user on Tuya side
            
            $data = $this->createUser($request->all());
            $tuya_id = @$data['result']['uid'] ?? null;

            # get role
            $role = Role::where('title', 'end_user')->first();
           
            # create user in DB
            $request['tuya_id'] = $tuya_id;
            $request['type'] = 'end_user';
            $request['installer_id'] = \Auth::Id();
            $user = User::create($request->except('country_code','time_zone'));


            # sync role
            if ($role) {
                $user->roles()->sync([$role->id]);
            }

            # send mail
            \Mail::send("email.installer", ['data' => $validated], function ($message) use ($validated) {
                $message->to($validated['email'])
                        ->from("info@gmail.com")
                        ->subject("Account Created");
            });

            return response()->json([
                'message'      => 'User created successfully',
                'user_id'      => $user->id,
                'Tuya_user_id' => $tuya_id,
                'status' => 200,
                'success' => true,
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error in createUserOverTuya: ' . $e->getMessage());

            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
                'status' => 500,
                'success' => false,
            ], 500);
        }
    }


    public function resetUserPassword($allData)
    {

        //echo '<pre>';print_r($allData);die;
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }

        # reset password endpoint
        $uri = "/v1.0/apps/aetheraethersmart/user/password/update";
        
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $data = [
            "username"      => $allData['email'],                   # or phone number if required
            "new_password"  => md5($allData['new_password']),       # if API accepts hashed
            "username_type" => 2                                    # 1 = phone, 2 = email
        ];

        $payload = json_encode($data);

        $stringToSign = "POST\n" . hash("sha256", $payload) . "\n\n" . $uri;

        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'POST', $headers, $payload);

        return json_decode($response, true);
    }


        /**
     * @OA\Post(
     *     path="/api/v1/deviceInfo",
     *     summary="Device Info",
     *     tags={"Tuya APIs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id"},
     *             @OA\Property(property="device_id", type="string", example="bf99d82a40364996a72qlx")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device Info",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Device Info")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */
    public function deviceInfo(Request $request)
    {
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }

        $uri = "/v1.0/devices/".$request->device_id."/status";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $stringToSign = "GET\n" . hash("sha256", '') . "\n\n" . $uri;
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            'method: GET',
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
        return json_decode($response, true);
 
    }


    /**
     * @OA\Post(
     *     path="/api/v1/sendCommand",
     *     summary="Device Info",
     *     tags={"Tuya APIs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","code","value"},
     *             @OA\Property(property="device_id", type="string", example="bf99d82a40364996a72qlx"),
     *              @OA\Property(property="code", type="string", example="mode"),
     *              @OA\Property(property="value", type="string", example="Stand")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device Info",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Device Info")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     * )
     */

    // For mobile need to device control
    public function sendCommand(Request $request)
    {   
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }
        $uri = "/v1.0/iot-03/devices/".$request->device_id."/commands";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $data = [
            "commands" => [
                [
                    "code" => $request->code,
                    "value" => $request->value
                ]
            ]
        ];

        // Convert data to JSON format
        $payload = json_encode($data);

        // Generate the string to sign for POST requests
        $stringToSign = "POST\n" . hash("sha256", $payload) . "\n\n" . $uri;
        
        // Generate HMAC-SHA256 signature
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        // Send the POST request with JSON payload
        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'POST', $headers, $payload);
        
        return json_decode($response, true);
    }


    # get user devices
     
    public function getUserDevices()
    {
        $accessToken = $this->getToken(); // get token from your function
    
        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }
    
        $userUid = "eu17514304598029m6VG"; // your Tuya user ID
        //$uri = "/v1.0/users/{$userUid}/devices";

        $uri = "/v1.0/apps/aetheraethersmart/users";

    
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';
    
        // for GET request stringToSign should be empty after 2nd newline
        $stringToSign = "GET\n" . hash("sha256", '') . "\n\n" . $uri;
    
        // create signature
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));
    
        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];
    
        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
    
        return json_decode($response, true);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/shareDevice",
     *     summary="Share Tuya device with another user",
     *     tags={"Tuya APIs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","country_code","user_email"},
     *             @OA\Property(property="device_id", type="string", example="bf914ddbd56a603fc6xbko"),
     *             @OA\Property(property="country_code", type="string", example="91"),
     *             @OA\Property(property="user_email", type="string", example="testuser@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device successfully shared",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Device shared successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated"),
     *     @OA\Response(response=404, description="Device not found")
     * )
     */


    
     public function shareDevice()
     {
         # === static values ===
         $homeId = "243807979";                   // home ID
         $countryCode = "61";                   // e.g. "86" (China) or "61" (Australia)
         $memberAccount = "neha@yopmail.com";   // user to invite/share with
         $memberName = "Neha";                  // member display name
         $appSchema = "aetheraethersmart";                   // your Tuya app schema
         $isAdmin = false;                      // make true if admin access
     
         # === get access token ===
         $accessToken = $this->getToken();
         if (!$accessToken) {
             return response()->json(['error' => 'Failed to get access token'], 401);
         }
     
         # === Tuya API endpoint ===
         $uri = "/v1.0/homes/{$homeId}/members";
         $url = $this->baseUrl . $uri;
     
         # === timestamp + nonce ===
         $t = (string) round(microtime(true) * 1000);
         $nonce = '';
     
         # === request body ===
         $payloadArr = [
             "app_schema" => $appSchema,
             "member" => [
                 "country_code" => $countryCode,
                 "member_account" => $memberAccount,
                 "admin" => $isAdmin,
                 "name" => $memberName
             ]
         ];
         $payload = json_encode($payloadArr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
     
         # === signature generation ===
         $hashPayload = hash('sha256', $payload);
         $stringToSign = "POST\n{$hashPayload}\n\n{$uri}";
         $signStr = $this->clientID . $accessToken . $t . $nonce . $stringToSign;
         $sign = strtoupper(hash_hmac('sha256', $signStr, $this->secret));
     
         # === headers ===
         $headers = [
             "client_id: {$this->clientID}",
             "sign: {$sign}",
             "t: {$t}",
             "sign_method: HMAC-SHA256",
             "access_token: {$accessToken}",
             "Content-Type: application/json"
         ];
     
         # === cURL request ===
         $ch = curl_init();
         curl_setopt_array($ch, [
             CURLOPT_URL => $url,
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_POST => true,
             CURLOPT_HTTPHEADER => $headers,
             CURLOPT_POSTFIELDS => $payload,
             CURLOPT_SSL_VERIFYPEER => true,
             CURLOPT_TIMEOUT => 30
         ]);
     
         $result = curl_exec($ch);
         if ($result === false) {
             $error = curl_error($ch);
             curl_close($ch);
             return response()->json(['error' => $error], 500);
         }
     
         curl_close($ch);
     
         return response()->json(json_decode($result, true));
     }
     
     /**
     * @OA\Post(
     *     path="/api/v1/syncDeviceByInstallerIos",
     *     summary="Sync device with authenticated user",
     *     tags={"Installer"},
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","user_id"},
     *             @OA\Property(property="device_id", type="string", example="bfb080fc04d5a22ed5epu2"),
     *              @OA\Property(property="user_id", type="string", example="234")
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
    public function syncDeviceByInstallerIos(Request $request)
    {
        // Validate that device_id is required
        $request->validate([
            'device_id' => 'required|string',
            'user_id' => 'required',
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Get device info first then need to store in db
        $accessToken = $this->getToken();

        if (!$accessToken) {
            return response()->json(['error' => 'Failed to retrieve access token'], 401);
        }

        $uri = "/v2.0/cloud/thing/{$request->device_id}";
        $timestamp = round(microtime(true) * 1000);
        $nonce = '';

        $stringToSign = "GET\n" . hash("sha256", '') . "\n\n" . $uri;
        $sign = strtoupper(hash_hmac("sha256", $this->clientID . $accessToken . $timestamp . $nonce . $stringToSign, $this->secret));

        $headers = [
            'client_id: ' . $this->clientID,
            'sign: ' . $sign,
            'access_token: ' . $accessToken,
            'method: GET',
            't: ' . $timestamp,
            'sign_method: HMAC-SHA256',
            'Content-Type: application/json',
        ];

        $response = $this->sendCurlRequest($this->baseUrl . $uri, 'GET', $headers);
        $result = json_decode($response, true);

        if (!@$result['result']) {
            return response()->json([
                'message' => 'Device data not found',
                'status' => 404,
                'success' => false,
            ], 404);
        }

        $result['result'] = [
            0 => @$result['result']
        ];

        //dd($result);

       // echo '<pre>';print_r($result['result']);die;

       $api_res = $this->storeDevices($result['result']);

        // Attempt to find the device record
        $device = \DB::table('user_devices')
        ->where('device_id', $request->device_id)
        ->where('user_id', $request->user_id)
        ->where('installer_id', Auth::id())
        ->first();

            if (!$device) {
                \DB::table('user_devices')->insert([
                    'device_id' => $request->device_id,
                    'user_id' => $request->user_id,
                    'installer_id' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                \DB::table('devices')
                ->where('device_id', $request->device_id)
                ->update([
                    'user_id'      => $request->user_id,
                    'installer_id' => Auth::id(),
                    'updated_at'   => now(),
                ]);
 
            } 
        return $api_res;

    }
     
     
     

     
    
    


    

}