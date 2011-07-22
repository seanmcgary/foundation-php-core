<?php
/**
 * util.php
 *
 * Miscellaneous helper and utility functions
 *
 * @author Sean McGary <sean@seanmcgary.com>
 */

/**
 * Wrapper for print_r. Same as print_r, but pre-formatted
 * @param string $url
 * @return string
 */
function printr($input)
{
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}

/**
 * Return a formatted site url
 * @param string $url   URL to format
 * @return string       Formatted URL
 */
function site_url($url = '')
{
    return BASEURL.$url;
}

/**
 * Format unix timestamp to a readable format
 * @param  $unix_time       Unix timestamp to format
 * @return string           The formatted date in string form
 */
function format_date($unix_time)
{
    $format = 'F j, Y @ g:i a';
    return date($format, $unix_time);
}

/**
 * Redirect to a specified URL
 *
 * @param bool $url     If the $url parameter is false, just redirect to the root site_url
 */
function redirect($url = false)
{
    if($url == false)
    {
        $url = site_url();
    }

    header('Location: '.$url);
}

function is_xhr()
{
    if(array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        return true;
    }
    else
    {
        return false;
    }
}

function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE)
{
    if ($fp = @opendir($source_dir))
    {
        $filedata	= array();
        $new_depth	= $directory_depth - 1;
        $source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        while (FALSE !== ($file = readdir($fp)))
        {
            // Remove '.', '..', and hidden files [optional]
            if ( ! trim($file, '.') OR ($hidden == FALSE && $file[0] == '.'))
            {
                continue;
            }

            if (($directory_depth < 1 OR $new_depth > 0) && @is_dir($source_dir.$file))
            {
                $filedata[$file] = directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
            }
            else
            {
                $filedata[] = $file;
            }
        }

        closedir($fp);
        return $filedata;
    }

    return FALSE;
}

/**
 * Given the URI segments, find the controller and the function by checking to see if the
 * class file exists;
 *
 * @param  $uri
 * @param  $routes
 * @return array
 */
function get_controller_and_function(&$uri, $routes)
{
    //printr($uri);

    $ret_val = array();

    $controller_path = 'lib_controllers';

    for($i = 0; $i < sizeof($uri); $i++)
    {


        $controller_path .= '_'.$uri[$i];
        //echo $controller_path.'<br>';

        if(file_exists(str_replace('_', '/', $controller_path).'.php'))
        {
            $ret_val[0] = $controller_path;


            if(($i + 1) <= sizeof($uri) - 1)
            {
                $ret_val[1] = $uri[$i + 1];

            }
            else
            {
                $ret_val[1] = $routes['function'];
                $uri[$i + 1] = $routes['function'];
            }
        }
    }

    //printr($ret_val);

    return $ret_val;
}