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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {return redirect('/login');});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/church/{id}','ChurchesController@getChurchUsers');
    Route::get('/groups','ChurchesController@getAllChurches')->name('Groups');
    Route::get('/user','ChurchUserController@show')->name('TIG Users');
    Route::get('/search-user','ChurchUserController@index');
    Route::get('/display-sent-messages','messages@display_sent_messages')->name('Sent Messages');
    Route::get('/sent-quick-messages','messages@drop_down_groups');
    Route::get('/sent-messages','messages@send');
    Route::get('/view-church-user/{id}','ChurchesController@view_church_user');
    Route::get('/create-user',function() { return view('after_login.create-users');});
    Route::get('/addusers',function() { return view('after_login.add-users');});
    Route::get('/contacts',function() { return view('after_login.contacts');});
    Route::get('/manager',function() { return view('after_login.manager');});
    Route::get('/create-TIG-groups',function(){return view('after_login.create-church');});
    Route::get('/search','ChurchUserController@index');
    Route::post('/create-groups','ChurchesController@addNewChurch');
    Route::post('/create-user','ChurchesController@addUserToChurch');
    Route::get('/adds-user','ChurchUserController@store');
    Route::get('/search-church','ChurchesController@search');
    Route::get('/contact-groups','GroupsController@index')->name('Contact Groups');
    Route::get('/get-next-page/{id}','GroupsController@pagination_for_groups');
    Route::get('/search-group','GroupsController@search_group');
    Route::post('/import-contacts/{id}', 'ContactsController@import')->name('import');
    Route::get('/create-group','GroupsController@create_group');
    Route::get('/create-group-form','GroupsController@show_form');
    Route::get('/store-sent-messages','SendingMessages@sendImmediateMessage');
    Route::get('/view-contacts/{id}','ContactsController@view_for_group')->name('Add Contacts to Group');
    Route::get('/save-contact-to-group/{id}','ContactsController@save_contact_to_group');
    Route::get('/search-sent-messages','messages@search_messages');
    Route::get('/read-file','messages@read_file');
    Route::get('/send-categorized-message','sendCategorizedMessageController@sendCategorizedMessage');
    Route::get('/file-reading',function(){return view('after_login.file-reading');});
    Route::get('/search-term-list/{id}','messages@show_search_terms')->name("Search terms");
    Route::get('/message-categories','messages@message_categories_page')->name("Message categories");
    Route::get('/change-passwords',function(){return view('after_login.change-password');});
    Route::get('/save-change-password','ChurchUserController@store_users_password');
    Route::get('/add-message-category','messages@show_add_category_blade');
    Route::get('/incoming-messages','messages@show_incoming_messages');
    Route::get('/edit-category-term/{id}','messages@edit_message_category');
    Route::get('/add-search-term/{id}','messages@display_message_category_form');
    Route::get('/add-message-categories','messages@save_message_category');
    Route::get('/search-message-categories','messages@search_message_categories');
    Route::get('/delete-contact/{contact_id}','ContactsController@deleteContact');
    Route::get('/save-search-term/{id}','messages@save_search_terms');
    Route::get('/delete-search-term/{id}','messages@deleteSearchTerm');
    Route::get('/search-incoming-messages','messages@searchIncomingMessages');
    Route::get('/show-search-terms','messages@display_search_terms');
    Route::get('/packages','PackagesController@getChurchPackages')->name('Packages');
    Route::get('/addnewsubscription','PackagesController@selectSubscribedForMessagesTitle');
    Route::get('/logs','PackagesController@getPaymentLogs')->name('Payment Logs');
    Route::get('/create-a-subscription-period','PackagesController@createASubscriptionTimeFrame');
    Route::get('/uncategorized-messages','messages@showUnCategorizedMessages');
    Route::get('/delete-uncategorized-message/{id}','messages@deleteUncategorizedMessage');
    Route::get('/deleted-messages','messages@showDeletedMessages');
    Route::get('/show-scheduled-message','SendingMessages@sendScheduledMessage');
    Route::get('/permanetly-delete-message','messages@permanetlyDeleteMessage');
    Route::get('/create-a-package','PackagesController@createPackage');
    Route::get('/map-package-to-category','PackagesController@mapCategoryToPackage');
    Route::get('/display-scheduled-messages','ScheduledMessagesController@displayScheduledMessages')->name("Scheduled Messages");
    Route::post('/create-contact/{id}','ContactsController@save_contact_to_group');
    Route::post('/create-contact-to-group/{id}','ContactsController@addContactToGroup');
    Route::post('/check-if-number-exists/{id}','ContactsController@save_contact_to_group');
    Route::post('/upload-excel-file','ImportAndExportContactsController@uploadExcel')->name('import');
    Route::post('/import-contacts-category/{id}','ImportCategoriesContacts@import')->name('import contacts');
    Route::get('/export-group-contact/{id}','ImportAndExportContactsController@exportContacts')->name('export');
    Route::get('/roles-and-permision','PermisionsController@rolesAndPermisionsView')->name('Roles and Permisions');
    Route::get('/contact-not-found-messages','messages@displayWrongMessageToAdmin')->name('Contacts Not Hosted');
    Route::get('/add-category-contacts/{id}','CategoriesController@addContacts');
    Route::get('/save-contact-to-category/{id}','CategoriesController@saveContact');
});
