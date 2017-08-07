<?php

class FabriqueDaoXml extends aFabriqueDao {
	
	/*** Attributs: ***/
	
	private $fichier;
	
	/*** Constructeurs : ***/
	 
	/**
	* Constructeur du type de donn�es issu de la base de donn�es.
	*
	* @param string le chemin d'acc�s au fichier XML.
	* @return object
	* @access public
	*/
	public function __construct($fichier)
	{
		// Connexion � la base de donn�es
		$this->fichier = $fichier;
	}
	
	/*** M�thodes : ***/
	
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