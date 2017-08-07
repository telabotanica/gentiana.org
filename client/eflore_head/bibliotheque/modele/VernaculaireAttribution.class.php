<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.			                                                                |
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
// CVS : $Id: VernaculaireAttribution.class.php,v 1.3 2005-09-27 16:03:46 jp_milcent Exp $
/**
* eFlore : Classe VernaculaireAttribution
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
*@version       $Revision: 1.3 $ $Date: 2005-09-27 16:03:46 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VernaculaireAttribution extends AModele
{
	/*** Attributs : ***/
	
	private $commentaires_geographiques;
	private $mark_info_biblio;
		
	/*** Constructeurs : ***/
	
	public function __construct( )
	{
		
	}
	
	/*** Accesseurs : ***/

	// Ce Emploi
	public function getCeEmploi( )
	{
		return (int)$this->getCe('emploi');
	}
	public function setCeEmploi( $ce )
	{
		$this->setCe($ce, 'emploi');
	}
	
	// Ce Contributeur
	public function getCeContributeur( )
	{
		return (int)$this->getCe('contributeur');
	}
	public function setCeContributeur( $cc )
	{
		$this->setCe($cc, 'contributeur');
	}
	
	// Ce Zone Geo
	public function getCeZoneGeo( )
	{
		return $this->getCe('zone_geo');
	}
	public function setCeZoneGeo( $czg )
	{
		$this->setCe($czg, 'zone_geo') ;
	}

	// Ce Version Projet Zg
	public function getCeVersionProjetZg( )
	{
		return $this->getCe('version_projet_zg');
	}
	public function setCeVersionProjetZg( $cvpzg )
	{
		$this->setCe($cvpzg, 'version_projet_zg');
	}

	// Commentaires geographiques
	public function getCommentairesGeographiques( )
	{
		return $this->commentaires_geographiques;
	}
	public function setCommentairesGeographiques( $cg )
	{
		$this->commentaires_geographiques = $cg;
	}

	// Ce Citation Biblio
	public function getCeCitationBiblio( )
	{
		return $this->getCe('zone_geo');
	}
	public function setCeCitationBiblio( $czg )
	{
		$this->setCe($czg, 'zone_geo');
	}

	// Mark Info Biblio
	public function getMarkInfoBiblio( )
	{
		return $this->mark_info_biblio;
	}
	public function setMarkInfoBiblio( $mib )
	{
		$this->mark_info_biblio = $mib;
	}
	
	/*** Méthodes : ***/
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: VernaculaireAttribution.class.php,v $
* Revision 1.3  2005-09-27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.2  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.1  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>