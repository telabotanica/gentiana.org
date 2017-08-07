<?php

class NomFormatage {
	private $Nom;
	
	function __construct(NomDeprecie $Nom)
	{
		$this->Nom = $Nom;
	}
	
	function formaterNom($type = NomDeprecie::FORMAT_SIMPLE, $format = 'html')
	{
		$action = new NomFormatageAction($this->Nom, $type);
		$vue = new NomFormatageVue($format);
		return $vue->executer($action->executer());
	}

}
?>