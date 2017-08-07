<?php

abstract class aAction {
	private $registre;
	
	public function __construct($Registre)
	{
		// Ajout du registre à l'objet aAction
		$this->registre = $Registre;
		// TODO : améliorer ce système. Utiliser une classe Parametres à passer à l'objet Action par l'objet Service
		$fichier_ini = EF_CHEMIN_CONFIG.strtolower($_SESSION['cpr']).'.ini';
		$this->parserFichierIni($fichier_ini);
	}
	
	public function getRegistre()
	{
		return $this->registre;
	}
	
	public function parserFichierIni($fichier_ini)
	{
    	if (file_exists($fichier_ini)) {
			$aso_ini = parse_ini_file($fichier_ini);
	    	foreach ($aso_ini as $cle => $val) {
	    		if (preg_match('/^php:(.+)$/', $val, $correspondances)) {
	    			eval('$this->getRegistre()->set($cle, '.$correspondances[1].');');
	    		} else if (preg_match('/^php-static:(.+)$/', $val, $correspondances)) {
	    			eval('$this->getRegistre()::$'.$cle.' = '.$correspondances[1].';');
	    		} else {
	    			$this->getRegistre()->set($cle, $val);
	    		}
	    	}
    	} else {
    		return false;
    	}
	}
}
?>