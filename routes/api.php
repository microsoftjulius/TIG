<?php

use Illuminate\Http\Request;
use App\Http\Resources\MessagesResource as MessageResource;
use App\messages;
use Illuminate\Mail\Message;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/messages','ApiMessagesController@createAPIMessage');
Route::get('/messages','ApiMessagesController@getErrorMessageOnHttpGet');

