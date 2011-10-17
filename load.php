<?php
/**
 * load.php
 *
 * Loader class loads specified objects, databases, views, etc
 *
 * @author Sean McGary <sean@seanmcgary.com>
 */

class core_load
{
    public function __construct()
    {

    }

    /**
     * Load the specified view, passing data to it.
     *
     * @param  (string)$view_name   The view file to load
     * @param array $params         Array of params to pass as variables to the view
     * @param bool $return          If set to true, capture the view in the output butffer and return instead of displaying
     *                              on the screen.
     * @return void
     */
    public function view($view_name, $params = array(), $return = false)
    {

        if($params == '')
        {
            $params = array();
        }

        // start the buffer
        ob_start();

        // take the params array and create some variables
        extract($params);

        // include the view file
        include(LIBPATH.'views/'.$view_name.'.php');

        // if return, dont flush the buffer to the screen. Assign it to a variable and return
        if($return == true)
        {
            $var = ob_get_contents();
            ob_clean();
            return $var;
        }
        else
        {
            ob_end_flush();
        }
    }

}
