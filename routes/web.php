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
//  FUNCTION : check the type of a triangle
//  PARAM : A, B, C = size of triangle sides
//  RETURN : type of triangle (Scalene, Equilateral, Isosceles, Incorrect) */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// ========================================================================
//    CRUD BLOG ENDPOINTS
// ========================================================================

// ------------------- POST -------------------

//  FUNCTION : return a list of all posts
//  PARAM : -
//  RETURN : JSON array of all posts */

$router->get('/test', function () use ($router) {
    return "TEST";
});

//  FUNCTION : return a specific posts
//  PARAM : IDPOST
//  RETURN : JSON object of the post

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//  FUNCTION : add a new post
//  PARAM : 
//  RETURN : 

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//  FUNCTION : delete an existing post
//  PARAM : 
//  RETURN : 

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//  FUNCTION : modify an existing post
//  PARAM : 
//  RETURN : 

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// ----------------- COMMENT -----------------

//  FUNCTION : return a list of all comments from a post
//  PARAM : 
//  RETURN :

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//  FUNCTION : add a new comment
//  PARAM : 
//  RETURN : 

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//  FUNCTION : delete an existing comment
//  PARAM : 
//  RETURN : 

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//  FUNCTION : modify an existing comment
//  PARAM : 
//  RETURN : 

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// BONUS : Make it possible to have images as part of posts