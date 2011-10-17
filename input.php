<?php
/**
 * core_input.php
 *
 * Functions to pull data from POST and GET super globals
 *
 * @author Sean McGary <sean@seanmcgary.com>
 */
class core_input
{
    public function __construct()
    {

    }

    public function post($post_var)
    {

        if(array_key_exists($post_var, $_POST))
        {
            return htmlentities(stripcslashes($_POST[$post_var]));
        }
        else
        {
            return null;
        }
    }

    public function post_array($variables)
    {
        $post_vals = array();

        foreach($variables as $var)
        {
            if(array_key_exists($var, $_POST))
            {
                $post_vals[$var] = htmlentities(stripcslashes($_POST[$var]));
            }
            else
            {
                $post_vals[$var] = null;
            }

        }

        return $post_vals;
    }

    public function get($get_var)
    {
        return $_GET[$get_var];
    }

    public function get_array($variables)
    {
        $get_vals = array();

        foreach($variables as $var)
        {
            $get_vals[$var] = $_GET[$var];
        }

        return $get_vals;
    }
}