<?php
/**
 * uri.php
 *
 * URI class for manipulating and getting information on the URI segment
 *
 * @author Sean McGary <sean@seanmcgary.com>
 */

class core_uri
{
    public $uri_segments;
    public function __construct($uri_segment)
    {
        $this->uri_segments = $uri_segment;
    }

    /**
     * Set the URI
     *
     * @param  $uri_segment     The URI to set
     * @return void
     */
    public function set_uri_seg($uri_segment)
    {
        $this->uri_segments = $uri_segment;
    }

    /**
     * Get the total number of segments
     * @return int      Total number of segments
     */
    public function total_segments()
    {
        return sizeof($this->uri_segments);
    }

    /**
     * Return the URI in an array
     * @return
     */
    public function segment_array()
    {
        return $this->uri_segments;
    }

    /**
     * Return the requested URI segment
     * @param  $seg_num         Number of the URI segment requested in the array
     * @return
     */
    public function segment($seg_num)
    {
        return $this->uri_segments[$seg_num];
    }
}
