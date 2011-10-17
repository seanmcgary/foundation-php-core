<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class core_coreCommon {

	private static $instance;

	public function __construct()
	{
		self::$instance =& $this;
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
}

function &get_instance()
{
	return core_coreCommon::get_instance();
}