<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */

function &load_class($class_name, $params = array())
{
    // keep track of the loaded class instances
    static $_classes = array();

    // get the long name of the core class to load
    //$long_class_name = 'lib_core_'.$class_name;

    // if its already set, return it
    if(isset($_classes[$class_name]))
    {
        return $_classes[$class_name];
    }

    // call is_loaded to keep track of a list of classes
    is_loaded($class_name);

    // create instance of class
    $_classes[$class_name] =& instantiate_class(new $class_name($params));

    // return the instance of it
    return $_classes[$class_name];
}

/**
 * Returns a new class object by reference. Makes it play nice with PHP5.3
 * @param  $class_object
 * @return
 */
function &instantiate_class(&$class_object)
{
    return $class_object;
}

/**
 * Keep a list of classes that we're loading
 * 
 * @param string $class
 * @return
 */
function is_loaded($class = '')
{
    static $_is_loaded = array();

    if ($class != '')
    {
        $_is_loaded[$class] = $class;
    }

    return $_is_loaded;
}

 
