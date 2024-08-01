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

// Import
// Route::get('importlocations', 'ImportController@importLocations');
// Route::get('importstates', 'ImportController@importStates');
// Route::get('importinterests', 'ImportController@importInterests');

// Authentication
Auth::routes();
/*
/* REMOVED --> SOCIAL LOGIN ROUTES
/*
Route::get('register', 'Auth\LoginController@showRegistrationView')->name('register');
Route::get('login', 'Auth\LoginController@showLoginView')->name('login');
Route::get('login/social/{provider}', 'Auth\SocialController@redirect');
Route::get('login/social/callback/{provider}', 'Auth\SocialController@callback');
*/

// Index
Route::get('/', 'MainController@index'); // Dig Doing Home Page (Should Re-Direct to /home for logged in users)

// Home
Route::get('/home', 'HomeController@index')->name('home'); // Logged In Users Home Page

// API Documentation
Route::get('api', 'MainController@api')->name('apiInstructionsWeb');

// Admin
// This is for you to admin the site (add / remove interests, ban users, make users moderators or admins, manage reported posts, manage reported interests, ban posts, remove locations)
// TODO: ADD ADMINISTRATOR MIDDLEWEAR TO ENSURE ONLY ADMINS CAN ACCESS THIS!!!
Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->middleware('web', 'auth');
    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('web', 'auth');

});

// Moderate
// This is for moderators to add and edit interests and locations
// TODO: ADD MODERATOR GATE OR GUARD OR MIDDLEWEAR TO ENSURE ONLY MODERATORS CAN ACCESS THIS!!!
Route::prefix('moderate')->group(function () {
    Route::get('/{interest}', 'ModerateController@index')->middleware('web', 'auth');                   // View
    Route::get('/{interest}/update', 'ModerateController@updateInterest')->middleware('web', 'auth');   // Update from Index View
});

// Alerts
Route::prefix('alerts')->group(function () {
    Route::get('/', 'AlertsController@index');
});

// Search
Route::prefix('search')->group(function () {
    Route::get('/', 'SearchController@index');
});

// Blog
Route::prefix('blog')->group(function () {
    Route::get('/', 'BlogController@index');
});

// News
Route::prefix('news')->group(function () {
    Route::get('/', 'NewsController@index');
});

// User Account
Route::prefix('user')->group(function () {
    Route::get('/', 'UserController@index');
});

// Profile
Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@index');
});

// Post
Route::prefix('post')->group(function () {
    Route::get('/', 'PostController@index');
});

// Calendar
Route::prefix('calendar')->group(function () {
    Route::get('/', 'CalendarController@index');
});

// Votes
Route::prefix('vote')->group(function () {
    Route::post('/location_interest', 'VotesController@ProcessLocationInterestVote')->middleware('web', 'auth');
});

// Locations
Route::prefix('location')->group(function () {
    Route::redirect('/', '/location/US/08');
    Route::get('/{country?}/{state?}/{location?}/{locationRoute?}', 'LocationController@index');
    Route::get('/add', 'LocationController@addLocation')->middleware('web', 'auth');            // View
    Route::post('/insert', 'LocationController@insertLocation')->middleware('web', 'auth');     // Insert from Add View
    Route::get('/edit', 'LocationController@editLocation')->middleware('web', 'auth');          // View
    Route::post('/update', 'LocationController@updateLocation')->middleware('web', 'auth');     // Update from Edit View
});

// Interests
Route::prefix('interests')->group(function () {
    Route::get('/', 'InterestController@index');
    Route::get('/add', 'InterestController@addInterest')->middleware('web', 'auth');           // View for Add an Interest
    Route::post('/insert', 'InterestController@insertInterest')->middleware('web', 'auth');    // Post Action for Add an Interest
});

// Fallback for All Routes
Route::fallback('InterestController@getInterest');