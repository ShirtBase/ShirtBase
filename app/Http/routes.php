<?php

use Illuminate\Support\Facades\Request;
use ShirtBase\Color;
use ShirtBase\Shirt;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/api'], function() {
    Route::group(['prefix' => 'shirts'], function() {
        //Get a list of all shirts
        Route::get('/', function() {
            $shirts = Shirt::all();
            return Response::json($shirts, 200, [], JSON_PRETTY_PRINT);
        });

        //Add a shirt
        Route::post('/', function() {
            // Validate input data
            // Check if shirt not already in database
            $validator = Validator::make(
                Request::all(),[
                'name' => 'required|min:3|max:30|unique:shirts,name',
                'user_id' => 'required|integer|min:1|max:5',
                'size' => 'required|alpha_num|min:1|max:5',
                'photo' => 'required|min:4|max:50',
                'color_id' => 'required|integer',
                'comfortability' => 'required|integer|between:1,10',
                'wear' => 'required|integer|between:1,10',
                'sleeve_length' => 'required|integer|between:1,200',
                'notes' => 'max:160',
            ]);
            if ($validator->fails()) {
                $responseJson = [
                    'message' => 'Dane niepoprawne.',
                    'error' => $validator->errors()
                ];
                $statusCode = 400;
            } else {
                //Add Shirt
                $shirt = Shirt::create([
                    'name' => Request::input('name'),
                    'user_id' => Request::input('user_id'),
                    'size' => Request::input('size'),
                    'photo' => Request::input('photo'),
                    'color_id' => Request::input('color_id'),
                    'comfortability' => Request::input('comfortability'),
                    'wear' => Request::input('wear'),
                    'sleeve_length' => Request::input('sleeve_length'),
                    'notes' => Request::input('notes'),
                ]);

                $responseJson = [
                    'message' => 'Dodano koszulkę.',
                    'data' => $shirt
                ];
                $statusCode = 200;
            }
            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });

        //Get a shirt with specific ID
        Route::get('/{id}', function($id) {
            $shirt = Shirt::whereId($id);
            if ($shirt->exists()) {
                $responseJson = $shirt->get();
                $statusCode  = 200;
            } else {
                $responseJson = [
                    'message' => 'Nie ma koszulki o podanym ID.'
                ];
                $statusCode = 400;
            }
            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });


        //Update a shirt with specific ID
        Route::put('/{id}', function($id){
            //Validate input data
            $validator = Validator::make(
                Request::all(),[
                'name' => 'min:3|max:30|unique:shirts,name',
                'user_id' => 'integer|min:1|max:5',
                'size' => 'alpha_num|min:1|max:5',
                'photo' => 'min:4|max:50',
                'color_id' => 'integer',
                'comfortability' => 'integer|between:1,10',
                'wear' => 'integer|between:1,10',
                'sleeve_length' => 'integer|between:1,200',
                'notes' => 'max:160',
            ]);
            if (!Shirt::whereId($id)->exists()) {
                $responseJson = [
                    'message' => 'Nie ma koszulki o podanym ID.'
                ];
                $statusCode = 400;
            } elseif ($validator->fails()) {
                $responseJson = [
                    'message' => 'Niepoprawne dane',
                    'errors' => $validator->errors()
                ];
                $statusCode  = 400;
            } elseif (Shirt::whereId($id)->exists() && $validator->passes()) {
                // Update shirt
                // Get shirt
                $shirt = Shirt::whereId($id)->first();
                //Update each element if it changed
                $elements = [
                    'name',
                    'user_id',
                    'size',
                    'photo',
                    'color_id',
                    'comfortability',
                    'wear',
                    'sleeve_length',
                    'notes',
                ];
                for ($i = 0; $i < sizeof($elements); $i++) {
                    if(Request::input($elements[$i]) !== null) {
                        $shirt->$elements[$i] = Request::input($elements[$i]);
                    }
                }
                $shirt->save();
                $responseJson = [
                    'message' => 'Zaktualizowano koszulkę.',
                    'data' => $shirt
                ];
                $statusCode  = 200;

            }

            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });

        //Delete a shirt with specific ID
        Route::delete('/{id}', function($id) {
            $shirt = Shirt::whereId($id);
            if ($shirt->exists()) {
                $shirt->delete();
                $responseJson = [
                    'message' => 'Usunięto koszulkę.'
                ];
                $statusCode  = 200;
            } else {
                $responseJson = [
                    'message' => 'Nie ma koszulki o podanym ID.'
                ];
                $statusCode = 400;
            }
            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });


    });

    Route::group(['prefix' => 'colors'], function() {

        // Get a list of all Colors
        Route::get('/', function() {
            $colors = Color::all();
            return Response::json($colors, 200, [], JSON_PRETTY_PRINT);
        });

        //Add a color
        Route::post('/', function() {
            // Validate input data
            // Check if color not already in database
            $validator = Validator::make(
                Request::all(),[
                    'name' => 'required|alpha|min:3|max:30|unique:colors,name',
                    'hexCode' => 'required|regex:/^#?[a-fA-F0-9]{3,6}$/|unique:colors,hexCode'
                ]);
            if ($validator->fails()) {
                $responseJson = [
                    'message' => 'Dane niepoprawne.',
                    'error' => $validator->errors()
                ];
                $statusCode = 400;
            } else {
                //Add color
                Color::create([
                    'name' => Request::input('name'),
                    'hexCode' => Request::input('hexCode')
                ]);

                $responseJson = [
                    'message' => 'Dodano kolor.'
                ];
                $statusCode = 200;
            }
            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });

        //Get a color with specific ID
        Route::get('/{id}', function($id) {
            $color = Color::whereId($id);
            if ($color->exists()) {
                $responseJson = $color->get();
                $statusCode  = 200;
            } else {
                $responseJson = [
                    'message' => 'Nie ma koloru o podanym ID.'
                ];
                $statusCode = 400;
            }
            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });

        //Update a color with specific ID
        Route::put('/{id}', function($id){
            //Validate input data
            $validator = Validator::make(
                Request::all(),[
                'name' => 'required_without:hexCode|alpha|min:3|max:30|unique:colors,name',
                'hexCode' => 'required_without:name|regex:/^#?[a-fA-F0-9]{3,6}$/|unique:colors,hexCode'
            ]);
            if (!Color::whereId($id)->exists()) {
                $responseJson = [
                    'message' => 'Nie ma koloru o podanym ID.'
                ];
                $statusCode = 400;
            } elseif ($validator->fails()) {
                $responseJson = [
                    'message' => 'Niepoprawne dane',
                    'errors' => $validator->errors()
                ];
                $statusCode  = 400;
            } elseif (Color::whereId($id)->exists() && $validator->passes()) {
                // Update color
                // Get color
                $color = Color::whereId($id)->first();
                if(Request::input('name') !== null) {
                    $color->name = Request::input('name');
                }
                if(Request::input('hexCode') !== null) {
                    $color->hexCode = Request::input('hexCode');
                }
                $color->save();
                $responseJson = [
                    'message' => 'Zaktualizowano kolor.',
                    'changed_data' => [
                        $color->toArray()
                    ]
                ];
                $statusCode  = 200;

            }

            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });

        //Delete a color with specific ID

        Route::delete('/{id}', function($id) {
            $color = Color::whereId($id);
            if ($color->exists()) {
                $color->delete();
                $responseJson = [
                    'message' => 'Usunięto kolor.'
                ];
                $statusCode  = 200;
            } else {
                $responseJson = [
                    'message' => 'Nie ma koloru o podanym ID.'
                ];
                $statusCode = 400;
            }
            // Return response
            return Response::json($responseJson, $statusCode, [], JSON_PRETTY_PRINT);
        });

    });
});
