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
function format_date_($unix_time)
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

function get_uri()
{
    
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

function printr2($string)
{
        echo "<pre>";
        $out = print_r($string, true);
        $out = preg_replace('/([ \t]*)(\[[^\]]+\][ \t]*\=\>[ \t]*[a-z0-9 \t_]+)\n[ \t]*\(/iUe',"'\\1<a href=\"javascript:toggleDisplay(\''.(\$id = substr(md5(rand().'\\0'), 0, 7)).'\');\">\\2</a><div id=\"'.\$id.'\" style=\"display: none;\">'", $out);
        $out = preg_replace('/^\s*\)\s*$/m', '</div>', $out);
        echo '<script language="Javascript">function toggleDisplay(id) { document.getElementById(id).style.display = (document.getElementById(id).style.display == "block") ? "none" : "block"; }</script>'."\n$out";
            echo "</pre>";
            die();
}

function format_date($unix_time)
{
    $format = 'm/d/y G:ia';
    return date($format, $unix_time);
}

function format_appt_time($unix_time)
{
    $format = 'g:iA';
    return date($format, $unix_time);
}

/*function date($unix_time)
{
    $format = 'm/d/Y';
    return date($format, $unix_time);
}*/

function get_age($dob)
{
    //printr($dob);
    list($BirthMonth,$BirthDay,$BirthYear) = explode("/", $dob);
    $YearDiff = date("Y") - $BirthYear;
    $MonthDiff = date("m") - $BirthMonth;
    $DayDiff = date("d") - $BirthDay;
    if ($DayDiff < 0 || $MonthDiff < 0)
      $YearDiff--;
        return $YearDiff;
}

function get_request_array($key)
{
        //$results =  "RU ".	$_SERVER['REQUEST_URI'] . "QS ". $_SERVER['QUERY_STRING'] ."end";
        $getString = str_replace($_SERVER['QUERY_STRING'] . '?', "", $_SERVER['REQUEST_URI']);
        parse_str($getString, $getArray);

        return $getArray[$key];
}

function get_display($field, $stored_value)
{
    if ($stored_value[$field] == "") return "";

    $field_def = get_field_details($field);

    foreach ($field_def["values"] as $value) {
        if ($value['value'] == $stored_value[$field])
            return $value['display'];
    }
    return "ERROR: DISPLAY_STRING_NOT_FOUND";
}

function get_field_details($field_id)
{
    $form_model = core_modelFactory::get_inst('lib_models_formModel', 'form_model');

    $field = $form_model->get_element_by_id($field_id);

    return $field;
    //printr($field);
}

function get_username()
{
    if (isset($_SESSION['loggedIn']))
    {
        return $_SESSION['loggedIn']['staff_data']['username'];
    }
    else
    {
        //not sure what to return, returning empty string
        return "";
    }
}

//builds quick title string based on $apt['patient'] template
function get_patient_title($apt)
{
    return $apt['patient']['patient_data']['last_name'] .", "
        . $apt['patient']['patient_data']['first_name'].' '
        . '(' . get_age($apt['patient']['patient_data']['date_of_birth'])
        . substr(get_display('gender', $apt['patient']['patient_data']),0,1) . ') '
        . $apt['patient']['patient_data']['phone_numbers'][0]['phone_number'];
}

function format_get_string($params)
{
    $params = explode('&', $params);

    $ret_param = array();

    foreach($params as $p)
    {
        $param = explode('=', $p);

        $ret_param[$param[0]] = $param[1];
    }

    return $ret_param;
}