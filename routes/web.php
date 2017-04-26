<?php

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

Route::get('/', 'HomeController@index');
Auth::routes();

//Route::get('/home', 'HomeController@index');
Route::group(['prefix'=>'dashboard','namespace'=>'Dashboard','middleware'=>['auth']],function (){
    Route::get('/','HomeController@index');
    Route::get('contact','HomeController@showContactForm');
    Route::post('contact','HomeController@contact');
    Route::resource('category','CategoryController');
    Route::resource('development','DevelopmentController');
    Route::resource('location','LocationController');
    Route::resource('lifestyle','LifeStyleController');
    Route::resource('area','AreaController');
    Route::resource('amenities','AmenitiesController');
    Route::delete('property/image/{id}','PropertyController@deleteLogo');
    Route::get('property/sale','PropertyController@sale');
    Route::get('property/holiday','PropertyController@holiday');
    Route::get('property/rental','PropertyController@rent');
    Route::get('property/offers','PropertyController@offers');
    Route::resource('property','PropertyController');
    Route::resource('images','ImageController');
    Route::delete('news/image/{id}','NewsController@deleteImage');
    Route::resource('news','NewsController');
    Route::resource('tags','TagsController');
    Route::resource('subscriber','SubscriberController');
    Route::post('enquiry/reply','EnquiryController@reply');
    Route::resource('enquiry','EnquiryController');
    Route::post('messages/reply','MessagesController@reply');
    Route::resource('messages','MessagesController');
    Route::resource('comments','NewsCommentsController');
    Route::resource('testimonial','TestimonialController');
    Route::resource('page','PagesController');
    Route::resource('user','UserController');
    Route::resource('mail','EmailController');
    Route::resource('menu','MenuController');
    Route::resource('events','EventsController');
    Route::resource('services','ServicesController');
    Route::get('settings/{slug}','SettingsController@index');
    Route::patch('settings/{slug}','SettingsController@update');
    Route::get('analytic/countries','AnalyticController@countries');
    Route::get('analytic/browsers','AnalyticController@browsers');
    Route::get('analytic/os','AnalyticController@os');
    Route::get('analytic/sources','AnalyticController@sources');
    Route::get('analytic/mobile','AnalyticController@mobile');
    Route::get('analytic/sites','AnalyticController@sites');
    Route::get('analytic/keywords','AnalyticController@keywords');
    Route::get('analytic/landing_pages','AnalyticController@landing_pages');
    Route::get('analytic/exit_pages','AnalyticController@exit_pages');
    Route::get('analytic/bounces','AnalyticController@bounces');
    Route::get('users/interesting','UserController@interesting');
    Route::get('currency','CurrencyController@index');
    Route::post('currency','CurrencyController@store');
    Route::post('todo','HomeController@todo');
    Route::delete('users/interesting/{id}','UserController@destroy_interesting');


});

