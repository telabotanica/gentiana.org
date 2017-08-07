<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                            			    |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: Vernaculaire.class.php,v 1.4 2005-09-27 16:03:46 jp_milcent Exp $
/**
* eFlore : Classe Vernaculaire
*
* 
*
*@package eFlore
*@subpackage Vernaculaire
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.4 $ $Date: 2005-09-27 16:03:46 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class Vernaculaire extends AModele
{
	/*** Attributes : ***/
	private $intitule;
	private $soundex;

	// TODO : supprimer les attributs ci-dessous après modif recherche nom verna
	private $id_taxon;
	private $id_taxon_version_projet;
	private $langue_intitule;
	private $langue_abreviation;
	private $zone_geo_intitule;
	private $zone_geo_abreviation;
	// Fin de la suppression
		
	/*** Constructeur : ***/
	
	public function __construct( $donnees = array() )
	{
		
	}
	
	/*** Accesseurs : ***/
	
	// Intitulé
	/**
	 * Lit la valeur de l'attribut intitule.
	 *
	 * @return string
	 * @access public
	 */
	public function getIntitule( ) {
		return $this->intitule;
	}
	/**
	 * Définit la valeur de l'attribut intitule.
	 *
	 * @param string Contient l'intitule du nom vernaculaire.
	 * @return void
	 * @access public
	 */
	public function setIntitule( $i ) {
		$this->intitule = $i;
	}

	// Soundex
	/**
	 * Lit la valeur de l'attribut soundex.
	 *
	 * @return string
	 * @access public
	 */
	public function getSoundex( ) {
		return $this->soundex;
	}
	/**
	 * Définit la valeur de l'attribut soundex.
	 *
	 * @param string Contient la valeur soundex pour l'intitule du nom vernaculaire.
	 * @return void
	 * @access public
	 */
	public function setSoundex( $s ) {
		$this->soundex = $s;
	}

	// TODO : supprimer les attributs ci-dessous après modif recherche nom verna
	public function getIdTaxon( )
	{
		return (int)$this->id_taxon;
	}
	public function setIdTaxon( $id )
	{
		$this->id_taxon = $id;
	}
	
	public function getIdTaxonVersionProjet( )
	{
		return (int)$this->id_taxon_version_projet;
	}
	public function setIdTaxonVersionProjet( $id)
	{
		$this->id_taxon_version_projet = $id;
	}

	public function getLgIntitule( )
	{
		return $this->langue_intitule;
	}
	public function setLgIntitule( $intitule )
	{
		$this->langue_intitule = $intitule;
	}
	
	public function getLgAbreviation( )
	{
		return $this->langue_abreviation;
	}
	public function setLgAbreviation( $abreviation )
	{
		$this->langue_abreviation = $abreviation;
	}
	
	public function getZgIntitule( )
	{
		return $this->zone_geo_intitule;
	}
	public function setZgIntitule( $intitule )
	{
		$this->zone_geo_intitule = $intitule;
	}
	
	public function getZgAbreviation( )
	{
		return $this->zone_geo_abreviation;
	}
	public function setZgAbreviation( $abreviation )
	{
		$this->zone_geo_abreviation = $abreviation;
	}
	// Fin de la suppression
	
	/*** Méthodes : ***/
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Vernaculaire.class.php,v $
* Revision 1.4  2005-09-27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.3  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.2  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>