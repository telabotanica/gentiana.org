<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: ProjetVersion.class.php,v 1.7 2007-02-07 18:04:44 jp_milcent Exp $
/**
* eFlore : Classe ProjetVersion
*
* 
*
*@package eFlore
*@subpackage projet
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.7 $ $Date: 2007-02-07 18:04:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ProjetVersion extends AModele
{
	/*** Attributes : ***/
	
	private $date_fin_version;
	private $code;
	private $liste_modules;
	
	/*** Constructeur : ***/
	
	public function __construct()
	{
		
	}
	
	/*** Accesseurs : ***/

	// Ce Projet
	public function getCeProjet()
	{
		return $this->getCe('projet');
	}

	// Ce Ouvrage Source Version
	public function getCeOuvrageSourceVersion()
	{
		return $this->getCe('ouvrage_source_version'); 
	}

	
	// Datin Fin Version
	public function getDateFinVersion()
	{
		return $this->date_fin_version; 
	}
	public function setDateFinVersion( $date )
	{
		$this->date_fin_version = $date; 
	}
	
	// Code
	public function getCode()
	{
		return $this->code; 
	}
	public function setCode( $code )
	{
		$this->code = $code; 
	}
	
	// Liste des Modules
	public function getListeModules()
	{
		return $this->liste_modules; 
	}
	public function setListeModules( $tab_modules )
	{
		$this->liste_modules = $tab_modules; 
	}
	
	/*** Méthodes : ***/
	
	/**
	* @return boolean True si on a à faire à la derniere version d'un projet,
	* sinon False.
	* @access public
	*/
	public function verifierDerniereVersion() {
		if (is_null($this->getDateFinVersion()) || $this->getDateFinVersion() == '0000-00-00') {
			return true;
		} else {
			return false;
		}
	}

} // end of ProjetVersion

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ProjetVersion.class.php,v $
* Revision 1.7  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.6.12.1  2007/02/02 18:11:26  jp_milcent
* Ajout d'un nouveau paramêtre pour vérifier la dernière version.
*
* Revision 1.6  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.5.2.1  2005/12/08 17:50:33  jp_milcent
* Passage v3+v4 en cours.
*
* Revision 1.5  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.4  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
* Revision 1.3  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.2  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.1  2005/07/28 15:37:56  jp_milcent
* Début gestion des squelettes et de l'API eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>