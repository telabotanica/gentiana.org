<?php

class HttpRequete {
	
	/*** Attributs : ***/
	
	private $entete_parametre = NULL;
	
	private $entete_generale = NULL;
	
	private $entete_requete = NULL;
	
	private $entite = NULL;
	
	/*** Constructeurs : ***/
    
	function __construct($meta = null)
	{
		// Instanciation des paramêtres de l'entête
		$this->setEnteteParametre(new HttpEnteteParametreRequete($meta));
		// Instanciation de l'entête générale
		$this->setEnteteGenerale(new HttpEnteteGenerale($meta));
		// Instanciation de l'entête de la requête
		$this->setEnteteRequete(new HttpEnteteRequete($meta));
		// Instanciation du corps (= entité) de la requête
		$this->setEntite(new HttpEntite($meta));
	}
	
	/*** Accesseurs : ***/

	// Entête Paramêtre
	public function getEnteteParametre()
	{
		return $this->entete_parametre;
	}	
	public function setEnteteParametre( $ep )
	{
    	$this->entete_parametre = $ep;
	}
	
	// Entête Générale
	public function getEnteteGenerale()
  {
		return $this->entete_generale;
	}
	public function setEnteteGenerale( $eg )
  {
    	$this->entete_generale = $eg;
	}

	// Entête Requete
	public function getEnteteRequete()
  {
		return $this->entete_requete;
	}
	public function setEnteteRequete( $er )
  {
    	$this->entete_requete = $er;
	}
	
	// Entité
	public function getEntite()
  {
		return $this->entite;
	}
	public function setEntite( $entite )
  {
    	$this->entite = $entite;
	}

}
?>