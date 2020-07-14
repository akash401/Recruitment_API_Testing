<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'AuthorController@postLogin');
$router->post('/save', 'AuthorController@save');

$router->group(['prefix' => 'v1','middleware' => ['auth:api']], function () use ($router) {
 // $router->group(['prefix' => 'v1'], function () use ($router) {
  $router->get('candidates',  ['uses' => 'AuthorController@showAllCandidates']);

  $router->get('candidates/search',  ['uses' => 'AuthorController@search']);

  $router->get('candidates/{id}', ['uses' => 'AuthorController@showOneCandidates']);

  $router->post('candidates', ['uses' => 'AuthorController@create']);

  $router->delete('candidates/{id}', ['uses' => 'AuthorController@delete']);

  $router->put('candidates/{id}', ['uses' => 'AuthorController@update']);
});
