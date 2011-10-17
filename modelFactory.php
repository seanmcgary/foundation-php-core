<?php
/**
 * @author Sean McGary <sean@seanmcgary.com>
 */
class core_modelFactory
{
    public static $models;

    public static function get_inst($model_class, $alias = '', $params = array())
    {
        if(self::$models === NULL)
        {
            self::$models = array();

        }

        $exists = false;
        $exists_key = null;

        foreach(self::$models as $key => $val)
        {
            if($key == $model_class || $key == $alias || get_class($val) == $model_class)
            {
                $exists = true;
                $exists_key = $key;
            }
        }

        if($exists == false)
        {
            if($alias == '')
            {
                $alias = $model_class;
            }
            
            $class =& instantiate_class(new $model_class($params));
            self::$models[$alias] = $class;

            $exists_key = $alias;
        }
        
        return self::$models[$exists_key];
    }

    function &instantiate_class(&$class_object)
    {
        return $class_object;
    }

    public static function get_all_instances()
    {
        return self::$models;
    }
}