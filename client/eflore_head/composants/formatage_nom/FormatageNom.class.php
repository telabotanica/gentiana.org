<?php

class FormatageNom extends aComposant {
	
	private $nom;
	private $type;
	
	public function __construct()
	{
		$this->setType(EfloreNom::FORMAT_SIMPLE);
		parent::__construct();
	}
	
	public function setNom($n)
	{
		$this->nom = $n;
	}
	
	public function setType($t)
	{
		$this->type = $t;
	}
	
	public function executerFormater($nom = array(), $type = '')
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$aso_donnees = array();

		// Gestion des paramêtres
		if (!empty($nom)) {
			$this->nom = $nom;
		}
		if (!empty($type) && $type != EfloreNom::FORMAT_SIMPLE) {
			$this->type = $type;
		}
				
		// Nous enregistrons les infos du noms pour l'affichage
		$Nom = new EfloreNom();
		$aso_donnees['nom_structure'] = $Nom->retournerTabloNomStructure($this->nom);
		$aso_donnees['nom_complement'] = $Nom->retournerTabloNomComplement($this->nom, $this->type);
		
		if ($this->type == EfloreNom::FORMAT_COMPLET_CODE) {
			// Nous chargeons le squelette du noms latin spécifique pour le js
			$this->getRegistre()->set('cps_squelette_fichier', 'nom_latin_pliage');
			$aso_donnees['code'] = rand();
		} else {
			$this->getRegistre()->set('cps_squelette_fichier', 'nom_latin');
		}
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Stockage des données
		//$this->setDebogage($aso_donnees);		
		$this->getRegistre()->set('cps_squelette_donnees', $aso_donnees);
	}
	
}
?>