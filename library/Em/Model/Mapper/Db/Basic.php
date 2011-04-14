<?php	

class Em_Model_Mapper_Db_Basic extends Em_Model_Mapper_Db_Abstract
{
	/* 
	* Basic save function for a model 
	* @return Em_Model_Abstract
	*/
	public function save($model) 
	{
		if(!($model instanceof $this->_basemodel))
		{
			throw new Exception("Model needs to be of type Em_Model_Abstract");
		}
		$data = $model->getData();
		if ($model->id < 0) {
			$id = $this->getDao()->insert($data);
			$model->id($id);
			$model->setMapper(this);
		} else {
			$where = $this->getDao()->getAdapter()->quoteInto('id = ?', $model->id());
			$this->getDao()->update($data, $where);
		}
		return $model;
	}
	
	/* 
	* Basic find by id function for a model 
	* @return Em_Model_Abstract
	*/
    public function find($id, $model = null) {
		$result = null;
		$rows = $this->getDao()->find($id);
		if (0 !== count($rows)) {
			$row = $rows->current()->toArray();
			if (!($model instanceof $this->_basemodel)) 
			{
				$model = new $this->_basemodel();
			}
			$model->setData($row);
			$model->setMapper(this);
			$result = $model;
		}
		return $result;
	}
	
	/* Convert a rowset into an array of models 
	*  @return array
	*/
	protected function toModelArray(Zend_Db_Table_Rowset_Abstract $rowset, $model = null) {
		$result = array();
		foreach ($rowset as $row) {
			$row = $row->toArray();
			if (!($model instanceof $this->_basemodel)) 
			{
				$model = new $this->_basemodel();
			}
			$model->setData($row);
			$model->setMapper($this);
			$result[] = $model;
		}
		return $result;
	}
}
?>