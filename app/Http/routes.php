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
// Authentication routes...
	Route::get('/login', 'Auth\AuthController@getLogin');
	Route::post('/login', 'Auth\AuthController@postLogin');
	Route::get('/logout', 'Auth\AuthController@getLogout');

	// Registration routes...
	Route::get('/register', 'Auth\AuthController@getRegister');
	Route::post('/register', 'Auth\AuthController@postRegister');

	Route::get('/confirm-login-worked', function() {
	    # You may access the authenticated user via the Auth facade
	    $user = Auth::user();
		    if($user) {
		        echo 'You are logged in.';
		        dump($user->toArray());
		    } else {
		        echo 'You are not logged in.';
		    }
		    return;
		});

	Route::get('/', 'WelcomeController@getIndex');


	Route::group(['middleware' => 'auth'], function() {
			Route::get('/create_round', 'HandicapController@getCreate_round');
			Route::post('/create_round', 'HandicapController@postCreate_round');
			Route::get('/edit_round/{id?}', 'HandicapController@getEdit_round');
			Route::post('/edit_round', 'HandicapController@postEdit_round');
			Route::get('/confirm-delete/{id?}', 'HandicapController@getConfirmDelete');
			Route::post('/delete/{id?}', 'HandicapController@getDoDelete');
      Route::get('/handicap', 'HandicapController@getHandicap');
      Route::post('/handicap', 'HandicapController@postHandicap');
	});

	Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(config('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    /*
    The following line will output your MySQL credentials.
    Uncomment it only if you're having a hard time connecting to the database and you
    need to confirm your credentials.
    When you're done debugging, comment it back out so you don't accidentally leave it
    running on your live server, making your credentials public.
    */
    //print_r(config('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    }
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});