<?php

abstract class Em_Model_Mapper_Db_Abstract
{
	
    private $_dao;
    protected $_basemodel = "Em_Model_Abstract";
	
	public function __construct(Zend_Db_Table_Abstract $dao) {
		$this->setDao($dao);
	}
	
	/*
	* Set the DAO for the mapper
	*/
	public function setDao($dao) {
		if (is_string($dao)) {
			$dao = new $dao();
		}
		if (!($dao instanceof Zend_Db_Table_Abstract)) {
			throw new InvalidArgumentException('DAO is not correct type');
		}
		$this->_dao = $dao;
	}
	
	/*
	* Get the DAO of the mapper
	*/
	public function getDao() {
		return $this->_dao;
	}
	
	/* Creates a model and executes necessary functions */
	public function create($model = null)
	{
		if(!($model instanceof $this->_basemodel))
		{
			$model = new $this->_basemodel();
		}
		$model->setMapper(this);
	}
	
	/*
	* Every mapper needs a save function
	*/
	abstract public function save($model);
	
	/*
	* Every mapper needs a find function
	*/
	abstract public function find($id, $model = null);
	
	/*
	* Delete a row by id
	*/
	public function delete($id) {
		$select = $this->getDao()->select();
		$select->where('id = ?', $id);
		$row = $this->getDao()->fetchRow($select);
		if (null !== $row) {
			return $row->delete();
		} else {
			return 0;
		}
	}
	
	/*
	* Fetch all the models as an array
	*/
	public function fetchAll() {
		return $this->toModelArray($this->getDao()->fetchAll());
	}
	
	/*
	* Fetch the models with a where clausule
	*/
	public function fetchFiltered($where = null, $order = null, $count = null, $offset = null) {
		return $this->toModelArray($this->getDao()->fetchAll($where, $order, $count, $offset));
	}
	
	/*
	* For the above standing functions we need a function who can convert a rowset to an array of models
	*/
	abstract protected function toModelArray(Zend_Db_Table_Rowset_Abstract $rowset);

}
?>