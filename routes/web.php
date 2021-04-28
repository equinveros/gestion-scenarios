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


Auth::routes();

Route::get('/', 'WelcomeController@index');

Route::get('/{lang?}', function() {
  return view('welcome');
})->where('lang', implode('|', array_flip(config('app.locales'))));

// USERS //
Route::post('/utilisateur', ['as'   => 'board',
'uses' => 'UserController@showBoard']);
Route::get('/utilisateur/{id}', ['as'   => 'getUser',
'uses' => 'UserController@getUser']);
Route::get('/utilisateurs', ['as'   => 'userList',
'uses' => 'UserController@lists']);
Route::get('/utilisateur/edit/{id}', ['as'   => 'editUser',
'uses' => 'UserController@editUser',]);
Route::get('/utilisateur/delete/{id}', ['as'   => 'deleteUser',
'uses' => 'UserController@deleteUser',]);


Route::get('/administration', function() {
  return view("administration/admin_home");
});

Route::get('/scenario_register', function() {
  return view("scenario/scenario_register");
});

Route::get('scenario/nouveau', ['as'   => 'new',
'uses' => 'ScenarioController@getFormScenario']);
Route::get('scenario/edition/{id}', ['as'   => 'edit',
'uses' => 'ScenarioController@getFormScenario']);
Route::get('/scenario/close/{id}', ['as'   => 'close',
'uses' => 'ScenarioController@closeScenario']);

Route::post('scenario', ['as'   => 'scenario_register',
'uses' => 'ScenarioController@registerScenario']);

Route::post('/scenario/update/{id}', ['as'   => 'editScenario',
'uses' => 'ScenarioController@update']);


Route::get('/scenarios', 'ScenarioController@showAll');
Route::get('/scenario/{id}', 'ScenarioController@view');
Route::get('/scenario/{idScena}/{idStep}', 'ScenarioController@view');
Route::get('/scenario/{idScena}/{idStep}/{lang}', 'ScenarioController@view');
//Route::get('/getScenarioStep/{id}', 'ScenarioController@getScenarioStep');
Route::get('/getScenarioStep/{idScena}/{idStep}', 'ScenarioController@getScenarioStep');
Route::get('/getScenarioStep/{idScena}/{idStep}/{lang}', 'ScenarioController@getScenarioStep');

Route::get('/steps', 'StepController@showAll');
Route::get('/getSteps/{id}', 'StepController@getNumberStepByScenario');
Route::get('/step/{id}', 'StepController@showAllByScenario');
Route::post('/scenario/step/update', ['as'   => 'editStep',
'uses' => 'StepController@update']);

Route::get('/image/{file}', function($filename) {
  $path = '/img/' . $filename;

  //    if(!File::exists($path)) {
    //        return response()->json(['message' => 'Image not found.'], 404);
    //    }
    //
    //    $file = File::get($path);
    //    $type = File::mimeType($path);
    //
    //    $response = Response::make($file, 200);
    //    $response->header("Content-Type", $type);
    return url($path);

  });
  Route::post('image/upload', 'UploadController@fileCreate');
  Route::post('image/delete', 'UploadController@fileDestroy');

  Route::resource('user', 'UserController');
  //Route::resource('scenario', 'ScenarioController');
  //Route::resource('step', 'StepController');
  //Route::resource('administration', 'AdministrationController');

  // Controller -> Function
  //Route::get('/home', 'HomeController@index')->name('home');
