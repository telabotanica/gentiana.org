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
		// Instanciation des param�tres de l'ent�te
		$this->setEnteteParametre(new HttpEnteteParametreRequete($meta));
		// Instanciation de l'ent�te g�n�rale
		$this->setEnteteGenerale(new HttpEnteteGenerale($meta));
		// Instanciation de l'ent�te de la requ�te
		$this->setEnteteRequete(new HttpEnteteRequete($meta));
		// Instanciation du corps (= entit�) de la requ�te
		$this->setEntite(new HttpEntite($meta));
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

	// Ent�te Requete
	public function getEnteteRequete()
  {
		return $this->entete_requete;
	}
	public function setEnteteRequete( $er )
  {
    	$this->entete_requete = $er;
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

}
?>