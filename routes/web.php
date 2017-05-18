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

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/register', 'Auth\RegisterController@register');

Route::resource('/patient', 'PatientController');

Route::get('/test', function() {

    // function send_line_notify($message, $token)
    // {
    //     $ch = curl_init();
    //     curl_setopt( $ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    //     curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    //     curl_setopt( $ch, CURLOPT_POST, 1);
    //     curl_setopt( $ch, CURLOPT_POSTFIELDS, "message=$message");
    //     curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    //     $headers = array( "Content-type: application/x-www-form-urlencoded", "Authorization: Bearer $token", );
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    //     $result = curl_exec( $ch );
    //     curl_close( $ch );

    //     return $result;
    // }
    // $message = 'การทดสอบ การส่ง line notify';
    // $token = 'GNYga83I4mg9roJYc8C2NXGlGb42dCDUDFUUVLwRZWF';
        
    // echo send_line_notify($message, $token);

    $token = 'GNYga83I4mg9roJYc8C2NXGlGb42dCDUDFUUVLwRZWF';
    $ln = new KS\Line\LineNotify($token);

    $message = 'test to send line notify.
                Form web page.';
    $ln->send($message);

});

Route::get('/home', 'HomeController@index')->name('home');
