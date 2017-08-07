<?php

abstract class aDaoXml {
	/*** Attributs: ***/

	/**
	* Le fichier contenant le XML.
	* @access private
	*/
	private $fichier_xml;
	
	/**
	* Le DOM contenant le XML propre au module Chorologie.
	* @access protected
	*/
	private static $dom_xml;
	
	/**
	* Requete XPATH demand�e.
	* @access private
	*/
	private $requete;
	
	/**
	* Permet de savoir si une requ�te retourne un r�sultat unique.
	* @access private
	*/
	private $resultat_unique;
	
	/*** Constructeurs : ***/
	
	/**
	* Constructeur du type de donn�es issu d'un fichier XML.
	*
	* @return object
	* @access public
	*/
	public function __construct($fichier_xml = null)
	{
		$this->setFichierXml($fichier_xml);
	}
	
	/*** Accesseurs : ***/
	
	// Fichier XML
	/**
	* Lit la valeur de l'attribut fichier XML.
	* 
	* @access public
	* @return string retourne le chemin et le nom du fichier.
	*/
	public function getFichierXml( )
	{
		return $this->fichier_xml;
	}
	/**
	* D�finit la valeur de l'attribut fichier XML.
	*
	* @param string le chemin et le nom du fichier XML.
	* @return void
	* @access public
	*/
	public function setFichierXml( $fichier_xml )
	{
		$this->fichier_xml = $fichier_xml;
	}

	// DOM XML
	/**
	* Lit la valeur de l'attribut DOM XML.
	* Utilise le motif de conception (=design pattern) Singleton.
	* 
	* @access public
	* @return string retourne le DOM XML.
	*/
	public static function getDomXml($fichier_xml)
	{
		if (!isset(self::$dom_xml)) {
			self::$dom_xml = new domDocument();
			if (file_exists($fichier_xml)) {
				self::$dom_xml->load($fichier_xml);
			} else {
				$xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";
				$xml .= '<eflore>'."\n";
				$xml .= '</eflore>'."\n";
				self::$dom_xml->loadXML($xml);
			}
		}
		return self::$dom_xml;
	}
	
	/**
	* D�finit la valeur de l'attribut dom.
	*
	* @param domDocument document DOM.
	* @return void
	* @access public
	*/
	public function setDomXml( $dom_xml )
	{
		self::$dom_xml = $dom_xml;
	}
	
	// Requete
	/**
	* Lit la valeur de l'attribut requete.
	*
	* @return string la requete.
	* @access public
	*/
	public function getRequete( )
	{
		return $this->requete;
	}
	/**
	* D�finit la valeur de l'attribut requete.
	*
	* @param string Contient une requete CRUD.
	* @return void
	* @access public
	*/
	public function setRequete( $requete )
	{
		$this->requete = $requete;
	}
	
	// Resultat Unique
	/**
	* Lit la valeur de l'attribut resultat_unique.
	*
	* @return boolean true si la requete doit renvoyer un r�sultat unique, sinon false.
	* @access public
	*/
	public function getResultatUnique( )
	{
		return $this->resultat_unique;
	}
	/**
	* D�finit la valeur de l'attribut resultat unique.
	*
	* @param boolean true si la requete doit renvoyer un r�sultat unique, sinon false.
	* @return void
	* @access public
	*/
	public function setResultatUnique( $ru )
	{
		$this->resultat_unique = $ru;
	}
	
	/*** M�thodes : ***/
	
	/**
	* Permet de consulter un type de donn�es.
	*
	* @return array
	* @access public
	*/
	public function consulter( $parametres )
	{
		$dom =& self::getDomXml($this->getFichierXml());
		$xpath = new domXPath($dom);
		if ($this->getResultatUnique()) {
			$aso_donnees = $xpath->query($this->getRequete())->item(0);
			return $this->instancierObjetModele($aso_donnees);
		} else {
			$aso_donnees = $xpath->query($this->getRequete());
			foreach ($aso_donnees as $donnees) {
				$tab_objets[] = $this->instancierObjetModele($donnees);	 
			}
			return $tab_objets;
		}
	}

	/**
	* Permet d'ajouter un type de donn�es.
	*
	* @param object l'objet contenant les infos � ajouter au fichier XML.
	* @return integer l'identifiant du nom ajout�.
	* @access public
	*/
	public function ajouter( $un_objet )
	{
		
	}

	/**
	* Permet de supprimer un type de donn�es.
	* 
	* @param mixed identifiant du type de donn�es � d�truire.
	* @return boolean true si les infos sont bien supprim�es, sinon false.
	* @access public
	*/
	public function supprimer( $id )
	{
		
	}

	/**
	* Permet de modifier un type de donn�es.
	*
	* @param mixed identifiant du type de donn�es � modifier.
	* @param object l'objet contenant les infos � remplacer dans la base de donn�e.
	* @return boolean true si les infos sont bien modifi�es, sinon false.
	* @access public
	*/
	public function modifier( $id, $un_objet )
	{
		
	}

	/**
	* Alloue les valeurs des champs aux bons attributs.
	*
	* @return object l'objet contenant les valeurs.
	* @access public
	*/
	//abstract public function instancierObjetModele();
	
}
?>