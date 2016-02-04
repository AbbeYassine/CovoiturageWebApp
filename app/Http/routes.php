<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
	/*	Route::match(['get', 'post'], '/', 'LoginController@index');
  Route::match(['get', 'post'], '/logout', 'LoginController@logout'); */
  		// login group
      /*  Route::group(['prefix' => 'login'], function () {
            // Login with facebook
            Route::match(['get', 'post'], '/', 'LoginController@pre_Login');
             // Verification
            Route::match(['get', 'post'], '/callback', 'LoginController@login');
        });

        Route::match(['get', 'post'], '/api/group', 'LoginController@getGroups');
        Route::match(['get', 'post'], '/api/posts', 'LoginController@storePostGroup');
    */

        Route::group(['prefix'=>'me'] , function(){
            //Retrive info User Connected with access Token
            Route::match(['get','post'],'/','UserController@index');

            Route::group(['prefix'=>'group'] , function(){
                //Retrive list groups admin 
                Route::match(['get','post'],'/','GroupController@index');
                //Retrive groups particulier 
                Route::match(['get','post'],'/{id_Group}','GroupController@index');

                Route::group(['prefix'=>'/{id_Group}/feed','before'=>'id_Group'], function() {
                    //List des publication dans un group
                    Route::match(['get','post'],'/','FeedController@index');
                    //Store publication dans la base
                    Route::match(['get','post'],'/store','FeedController@store');
                });

            });
        });
        

        //Show All post databases 
        Route::group(['prefix' => 'posts'], function(){
            Route::match(['get','post'],'/','FeedController@show');
        });

        Route::group(['prefix'=>'login'] , function(){
            //Login User 
            Route::match(['get','post'],'/','LoginController@index');
            //Callback save Token
            Route::match(['get','post'],'/callback','LoginController@callback');
        });

        Route::group(['prefix' => 'mobile'], function(){   
            Route::group(['middleware' => 'jwt.auth'], function () {
            
            });
            Route::post('signin', 'Auth\AuthentificateController@authentificate');
            Route::post('signup','InscriptionController@store');
            
        });
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
