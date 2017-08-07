<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                                         |
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
// CVS : $Id$
/**
* Classe Nom
*
* Description
*
*@package eFlore
*@subpackage modele
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class Nom extends aDonneesObjet
{
	/*** Constantes : ***/
	
	/** Constante définissant le nom de l'objet.*/
	const CLASSE_NOM = 'Nom';
	
	/*** Attributes : ***/
	private $nom_supra_generique;
	private $nom_genre;
	private $epithete_infra_generique;
	private $epithete_espece;
	private $epithete_infra_specifique;
	private $epithete_cultivar;
	private $intitule_groupe_cultivar;
	private $formule_hybridite;
	private $phrase_nom_non_nomme;
	
	/*** Constructeur : ***/
	
	/*** Accesseurs : ***/
	// Nom Supra Generique
	public function getNomSupraGenerique()
	{
		return $this->nom_supra_generique;
	}
	public function setNomSupraGenerique( $nsg )
	{
		$this->nom_supra_generique = $nsg;
		$this->setMetaAttributsUtilises('nom_supra_generique');
	}
	
	// Nom Genre
	public function getNomGenre()
	{
		return $this->nom_genre;
	}
	public function setNomGenre( $ng )
	{
		$this->nom_genre = $ng;
		$this->setMetaAttributsUtilises('nom_genre');
	}
	
	// Epithete Infra Generique
	public function getEpitheteInfraGenerique()
	{
		return $this->epithete_infra_generique;
	}
	public function setEpitheteInfraGenerique( $eig )
	{
		$this->epithete_infra_generique = $eig;
		$this->setMetaAttributsUtilises('epithete_infra_generique');
	}
	
	// Epithete Espece
	public function getEpitheteEspece()
	{
		return $this->epithete_espece;
	}
	public function setEpitheteEspece( $ee )
	{
		$this->epithete_espece = $ee;
		$this->setMetaAttributsUtilises('epithete_espece');
	}
	
	// Epithete Infra Specifique
	public function getEpitheteInfraSpecifique()
	{
		return $this->epithete_infra_specifique;
	}
	public function setEpitheteInfraSpecifique( $eis )
	{
		$this->epithete_infra_specifique = $eis;
		$this->setMetaAttributsUtilises('epithete_infra_specifique');
	}
	
	// Epithete Cultivar
	public function getEpitheteCultivar()
	{
		return $this->epithete_cultivar;
	}
	public function setEpitheteCultivar( $ec )
	{
		$this->epithete_cultivar = $ec;
		$this->setMetaAttributsUtilises('epithete_cultivar');
	}
	
	// Intitule Groupe Cultivar
	public function getIntituleGroupeCultivar()
	{
		return $this->intitule_groupe_cultivar;
	}
	public function setIntituleGroupeCultivar( $igc )
	{
		$this->intitule_groupe_cultivar = $igc;
		$this->setMetaAttributsUtilises('intitule_groupe_cultivar');
	}
	
	// Formule Hybridite
	public function getFormuleHybridite()
	{
		return $this->formule_hybridite;
	}
	public function setFormuleHybridite( $fh )
	{
		$this->formule_hybridite = $fh;
		$this->setMetaAttributsUtilises('formule_hybridite');
	}
	
	// Phrase Nom Non Nomme
	public function getPhraseNomNonNomme()
	{
		return $this->phrase_nom_non_nomme;
	}
	public function setPhraseNomNonNomme( $pnnn )
	{
		$this->phrase_nom_non_nomme = $pnnn;
		$this->setMetaAttributsUtilises('phrase_nom_non_nomme');
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.2  2007-01-03 17:05:30  jp_milcent
* Remplacement du nom de la classse "aModele" par "aDonneesObjet" pour éviter le téléscopage avec la classe déjà présente dans eFlore.
*
* Revision 1.1  2006/07/20 17:51:29  jp_milcent
* Le dossier modele est renomé en "do" puis les classes qu'il contient sont das "Data Object".
*
* Revision 1.2  2006/07/20 16:56:06  jp_milcent
* Modification d'un nom de champ.
*
* Revision 1.1  2006/07/20 16:11:05  jp_milcent
* Ajout des classes générées automatiquements.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>