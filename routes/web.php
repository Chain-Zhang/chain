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
Route::get('aboutme', 'Blog\UserProfileController@toAboutMe');

/*-----------------------------------------------
 *blog模块路由配置
 -----------------------------------------------*/
Route::group(['prefix' => 'blog'], function (){
    Route::get('/', 'Blog\ArticleController@toArticles');
    Route::get('article/{id}', 'Blog\ArticleController@toDetail');
    Route::get('category/{id}', 'Blog\CategoryController@toCategory');
});

/*-----------------------------------------------
 *用户中心模块路由配置
 -----------------------------------------------*/
Route::group(['prefix' => 'member'], function (){
    Route::get('login', 'Member\UserController@toLogin');

    Route::group(['middleware' => 'checklogin'], function (){
        Route::get('home', 'Member\UserController@toHome');
        Route::get('changepw', 'Member\UserController@toChangePassword');
        Route::get('profile', 'Member\UserController@toProfile');
        Route::get('category', 'Member\CategoryController@toCategory');

        Route::get('article', 'Member\ArticleController@toArticle');
        Route::get('article/add', 'Member\ArticleController@toAdd');
        Route::get('article/edit/{id}', 'Member\ArticleController@toEdit');
        Route::get('article/detail/{id}', 'Member\ArticleController@toDetail');


        Route::get('todolist', 'Member\TodolistController@toTodolist');
        Route::get('timeline', 'Member\TimelineController@toTimeline');
        Route::get('get_chart_data', 'Member\UserController@GetChartData');

        Route::get('project_list', 'Member\MyprojectController@toList');
        Route::get('project_edit/{id}', 'Member\MyprojectController@toEdit');
        Route::get('project_add', 'Member\MyprojectController@toAdd');
    });
});

/*-----------------------------------------------
 *
 -----------------------------------------------*/
Route::group(['prefix' => 'service'], function (){
    Route::post('register', 'Member\UserController@Register');
    Route::post('login', 'Member\UserController@Login');
    Route::post('logout', 'Member\UserController@Logout');
    Route::post('password_change', 'Member\UserController@ChangePassword');
    Route::post('profile_edit', 'Member\UserController@EditProfile');

    Route::post('add_project', 'Member\MyprojectController@ProjectAdd');
    Route::post('project_edit', 'Member\MyprojectController@ProjectEdit');
    Route::post('project_del', 'Member\MyprojectController@ProjectDel');
    Route::post('project_enable', 'Member\MyprojectController@ProjectEnable');


    Route::post('add_category', 'Member\CategoryController@Add');
    Route::post('del_category', 'Member\CategoryController@Del');
    Route::post('mod_category', 'Member\CategoryController@Mod');

    Route::post('add_article', 'Member\ArticleController@Add');
    Route::post('del_article', 'Member\ArticleController@Del');
    Route::post('mod_article', 'Member\ArticleController@Mod');
    Route::post('push_article', 'Member\ArticleController@PushBaidu');

    Route::post('add_todolist', 'Member\TodolistController@Add');
    Route::post('finish_todolist', 'Member\TodolistController@Finished');

    Route::post('add_comment', 'Blog\CommentController@Add');
});

/*-----------------------------------------------
 *
 -----------------------------------------------*/