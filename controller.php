<?php
/**
 * controller.php
 *
 * Base controller that all controllers must inherit.
 *
 * @author Sean McGary <sean@seanmcgary.com>
 */

class core_controller
{
    private $model_list;

    public function __construct()
    {
        $this->model_list = array();
        //printr(core_loadFactory::get_all_instances());
        $instances = core_loadFactory::get_all_instances();
        //printr($instances);
        foreach($instances as $key => $inst)
        {

            $name = get_class($inst);
            //echo $name.'<br>';
            $this->{$key} = $inst;

            
        }
    }


    public function load_model($model_name, $alias = '')
    {
        if($alias == '')
        {
            $alias = $model_name;
        }
        
        $this->{$alias} = core_modelFactory::get_inst($model_name, $alias);
        $this->model_list[] = $alias;

        $this->copy_models();
    }


    public function copy_models()
    {

        //loop over all the models to copy over model instances not already existing
        foreach($this->model_list as $curr_model)
        {

            //loop over the models to copy to the model
            foreach($this->model_list as $model)
            {

                if(!property_exists($this->{$curr_model}, $model) && $model != $curr_model)
                {
                    //echo $model.'<br>';
                    $this->{$curr_model}->set_property( new $this->{$model}, $model);
                }
            }

        }
    }
}
