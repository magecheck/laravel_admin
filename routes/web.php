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

Route::get('/', 'IndexController@view')->name('home');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::post('contact', 'ContactController@index')->name('contact');

Route::group(['prefix' => 'admin','middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@view')->name('dashboard');
    Route::post('permission', 'PermissionController@update')->name('permission');
    Route::get('permission', 'PermissionController@view')->name('permission');

    Route::group(['prefix' => 'account'], function () {
        Route::get('', 'AccountController@view')->name('account.view');
        Route::get('edit', 'AccountController@edit')->name('account.update');
        Route::post('edit', 'AccountController@update')->name('account.update');
        Route::get('{slug}', function () {
            return redirect()->route('account.view');
        });
    });
    Route::group(['prefix' => 'users','middleware' => ['permission']], function () {
        Route::get('add', 'Auth\RegisterController@showRegistrationForm')->name('users.create');
        Route::post('add', 'Auth\RegisterController@register')->name('users.create');
        Route::get('', 'AdminController@view')->name('users.view');
        Route::get('edit/{id}', 'AdminController@edit')->name('users.update');
        Route::post('edit', 'AdminController@update')->name('users.update');
        Route::get('delete/{id}', 'AdminController@delete')->name('users.delete');
        Route::get('export', 'AdminController@export')->name('users.export');
        Route::get('{slug}', function () {
            return redirect()->route('dashboard');
        });
    });
    Route::group(['prefix' => 'contact'], function () {
        Route::get('', 'ContactController@index')->name('contact');
        Route::get('view', 'ContactController@view')->name('contact.view');
        Route::get('delete/{id}', 'ContactController@delete')->name('contact.delete');
        Route::get('send/{id}', 'ContactController@send')->name('contact.send');
        Route::get('{slug}', function () {
            return redirect()->route('contact.view');
        });
    });
    Route::group(['prefix' => 'roles','middleware' => ['permission']], function () {
        Route::get('add', 'RoleController@create')->name('roles.create');
        Route::post('add', 'RoleController@register')->name('roles.create');
        Route::get('', 'RoleController@view')->name('roles.view');
        Route::get('edit/{id}', 'RoleController@edit')->name('roles.update');
        Route::post('edit', 'RoleController@update')->name('roles.update');
        Route::get('delete/{id}', 'RoleController@delete')->name('roles.delete');
        Route::get('export', 'RoleController@export')->name('roles.export');
        Route::get('{slug}', function () {
            return redirect()->route('roles.view');
        });
    });
    Route::group(['prefix' => 'groups','middleware' => ['permission']], function () {
        Route::get('add', 'GroupController@create')->name('groups.create');
        Route::post('add', 'GroupController@register')->name('groups.create');
        Route::get('', 'GroupController@view')->name('groups.view');
        Route::get('edit/{id}', 'GroupController@edit')->name('groups.update');
        Route::post('edit', 'GroupController@update')->name('groups.update');
        Route::get('users/{id}', 'GroupController@users')->name('groups.users');
        Route::post('users', 'GroupController@usersUpdate')->name('groups.users');
        Route::get('delete/{id}', 'GroupController@delete')->name('groups.delete');
        Route::get('export', 'GroupController@export')->name('groups.export');
        Route::get('{slug}', function () {
            return redirect()->route('groups.view');
        });
    });
    Route::group(['prefix' => 'config','middleware' => ['permission']], function () {
        Route::get('add', 'ConfigController@create')->name('config.create');
        Route::post('add', 'ConfigController@register')->name('config.create');
        Route::get('', 'ConfigController@view')->name('config.view');
        Route::get('edit/{id}', 'ConfigController@edit')->name('config.update');
        Route::post('edit', 'ConfigController@update')->name('config.update');
        Route::get('delete/{id}', 'ConfigController@delete')->name('config.delete');
        Route::get('{slug}', function () {
            return redirect()->route('config.view');
        });
    });
});
