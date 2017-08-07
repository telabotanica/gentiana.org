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
// CVS : $Id: VernaculaireDao.class.php,v 1.8 2007-06-11 12:45:32 jp_milcent Exp $
/**
* eFlore : Classe DAO Vernaculaire
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
*@version       $Revision: 1.8 $ $Date: 2007-06-11 12:45:32 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VernaculaireDao extends AModeleDao
{
	/*** Attributes : ***/
	
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'Vernaculaire';
		parent::__construct();
	}
	
	/*** Accesseurs : ***/
	
	/*** Méthodes : ***/
	
	/**
	* @return array
	* @access public
	*/
	public function consulter( $type = NULL, $param = array() ) {
		switch($type) {
			case EF_CONSULTER_V_GROUPE_ID :
				$sql = 'SELECT DISTINCT * '.		
					'FROM eflore_vernaculaire '.
					'WHERE ev_id_nom_vernaculaire IN ( ! ) '.
					'AND ev_id_version_projet_nom_verna = ? '.
					'ORDER BY ev_intitule_nom_vernaculaire ASC';
				break;
			case EF_CONSULTER_VERNACULAIRE_RADICAL_VERSION :
				$sql = 'SELECT DISTINCT '.
				'el_nom_langue_principal, '.
				'el_code_langue, '.
				'ezg_intitule_principal, '.
				'ezg_code, '.
				'ev_id_nom_vernaculaire, '.
				'ev_intitule_nom_vernaculaire, '.
				'eva_id_taxon_ref, '.
				'eva_id_version_projet_taxon_ref '.
								
				'FROM '.
				'eflore_langue, '.
				'eflore_zg, '.
				'eflore_vernaculaire, '.
				'eflore_vernaculaire_attribution '.
				
				'WHERE '.
				'eva_ce_zone_geo = ezg_id_zone_geo '. 
				'AND eva_ce_version_projet_zg = ezg_id_projet_zg '.
				'AND ev_ce_langue = el_id_langue '.
				'AND ev_ce_version_projet_langue = el_id_version_projet_langue '.
				'AND eva_id_nom_vernaculaire = ev_id_nom_vernaculaire '.
				'AND eva_id_version_projet_nom_verna = ev_id_version_projet_nom_verna '.
				'AND eva_id_version_projet_taxon_ref = ? '. 
				'AND LOWER(ev_intitule_nom_vernaculaire) LIKE ? '.
				
				'ORDER BY ev_intitule_nom_vernaculaire ASC';
				break;
			case EF_CONSULTER_VERNACULAIRE_RADICAL :
				$sql = 'SELECT DISTINCT '.
				'el_nom_langue_principal, '.
				'el_code_langue, '.
				'ezg_intitule_principal, '.
				'ezg_code, '.
				'ev_id_nom_vernaculaire, '.
				'ev_intitule_nom_vernaculaire, '.
				'eva_id_taxon_ref, '.
				'eva_id_version_projet_taxon_ref '.
								
				'FROM '.
				'eflore_langue, '.
				'eflore_zg, '.
				'eflore_vernaculaire, '.
				'eflore_vernaculaire_attribution '.
				
				'WHERE '.
				'eva_ce_zone_geo = ezg_id_zone_geo '. 
				'AND eva_ce_version_projet_zg = ezg_id_projet_zg '.
				'AND ev_ce_langue = el_id_langue '.
				'AND ev_ce_version_projet_langue = el_id_version_projet_langue '.
				'AND eva_id_nom_vernaculaire = ev_id_nom_vernaculaire '.
				'AND eva_id_version_projet_nom_verna = ev_id_version_projet_nom_verna '.
				'AND LOWER(ev_intitule_nom_vernaculaire) LIKE ? '.
				
				'ORDER BY ev_intitule_nom_vernaculaire ASC';
				break;
			case EF_CONSULTER_VERNACULAIRE_APPROCHE_VERSION :
				$sql = 'SELECT DISTINCT '.
				'el_nom_langue_principal, '.
				'el_code_langue, '.
				'ezg_intitule_principal, '.
				'ezg_code, '.
				'ev_id_nom_vernaculaire, '.
				'ev_intitule_nom_vernaculaire, '.
				'eva_id_taxon_ref, '.
				'eva_id_version_projet_taxon_ref '.
								
				'FROM '.
				'eflore_langue, '.
				'eflore_zg, '.
				'eflore_vernaculaire, '.
				'eflore_vernaculaire_attribution '.
				
				'WHERE '.
				'eva_ce_zone_geo = ezg_id_zone_geo '. 
				'AND eva_ce_version_projet_zg = ezg_id_projet_zg '.
				'AND ev_ce_langue = el_id_langue '.
				'AND ev_ce_version_projet_langue = el_id_version_projet_langue '.
				'AND eva_id_nom_vernaculaire = ev_id_nom_vernaculaire '.
				'AND eva_id_version_projet_nom_verna = ev_id_version_projet_nom_verna '.
				'AND eva_id_version_projet_taxon_ref = ? '. 
				'AND ' .
				'(SOUNDEX( ev_intitule_nom_vernaculaire ) = SOUNDEX( ? ) '.
				'OR SOUNDEX( REVERSE( ev_intitule_nom_vernaculaire ) ) = SOUNDEX( REVERSE( ? ) ) ' .
				'OR LOWER(ev_intitule_nom_vernaculaire) LIKE ? ' .
				')';
				break;
			case EF_CONSULTER_VERNACULAIRE_APPROCHE :
				$sql = 'SELECT DISTINCT '.
				'el_nom_langue_principal, '.
				'el_code_langue, '.
				'ezg_intitule_principal, '.
				'ezg_code, '.
				'ev_id_nom_vernaculaire, '.
				'ev_intitule_nom_vernaculaire, '.
				'eva_id_taxon_ref, '.
				'eva_id_version_projet_taxon_ref '.
								
				'FROM '.
				'eflore_langue, '.
				'eflore_zg, '.
				'eflore_vernaculaire, '.
				'eflore_vernaculaire_attribution '.
				
				'WHERE '.
				'eva_ce_zone_geo = ezg_id_zone_geo '. 
				'AND eva_ce_version_projet_zg = ezg_id_projet_zg '.
				'AND ev_ce_langue = el_id_langue '.
				'AND ev_ce_version_projet_langue = el_id_version_projet_langue '.
				'AND eva_id_nom_vernaculaire = ev_id_nom_vernaculaire '.
				'AND eva_id_version_projet_nom_verna = ev_id_version_projet_nom_verna '. 
				'AND ' .
				'(SOUNDEX( ev_intitule_nom_vernaculaire ) = SOUNDEX( ? ) '.
				'OR SOUNDEX( REVERSE( ev_intitule_nom_vernaculaire ) ) = SOUNDEX( REVERSE( ? ) ) ' .
				'OR LOWER(ev_intitule_nom_vernaculaire) LIKE ? ' .
				')';
				break;
				

		}
		$this->setRequete($sql);
		return parent::consulter($param);
	}
	
	/**
	* Ajoute les champs aux bons attributs. 
	* @return object l'objet dont on manipule les infos.
	* @access public
	*/
	public function attribuerChamps( $donnees )
	{
		$obj_nom = $this->getNomTypeInfo();
		$un_objet = new $obj_nom;
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'ev_id_nom_vernaculaire' :
					$un_objet->setId($val, 'nom_vernaculaire');
					break;
				case 'ev_ce_langue' :
					$un_objet->setCe($val, 'langue');
					break;
				case 'ev_ce_version_projet_langue' :
					$un_objet->setCe($val, 'version_projet_langue');
					break;
				case 'ev_ce_categorie_genre_nombre' :
					$un_objet->setCe($val, 'categorie_genre_nombre');
					break;
				case 'ev_ce_valeur_genre_nombre' :
					$un_objet->setCe($val, 'valeur_genre_nombre');
					break;
				case 'ev_intitule_nom_vernaculaire' :
					$un_objet->setIntitule($val);
					break;
				case 'ev_soundex_nom_vernaculaire' :
					$un_objet->setSoundex($val);
					break;
				case 'ev_notes_nom_vernaculaire' :
					$un_objet->setNotes($val);
					break;
				case 'ev_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'ev_ce_modifier_par' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'ev_ce_etat' :
					$un_objet->setCeEtat($val);
					break;
				// TODO : supprimer les champs ci-dessous après modif recherche nom verna
				case 'eva_id_version_projet_nom_verna' :
					$un_objet->setVersion($val);
					break;
				case 'eva_id_taxon_ref' :
					$un_objet->setIdTaxon($val);
					break;
				case 'eva_id_version_projet_taxon_ref' :
					$un_objet->setIdTaxonVersionProjet($val);
					break;
				case 'el_nom_langue_principal' :
					$un_objet->setLgIntitule($val);
					break;
				case 'el_code_langue' :
					$un_objet->setLgAbreviation($val);
					break;
				case 'ezg_intitule_principal' :
					$un_objet->setZgIntitule($val);
					break;
				case 'ezg_code' :
					$un_objet->setZgAbreviation($val);
					break;
				// Fin de la suppression
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
* $Log: VernaculaireDao.class.php,v $
* Revision 1.8  2007-06-11 12:45:32  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.6.2.2  2007-06-07 13:58:46  jp_milcent
* Comme utf8 ne permet pas de comparait les chaines avec la prise en compte des accents mais sans la prise en compte de la casse, nous somme obligé de mettre en minuscule le nom vernaculaire recherché.
*
* Revision 1.7  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.6.2.1  2007-05-16 10:57:13  jp_milcent
* Correction bogue : mauvais nom de champs table zg
*
* Revision 1.6  2007-01-17 18:22:34  jp_milcent
* Correction bogue : confusion entre les différents projets de noms verna.
*
* Revision 1.5  2005/12/06 09:47:26  ddelon
* Recherche vernaculaire (extension) + recherche approche
*
* Revision 1.4  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.3  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.2  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.1  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>