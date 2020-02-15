<?php

    /*
    *   FUNCTION NAME: || VIEW                                                                           ||
    *   FUNCTION:      || Renders the view page to the browser And also sends data to the page for usage ||
    *   USAGE:         || view('ViewPageName', compact('var1', 'var2'));                                 || 
    *   NOTE:          || The second argument 'compact()' is optional and can accept many variables      ||
    */
    function view($view, $params=array()) 
    {
        $public = $_SERVER['DOCUMENT_ROOT'].'/public/views';
        foreach($params as $key => $value) {
            $$key = $value;
        }
        $view = str_replace('.', '/', $view);
        require_once $public . '/' . $view . '.kirch.php';

        /*
        $path = $_SERVER['DOCUMENT_ROOT'];
        $file = file_get_contents($public . '/' . $view . '.php');
        $parse1 = str_replace('{{', '<?php', $file);
        $parse2 = str_replace('}}', ' ?>', $parse1);
        $render = fopen($path . '/public/index.render.php', 'w');
        fwrite($render, $parse2);
        fclose($render);
        require_once $path . '/public/index.render.php';
        return;
        */
    }

    /*
    *   FUNCTION NAME: || CONTROL                                    ||
    *   FUNCTION:      || Loads the Controller.                      ||
    *   USAGE:         || control('ControllerName')->functionName(); || 
    *   NOTE:          || The functionName is mandatory.             ||
    */
    function control($controller) 
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        require_once $path. '/controllers/'. $controller . '.php';
        return $controller = new $controller;
    }

    /*
    *   FUNCTION NAME: || ASSET                                             ||
    *   FUNCTION:      || Returns file path from the 'assets' folder.       ||
    *   USAGE:         || asset('css/style.css');                           || 
    *   NOTE:          || The function accept only one mandatory argument.  ||
    */
    function asset($path) 
    {
        $root = env('APP_URL') . '/assets';
        return $root . '/' . $path;
    }

    /*
    *   FUNCTION NAME: || RENDER                                                                ||
    *   FUNCTION:      || Renders a layout to the View. Used for file parting                   ||
    *   USAGE:         || render('layoutName');                                                 || 
    *   NOTE:          || 1. name of layout without '.kirch.php'. 2. a dot '.' represent '/'    ||
    */
    function render($layout)
    {
        return view($layout);
    }

    /*
    *   FUNCTION NAME: || ENV                                                       ||
    *   FUNCTION:      || Accepts key name and returns value from the '.env' file   ||
    *   USAGE:         || env('KEY_NAME');                                          || 
    *   NOTE:          || Make sure each key takes a new line in the env folder     ||
    */
    function env($key) 
    {
        $file = fopen($_SERVER['DOCUMENT_ROOT'] . '/.env', 'r');
        while(!feof($file)) {
            $line = fgets($file);
            if(preg_match('/' .$key . '=/', $line)) {
                $value = preg_replace('/' .$key . '=/', '', $line, 1);
                return $value;
            }   
        }
        return;
    }

    /*
    *   FUNCTION NAME: || ROUTE                                                         ||
    *   FUNCTION:      || Returns the user defined callback based on the requested uri  ||
    *   USAGE:         || route('/', function() { return 'Hello'; });                   || 
    *   NOTE:          || Make sure each key takes a new line in the env folder         ||
    */
    function route($request, $callback)
    {
        $cnt = 0;
        if($_SERVER['REQUEST_URI'] === $request)
        {
            call_user_func($callback);
            exit;
        }
        else
        {
            get_route_param($request, $cnt, $callback);
        }
        return;
    }

    


    /*                              <<< NOTE >>>
        THE BELOW FUNCTIONS ARE BOOTSTRAPPING INTO SOME OF THE ABOVE FUNCTIONS
        PLEASE DO NOT TERMPER WITH THEM, BECAUSE IT MIGHT BREAK THE FRAMEWORK FUCTIONS.
    */

    function get_route_param($request, $cnt, $callback)
    {
        foreach(preg_split('/\//', $request) as $param)
        {
            $param_name = str_replace(':', '', $param);
            if(preg_match('/:'.$param_name.'*/', $param))
            {
                foreach(preg_split('/\//', $_SERVER['REQUEST_URI']) as $key => $value)
                {
                    $req = preg_replace('/:'.$param_name.'/', $value, $request);
                    if($_SERVER['REQUEST_URI'] === $req)
                    {
                        if($key === $cnt)
                        {
                            call_user_func($callback, $value);
                            exit;
                        }
                    }
                }
            }
            $cnt++;
        }
    }