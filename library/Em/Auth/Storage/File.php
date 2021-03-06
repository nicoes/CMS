<?php
class EM_Auth_Storage_File implements Zend_Auth_Storage_Interface
{
	/**
	 * De identity van een gebruiker
	 * @var mixed 
	 */
	protected $_contents;
	/**
	 * De naam en pad van het bestand 
	 * @var string $_file
	 */
	protected $_file;
	
	public function __construct($path)
	{
		// we gebruiker het session id om een unieke bestandnaam te genereren
		$this->_file = $path.Zend_Session::getId().'.id';
		$this->_contents = $this->read();
	}

	/**
	 * bestaat de identity
	 * @return mixed
	 */
	public function isEmpty()
	{
		return empty($this->_contents);
	}

	/**
	 * lees de gegevens uit het bestand
	 * @return mixed De identity
	 * @throws Zend_Auth_Storage_Exception
	 */
	public function read()
	{
		$this->_contents = null;
		if (file_exists($this->_file)) {
			if (false !== ($fp = fopen($this->_file, 'r'))) {
				$contents = unserialize(base64_decode(fread($fp, 1024)));
				$this->_contents = $contents;
			} else {
				throw new Zend_Auth_Storage_Exception('Cannot open file');
			}
		}
		return $this->_contents;
	}

	/**
	 * sla de gegevens op in het bestand
	 * @param mixed $contents
	 */
	public function write($contents)
	{
		if (false !== ($fp = fopen($this->_file, 'w'))) {
			$secure = base64_encode(serialize($contents));
			fwrite($fp, $secure);
			$this->_contents = $contents;
		} else {
			throw new Zend_Auth_Storage_Exception('Cannot open file');
		}
	}

	/**
	 * maakt de gegevens leeg en verwijder het bestand
	 */
	public function clear()
	{
		if (file_exists($this->_file)) {
			unlink($this->_file);
		}
		$this->_contents = null;
	}
}
?>