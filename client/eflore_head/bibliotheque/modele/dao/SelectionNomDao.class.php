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
// CVS : $Id: SelectionNomDao.class.php,v 1.13 2006-05-16 09:27:33 jp_milcent Exp $
/**
* eFlore : Classe DAO SelectionNom
*
* 
*
*@package eFlore
*@subpackage Selection_nom
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.13 $ $Date: 2006-05-16 09:27:33 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// SELECTION_NOM
/** Récupère les id des projet pour un id de nom.*/
define('EF_CONSULTER_SN_NOM_ID', 'ESN1');
/** Récupère l'attribution de noms à un taxon pour un id de nom et une version de projet de taxon donnés.*/
define('EF_CONSULTER_SN_VERSION_NOM_ID', 'ESN2');
/** Récupère l'attribution de noms à un taxon pour un id de taxon et une version de projet de taxon donnés.*/
define('EF_CONSULTER_SN_VERSION_TAXON_ID', 'ESN3');
/** Récupère l'attribution du nom retenu à un taxon pour un id de taxon et une version de projet de taxon donnés.*/
define('EF_CONSULTER_SN_VERSION_TAXON_ID_RETENU', 'ESN4');
/** Récupère les attribution de noms à un taxon pour un groupe d'id de taxon, une statut et une version de projet de taxon donnés.*/
define('EF_CONSULTER_SN_STATUT_VERSION_TAXON_GROUPE_ID', 'ESN5');
/** Récupère les id des projet pour un id de nom dans la base principale et historique.*/
define('EF_CONSULTER_SN_NOM_ID_UNION', 'ESN6');

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class SelectionNomDao extends AModeleDao
{
	/*** Attributes : ***/
	
		
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->setNomTypeInfo('SelectionNom');
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
			case EF_CONSULTER_SN_NOM_ID :
				$sql =	'SELECT DISTINCT * '.
		               	'FROM '.$this->getBddCourante().'.eflore_selection_nom '.
		               	'WHERE esn_id_nom = ? '. 
		               	'AND esn_id_version_projet_nom = ? ';
				break;
			case EF_CONSULTER_SN_NOM_ID_UNION :
				$sql =	'SELECT DISTINCT * '. 
		               	'FROM '.EF_BDD_NOM_PRINCIPALE.'.eflore_selection_nom '.
		               	'WHERE esn_id_nom = ? AND esn_id_version_projet_nom = ? '.
		               	'UNION '.
		               	'SELECT DISTINCT * '. 
		               	'FROM '.EF_BDD_NOM_HISTORIQUE.'.eflore_selection_nom '.
		               	'WHERE esn_id_nom = ? AND esn_id_version_projet_nom = ? ';
				break;
			case EF_CONSULTER_SN_VERSION_NOM_ID :
				$sql =	'SELECT DISTINCT * '.
		               	'FROM '.$this->getBddCourante().'.eflore_selection_nom '.
		               	'WHERE esn_id_nom = ? '. 
		               	'AND esn_id_version_projet_taxon = ?';
				break;
			case EF_CONSULTER_SN_VERSION_TAXON_ID :
				$sql =	'SELECT DISTINCT * '. 
		               	'FROM '.$this->getBddCourante().'.eflore_selection_nom '.
		               	'WHERE esn_id_taxon = ? '. 
		               	'AND esn_id_version_projet_taxon = ?';
				break;
			case EF_CONSULTER_SN_VERSION_TAXON_ID_RETENU :
				$sql =	'SELECT DISTINCT * '.
		               	'FROM '.$this->getBddCourante().'.eflore_selection_nom '.
		               	'WHERE esn_id_taxon = ? '. 
		               	'AND esn_id_version_projet_taxon = ? '.
		               	'AND esn_ce_statut = 3 ';
				break;
			case EF_CONSULTER_SN_STATUT_VERSION_TAXON_GROUPE_ID :
				$sql =	'SELECT DISTINCT * '.
		               	'FROM '.$this->getBddCourante().'.eflore_selection_nom '.
		               	'WHERE esn_id_taxon IN (!) '. 
		               	'AND esn_id_version_projet_taxon = ? '.
		               	'AND esn_ce_statut = ? ';
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
				case 'esn_id_nom' :
					$un_objet->setId($val, 'id_nom');// TODO : Supprimer l'utilisation de $un_objet->getId('id_nom') !
					$un_objet->setId($val, 'nom');
					break;
				case 'esn_id_version_projet_nom' :
					$un_objet->setId($val, 'version_projet_nom');
					break;
				case 'esn_id_taxon' :
					$un_objet->setId($val, 'id_taxon');// TODO : Supprimer l'utilisation de $un_objet->getId('id_taxon') !
					$un_objet->setId($val, 'taxon');
					break;
				case 'esn_id_version_projet_taxon' :
					$un_objet->setId($val, 'id_version');// TODO : Supprimer l'utilisation de $un_objet->getId('id_version') !
					$un_objet->setId($val, 'version');
					$un_objet->setId($val, 'version_projet_taxon');
					break;
				case 'esn_ce_statut' :
					$un_objet->setCeStatut($val);// TODO : Supprimer l'utilisation de $un_objet->getCeStatut() !
					$un_objet->setCe($val, 'statut');
					break;
				case 'esn_code_numerique_1' :
					$un_objet->setCodeNumerique1($val);
					break;
				case 'esn_code_numerique_2' :
					$un_objet->setCodeNumerique2($val);
					break;
				case 'esn_code_alphanumerique_1' :
					$un_objet->setCodeAlphanumerique1($val);
					break;
				case 'esn_code_alphanumerique_2' :
					$un_objet->setCodeAlphanumerique2($val);
					break;
				case 'esn_commentaire_nomenclatural' :
					$un_objet->setCommentaireNomenclatural($val);
					break;
				case 'esn_notes_nom_selection' :
					$un_objet->setNotes($val);
					break;
				case 'esn_date_derniere_modif' :
					$un_objet->setDateDerniereModif($val);
					break;
				case 'esn_ce_modifier_par' :
					$un_objet->setCeModifierPar($val);
					break;
				case 'esn_ce_etat' :
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
* $Log: SelectionNomDao.class.php,v $
* Revision 1.13  2006-05-16 09:27:33  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.12  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.11  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.9.2.2  2006/03/10 14:57:34  jp_milcent
* Mise en forme requête sql.
*
* Revision 1.10  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.9.2.1  2006/03/07 10:50:12  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet.
*
* Revision 1.9  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.8  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.7.2.2  2005/12/15 13:59:02  jp_milcent
* Gestion de 2 bases séparées historique et principales avec identifiant de version de projet distincts.
*
* Revision 1.7.2.1  2005/12/08 17:50:34  jp_milcent
* Passage v3+v4 en cours.
*
* Revision 1.7  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.6  2005/10/13 16:25:05  jp_milcent
* Ajout de la classification à la synthèse.
*
* Revision 1.5  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
*
* Revision 1.4  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.3  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.2  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.1  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>