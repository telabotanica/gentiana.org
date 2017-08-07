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
// CVS : $Id: ZgDaoDeprecie.class.php,v 1.1 2007-06-11 15:32:50 jp_milcent Exp $
/**
* eFlore : Classe DAO Zg
*
* 
*
*@package eFlore
*@subpackage Zone_geographique
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2007-06-11 15:32:50 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// ZG
/** Récupère les infos d'une zone géo pour un id de zg et une version de projet de zg.*/
define('EF_CONSULTER_ZG_VERSION_ID', 'EZG1');
/** Récupère les infos d'un groupe d'id de zone géo d'une version de projet de zg donnée.*/
define('EF_CONSULTER_ZG_GROUPE_VERSION_ID', 'EZG2');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ZgDaoDeprecie extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  )
	{
		$this->setNomTypeInfo('ZgDeprecie');
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
			case EF_CONSULTER_ZG_VERSION_ID :
				$sql =	'SELECT DISTINCT * 
		               FROM eflore_zg
		               WHERE ezg_id_projet_zg = ? 
		               AND ezg_id_zone_geo = ?';
				break;
			case EF_CONSULTER_ZG_GROUPE_VERSION_ID :
				$sql = 	'SELECT DISTINCT * '.		
							'FROM eflore_zg '.
							'WHERE ezg_id_projet_zg = ? '.
							'AND ezg_id_zone_geo IN ( ! ) '.
							'ORDER BY ezg_intitule_principal ASC';
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
				case 'ezg_id_zone_geo' :
					$un_objet->setId($val, 'zone_geo');
					break;
				case 'ezg_id_projet_zg' :
					$un_objet->setId($val, 'projet_zg');
					break;
				case 'ezg_intitule_principal' :
					$un_objet->setIntitulePrincipal($val);
					break;
				case 'ezg_code' :
					$un_objet->setCode($val);
					break;
				case 'ezg_superficie' :
					$un_objet->setSuperficie($val);
					break;
				case 'ezg_nombre_habitant' :
					$un_objet->setNombreHabitant($val);
					break;
				case 'ezg_date_recensement' :
					$un_objet->setDateRecensement($val);
					break;
				case 'ezg_altitude_moyenne' :
					$un_objet->setAltitudeMoyenne($val);
					break;
				case 'ezg_altitude_max' :
					$un_objet->setAltitudeMax($val);
					break;
				case 'ezg_altitude_min' :
					$un_objet->setAltitudeMin($val);
					break;
				case 'ezg_longitude' :
					$un_objet->setLongitude($val);
					break;
				case 'ezg_latitude' :
					$un_objet->setLatitude($val);
					break;
				case 'ezg_couleur_rvb' :
					$un_objet->setCouleurRvb($val);
					break;
				case 'ezg_notes' :
					$un_objet->setNotes($val);
					break;
				case 'ezg_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'ezg_ce_modifier_par' :
					$un_objet->setCeModifierPar($val);
					break;
				case 'ezg_ce_etat' :
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
* $Log: ZgDaoDeprecie.class.php,v $
* Revision 1.1  2007-06-11 15:32:50  jp_milcent
* Correction problème entre ancienne api et nouvelle version 1.1.1
*
* Revision 1.6  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.5  2007-02-09 16:54:36  jp_milcent
* Nouveau module Zone Géo basé sur la version 1.2.
*
* Revision 1.4  2006/10/25 09:06:03  jp_milcent
* Ajout des nouveaux champs pour la table des zg.
*
* Revision 1.3  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.2  2005/10/13 08:27:09  jp_milcent
* Ajout d'une mini chorologie sur la page de synthèse.
* Déplacement des constantes de requete sql dans les fichiers de chaque classe DAO.
*
* Revision 1.1  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>