<?php

Route::get('/', 'BookingController@index');
Route::get('/home', 'BookingController@index');
Route::post('/get-calculated-room-price', 'BookingController@calcRoomPrice');
Route::resource('/test', 'EmailController');


/*
 * Route booking
 */

Route::get('confirm/{id}', 'BookingController@confirm');
Route::resource('booking', 'BookingController');

Route::get('/booking-confirm', function () {
    return view('frontend.showall');
});

Route::get('/booking-form', function () {
    return view('frontend.form');
});


/*
 * Route Authentication
 */
Route::get('admin', function () {
    return Redirect('admin/login');
});

Route::get('auth/login', function () {
    return Redirect('admin/login');
});


/*
 * Route admin
 */
Route::get('admin/login', 'Auth\AuthController@getLogin');
Route::post('admin/login', 'Auth\AuthController@postLogin');
Route::get('admin/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('admin/register', 'Auth\AuthController@getRegister');
Route::post('admin/register', 'Auth\AuthController@postRegister');

// Password routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset/{token}', 'Auth\PasswordController@postReset');


/*
 * Route dashboard - Admin
 */
Route::get('dashboard', ['middleware' => 'auth', function () {
    return redirect('rooms');
}]);


/*
 * Route rooms - Admin
 */
Route::get('rooms/ajax/get-list-data/{display_by}', 'RoomController@ajaxGetRoomList');
Route::post('rooms/ajax/update-name', 'RoomController@ajaxUpdateName');
Route::post('rooms/ajax/remove-rate', 'RoomController@ajaxRemoveRate');
Route::post('rooms/upload/image','RoomController@ajaxPostUploadRoomImage');
Route::post('rooms/ajax/update-pic-name','RoomController@ajaxUpdateImage');
Route::post('rooms/ajax/cancel-room-pic','RoomController@ajaxRemoveImage');
Route::post('rooms/ajax/remove-room-available', 'RoomController@ajaxRemoveRoomAvailable');
Route::get('/rooms/recap', 'RoomController@recap');
Route::resource('/rooms', 'RoomController');


/*
 * Route addons - Admin
 */
Route::post('addon/ajax/update', 'AddonController@ajaxUpdate');
Route::post('addon/ajax/create', 'AddonController@ajaxCreate');
Route::post('addon/ajax/destroy', 'AddonController@ajaxDestroy');
Route::resource('/addon', 'AddonController');


/*
 * Route Reservations - Admin
 */
Route::resource('/reservations', 'ReservationsController');

