<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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

// ========================================================================
//    TRIANGLE ENDPOINT
// ========================================================================

/**
     * Check and return the type of triangle made by the 3 variables a, b and c.
     * This endpoint only accept numeric values or return an error.
     * @param int $a, $b, $c => sides of the triangle
     * @return string => Type of the triangle
     */

$router->get('/triangle/{a:[0-9]+}/{b:[0-9]+}/{c:[0-9]+}', function ($a,$b,$c) {

    if($a == $b && $b == $c){
        $triangle = 'Equilateral';
    }
    else if($a != $b && $b != $c && $a != $c){
        $triangle = 'Scalene';
    }
    else if(($a == $b && $a != $c) || ($a == $c && $a != $b) || ($b == $c && $b != $a)){
        $triangle = 'Isosceles';
    }
    else {
        $triangle = 'Incorrect';
    }
    return $triangle;
});

// ========================================================================
//    CRUD BLOG ENDPOINTS
// ========================================================================

// ------------------- POST -------------------

//  Return a list of all posts (call postList in BlogController)
Route::get('posts', 'BlogController@postList');

//  Return a specific post selected by its ID (call post in BlogController)
Route::get('posts/{id}', 'BlogController@post');

//  Add a new post (call postAdd in BlogController)
Route::post('posts', 'BlogController@postAdd');

//  Delete an existing post selected by its ID (call postDelete in BlogController)
Route::delete('posts/{id}', 'BlogController@postDelete');

//  Update an existing post (call postUpdate in BlogController)
Route::put('posts', 'BlogController@postUpdate');

// ----------------- COMMENT -----------------

//  Return a list of all comments from a post (call comList in BlogController)
Route::get('posts/{id}/comments', 'BlogController@comList');

//  Return a specific comment selected by its ID from a post (call com in BlogController)
Route::get('posts/{id}/comments/{idcom}', 'BlogController@com');

//  Add a new comment to an existing post selected by its ID (call comAdd in BlogController)
Route::post('posts/{id}/comments/', 'BlogController@comAdd');


// BONUS : Make it possible to have images as part of posts
// encoder l'image en chaine de caractères > limité par le protocole HTTP
// uploader l'image dans un serveur, envoyer le lien de l'image via l'API