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
Route::group(['middleware' => 'throttle:7000,1'], function () {
    Route::post('/messages','ApiMessagesController@createAPIMessage');
    Route::get('/messages','ApiMessagesController@getErrorMessageOnHttpGet');
    Route::post('/messages/test-search-term','ApiMessagesController@checkIfSearchTermExists');
    Route::post('/messages/test-uncategorized-message','ApiMessagesController@saveUncategorizedMessage');
    Route::post('/messages/test-created-new-subscriber-message','ApiMessagesController@createNewContactSubscriber');
    Route::post('/messages/test-all-controller','ApiMessagesController@createAPIMessage');
});