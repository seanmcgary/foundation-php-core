<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class core_loadFactory
{
    public static $instances;
    
    public static function get_inst($object_class, $alias = '', $params = array())
    {
        if(self::$instances === NULL)
        {
            self::$instances = array();
        }

        $exists = false;
        $exists_key = null;

        foreach(self::$instances as $key => $val)
        {
            if($key == $object_class || $key == $alias || get_class($val) == $object_class)
            {
                $exists = true;
                $exists_key = $key;
            }
        }

        if($exists == false)
        {
            if($alias == '')
            {
                $alias = $object_class;
            }
            
            $class =& instantiate_class(new $object_class($params));
            self::$instances[$alias] = $class;

            $exists_key = $alias;
        }
        
        return self::$instances[$exists_key];
    }

    function &instantiate_class(&$class_object)
    {
        return $class_object;
    }

    public static function get_all_instances()
    {
        return self::$instances;
    }
}