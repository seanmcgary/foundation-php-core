<?php
/**
 * model.php
 *
 * base model that all models must extend
 * 
 * @author Sean McGary <sean@seanmcgary.com>
 */
class core_model
{
    public $id;
    public function __construct()
    {
        $instances = core_loadFactory::get_all_instances();
        //printr($instances);
        foreach($instances as $inst)
        {

            $name = get_class($inst);
            //echo $name.'<br>';
            $this->{$name} = $inst;


        }
    }

    public function set_property($class, $name = '')
    {
        if($name == '')
        {
            $name = $class;
        }

        $this->{$name} = $class;
    }
}
 
