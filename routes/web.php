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

/**
 * ДЛЯ ТЕСТА
 * /test        Простотр сессий
 * /deltest     Удаление всех сессий
 */
Route::get('/test', "Controller@Test");
Route::get('/deltest', "Controller@delTest");

/**
 * СТРАНИЦЫ
 * /                Страница главная
 * /list            Страница просмотра и добавления задач
 * /addGroup        Страница добавления списка задач
 * /edit/{group}    Страница с изменением задач внутри списка
 * /view/{group}    Страница со списком задач внутри группы
 */
Route::get('/', function () {return view('welcome');});
Route::get('/list', "Controller@list");
Route::get('/addGroup', "Controller@addGroup");
Route::get('/edit/{group}', "Controller@editGroup");
Route::get('/view/{group}', "Controller@viewGroup");

/**
 * ОБРАБОТЧИКИ ФОРМЫ
 * /addGroup    Обработчик добавления списка задач со страницы /addGroup 
 * /addList     Обработчик формы добавления задачи к списку со страницы /list
 * /editGroup   Обработчик форы изменения задач внутри списка со страницы /edit/{group}
 */
Route::post('/addGroup', "Controller@addGroupPOST");
Route::post('/addList', "Controller@addList");
Route::post('/editGroup', "Controller@editGroupPOST");

/**
 * ОБРАБОТЧИКИ ДЕЙСТВИЙ С ЗАДАЧАМИ
 * /del/{group}/{key}   Удаление задачи у списка
 * /del/{group}         Удаление всего списка
 * /sort/{group}        Сортировка задач внутри списка
 */
Route::get('/del/{group}/{key}', "Controller@del");
Route::get('/del/{group}', "Controller@delGroup");
Route::get('/sort/{group}', "Controller@sortGroup");



