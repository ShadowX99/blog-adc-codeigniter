<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

/**
 * Routes -set the general redirection of pages routing system.
 * 
 */

/**
 * User API with JWT Aauthentication routed.
 */
$route['api/simple']='api/user_api/simple_api';
$route['api/limit']='api/user_api/api_limit';
$route['api/key'] = 'api/user_api/api_key';

$route['api/user/login'] = 'api/user_api/login';
$route['api/user/view'] = 'api/user_api/view';


/**
 * Users REST API routes
 */

$route['api/users'] = 'api/users';

/**
 * Password Recovery and Account Activtion routes
 */

$route['recover?(:any)'] = 'users/recover';
$route['activate?(:any)'] = 'users/activate';

/**
 * Posts, Categories and Comments API routes
 */
$route['api/categories'] = 'api/categories';
$route['api/comments'] = 'api/comments';
$route['api/comments?(:any)'] = 'api/comments';
$route['api/posts'] = 'api/posts';

/**
 * Post, Categories, Trivia, Default Site Routes
 */

$route['posts/create'] = 'posts/create';
$route['posts/index'] = 'posts/index';
$route['trivia'] = 'trivia/index';
$route['posts/update'] = 'posts/update';
$route['posts/(:any)'] = 'posts/view/$1';
$route['posts'] = 'posts/index';
$route['categories/create'] = 'categories/create';
$route['categories/posts/(:any)'] = 'categories/posts/$1';

$route['default_controller'] = 'pages/view';

//System Routes
$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;




