<?php

class HttpReponse {
	
	/*** Attributs : ***/
	
	private $entete_parametre = NULL;
	
	private $entete_generale = NULL;
	
	private $entete_reponse = NULL;
	
	private $entite = NULL;
    
	/*** Constructeurs : ***/
    
	function __construct($meta = null)
	{
		// Instanciation des paramêtres de l'entête
		$this->setEnteteParametre(new HttpEnteteParametreReponse($meta));
		// Instanciation de l'entête générale
		$this->setEnteteGenerale(new HttpEnteteGenerale($meta));
		// Instanciation de l'entête de la reponse
		$this->setEnteteReponse(new HttpEnteteReponse);
		// Instanciation du corps (= entité) de la requête
		$this->setEntite(new HttpEntite);
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

	// Entête Reponse
	public function getEnteteReponse()
	{
		return $this->entete_reponse;
	}
	public function setEnteteReponse( $er )
	{
    	$this->entete_reponse = $er;
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
	
	/*** Méthodes : ***/
	
	public function genererReponse( )
	{
    	$this->getEnteteParametre()->genererEntete();
    	$this->getEnteteGenerale()->genererEntete();
    	$this->getEnteteReponse()->genererEntete();
    	$this->getEntite()->genererEntite();
	}
	
}
?>