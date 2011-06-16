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
        return stripcslashes($_POST[$post_var]);
    }

    public function post_array($variables)
    {
        $post_vals = array();

        foreach($variables as $var)
        {
            $post_vals[$var] = stripcslashes($_POST[$var]);
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
    }
}