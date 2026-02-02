<?php
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Routes;

Route::get('/sw', function () {
    Artisan::call('l5-swagger:generate');
    return response()->json(['message' => 'Swagger documentation generated successfully']);
});



Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    Route::POST('userLogin', 'UsersApiController@userLogin');

    Route::POST('signUp', 'UsersApiController@signUp');

    Route::GET('listState', 'UsersApiController@listState');
    Route::post('/sendOtp', 'UsersApiController@sendOtp');
    Route::post('/verifyOtp', 'UsersApiController@verifyOtp');
    Route::GET('/getToken', 'TuyaController@getToken');
    Route::GET('/getAllProducts', 'TuyaController@getAllProducts');
    Route::GET('/getAllDevices', 'TuyaController@getAllDevices');
    Route::post('/deviceInfo', 'TuyaController@deviceInfo');
    Route::post('/sendCommand', 'TuyaController@sendCommand');

    Route::any('/getDeviceLogByID', 'UsersApiController@getDeviceLogByID');
    Route::any('/resetPassword', 'UsersApiController@resetPassword');
    Route::any('/getUserDevices', 'TuyaController@getUserDevices');

    Route::any('/shareDevice', 'TuyaController@shareDevice');
   
});


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');
    Route::put('/setPassword', 'UsersApiController@setPassword');

    Route::any('/deviceTimeSchedule', 'UsersApiController@deviceTimeSchedule');
    Route::any('/updateScheduleStatus', 'UsersApiController@updateScheduleStatus');
    Route::any('/profile', 'UsersApiController@profile');
    Route::any('/logout', 'UsersApiController@logout');
    Route::any('/getDeviceSchedule', 'UsersApiController@getDeviceSchedule');
    Route::any('/syncDevice', 'UsersApiController@syncDevice');
    Route::any('/syncUserDevice', 'TuyaController@syncUserDevice');
    Route::any('/enableDisableTime', 'UsersApiController@enableDisableTime');
    Route::any('/deleteSchedule', 'UsersApiController@deleteSchedule');
    
    Route::any('/getDeviceErrorLogs', 'UsersApiController@getDeviceErrorLogs');
    Route::any('/syncDeviceByInstallerIos', 'TuyaController@syncDeviceByInstallerIos');

    // For installer 
    Route::any('/listInstallerInstalledDevices', 'UsersApiController@listInstallerInstalledDevices');
    Route::any('/listInstallerUsers', 'UsersApiController@listInstallerUsers');
    Route::any('/syncDeviceByInstaller', 'UsersApiController@syncDeviceByInstaller');
    Route::any('/createUserOverTuya', 'TuyaController@createUserOverTuya');
    Route::any('/deleteUserByInstaller', 'UsersApiController@deleteUserByInstaller');
   

    // List user devices
    Route::any('/listUserDevices', 'UsersApiController@listUserDevices');
    Route::any('/listUserDevicesForIos', 'UsersApiController@listUserDevicesForIos');
    
    


});
