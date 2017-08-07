<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
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
// CVS : $Id: ProjetDao.class.php,v 1.8 2007-02-07 18:04:44 jp_milcent Exp $
/**
* project_name
*
* 
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.8 $ $Date: 2007-02-07 18:04:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// PROJET
/**Récupère les infos sur un projet (=référentiel) pour un id donné.*/
define('EF_CONSULTER_PR_ID', 'EPR1');
/**Récupère les infos sur un projet (=référentiel) pour une abbréviation donnée.*/
define('EF_CONSULTER_PR_ABBR', 'EPR2');
/**Récupère les référentiel consultable en ligne.*/
define('EF_CONSULTER_REFERENTIEL_BOTA', 'EPR3');
/**Récupère les référentiel consultable en ligne.*/
define('EF_CONSULTER_PR_ID_REFERENTIEL_BOTA', 'EPR4');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ProjetDao extends AModeleDao
{
	/*** Attributes : ***/
	
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'Projet';
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
			case EF_CONSULTER_PR_ID :
				$sql = 	'SELECT * '.
							'FROM eflore_projet '. 
							'WHERE epr_id_projet = ? ';
				break;
			case EF_CONSULTER_PR_ABBR :
				$sql = 	'SELECT * '.
							'FROM eflore_projet '. 
							'WHERE  epr_abreviation_projet = ? ';
				break;
			case EF_CONSULTER_REFERENTIEL_BOTA :
				$sql = 	'SELECT DISTINCT projet.* '.
							'FROM eflore_projet AS projet, eflore_projet_version, eflore_projet_utiliser_module '. 
							'WHERE epr_mark_projet_consultable = ? '. 
							'AND epr_ce_type_projet IN (4, 5) '.
							'AND eprum_id_module = 18 ' .
							'AND eprum_id_version = eprv_id_version '.
							'AND (eprv_date_fin_version IS NULL OR eprv_date_fin_version = "0000-00-00") '.
							'AND eprv_ce_projet = epr_id_projet';
				break;
			case EF_CONSULTER_PR_ID_REFERENTIEL_BOTA :
				$sql = 	'SELECT DISTINCT projet.* '.
							'FROM eflore_projet AS projet, eflore_projet_version, eflore_projet_utiliser_module '. 
							'WHERE epr_mark_projet_consultable = ? '. 
							'AND epr_ce_type_projet IN (4, 5) '.
							'AND eprum_id_module = 18 ' .
							'AND eprum_id_version = eprv_id_version '.
							'AND (eprv_date_fin_version IS NULL OR eprv_date_fin_version = "0000-00-00") '.
							'AND eprv_ce_projet = epr_id_projet '.
							'AND epr_id_projet IN (!)';
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
				case 'epr_id_projet' :
					$un_objet->setId($val, 'projet');
					break;
				case 'epr_ce_type_projet' :
					$un_objet->setCe($val, 'type_projet');
					break;
				case 'epr_ce_naturaliste' :
					$un_objet->setCe($val, 'naturaliste');
					break;
				case 'epr_ce_contributeur' :
					$un_objet->setCe($val, 'contributeur');
					break;
				case 'epr_intitule_projet' :
					$un_objet->setIntitule($val);
					break;
				case 'epr_abreviation_projet' :
					$un_objet->setAbreviation($val);
					break;
				case 'epr_description_projet' :
					$un_objet->setDescriptionProjet($val);
					break;
				case 'epr_lien_web' :
					$un_objet->setLienWeb($val);
					break;
				case 'epr_mark_projet_consultable' :
					$un_objet->setMarkProjetConsultable($val);
					break;
				case 'epr_notes_projet' :
					$un_objet->setNotes($val);
					break;
				case 'epr_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'epr_ce_modifier_par' :
					$un_objet->setCe($val, 'modifier_par');
					break;
				case 'epr_ce_etat' :
					$un_objet->setCe($val, 'etat');
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
* $Log: ProjetDao.class.php,v $
* Revision 1.8  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.7.6.1  2007/02/02 14:35:51  jp_milcent
* Complément la date peut être NULL ou égale à 0000-00-00.
*
* Revision 1.7  2006/05/16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
* Revision 1.6  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.5  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.4  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.3  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
* Revision 1.2  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.1  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>