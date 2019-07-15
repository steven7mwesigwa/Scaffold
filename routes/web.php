<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a given Closure or controller and enjoy the fresh air.
|
*/

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', 'PagesController@home');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('register/invite', 'Auth\RegisterController@showRegistrationInviteForm');
Route::post('register/invite', 'Auth\RegisterController@registerViaInvite');

Auth::routes([
    'verify' => true
]);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth', 'verified']], function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('dashboard', 'DashboardController@get')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('settings', 'SettingsController@settings')->name('user.settings');
        Route::delete('settings/{user}', 'SettingsController@settings')->name('user.destroy');
        Route::put('settings', 'SettingsController@update')->name('user.update');

        Route::get('security', 'SecurityController@get')->name('user.security');
        Route::put('security', 'SecurityController@update')->name('user.security.update');

        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', 'NotificationsController@index')->name('user.notifications');
            Route::post('{uuid}/read', 'NotificationsController@read')->name('user.notifications.read');
            Route::delete('{uuid}/delete', 'NotificationsController@delete')->name('user.notifications.destroy');
        });

        Route::group(['prefix' => 'teams'], function () {
            Route::get('/', 'TeamsController@index')->name('user.teams');
            Route::post('/', 'TeamsController@store')->name('user.teams.store');
            Route::get('create', 'TeamsController@create')->name('user.teams.create');
            Route::get('{team}/edit', 'TeamsController@edit')->name('user.teams.edit');
            Route::get('{team}', 'TeamsController@show')->name('user.teams.show');
            Route::delete('{team}/delete', 'TeamsController@destroy')->name('user.teams.destroy');
            Route::put('{team}/update', 'TeamsController@update')->name('user.teams.update');
            Route::post('{team}/invite', 'TeamsController@invite')->name('user.teams.invite');
            Route::post('{team}/leave', 'TeamsController@leave')->name('user.teams.leave');
        });

        Route::group(['prefix' => 'invites'], function () {
            Route::get('/', 'InvitesController@index')->name('user.invites');
            Route::post('{invite}/accept', 'InvitesController@accept')->name('user.invites.accept');
            Route::post('{invite}/reject', 'InvitesController@reject')->name('user.invites.reject');
        });

    });

    Route::post('invites/{invite}/resend', 'InvitesController@resend')->name('invite.resend');
    Route::post('invites/{invite}/revoke', 'InvitesController@revoke')->name('invite.revoke');
});
