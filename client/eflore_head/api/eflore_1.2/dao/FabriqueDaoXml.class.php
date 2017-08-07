<?php

class FabriqueDaoXml extends aFabriqueDao {
	
	/*** Attributs: ***/
	
	private $fichier;
	
	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de données issu de la base de données.
	*
	* @param string le chemin d'accès au fichier XML.
	* @return object
	* @access public
	*/
	public function __construct($fichier)
	{
		// Connexion à la base de données
		$this->fichier = $fichier;
	}
	
	/*** Méthodes : ***/
	
	public function getNomDao()
	{
		return new NomXmlDao($this->fichier);
	}
	
	public function getNomRangDao()
	{
		return new NomRangXmlDao($this->fichier);
	}
	
	public function getChorologieDonneeDao()
	{
		return new ChorologieDonneeXmlDao($this->fichier);
	}

	public function getChorologieInformationDao()
	{
		return new ChorologieInformationXmlDao($this->fichier);
	}
	
}
?>