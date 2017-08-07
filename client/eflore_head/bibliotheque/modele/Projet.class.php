<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-consultation.                                                            |
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
// CVS : $Id: Projet.class.php,v 1.7 2006-05-16 16:21:23 jp_milcent Exp $
/**
* Classe Projet.
*
* Permet la gestion des projets.
*
*@package eRibo
*@subpackage modele
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.7 $ $Date: 2006-05-16 16:21:23 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class Projet extends AModele
{
	/*** Attributes : ***/
	
	private $intitule;
	private $abreviation;
	private $description_projet;
	private $lien_web;
	private $mark_projet_consultable;
	private $liste_versions = array();
		
	/*** Constructeur : ***/
	
	public function __construct($donnees = array() )
	{
		
	}
	
	/*** Accesseurs : ***/

	// Abréviations	
	public function setAbreviation( $abreviation )
	{
		$this->abreviation = $abreviation;
	}
	public function getAbreviation()
	{
		return $this->abreviation;
	}
	
	// Intitulé
	public function setIntitule( $intitule )
	{
		$this->intitule = $intitule;
	}
	public function getIntitule()
	{
		return $this->intitule;
	}

	// Description Projet
	public function setDescriptionProjet( $dp )
	{
		$this->description_projet = $dp;
	}
	public function getDescriptionProjet()
	{
		return $this->description_projet;
	}
	
	// Lien Web
	public function setLienWeb( $lw )
	{
		$this->lien_web = $lw;
	}
	public function getLienWeb()
	{
		return $this->lien_web;
	}

	// Mark Projet Consultable
	public function setMarkProjetConsultable( $mpc )
	{
		$this->mark_projet_consultable = $mpc;
	}
	public function getMarkProjetConsultable()
	{
		return $this->mark_projet_consultable;
	}

	// Liste Versions
	public function setListeVersions( $versions = array() )
	{
		$this->liste_versions = $versions;
	}
	public function getListeVersions()
	{
		return $this->liste_versions;
	}
	
	/*** Méthodes : ***/
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Projet.class.php,v $
* Revision 1.7  2006-05-16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
* Revision 1.6  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.5  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.4  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.3  2005/07/28 15:37:56  jp_milcent
* Début gestion des squelettes et de l'API eFlore.
*
* Revision 1.2  2005/07/27 15:43:21  jp_milcent
* Début débogage avec gestion de l'appli hors Papyrus.
*
* Revision 1.1  2005/07/26 16:27:29  jp_milcent
* Début mise en place framework eFlore.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>