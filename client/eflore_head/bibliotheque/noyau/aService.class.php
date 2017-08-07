<?php
abstract class aService {
	private $arguments = null;
	
	public function __construct($arguments)
	{
		$this->arguments = $arguments;
	}
    
	public function getArguments($a = null)
	{
		if (is_null($a)) {
			return $this->arguments;
		} else {
			if (isset($this->arguments[$a])) {
				return $this->arguments[$a];
			} else {
				return false;
			}
		}
	}
}
?>