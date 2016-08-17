<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Sandbox route for testing
Route::get('sandbox', function() {
  
  $services = json_decode(getenv('VCAP_SERVICES'), true);
  $sqlCreds = $services['cleardb'][0]['credentials'];
  dd($sqlCreds);

});

//Homepage that the user sees
Route::get('/', 'HomeController@index');
Route::get('ajax/index', 'HomeController@outputJson');

//Route for admin redirect when logged in
Route::get('home', function() {
  return Redirect::to('admin');
});
  
//Admin section, protected by login
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function()
{

  Route::get('/', 'HomeController@dashboard');
  Route::get('dashboard', ['as' => 'admin.dashboard', 'uses' => 'HomeController@dashboard']);
  
  Route::resource('post', 'PostController');
  Route::get('post/filter/{category}', ['as' => 'admin.post.filter', 'uses' => 'PostController@filterByCategory']);
  Route::get('ajax/post/{id}/active/{status}', 'PostController@ajaxSetActive');
  Route::get('ajax/post/{id}/delete', 'PostController@ajaxDelete');
  Route::get('ajax/click/{id}/{network}', 'PostController@ajaxClick');

  Route::resource('category', 'CategoryController');
  Route::get('ajax/category/{id}/delete', 'CategoryController@ajaxDelete');
  Route::get('ajax/category/get/list', 'CategoryController@ajaxList');

  Route::resource('user', 'UserController');
  Route::get('ajax/user/{id}/delete', 'UserController@ajaxDelete');

  Route::get('settings', ['as' => 'admin.settings.index', 'uses' => 'SettingController@index']);
  Route::put('settings/update', ['as' => 'admin.settings.update', 'uses' => 'SettingController@update']);
  Route::get('analytics', ['as' => 'admin.analytics', 'uses' => 'HomeController@analytics']);

});

//Registers the routes required for the auth
Route::controllers([
 'auth' => 'Auth\AuthController',
 'password' => 'Auth\PasswordController',
]);

//Debug route to show all available routes
Route::get('routes', function() {
  $routeCollection = Route::getRoutes();
  echo "<table style='width:100%'>";
      echo "<tr>";
          echo "<td width='10%'><h4>HTTP Method</h4></td>";
          echo "<td width='10%'><h4>Route</h4></td>";
          echo "<td width='80%'><h4>Corresponding Action</h4></td>";
      echo "</tr>";
      foreach ($routeCollection as $value) {
          echo "<tr>";
              echo "<td>" . $value->getMethods()[0] . "</td>";
              echo "<td>" . $value->getPath() . "</td>";
              echo "<td>" . $value->getActionName() . "</td>";
          echo "</tr>";
      }
  echo "</table>";
});