<?php

class Em_Model_Abstract
{
	protected $_mapper;
	
    /*
    * Magic getter method for getting properties
    * @return string
    */
    public function __get($key)
    {
    	$accessor = "get".ucfirst(strtolower($key));
    	
        if(!method_exists(this, $accessor))
        {
        	if(property_exists($this, strtolower($key)))
        	{
        		return $this->$key;
        	} else
	        {
	            throw new Exception("Invalid property '".$key."'");
	        } 
        }
        return $this->$accessor();
    }
    
    /*
    * Magic setter method for setting properties
    * @return
    */
    public function __set($key, $value)
    {
    	$accessor = "get".ucfirst(strtolower($key));
    	
        if(!method_exists(this, $accessor))
        {
        	if(property_exists($this, strtolower($key)))
        	{
        		$this->$key = $value;
        	} else
	        {
	            throw new Exception("Invalid property '".$key."'");
	        } 
        }
        $this->$accessor($value);
    }
    
    /*
    * Get all model data at once
    * @return array
    */
    public function getData()
    {
    	$data = array();
    	foreach(get_class_vars(get_class(this)) as $key => $value)
    	{
    		if(substr($key,1,1) != "_")
    		{
    			$data[$key] = $value;
    		}
    	}
    	return $data;
    }
    
	/*
    * Set all model data at once
    * @return void
    */
    public function setData($data)
    {
    	if(!is_array($data))
    	{
    		throw new Exception("Data is not of type Array");
    	}
    	foreach(get_class_vars(get_class($this)) as $key => $value)
    	{
    		if(array_key_exists($key, $data))
    		{
    			$this->$key = $data[$key];
    		}
    	}
    }
    
    
    
    public function setMapper($mapper)
    {
    	$this->_mapper = $mapper;
    }
    
    public function getMapper()
    {
    	return $this->_mapper;
    }
    
    public function save() 
	{
		if($mapper = $this->getMapper())
		{
			return $mapper->save($this);
		} else
		{
			throw new Exception("No mapper set");
		}
	}

	public static function delete() 
	{
		if($mapper = $this->getMapper())
		{
			if(isset($this->_data["id"]))
			{
				return $mapper->delete($this->id);
			}
		} else
		{
			throw new Exception("No mapper set");
		}
	}
}

?>