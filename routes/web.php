<?php

Route::get('/', 'HomeController@index')->name('home');
Route::redirect('/home', '/admin');
Auth::routes(['register' => false]); 

Route::get('/thankyou', function () {
    return view('thankyou');
})->name('thankyou');

Route::get('/user/login', 'HomeController@userLogin')->name('userLogin');
Route::get('/user/register', 'HomeController@userRegister')->name('register');
Route::any('registerStep', 'App\Http\Controllers\Admin\UsersController@registerStep')->name('registerStep');
Route::any('registerComplete', 'App\Http\Controllers\Admin\UsersController@registerComplete')->name('registerComplete');

Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('spiner', 'HomeController@spiner')->name('spiner');

Route::get('contactSubmit', 'HomeController@contactSubmit')->name('contactSubmit');
// Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::any('/joinMerchant', 'App\Http\Controllers\Admin\UsersController@joinMerchant')->name('joinMerchant');




 Route::any('/customLogin', 'Auth\LoginController@customLogin')->name('customLogin');
 Route::any('/task_detail/{id}', 'Admin\TaskController@task_detail')->name('task_detail');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::any('admin', 'UsersController@admin')->name('admin');
    Route::any('admin_create', 'UsersController@admin_create')->name('admin.create');
    Route::any('admin_store', 'UsersController@admin_store')->name('admin.store');
    Route::any('admin_edit/{id}', 'UsersController@admin_edit')->name('admin.edit');
    Route::any('admin_update/{id}', 'UsersController@admin_update')->name('admin.update');

    Route::any('notesStore/{id}', 'UsersController@notesStore')->name('notesStore');
    Route::any('view_data/{id}', 'UsersController@view_data')->name('view_data');
    Route::any('view_info/{id}', 'UsersController@view_info')->name('view_info');
    Route::any('contacts', 'UsersController@contacts')->name('contacts');

    // Order
    Route::any('orders', 'UsersController@orders')->name('orders');

    Route::any('contact_view/{id}', 'UsersController@contact_view')->name('contact_view');
    

    Route::any('contactDelete/{id}', 'UsersController@contactDelete')->name('contactDelete');
    Route::any('contactEdit/{id}', 'UsersController@contactEdit')->name('contactEdit');
    
    Route::any('contactUpdate/{id}', 'UsersController@contactUpdate')->name('contactUpdate');
    
    Route::any('send-email', 'UsersController@sendEmail')->name('sendEmail');
    
    Route::any('userProfile', 'UsersController@userProfile')->name('userProfile');
    Route::any('updateProfile', 'UsersController@updateProfile')->name('updateProfile');

    Route::any('createContact', 'UsersController@createContact')->name('createContact');
    Route::any('contactStore', 'UsersController@contactStore')->name('contactStore');


    // Registration proceess
    Route::any('registerStep', 'UsersController@registerStep')->name('registerStep');
    Route::any('registerComplete', 'UsersController@registerComplete')->name('registerComplete');

    Route::resource('users', 'UsersController');
    Route::resource('fault', 'FaultController');
    Route::any('faultDevice', 'FaultController@faultDevice')->name('faultDevice');
    Route::post('/fault/update-doc', 'FaultController@updateDoc')->name('updateDoc');

    // Case Intake
    Route::resource('case_intake', 'CaseController');
    Route::resource('message', 'MessageController');
    Route::resource('task', 'TaskController');
    Route::resource('category', 'CategoryController');
    
    Route::any('approve/{id}', 'LeadsController@salesApprove')->name('sales.approve');
    Route::any('salesRejct/{id}', 'LeadsController@salesRejct')->name('sales.reject');
    Route::any('salesUpdate/{id}', 'LeadsController@salesUpdate')->name('salesUpdate');
    Route::any('changeStatus/{id}', 'TaskController@changeStatus')->name('task.changeStatus');


    // Training module
    Route::any('listCategoryUser', 'TaskController@listCategoryUser')->name('listCategoryUser');
    Route::any('userTraining', 'TaskController@userTraining')->name('userTraining');

    Route::any('listCategory', 'TaskController@listCategory')->name('listCategory');
    Route::any('marchentAddress/{id}', 'TaskController@marchentAddress')->name('marchentAddress');

    Route::any('addAddress/{id}', 'TaskController@addAddress')->name('addAddress');
    Route::any('addAddressStore/{id}', 'TaskController@addAddressStore')->name('addAddressStore');
    Route::any('mAddressDelete/{id}', 'TaskController@mAddressDelete')->name('mAddressDelete');

    Route::any('training', 'TaskController@training')->name('training');
    Route::any('trainingEdit/{id}', 'TaskController@trainingEdit')->name('trainingEdit');
    Route::any('trainingUpdate/{id}', 'TaskController@trainingUpdate')->name('trainingUpdate');
    Route::any('trainingCreate', 'TaskController@trainingCreate')->name('trainingCreate');
    Route::any('trainingStore', 'TaskController@trainingStore')->name('trainingStore');
    Route::any('mark-video-watched', 'TaskController@markVideoWatched')->name('markVideoWatched');
    Route::any('trainingDelete/{id}', 'TaskController@trainingDelete')->name('trainingDelete');
    Route::any('addContent/{id}', 'TaskController@addContent')->name('addContent');

    Route::any('reorderTrainingContent', 'TaskController@reorderTrainingContent')->name('reorderTrainingContent');
    
    Route::any('addTrainingContent/{id}', 'TaskController@addTrainingContent')->name('addTrainingContent'); 
    Route::any('contentsStore/{id}', 'TaskController@contentsStore')->name('contentsStore');
    
    Route::any('collectionCondentDelete/{id}', 'TaskController@collectionCondentDelete')->name('collectionCondentDelete'); 
    Route::any('viewContant/{id}/{collectionId}', 'TaskController@viewContant')->name('viewContant'); 
    Route::any('saveMcqAnswers', 'TaskController@saveMcqAnswers')->name('saveMcqAnswers'); 
    
    
    Route::any('updateContent/{contentId}', 'TaskController@updateContent')->name('updateContent');  

    Route::any('chat/{id}', 'ChatController@index')->name('chat.index');
    Route::any('getUnreadMessageCounts', 'ChatController@getUnreadMessageCounts')->name('getUnreadMessageCounts');
    Route::any('chat', 'ChatController@store')->name('salesUpdate')->name('chatStore');
    Route::any('chat/sse/{receiverId}', 'ChatController@sse')->name('salesUpdate')->name('chat.sse');

    // Route::get('chat/{receiverId}', [ChatController::class, 'index'])->name('chat.index');
    // Route::post('chat', [ChatController::class, 'store'])->name('chat.store');
    // Route::get('chat/sse/{receiverId}', [ChatController::class, 'sse'])->name('chat.sse');

    Route::any('products', 'TaskController@products')->name('products');
    Route::any('devices', 'TaskController@devices')->name('devices');
    Route::any('viewLogs/{deviceid}', 'TaskController@viewLogs')->name('viewLogs');

    Route::any('manageDevice', 'TaskController@manageDevice')->name('manageDevice');

    Route::any('scheduleDevice/{id}', 'TaskController@scheduleDevice')->name('scheduleDevice');
    Route::any('scheduleCreate/{id}', 'TaskController@scheduleCreate')->name('scheduleCreate');
    Route::any('deleteSchedule/{id}', 'TaskController@deleteSchedule')->name('deleteSchedule');
    Route::any('deviceOverMap', 'TaskController@deviceOverMap')->name('deviceOverMap');


    Route::get('/learning/create', 'LearningController@create')->name('learning.create');
    Route::post('/learning/store', 'LearningController@store')->name('learning.store');
    Route::get('/learning/{collection}/add-items', 'LearningController@addItems')->name('learning.addItemsForm');
    Route::post('/learning/{collection}/add-items', 'LearningController@storeItems')->name('learning.addItems');

    Route::get('/viewLogs1/{deviceId}', 'TaskController@viewLogsDatatable');
    
    Route::resource('download', 'DownloadsController');
    Route::any('deleteFile/{id}', 'DownloadsController@deleteFile')->name('deleteFile');
    Route::any('sendAttachment', 'DownloadsController@sendAttachment')->name('sendAttachment');

});
