<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

    $path = $_SERVER['DOCUMENT_ROOT'];

    $routes = [

        route('/users', function() {
            return control('ExampleController')->users();
        }),
    
        route('/user/:name', function($name) {
            return control('ExampleController')->index($name);
        }),
    
        route('/', function() {
            echo 'hello';
        }),

        route('/', function() {
            return view('error.404');
        })
        
    ];

return $routes;