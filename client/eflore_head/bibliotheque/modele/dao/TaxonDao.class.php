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
// CVS : $Id: TaxonDao.class.php,v 1.9 2006-05-19 15:10:07 jp_milcent Exp $
/**
* Classe : TaxonDao
*
* 
*
*@package eFlore
*@subpackage taxon
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.9 $ $Date: 2006-05-19 15:10:07 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// TAXON
/** Récupère les taxons supérieur au genre dont le nom commence par la lettre demandée.*/
define('EF_CONSULTER_TAXON_LETTRE_SUPRAGENRE', 'EFT1');
/** Récupère les taxons dont l'intitulé du genre commence par la lettre demandée.
 * Ne fonctionne donc pas pour les taxons dont le rang est situé entre le genre et l'espèce.'*/
define('EF_CONSULTER_TAXON_LETTRE_GENRE', 'EFT2');
/** Récupère les taxons fils d'un taxon donné.*/
define('EF_CONSULTER_TAXON_CLASSIF_FILS', 'EFT3');
/** Récupère le nombre de taxons fils d'un taxon donné.*/
define('EF_CONSULTER_TAXON_CLASSIF_FILS_NBRE', 'EFT4');
/** Récupère le nombre de taxons fils pour un groupde de taxons donné.*/
define('EF_CONSULTER_TAXON_CLASSIF_FILS_NBRE_GROUPE_ID', 'EFT5');
/** Récupère le nombre de taxons pour un id de version de projet.*/
define('EF_CONSULTER_TAXON_NBRE_PROJET', 'EFT6');
/** Récupère les info d'un taxons pour un id de version et de taxon.*/
define('EF_CONSULTER_TAXON_VERSION_ID', 'EFT7');
/** Récupère les info des taxons pour un groupe d'id de taxon et une version de projet.*/
define('EF_CONSULTER_TAXON_VERSION_GROUPE_ID', 'EFT8');
/** Récupère les info des taxons pour une version de projet.*/
define('EF_CONSULTER_TAXON_VERSION', 'EFT9');
/** Récupère les info des taxons pour une version de projet et un rang.*/
define('EF_CONSULTER_TAXON_VERSION_RANG', 'EFT10');


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class TaxonDao extends AModeleDao
{
	/*** Attributes : ***/
	
	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'Taxon';
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
			case EF_CONSULTER_TAXON_LETTRE_SUPRAGENRE :
				$sql =	'SELECT DISTINCT '.
							'eflore_taxon.*, '.
							'esn_id_nom, '.
							'en_ce_rang '.
				    		
				    		'FROM '. 
				    		'eflore_taxon, '.
				    		'eflore_selection_nom, '.
				    		'eflore_nom '.
				    		
				    		'WHERE en_nom_supra_generique LIKE ? '.  
							'AND en_ce_rang = ? '. 
							'AND en_id_nom = esn_id_nom '. 
							'AND en_id_version_projet_nom = esn_id_version_projet_nom '.
							'AND esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = ? '.
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '. 
				        	
							'ORDER BY en_nom_supra_generique ASC';
				break;
			case EF_CONSULTER_TAXON_LETTRE_GENRE :
				$sql =	'SELECT DISTINCT '.
							'eflore_taxon.*, '.
				    		'esn_id_nom, '.
				    		'en_ce_rang '.
				    		
				    		'FROM '. 
				    		'eflore_taxon, '.
				    		'eflore_selection_nom, '.
				    		'eflore_nom '.
				    		
				    		'WHERE en_nom_genre LIKE ? '.  
				        	'AND en_ce_rang = ? '.
							'AND en_id_nom = esn_id_nom '. 
							'AND en_id_version_projet_nom = esn_id_version_projet_nom '.
							'AND esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = ? '. 
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '. 
				        	
							'ORDER BY en_nom_genre ASC';
				break;
			case EF_CONSULTER_TAXON_CLASSIF_FILS :
				$sql =	'SELECT DISTINCT '. 
							'eflore_taxon.*, '.
							'esn_id_nom, '.
							'en_ce_rang '.
							
							'FROM '. 
							'eflore_taxon, '.
							'eflore_taxon_relation, '.
							'eflore_selection_nom, '.
							'eflore_nom '.
							
							'WHERE '.
							'en_id_nom = esn_id_nom '.
							'AND en_id_version_projet_nom = esn_id_version_projet_nom '.
							'AND esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '.
							'AND et_id_version_projet_taxon = etr_id_version_projet_taxon_1 '.
							'AND et_id_taxon = etr_id_taxon_1 '.
							'AND etr_id_version_projet_taxon_2 = ? '.
							'AND etr_id_taxon_2 = ? '.
							'AND etr_id_categorie_taxon = 3 '.
							'AND etr_id_valeur_taxon = 3 ';
				break;
			case EF_CONSULTER_TAXON_CLASSIF_FILS_NBRE :
				$sql =	'SELECT '.
							'COUNT(et_id_taxon) AS nbre '.
							
							'FROM '. 
							'eflore_taxon, '.
							'eflore_taxon_relation '.
							
							'WHERE '.
							'et_id_version_projet_taxon = etr_id_version_projet_taxon_1 '.
							'AND et_id_taxon = etr_id_taxon_1 '.
							'AND etr_id_version_projet_taxon_2 = ? '.
							'AND etr_id_taxon_2 = ? '.
							'AND etr_id_categorie_taxon = 3 '.
							'AND etr_id_valeur_taxon = 3 ' .

							'GROUP BY etr_id_taxon_2';
				break;
			case EF_CONSULTER_TAXON_CLASSIF_FILS_NBRE_GROUPE_ID :
				$sql =	'SELECT esn_id_nom, '.
							'COUNT(etr_id_taxon_2) AS nbre '.
							
							'FROM '.
							'eflore_selection_nom, '.
							'eflore_taxon_relation '.
							
							'WHERE '.
							'esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = etr_id_version_projet_taxon_2 '.
							'AND esn_id_taxon = etr_id_taxon_2 '.
							'AND etr_id_version_projet_taxon_2 = ? '.
							'AND etr_id_taxon_2 IN (!) '.
							'AND etr_id_categorie_taxon = 3 '.
							'AND etr_id_valeur_taxon = 3 ' .

							'GROUP BY etr_id_taxon_2';
				break;
			case EF_CONSULTER_TAXON_NBRE_PROJET :
				$sql =	'SELECT '.
							'COUNT(et_id_taxon) AS nbre '.
							
							'FROM '. 
							'eflore_taxon '.
							
							'WHERE '.
							'et_id_version_projet_taxon = ? '.

							'GROUP BY et_id_taxon';
				break;
			case EF_CONSULTER_TAXON_VERSION_ID :
				$sql =	'SELECT DISTINCT '. 
							'eflore_taxon.*, '.
							'esn_id_nom '.
							
							'FROM '. 
							'eflore_taxon, '.
							'eflore_selection_nom '.
							
							'WHERE '.
							'esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '. 
							'AND et_id_version_projet_taxon = ? '.
							'AND et_id_taxon = ? ';
				break;
			case EF_CONSULTER_TAXON_VERSION_GROUPE_ID :
				$sql =	'SELECT DISTINCT '. 
							'eflore_taxon.*, '.
							'esn_id_nom, '.
							'esn_id_version_projet_nom '.
							
						'FROM '. 
							'eflore_taxon, '.
							'eflore_selection_nom '.
							
						'WHERE '.
							'esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '. 
							'AND et_id_version_projet_taxon = ? '.
							'AND et_id_taxon IN (!) ';
				break;
			case EF_CONSULTER_TAXON_VERSION :
				$sql =	'SELECT DISTINCT '. 
							'esn_id_nom '.
							
							'FROM '. 
							'eflore_taxon, '.
							'eflore_selection_nom '.
							
							'WHERE '.
							'esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '. 
							'AND et_id_version_projet_taxon = ? ';
				break;
			case EF_CONSULTER_TAXON_VERSION_RANG :
				$sql =	'SELECT DISTINCT '. 
							'esn_id_nom,'.
							'en_ce_rang '.
							
							'FROM '. 
							'eflore_taxon, '.
							'eflore_selection_nom '.
							'eflore_selection_nom, '.
							'eflore_nom '.
							
							'WHERE '.
							'en_ce_rang = ? '.
							'AND en_id_nom = esn_id_nom '.
							'AND en_id_version_projet_nom = esn_id_version_projet_nom '.
							'AND esn_ce_statut = 3 '.
							'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
							'AND esn_id_taxon = et_id_taxon '. 
							'AND et_id_version_projet_taxon = ? ';
				break;
							
		}
		$this->setRequete($sql);
		return parent::consulter($param);
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: TaxonDao.class.php,v $
* Revision 1.9  2006-05-19 15:10:07  jp_milcent
* Amélioration de la gestion des informations sur les projets.
* Début gestion d'un graphique du nombre de noms publiés par année.
*
* Revision 1.8  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.7.2.1  2006/03/07 10:50:12  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet.
*
* Revision 1.7  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.6  2005/09/07 13:16:41  jp_milcent
* Fin de la gestion de l'arborescence.
*
* Revision 1.5  2005/09/05 15:53:30  jp_milcent
* Ajout de la gestion du bouton plus et moins.
* Optimisation en cours.
*
* Revision 1.4  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.3  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.2  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.1  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>