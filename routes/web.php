<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/', 'Website\IndexController');
Route::resource('blog', 'Website\BlogController');
Route::get('service/{name}', 'Website\MenuController@show_menu');
Route::resource('contact-us', 'Website\ContactUsController');
Route::resource('about-us', 'Website\AboutUsController');

Route::group(['prefix' => 'serviceOperation', 'as' => 'serviceOperation.'], function (){
    Route::post('addService', 'Website\ServiceOperationController@addService');
    Route::post('removeService', 'Website\ServiceOperationController@removeService');
    Route::get('getSelectedServices', 'Website\ServiceOperationController@getSelectedServices');
});




Route::group(['prefix' => 'Auth', 'as' => 'Auth.'], function (){
    Route::resource('register', 'Website\Auth\RegisterController');
    Route::resource('otp', 'Website\Auth\OtpController');
});

Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.'], function (){
    Route::resource('dashboard', 'Superadmin\Dashboard\DashboardController');
    Route::resource('login', 'Superadmin\Auth\AuthController');

    Route::group(['prefix' => 'master', 'as' => 'master.'], function (){
        Route::resource('period', 'Superadmin\Master\PeriodController');
        Route::resource('document', 'Superadmin\Master\DocumentController');
        Route::resource('company-type', 'Superadmin\Master\CompanyTypeController');
        Route::resource('category', 'Superadmin\Master\CategoryController');
        Route::resource('service', 'Superadmin\Master\ServiceController');
    });

    Route::group(['prefix' => 'message-template', 'as' => 'message-template.'], function (){
        Route::resource('sms', 'Superadmin\MessagesTemplates\SmsController');
        Route::resource('email', 'Superadmin\MessagesTemplates\EmailController');
        Route::resource('whats-app', 'Superadmin\MessagesTemplates\WhatsAppController');
    });

    Route::group(['prefix' => 'website', 'as' => 'website.'], function (){
        Route::resource('menu-service', 'Superadmin\Website\MenuServiceController');
        Route::resource('web-page', 'Superadmin\Website\WebPageController');
        Route::resource('blog', 'Superadmin\Website\BlogController');
        Route::post('advertise/delete-images', 'Superadmin\Website\AdvertiseController@delete_images');
        Route::resource('advertise', 'Superadmin\Website\AdvertiseController');
    });

    Route::group(['prefix' => 'user-list', 'as' => 'user-list.'], function (){
        Route::resource('client', 'Superadmin\UserList\ClientController');
        Route::resource('ca', 'Superadmin\UserList\CaController');
        Route::resource('freelancer', 'Superadmin\UserList\FreelancerController');
    });

    Route::group(['prefix' => 'service-list', 'as' => 'service-list.'], function (){
        Route::resource('client-added-services', 'Superadmin\ServiceList\ClientAddedServiceController');
        Route::put('client-added-services/document-status-update/{id}', 'Superadmin\ServiceList\ClientAddedServiceController@documentStatusUpdate');

    });

});

Route::group(['prefix' => 'message', 'as' => 'message.'], function (){
    Route::post('get-message-modal', 'Message\MessageController@get_message_modal');
    Route::post('get-template-description', 'Message\MessageController@get_template_description');
    Route::post('send-message', 'Message\MessageController@send_message');
});


Route::group(['prefix' => 'client', 'as' => 'client.'], function (){
    Route::get('add_user_added_service', 'Client\Dashboard\DashboardController@add_user_added_service');
    Route::resource('dashboard', 'Client\Dashboard\DashboardController');
    Route::resource('login', 'Client\Auth\AuthController');
});

