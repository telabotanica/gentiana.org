<?php

class Registre {

	private $aso_stock = array();
	private static $registre;

	public function __construct()
	{
		
	}

	public static function getInstance()
	{
		if (self::$registre instanceof Registre) {
			return self::$registre;
		}
		self::$registre = new Registre;
	    return self::$registre;
	}
	
	function set($intitule, $objet)
	{
		if (is_array($objet) && isset($this->aso_stock[$intitule])) {
			$this->aso_stock[$intitule] = array_merge((array)$this->aso_stock[$intitule], (array)$objet);
			//$message = "Le tableau $intitule présent dans le registre a été fusionné avec un nouveau tableau de même intitulé !";
			//trigger_error($message, E_USER_WARNING);
		} else {
			$this->aso_stock[$intitule] = $objet;
		}
	}

	function get($intitule)
	{
		if (isset($this->aso_stock[$intitule])) {
			return $this->aso_stock[$intitule];
		}
		return null;
	}
	
	function detruire($intitule)
	{
		if (isset($this->aso_stock[$intitule])) {
			unset($this->aso_stock[$intitule]);
		}
	}
		
	public function etrePresent($intitule)
	{
		if(isset($this->aso_stock[$intitule])){
			return true;
		}
		return false;
	}
}
?>