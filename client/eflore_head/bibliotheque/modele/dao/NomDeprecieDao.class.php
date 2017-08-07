<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore.                                                               |
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
// CVS : $Id: NomDeprecieDao.class.php,v 1.1 2007-06-19 10:32:57 jp_milcent Exp $
/**
* eFlore : Classe DAO Nom
*
*
*
*@package eFlore
*@subpackage Nomenclature
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// NOM
/** Récupère un nom pour un id précis.*/
define('EF_CONSULTER_NOM_ID', 'EFN1');
/** Récupère le nom pour un id et une version donnés.*/
define('EF_CONSULTER_NOM_VERSION_ID', 'EFN2');
/** Récupère les noms pour une version de projet et un radical.*/
define('EF_CONSULTER_NOM_VERSION', 'EFN3');
/** Récupère les noms pour une version de projet et un radical d'sp.'.*/
define('EF_CONSULTER_NOM_VERSION_SP', 'EFN4');
/** Récupère les noms pour une version de projet et un radical d'infrasp.'.*/
define('EF_CONSULTER_NOM_VERSION_INFRASP', 'EFN5');
/** Récupère l'intitulé court des noms pour une version de projet et un radical.*/
define('EF_CONSULTER_NOM_RADICAL_VERSION_INTITULE', 'EFN6');
/** Récupère les noms pour un radical donné. */
define('EF_CONSULTER_NOM', 'EFN7');
/** Récupère le nombre de nom par rang pour une version de projet. */
define('EF_CONSULTER_NOM_NBRE_PAR_RANG', 'EFN8');
/** Récupère le nombre de nom par année pour une version de projet. */
define('EF_CONSULTER_NOM_NBRE_PAR_ANNEE', 'EFN21');
/** Récupère les noms pour un radical d'sp. */
define('EF_CONSULTER_NOM_SP', 'EFN9');
/** Récupère les noms pour un radical d'infrasp.'.*/
define('EF_CONSULTER_NOM_INFRASP', 'EFN10');
/** Récupère l'intitulé court des noms pour un radical.*/
define('EF_CONSULTER_NOM_RADICAL_INTITULE', 'EFN11');
/** Récupère les noms pour un ensemble d'ID donnés.*/
define('EF_CONSULTER_NOM_GROUPE_ID', 'EFN12');
/** Récupère les noms de facon approche pour un radical quelconque */
define('EF_CONSULTER_NOM_APPROCHE', 'EFN13');
/** Récupère les noms de facon approche pour une version de projet et pour un radical quelconque */
define('EF_CONSULTER_NOM_APPROCHE_VERSION', 'EFN14');
/** Récupère les noms pour un radical donné dans la base de donnée historique et principale.*/
define('EF_CONSULTER_NOM_UNION', 'EFN15');
/** Récupère les noms pour un radical d'sp donné dans la base de donnée historique et principale.*/
define('EF_CONSULTER_NOM_UNION_SP', 'EFN16');
/** Récupère les noms pour un radical d'infrasp donné dans la base de donnée historique et principale.*/
define('EF_CONSULTER_NOM_UNION_INFRASP', 'EFN17');
/** Récupère l'intitulé court des noms pour un radical dans la base de donnée historique et principale.*/
define('EF_CONSULTER_NOM_RADICAL_UNION_INTITULE', 'EFN18');
/** Récupère l'intitulé court , a destination de la complétion, pour un radical genre + espece, dans la base de donnnée principale*/
define('EF_CONSULTER_NOM_COMPLETION_ESPECE', 'EFN19');
/** Récupère l'intitulé court , a destination de la complétion, pour un radical genre, dans la base de donnnée principale*/
define('EF_CONSULTER_NOM_COMPLETION_GENRE', 'EFN20');



// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class NomDeprecieDao extends AModeleDao
{
	/*** Attributes : ***/


	/*** Constructeur : ***/
	public function __construct(  ) {
		$this->nom_type_info = 'NomDeprecie';
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
		$select_std_ss_selection =
							'eflore_nom.*,
							auteur_bex.enaia_intitule_abrege AS abreviation_auteur_basio_ex,
							auteur_b.enaia_intitule_abrege AS abreviation_auteur_basio,
							auteur_mex.enaia_intitule_abrege AS abreviation_auteur_modif_ex,
							auteur_m.enaia_intitule_abrege AS abreviation_auteur_modif,
							enci_ce_auteur_in,
							auteur_in.enaia_intitule_abrege AS abreviation_auteur_in,
							enci_intitule_citation_origine,
							enci_annee_citation,
							enic_intitule_cn_origine,
							enic_intitule_cn_complet,
							enrg_id_rang,
							enrg_abreviation_rang,
							enrg_intitule_rang ';
		$select_std = $select_std_ss_selection.', '.
							'esn_ce_statut';
		$from_std_ss_selection =
							$this->getBddCourante().'.eflore_nom,
							'.$this->getBddCourante().'.eflore_nom_rang,
							'.$this->getBddCourante().'.eflore_naturaliste_intitule_abreviation AS auteur_bex,
							'.$this->getBddCourante().'.eflore_naturaliste_intitule_abreviation AS auteur_b,
							'.$this->getBddCourante().'.eflore_naturaliste_intitule_abreviation AS auteur_mex,
							'.$this->getBddCourante().'.eflore_naturaliste_intitule_abreviation AS auteur_m,
							'.$this->getBddCourante().'.eflore_naturaliste_intitule_abreviation AS auteur_in,
							'.$this->getBddCourante().'.eflore_nom_intitule_commentaire,
							'.$this->getBddCourante().'.eflore_nom_citation ';
		$from_std_ss_selection_principal =
							EF_BDD_NOM_PRINCIPALE.'.eflore_nom,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_nom_rang,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_naturaliste_intitule_abreviation AS auteur_bex,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_naturaliste_intitule_abreviation AS auteur_b,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_naturaliste_intitule_abreviation AS auteur_mex,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_naturaliste_intitule_abreviation AS auteur_m,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_naturaliste_intitule_abreviation AS auteur_in,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_nom_intitule_commentaire,
							'.EF_BDD_NOM_PRINCIPALE.'.eflore_nom_citation ';
		$from_std_ss_selection_historique =
							EF_BDD_NOM_HISTORIQUE.'.eflore_nom,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_nom_rang,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_naturaliste_intitule_abreviation AS auteur_bex,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_naturaliste_intitule_abreviation AS auteur_b,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_naturaliste_intitule_abreviation AS auteur_mex,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_naturaliste_intitule_abreviation AS auteur_m,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_naturaliste_intitule_abreviation AS auteur_in,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_nom_intitule_commentaire,
							'.EF_BDD_NOM_HISTORIQUE.'.eflore_nom_citation ';
		$from_std = 	$from_std_ss_selection.', '.
							'eflore_selection_nom';
		$from_std_projet = 	$from_std_ss_selection.', '.
							'eflore_projet_version';
		$from_std_projet_principal = 	$from_std_ss_selection_principal.', '.
										EF_BDD_NOM_PRINCIPALE.'.eflore_projet_version';
		$from_std_projet_historique = 	$from_std_ss_selection_historique.', '.
										EF_BDD_NOM_HISTORIQUE.'.eflore_projet_version';
		$where_std_ss_selection =
						 	'en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege
							AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege
							AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege
							AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege
							AND en_ce_intitule_cn = enic_id_intitule_cn
							AND en_ce_citation_initiale = enci_id_citation
							AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege
							AND en_ce_rang = enrg_id_rang ';
		$where_std = 	$where_std_ss_selection.
                    	'AND en_id_nom = esn_id_nom '.
                    	'AND en_id_version_projet_nom = esn_id_version_projet_nom '.
                    	'AND esn_id_version_projet_taxon = ? ';
		$where_std_projet = $where_std_ss_selection.
                    		'AND en_id_version_projet_nom = eprv_id_version '.
                    		'AND eprv_ce_projet IN (!)';
                    		
		switch($type) {
			// Consultation par id
			case EF_CONSULTER_NOM_ID :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.
						'FROM '.$from_std_ss_selection.
						'WHERE '.$where_std_ss_selection.' '.
						'AND en_id_nom = ? '.
						'AND en_id_version_projet_nom = ? ';
				break;
			case EF_CONSULTER_NOM_VERSION_ID :
				$sql = 	'SELECT DISTINCT '.$select_std.' '.
                		'FROM '.$from_std.' '.
						'WHERE '.$where_std.' '.
						'AND en_id_nom = ? ';
				break;
			// Un seul element de recherche
			case EF_CONSULTER_NOM_VERSION :
				$sql = 	'SELECT DISTINCT '.$select_std.' '.

                		'FROM '.$from_std.' '.

							'WHERE '.$where_std.' '.
							'AND ('.
							'	en_nom_genre LIKE ? '.
							'	OR en_nom_supra_generique LIKE ? '.
							'	OR en_epithete_infra_generique LIKE ? '.
							'	OR en_epithete_espece LIKE ? '.
							'	OR en_epithete_infra_specifique LIKE ? '.
                    	') ';
				break;
			// Deux elements de recherche
			case EF_CONSULTER_NOM_VERSION_SP :
				$sql = 	'SELECT DISTINCT '.$select_std.' '.
                		'FROM '.$from_std.' '.
						'WHERE '.$where_std.' '.
						'AND en_nom_genre LIKE ? '.
						'AND en_epithete_espece LIKE ? ';
				break;
			// Trois elements de recherche
			case EF_CONSULTER_NOM_VERSION_INFRASP :
				$sql = 	'SELECT DISTINCT '.$select_std.' '.
                		'FROM '.$from_std.' '.
						'WHERE '.$where_std.' '.
						'AND en_nom_genre LIKE ? '.
						'AND en_epithete_espece LIKE ? '.
						'AND en_epithete_infra_specifique LIKE ? ';
				break;
			case EF_CONSULTER_NOM_RADICAL_VERSION_INTITULE :
				$sql = 	'SELECT DISTINCT '.$select_std.' '.
                    	'FROM eflore_nom_intitule, '.$from_std.' '.
						'WHERE '.$where_std.' '.
						'AND eni_intitule_nom LIKE ? '.
                    	'AND eni_id_categorie_format = 3 '.
                    	'AND eni_id_valeur_format = 3 '.
                    	'AND en_id_nom = eni_id_nom ';
				break;
			case EF_CONSULTER_NOM_APPROCHE_VERSION :
	            	$sql = 	'SELECT DISTINCT '.$select_std.' '.
	                		'FROM '.$from_std.' '.
							'WHERE '.$where_std.' '.
							'AND ('.
							'SOUNDEX(en_nom_genre) = SOUNDEX(?) '.
							'OR SOUNDEX(en_nom_supra_generique) = SOUNDEX(?) '.
							'OR SOUNDEX(en_epithete_infra_generique) = SOUNDEX(?) '.
							'OR SOUNDEX(en_epithete_espece) = SOUNDEX(?) '.
							'OR SOUNDEX(en_epithete_infra_specifique) = SOUNDEX(?) '.
							'OR SOUNDEX(REVERSE(en_nom_genre)) = SOUNDEX(REVERSE(?)) '.
							'OR SOUNDEX(REVERSE(en_nom_supra_generique)) = SOUNDEX(REVERSE(?)) '.
							'OR SOUNDEX(REVERSE(en_epithete_infra_generique)) = SOUNDEX(REVERSE(?)) '.
							'OR SOUNDEX(REVERSE(en_epithete_espece)) = SOUNDEX(REVERSE(?)) '.
							'OR SOUNDEX(REVERSE(en_epithete_infra_specifique)) = SOUNDEX(REVERSE(?)) '.
                    	') ';
				break;
			case EF_CONSULTER_NOM_NBRE_PAR_RANG :
				$sql = 	'SELECT en_ce_rang, COUNT(en_id_nom) AS nombre '.
	               		'FROM eflore_nom '.
						'WHERE en_id_version_projet_nom = ? '.
						'GROUP BY en_ce_rang';
				break;
			case EF_CONSULTER_NOM_NBRE_PAR_ANNEE :
				$sql = 	'SELECT enci_annee_citation, COUNT(en_id_nom) AS nombre '.
	               		'FROM eflore_nom, eflore_nom_citation '.
						'WHERE en_id_version_projet_nom = ? '.
						'AND en_ce_citation_initiale = enci_id_citation '.
						'GROUP BY enci_annee_citation';
				break;
			// Un seul element de recherche
			case EF_CONSULTER_NOM :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet.' '.
						'WHERE '.$where_std_projet.' '.
							'AND ('.
							'	en_nom_genre LIKE ? '.
							'	OR en_nom_supra_generique LIKE ? '.
							'	OR en_epithete_infra_generique LIKE ? '.
							'	OR en_epithete_espece LIKE ? '.
							'	OR en_epithete_infra_specifique LIKE ? '.
                    	')';
				break;
			case EF_CONSULTER_NOM_UNION :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_principal.' '.
						'WHERE '.$where_std_projet.' '.
							'AND ('.
							'	en_nom_genre LIKE ? '.
							'	OR en_nom_supra_generique LIKE ? '.
							'	OR en_epithete_infra_generique LIKE ? '.
							'	OR en_epithete_espece LIKE ? '.
							'	OR en_epithete_infra_specifique LIKE ? '.
        	            	') '.
                    'UNION '.
                    	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_historique.' '.
						'WHERE '.$where_std_projet.' '.
							'AND ('.
							'	en_nom_genre LIKE ? '.
							'	OR en_nom_supra_generique LIKE ? '.
							'	OR en_epithete_infra_generique LIKE ? '.
							'	OR en_epithete_espece LIKE ? '.
							'	OR en_epithete_infra_specifique LIKE ? '.
            	        	')';
				break;
			// Deux elements de recherche
			case EF_CONSULTER_NOM_SP :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.

                		'FROM '.$from_std_projet.' '.

							'WHERE '.$where_std_projet.' '.
							'AND en_nom_genre LIKE ? '.
							'AND en_epithete_espece LIKE ? ';
				break;
			case EF_CONSULTER_NOM_UNION_SP :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_principal.' '.
						'WHERE '.$where_std_projet.' '.
						'AND en_nom_genre LIKE ? '.
						'AND en_epithete_espece LIKE ? '.
                    'UNION '.
                    	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_historique.' '.
						'WHERE '.$where_std_projet.' '.
						'AND en_nom_genre LIKE ? '.
						'AND en_epithete_espece LIKE ? ';
				break;
			// Trois elements de recherche
			case EF_CONSULTER_NOM_INFRASP :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
                		'FROM '.$from_std_projet.' '.
						'WHERE '.$where_std_projet.' '.
							'AND en_nom_genre LIKE ? '.
							'AND en_epithete_espece LIKE ? '.
							'AND en_epithete_infra_specifique LIKE ? ';
				break;
			
			case EF_CONSULTER_NOM_UNION_INFRASP :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_principal.' '.
						'WHERE '.$where_std_projet.' '.
							'AND en_nom_genre LIKE ? '.
							'AND en_epithete_espece LIKE ? '.
							'AND en_epithete_infra_specifique LIKE ? '.
					'UNION '.
                    	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_historique.' '.
						'WHERE '.$where_std_projet.' '.
							'AND en_nom_genre LIKE ? '.
							'AND en_epithete_espece LIKE ? '.
							'AND en_epithete_infra_specifique LIKE ? ';
				break;

			case EF_CONSULTER_NOM_RADICAL_INTITULE :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
                    	'FROM eflore_nom_intitule, '.$from_std_projet.' '.
						'WHERE '.$where_std_projet.' '. 
							'AND eni_intitule_nom LIKE ? '.
                    		'AND eni_id_categorie_format = 3 '.
                    		'AND eni_id_valeur_format = 3 '.
                    		'AND en_id_nom = eni_id_nom ';
				break;
			case EF_CONSULTER_NOM_RADICAL_UNION_INTITULE :
				$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_principal.' '.
						'WHERE '.$where_std_projet.' '.
							'AND eni_intitule_nom LIKE ? '.
                    		'AND eni_id_categorie_format = 3 '.
                    		'AND eni_id_valeur_format = 3 '.
                    		'AND en_id_nom = eni_id_nom '.
					'UNION '.
                    	'SELECT DISTINCT '.$select_std_ss_selection.' '.
	               		'FROM '.$from_std_projet_historique.' '.
						'WHERE '.$where_std_projet.' '.
							'AND eni_intitule_nom LIKE ? '.
                    		'AND eni_id_categorie_format = 3 '.
                    		'AND eni_id_valeur_format = 3 '.
                    		'AND en_id_nom = eni_id_nom ';
				break;
			case EF_CONSULTER_NOM_APPROCHE :
					$sql = 	'SELECT DISTINCT '.$select_std_ss_selection.' '.
                		'FROM '.$from_std_projet.' '.
						'WHERE '.$where_std_projet.' '.
						'AND ('.
						'SOUNDEX(en_nom_genre) = SOUNDEX(?) '.
						'OR SOUNDEX(en_nom_supra_generique) = SOUNDEX(?) '.
						'OR SOUNDEX(en_epithete_infra_generique) = SOUNDEX(?) '.
						'OR SOUNDEX(en_epithete_espece) = SOUNDEX(?) '.
						'OR SOUNDEX(en_epithete_infra_specifique) = SOUNDEX(?) '.
						'OR SOUNDEX(REVERSE(en_nom_genre)) = SOUNDEX(REVERSE(?)) '.
						'OR SOUNDEX(REVERSE(en_nom_supra_generique)) = SOUNDEX(REVERSE(?)) '.
						'OR SOUNDEX(REVERSE(en_epithete_infra_generique)) = SOUNDEX(REVERSE(?)) '.
						'OR SOUNDEX(REVERSE(en_epithete_espece)) = SOUNDEX(REVERSE(?)) '.
						'OR SOUNDEX(REVERSE(en_epithete_infra_specifique)) = SOUNDEX(REVERSE(?)) '.
                	') ';
				break;
			case EF_CONSULTER_NOM_GROUPE_ID :
				$sql = 	'SELECT '.$select_std_ss_selection.' '.
                    	'FROM '.$from_std_ss_selection.' '.
						'WHERE en_id_nom IN (!) '.
						'AND en_id_version_projet_nom = ? '.
						'AND '.$where_std_ss_selection;
				break;
				
			case EF_CONSULTER_NOM_COMPLETION_ESPECE :
				$sql = 	'SELECT DISTINCT en_nom_genre, en_epithete_espece, en_nom_supra_generique, en_epithete_infra_generique, en_epithete_espece, en_epithete_infra_specifique, en_ce_rang, enrg_abreviation_rang,  en_id_nom  '.
                    	'FROM '.EF_BDD_NOM_PRINCIPALE.'.eflore_nom, '.EF_BDD_NOM_PRINCIPALE.'.eflore_nom_rang '.
						'WHERE en_id_version_projet_nom = ? '.
						'AND en_nom_genre = ? '.
						'AND en_epithete_espece like ? ' .
						'AND en_ce_rang = enrg_id_rang '.
						'ORDER BY en_epithete_espece, en_nom_genre ' ;
				break;
			
			case EF_CONSULTER_NOM_COMPLETION_GENRE :
				$sql = 	'SELECT DISTINCT en_nom_genre '.
                    	'FROM '.EF_BDD_NOM_PRINCIPALE.'.eflore_nom '.
						'WHERE en_id_version_projet_nom = ? '.
						'AND en_nom_genre like ? '.
						'ORDER BY en_nom_genre ' ;
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
		$un_objet = $this->nom_type_info;
		$un_nom = new $un_objet();
		foreach ($donnees as $cle => $val) {
			switch ($cle) {
				case 'en_id_nom' :
					$un_nom->setId($val, 'nom');
					break;
				case 'en_id_version_projet_nom' :
					$un_nom->setId($val, 'version_projet_nom');
					break;
				case 'en_ce_auteur_basio_ex' :
					$un_nom->setCe($val, 'auteur_basio_ex');
					break;
				case 'en_ce_auteur_basio' :
					$un_nom->setCe($val, 'auteur_basio');
					break;
				case 'en_ce_auteur_modif_ex' :
					$un_nom->setCe($val, 'auteur_modif_ex');
					break;
				case 'en_ce_auteur_modif' :
					$un_nom->setCe($val, 'auteur_modif');
					break;
				case 'en_ce_citation_initiale' :
					$un_nom->setCe($val, 'citation_initiale');
					break;
				case 'en_ce_intitule_cn' :
					$un_nom->setCe($val, 'intitule_cn');
					break;
				case 'en_ce_rang' :
					$un_nom->setCe($val, 'rang');
					break;
				case 'en_nom_supra_generique' :
					$un_nom->setNomSupraGenerique($val);
					break;
				case 'en_nom_genre' :
					$un_nom->setNomGenre($val);
					break;
				case 'en_epithete_infra_generique' :
					$un_nom->setEpitheteInfraGenerique($val);
					break;
				case 'en_epithete_espece' :
					$un_nom->setEpitheteEspece($val);
					break;
				case 'en_epithete_infra_specifique' :
					$un_nom->setEpitheteInfraSpecifique($val);
					break;
				case 'en_epithete_cultivar' :
					$un_nom->setEpitheteCultivar($val);
					break;
				case 'en_intitule_groupe_cultivar' :
					$un_nom->setIntituleGroupeCultivar($val);
					break;
				case 'en_formule_hybridite' :
					$un_nom->setFormuleHybridite($val);
					break;
				case 'en_phrase_nom_non_nomme' :
					$un_nom->setPhraseNomNonNomme($val);
					break;
				case 'en_notes_nom' :
				case 'en_notes' :
					$un_nom->setNotes($val);
					break;
				case 'en_date_derniere_modif' :
					$un_nom->setDateDerniereModif($val);
					break;
				case 'en_ce_modifier_par' :
					$un_nom->setCe($val, 'modifier_par');
					break;
				case 'en_ce_etat' :
					$un_nom->setCe($val, 'etat');
					break;
				default:
					$un_nom->$cle = $val;
			}
			unset($donnees[$cle]);
		}
		return $un_nom;
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: NomDeprecieDao.class.php,v $
* Revision 1.1  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.34  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.33.2.1  2007/02/02 18:10:39  jp_milcent
* Suppression du décodage utf8.
*
* Revision 1.33  2007/01/17 16:42:35  jp_milcent
* Patch bogue utf8.
*
* Revision 1.32  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.31.2.1  2006/07/27 10:05:17  jp_milcent
* Gestion du référentiel pour la complétion.
* Améliorer la gestion du cache en fonction du référentiel.
* Améliorer la gestion de la fonction actualiserUrl().
*
* Revision 1.31  2006/07/20 13:14:08  jp_milcent
* Correction du nom d'un champ.
*
* Revision 1.30  2006/07/20 09:43:39  jp_milcent
* Modification d'un nom de champ qui posait problème pour l'api.
*
* Revision 1.29  2006/05/19 15:10:07  jp_milcent
* Amélioration de la gestion des informations sur les projets.
* Début gestion d'un graphique du nombre de noms publiés par année.
*
* Revision 1.28  2006/05/16 09:27:33  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.27  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.26  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.25  2006/04/11 10:08:36  ddelon
* completion
*
* Revision 1.24  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.22.2.3  2006/04/07 10:50:29  ddelon
* Completion a la google suggest
*
* Revision 1.23  2006/03/07 17:32:01  jp_milcent
* Fusion avec branche livraison_bdnbe_v1 : correction bogue sql
*
* Revision 1.22.2.2  2006/03/09 13:31:25  jp_milcent
* Gestion des id des projets dans lesquels limités les recherches d'un nom lorsqu'on sélectionne recherche dans "Tous les référentiels".
*
* Revision 1.22.2.1  2006/03/07 12:01:23  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet de nom.
*
* Revision 1.22  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.21  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.20  2005/12/05 14:28:15  jp_milcent
* Correction affichage des cultivars.
*
* Revision 1.19  2005/12/05 13:13:20  jp_milcent
* Correction bogue : écrasement sauvage des constantes.
*
* Revision 1.18  2005/12/05 10:51:36  jp_milcent
* Remise en route des requêtes sur l'intitulé complet du nom.
* Il faudra transférer cette intitulé directement dans la table nom pour que cela soit plus simple à gérer.
*
* Revision 1.17  2005/12/04 23:57:28  ddelon
* Recherche approchee
*
* Revision 1.16  2005/12/02 21:29:41  ddelon
* Limitation recherche nom verna
*
* Revision 1.15  2005/11/28 22:11:44  ddelon
* Commentaire
*
* Revision 1.14  2005/11/28 17:02:40  ddelon
* correction assignation champ hybridite
*
* Revision 1.13  2005/10/21 16:28:54  jp_milcent
* Amélioration des onglets Synonymies et Synthèse.
*
* Revision 1.12  2005/10/13 16:25:05  jp_milcent
* Ajout de la classification à la synthèse.
*
* Revision 1.11  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.10  2005/10/06 20:23:30  jp_milcent
* Ajout de classes métier pour le module Nomenclature.
*
* Revision 1.9  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.8  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
*
* Revision 1.7  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.6  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les référentiels.
*
* Revision 1.5  2005/09/05 15:53:30  jp_milcent
* Ajout de la gestion du bouton plus et moins.
* Optimisation en cours.
*
* Revision 1.4  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.3  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
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