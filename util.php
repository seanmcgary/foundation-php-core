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