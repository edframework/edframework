<?php
use Edogawa\Core\Route\Route;

/**
 * Déclaration des routes
 */

Route::get('/', 'Generator$GController$gen');
Route::get('/Generator/GController/gen', 'Generator$GController$gen');
Route::get('/Generator/GController/lister', 'Generator$GController$lister');
Route::get('/Generator/GVue/gen', 'Generator$GVue$gen');
Route::get('/Generator/GVue/lister', 'Generator$GVue$lister');
Route::get('/Generator/GModele/gen', 'Generator$GModele$gen');
Route::get('/Generator/GModele/lister', 'Generator$GModele$lister');
Route::get('/Generator/GTable/gen', 'Generator$GTable$gen');
Route::get('/Generator/GTable/lister', 'Generator$GTable$lister');
Route::get('/Generator/GCrud/gen', 'Generator$GCrud$gen');
Route::get('/Generator/removeGen' , 'Generator$removeGen');
Route::get('/Generator/help' , 'Generator$help');
Route::get('/Generator/sendMail' , 'Generator$sendMail');
Route::post('/Generator/GController/genAjax', 'Generator$GController$genAjax');
Route::post('/Generator/GVue/genAjax', 'Generator$GVue$genAjax');
Route::post('/Generator/GModele/genAjax', 'Generator$GModele$genAjax');
Route::post('/Generator/GTable/genAjax', 'Generator$GTable$genAjax');
Route::post('/Generator/GTable/searchTable', 'Generator$GTable$searchTable');
Route::post('/Generator/GCrud/genAjax', 'Generator$GCrud$genAjax');
Route::post('/Generator/GCrud/getAttributes' , 'Generator$GCrud$getAttributes');