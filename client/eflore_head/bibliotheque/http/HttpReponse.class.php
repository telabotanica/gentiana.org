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
		// Instanciation des param�tres de l'ent�te
		$this->setEnteteParametre(new HttpEnteteParametreReponse($meta));
		// Instanciation de l'ent�te g�n�rale
		$this->setEnteteGenerale(new HttpEnteteGenerale($meta));
		// Instanciation de l'ent�te de la reponse
		$this->setEnteteReponse(new HttpEnteteReponse);
		// Instanciation du corps (= entit�) de la requ�te
		$this->setEntite(new HttpEntite);
	}
	
	/*** Accesseurs : ***/

	// Ent�te Param�tre
	public function getEnteteParametre()
	{
		return $this->entete_parametre;
	}	
	public function setEnteteParametre( $ep )
	{
    	$this->entete_parametre = $ep;
	}
	
	// Ent�te G�n�rale
	public function getEnteteGenerale()
	{
		return $this->entete_generale;
	}
	public function setEnteteGenerale( $eg )
	{
    	$this->entete_generale = $eg;
	}

	// Ent�te Reponse
	public function getEnteteReponse()
	{
		return $this->entete_reponse;
	}
	public function setEnteteReponse( $er )
	{
    	$this->entete_reponse = $er;
	}
	
	// Entit�
	public function getEntite()
	{
		return $this->entite;
	}
	public function setEntite( $entite )
	{
    	$this->entite = $entite;
	}
	
	/*** M�thodes : ***/
	
	public function genererReponse( )
	{
    	$this->getEnteteParametre()->genererEntete();
    	$this->getEnteteGenerale()->genererEntete();
    	$this->getEnteteReponse()->genererEntete();
    	$this->getEntite()->genererEntite();
	}
	
}
?>