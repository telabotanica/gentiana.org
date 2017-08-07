<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreZoneGeographique.class.php,v 1.12 2007-09-21 15:02:47 jp_milcent Exp $
/**
* eflore_bp - EfloreZoneGeographique.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.12 $ $Date: 2007-09-21 15:02:47 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreZoneGeographique extends aEfloreModule {

	/*** Constantes : ***/
	/** Donne l'id du projet ISO-3166-1 (Pays actuels).*/
	const ISO_3166_1 = 17;
	
	/** Donne l'id du projet ISO-3166-2 (Subdivision des Pays actuels).*/
	const ISO_3166_2 = 18;
	
	/** Donne l'id du projet ISO-3166-3 (Zones géographiques historiques).*/
	const ISO_3166_3 = 19;
	
	/** Donne l'id du projet INSEE-P (Pays).*/
	const INSEE_P = 20;
	
	/** Donne l'id du projet INSEE-R (Régions).*/
	const INSEE_R = 21;
	
	/** Donne l'id du projet INSEE-D (Départements).*/
	const INSEE_D = 22;
	
	/** Donne l'id du projet INSEE-C (Communes).*/
	const INSEE_C = 23;
	
	/** Donne l'id du projet TDWG-ZG-N1.*/
	const TDWG_ZG_N1 = 35;
	
	/** Donne l'id du projet TDWG-ZG-N2.*/
	const TDWG_ZG_N2 = 34;

	/** Donne l'id du projet TDWG-ZG-N3.*/
	const TDWG_ZG_N3 = 33;
	
	/** Donne l'id du projet TDWG-ZG-N4.*/
	const TDWG_ZG_N4 = 30;

	/*** Méthodes : ***/
	
	public function consulterZg($zg_projet_id, $zg_id)
	{
		$sql = 	'SELECT * '.
				'FROM eflore_zg '.
				"WHERE ezg_id_projet_zg = $zg_projet_id ".
				"AND ezg_id_zone_geo IN ($zg_id) ";
		//$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}

	/**
	* Retourne un tableau de résultats contenant les informations sur les zones géographiques correspondant à un id de
	* projet donné et pour un code donnée évaluées avec la clause SQL LIKE.
	* Les zones géographiques possédant la relation "code a été supprimé" sont éliminées du taleau des résultats.
	* 
	* @param int l'identifiant d'un projet de zone géographique.
	* @param string un code de zone géographique qui sera évaluée avec la clause LIKE.
	* 
	* @return array
	*/
	public function consulterZgParCode($zg_projet_id, $zg_code)
	{
		$zg_code = $this->echapperQuote($zg_code);
		$sql = 	'SELECT DISTINCT eflore_zg.* '.
				'FROM eflore_zg, eflore_zg_relation '.
				"WHERE ezg_id_projet_zg = $zg_projet_id ".
				"AND ezg_code LIKE '$zg_code' ".
				'AND ezg_id_projet_zg = ezr_id_projet_zg_1 '.
				'AND ezg_id_zone_geo = ezr_id_zone_geo_1 '.
				'AND ezr_id_valeur != 55 '.// 55 = zone géo supprimée -> historique
				'ORDER BY ezg_intitule_principal ASC';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	/**
	* Retourne les valeurs de la zone parente.
	* 
	* @param int l'identifiant d'un projet de zone géographique.
	* @param int l'identifiant d'une zone géographique.
	* 
	* @return array
	*/
	public function consulterZgParente($zg_projet_id, $zg_id)
	{
		$sql = 	'SELECT DISTINCT eflore_zg.* '.
				'FROM eflore_zg, eflore_zg_relation '.
				'WHERE ezg_id_projet_zg = ezr_id_projet_zg_2 '.
				'AND ezg_id_zone_geo = ezr_id_zone_geo_2 '.
				"AND ezr_id_projet_zg_1 = $zg_projet_id ".
				"AND ezr_id_zone_geo_1 = $zg_id ".
				'AND ezr_id_valeur = 74 ';// Type de zone géo : relation à pour père
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public static function consulterZgProjetId($code)
	{
		switch ($code) {
			case 'ISO_3166_1' :
				return self::ISO_3166_1;
				break;
			case 'ISO_3166_2' :
				return self::ISO_3166_2;
				break;
			case 'ISO_3166_3' :
				return self::ISO_3166_3;
				break;
			case 'INSEE_P' :
				return self::INSEE_P;
				break;
			case 'INSEE_R' :
				return self::INSEE_R;
				break;
			case 'INSEE_D' :
				return self::INSEE_D;
				break;
			case 'INSEE_C' :
				return self::INSEE_C;
				break;
			case 'TDWG_ZG_N1' :
				return self::TDWG_ZG_N1;
				break;
			case 'TDWG_ZG_N2' :
				return self::TDWG_ZG_N2;
				break;
			case 'TDWG_ZG_N3' :
				return self::TDWG_ZG_N3;
				break;
			case 'TDWG_ZG_N4' :
				return self::TDWG_ZG_N4;
				break;
			default:
				$e = 'Aucun code ne correspond pour : '.$code;
				trigger_error($e, E_USER_WARNING);
				return false;
		}
	}
	
	public static function getCodeProjet($id)
	{
		switch ($id) {
			case self::ISO_3166_1 :
				return 'ISO_3166_1';
				break;
			case self::ISO_3166_2 :
				return 'ISO_3166_2';
				break;
			case self::ISO_3166_3 :
				return 'ISO_3166_3';
				break;
			case self::INSEE_P :
				return 'INSEE_P';
				break;
			case self::INSEE_R :
				return 'INSEE_R';
				break;
			case self::INSEE_D :
				return 'INSEE_D';
				break;
			case self::INSEE_C :
				return 'INSEE_C';
				break;
			case self::TDWG_ZG_N1 :
				return 'TDWG_ZG_N1';
				break;
			case self::TDWG_ZG_N2 :
				return 'TDWG_ZG_N2';
				break;
			case self::TDWG_ZG_N3 :
				return 'TDWG_ZG_N3';
				break;
			case self::TDWG_ZG_N4 :
				return 'TDWG_ZG_N4';
				break;
			default:
				$e = 'Aucun code n\'a été défini pour ce projet de zone géographique!';
				trigger_error($e, E_USER_WARNING);
				return false;
		}
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreZoneGeographique.class.php,v $
* Revision 1.12  2007-09-21 15:02:47  jp_milcent
* Suppression du débogage.
*
* Revision 1.11  2007-08-17 13:14:32  jp_milcent
* Mise à niveau.
*
* Revision 1.10  2007-08-01 09:08:52  jp_milcent
* Correction problème d'utilisation d'eval.
*
* Revision 1.9  2007-07-06 18:08:56  jp_milcent
* Récupération du code des projets de zone géographiques.
*
* Revision 1.8  2007-07-05 19:07:52  jp_milcent
* Amélioration et ajout de requêtes.
*
* Revision 1.7  2007-07-02 15:33:01  jp_milcent
* Utilisation du Wrapper SQL pour l'ensemble des requêtes de ces modules.
*
* Revision 1.6  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.5  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.4  2007-06-22 15:43:47  jp_milcent
* Prise en compte des codes INSEE périmés.
*
* Revision 1.3  2007-06-21 17:42:49  jp_milcent
* Ajout de méthodes mais nécessite de les uniformiser...
*
* Revision 1.2  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.1  2007-06-11 12:47:51  jp_milcent
* Début gestion de l'application Chorologie et ajout de modification suite à travail pour Gentiana.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>