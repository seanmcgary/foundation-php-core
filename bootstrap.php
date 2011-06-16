<?php
/**
 * bootstrap.php
 *
 * "Bootstrap" the app by setting paths, autoloading, loading configs, parsing URI, and loading controller
 *
 * @author Sean McGary <sean@seanmcgary.com>
 */

// set the include paths to everything inside lib

set_include_path(get_include_path() . ':'.BASEPATH.'core');
set_include_path(get_include_path() . ':'.BASEPATH.'models');
set_include_path(get_include_path() . ':'.BASEPATH.'controllers');
set_include_path(get_include_path() . ':'.BASEPATH.'views');
set_include_path(get_include_path() . ':'.BASEPATH.'config');
set_include_path(get_include_path() . ':'.BASEPATH.'libraries');

function __autoload($class_name)
{
    $class = str_replace('_', '/', $class_name);
    require_once($class.'.php');
}

// load the basic configs
require_once('config.php');
require_once('routes.php');

if($config['index_page'] != '')
{
    define('BASEURL', $config['base_url'].$config['url_extension'].$config['index_page']);
}
else
{
    define('BASEURL', $config['base_url'].$config['url_extension']);
}


// get the URI segment
$URI = $_SERVER['REQUEST_URI'];

// remove the domain extension
if($config['url_extension'] != '')
{
    $URI = str_replace($config['url_extension'], '', $URI);
}

// remove un-needed index.php from URI
$URI = str_replace('index.php', '', $URI);

// remove leading and trailing slashes
$URI = trim($URI, '/');

// if the length of the URI is 0, load the default controller
// and default function
if(strlen($URI) == 0)
{
    $URI .= $routes['default'];
}

// break up URI into segments
$URI_SEG = explode('/', $URI);

// if we're missing the deafult function, add it only if there arent any other parameters
if(sizeof($URI_SEG) < 2)
{
    $URI_SEG[1] = $routes['function'];
}

// load the utility functions
require_once('util.php');

// load some common functions
require_once('common.php');

// Instantiate some controller level classes.
// These will be loaded to the core controller in the constructor
$URI_INST = core_loadFactory::get_inst('core_uri', 'uri', $URI_SEG);
$LOAD = core_loadFactory::get_inst('core_load', 'load');

/**
 * $URI structure
 * 0 => controller
 * 1 => function
 * 2 => param1
 * 3 => param2
 * n => param n
 */
// prepend the controller name with the path
$controller_name = 'lib_controllers_'.$URI_SEG[0];
$function_name = $URI_SEG[1];

// dynamically load the controller
//$controller_inst = new $controller_name();
$controller_inst = core_loadFactory::get_inst($controller_name);

// if the size is gte 2, check to see that the function exists
if(sizeof($URI_SEG) >= 2)
{
    // if the function exists, call it
    if(method_exists($controller_inst, $function_name))
    {
        // call the function in the controller and pass the params to it
        call_user_func_array(array(&$controller_inst, $function_name), array_slice($URI_SEG, 2));
    }
    else
    {
        // check to see if they are remapping
        if(method_exists($controller_inst, '_remap'))
        {
            $function_name = '_remap';
            call_user_func_array(array(&$controller_inst, $function_name), array_slice($URI_SEG, 2));
        }
        else
        {
            // if they arent, just tell them the function doesnt exist
            echo 'function '.$function_name.' doesnt exist';
        }

    }
}
else
{
    // TODO - handle URI count error
    echo 'Something happened that shouldnt have...';
}