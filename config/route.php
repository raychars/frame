<?php
/**
 * Created by PhpStorm.
 * User: qiandutianxia
 * Date: 2018/4/27 0027
 * Time: 14:35
 */

Route::get('/','IndexController@index');

Route::get('/post','IndexController@post');
Route::post('/post','TestController@test');
