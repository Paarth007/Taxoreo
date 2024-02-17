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
Route::get('privacy-policy', 'Website\PolicyAndTermsController@privacy_policy');
Route::get('refund-policy', 'Website\PolicyAndTermsController@refund_policy');
Route::get('return-policy', 'Website\PolicyAndTermsController@return_policy');
Route::get('terms-and-conditions', 'Website\PolicyAndTermsController@terms_and_conditions');


Route::group(['prefix' => 'serviceOperation', 'as' => 'serviceOperation.'], function (){
    Route::post('addService', 'Website\ServiceOperationController@addService');
    Route::post('removeService', 'Website\ServiceOperationController@removeService');
    Route::get('getSelectedServices', 'Website\ServiceOperationController@getSelectedServices');
});

Route::group(['prefix' => 'Auth', 'as' => 'Auth.'], function (){
    Route::resource('login', 'Website\Auth\LoginController');
    Route::resource('register', 'Website\Auth\RegisterController');
    Route::resource('otp', 'Website\Auth\OtpController');
});

Route::group(['prefix' => 'shared', 'as' => 'shared.'], function (){
    Route::group(['middleware' =>['SessionCheckSuperadmin','SessionCheckClient','SessionCheckUser']],function(){
        Route::resource('comments', 'SharedControllers\CommentsController');
    });
});


Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.'], function (){
    Route::resource('login', 'Superadmin\Auth\AuthController');

    Route::group(['middleware' =>['SessionCheckSuperadmin']],function(){

        Route::resource('dashboard', 'Superadmin\Dashboard\DashboardController');
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

        Route::group(['prefix' => 'client-service', 'as' => 'client-service.'], function (){
            //STAGE-1
            Route::resource('newly-added-services', 'Superadmin\ClientService\NewlyAddedServiceController');
            Route::put('newly-added-services/document-status-update/{id}', 'Superadmin\ClientService\NewlyAddedServiceController@documentStatusUpdate');

            //STAGE-2
            Route::resource('payment-verification-assign-user', 'Superadmin\ClientService\PaymentVerificationAssignUserServiceController');
            Route::post('change-user', 'Superadmin\ClientService\PaymentVerifyAssignUserServiceController@changeUser');

            //STAGE-3
            Route::resource('in-progress', 'Superadmin\ClientService\InProgressServiceController');

            Route::resource('complete', 'Superadmin\ClientService\CompleteServiceController');

        });

        Route::group(['prefix' => 'report', 'as' => 'report.'], function (){
            Route::resource('payment-log', 'Superadmin\Report\PaymentLogController');
            Route::resource('payment-details', 'Superadmin\Report\PaymentDetailsController');
        });

    });
});

Route::group(['prefix' => 'message', 'as' => 'message.'], function (){
    Route::post('get-message-modal', 'Message\MessageController@get_message_modal');
    Route::post('get-template-description', 'Message\MessageController@get_template_description');
    Route::post('send-message', 'Message\MessageController@send_message');
});


Route::post('make-payment','Client\Payment\PaymentController@make_payment');
Route::any('payment-response','Client\Payment\PaymentController@payment_response');

Route::group(['prefix' => 'client', 'as' => 'client.'], function (){
    Route::resource('login', 'Client\Auth\AuthController');

    Route::group(['middleware' =>['SessionCheckClient']],function(){
        Route::resource('dashboard', 'Client\Dashboard\DashboardController');
        Route::get('add_user_added_service', 'Client\Dashboard\DashboardController@add_user_added_service');
    });
});


//FREELANCER & OTHER DIFFENT USERS //
Route::group(['prefix' => 'user', 'as' => 'user.'], function (){
    Route::resource('login', 'User\Auth\AuthController');

    Route::group(['middleware' =>['SessionCheckUser']],function(){
        Route::resource('dashboard', 'User\Dashboard\DashboardController');

        Route::group(['prefix' => 'services', 'as' => 'services.'], function (){
            Route::resource('assigned-services', 'User\Services\AssignedServicesController');
        });

    });

});
