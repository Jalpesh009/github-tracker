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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/create-repo', 'GithubController@createRepo')->name('create.repo');
Route::any('/clone-repo/{id}', 'GithubController@cloneRepo')->name('clone.repo');
Route::any('/clone-repo-github', 'GithubController@cloneFromGithub')->name('clone.repo-github');
Route::any('/remove-repo-github/{name}', 'GithubController@removeFromGithub')->name('remove.repo-github');
Route::any('/push-repo/{id}', 'GithubController@pushRepo')->name('push.repo');
Route::any('/view-repo/{id}', 'GithubController@viewRepo')->name('view.repo');
Route::any('/view-repo-commits/{id}', 'GithubController@viewRepoCommits')->name('view.repo.commits');
Route::any('/checkout-commit/{id}/{repoId}', 'GithubController@checkoutCommit')->name('checkout.commit');
Route::any('/checkout-master/{repoId}', 'GithubController@checkoutMaster')->name('checkout.master');
