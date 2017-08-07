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
// CVS : $Id: ChorologieDonneeDao.class.php,v 1.6 2006-04-14 12:07:58 jp_milcent Exp $
/**
* eFlore : Classe DAO ChorologieDonnee
*
* 
*
*@package eFlore
*@subpackage Chorologie
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.6 $ $Date: 2006-04-14 12:07:58 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// CHOROLOGIE_DONNEE
/**Récupère les infos sur une donnée chorologique pour un id de donnée et de version.*/
define('EF_CONSULTER_CD_VERSION_ID', 'ECD1');
/**Récupère les infos sur une donnée chorologique pour une version de projet choro et un taxon et sa version donné.*/
define('EF_CONSULTER_CD_VERSION_CHORO_TAXON', 'ECD2');
/** Récupère les zones géo distinctes pour une version de projet de données choro et de projet de taxon.*/
define('EF_CONSULTER_CD_ZG_CHORO_VERSION', 'ECD3');
/** Récupère les différentes version de projet de données choro pour un projet de taxon donné.*/
define('EF_CONSULTER_CD_PROJET_CHORO_VERSION', 'ECD4');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ChorologieDonneeDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->setNomTypeInfo('ChorologieDonnee');
		parent::__construct();
	}
	
	/*** Accesseurs : ***/
	
	
	/*** Méthodes : ***/
	
	/**
	* @return array
	* @access public
	*/
	public function consulter( $type = NULL, $param = array() )
	{
		switch($type) {
			case EF_CONSULTER_CD_VERSION_ID :
				$sql =	'SELECT DISTINCT * '. 
		               	'FROM eflore_chorologie_donnee '.
		               	'WHERE ecd_id_version_projet_donnee_choro = ? '. 
		               	'AND ecd_id_donnee_choro = ?';
				break;
			case EF_CONSULTER_CD_VERSION_CHORO_TAXON :
				$sql =	'SELECT DISTINCT * '. 
		               	'FROM eflore_chorologie_donnee '.
		               	'WHERE ecd_id_version_projet_donnee_choro = ? '.
		               	'AND ecd_ce_taxon = ? '. 
		               	'AND ecd_ce_version_projet_taxon = ? ';
				break;
			case EF_CONSULTER_CD_ZG_CHORO_VERSION :
				$sql =	'SELECT DISTINCT ecd_ce_zone_geo, ecd_ce_version_projet_zg '.  
		               	'FROM eflore_chorologie_donnee '.
		               	'WHERE ecd_id_version_projet_donnee_choro = ? '. 
						'AND ecd_ce_version_projet_taxon = ? ';
				break;
			case EF_CONSULTER_CD_PROJET_CHORO_VERSION :
				$sql =	'SELECT DISTINCT ecd_id_version_projet_donnee_choro '.  
		               	'FROM eflore_chorologie_donnee '.
		               	'WHERE ecd_ce_version_projet_taxon = ? ';
				break;
		}
		$this->setRequete($sql);
		return parent::consulter($param);
	}
	
	/**
	* Ajoute les champs aux bons attributs. 
	* @return array
	* @access public
	*/
	public function attribuerChamps( $donnees )
	{
		$obj_nom = $this->getNomTypeInfo();
		$un_objet = new $obj_nom;
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'ecd_id_donnee_choro' :
					$un_objet->setId($val, 'donnee_choro');
					break;
				case 'ecd_id_version_projet_donnee_choro' :
					$un_objet->setId($val, 'version_projet_donnee_choro');
					break;
				case 'ecd_ce_taxon' :
					$un_objet->setCe($val, 'taxon');
					break;
				case 'ecd_ce_version_projet_taxon' :
					$un_objet->setCe($val, 'version_projet_taxon');
					break;
				case 'ecd_ce_zone_geo' :
					$un_objet->setCe($val, 'zone_geo');
					break;
				case 'ecd_ce_version_projet_zg' :
					$un_objet->setCe($val, 'version_projet_zg');
					break;
				case 'ecd_notes_donnee_choro' :
					$un_objet->setNotes($val);
					break;
				case 'ecd_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'ecd_ce_modifier_par' :
					$un_objet->setCeModifierPar($val);
					break;
				case 'ecd_ce_etat' :
					$un_objet->setCeEtat($val);
					break;
				default:
					$un_objet->$cle = $val;
			}
			unset($donnees[$cle]);
		}
		return $un_objet;
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ChorologieDonneeDao.class.php,v $
* Revision 1.6  2006-04-14 12:07:58  jp_milcent
* Modification pour gérer la chorologie de la BDNBE.
*
* Revision 1.5.6.1  2006/04/14 11:56:39  jp_milcent
* Modification pour gérer la chorologie de la BDNBE.
*
* Revision 1.5  2005/11/24 16:01:12  jp_milcent
* Suite correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.4  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.3  2005/10/13 08:27:09  jp_milcent
* Ajout d'une mini chorologie sur la page de synthèse.
* Déplacement des constantes de requete sql dans les fichiers de chaque classe DAO.
*
* Revision 1.2  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.1  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>