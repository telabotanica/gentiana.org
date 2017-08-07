<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                      |
// |                                                                                                      |
// | eflore_bp is free software; you can redistribute it and/or modify                                    |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_bp is distributed in the hope that it will be useful,                                         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreChorologie.class.php,v 1.16 2007-09-21 15:02:47 jp_milcent Exp $
/**
* eflore_bp - EfloreChorologie.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.16 $ $Date: 2007-09-21 15:02:47 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreChorologie extends aEfloreModule {
	
	public function consulterDonnees($projet_choro_id, $protection = false)
	{
		// +-------------------------------------------------------------------------------------------------------+
		// Récupération des différents projets de données choro utilisant le projet du taxon
		$sql = 	'SELECT DISTINCT ezg_id_projet_zg, ezg_id_zone_geo, ezg_intitule_principal, ezg_code, ezg_couleur_rvb, '.
				'	COUNT(ecd_id_donnee_choro) AS ecd_donnee_choro_nbre '.
				'FROM eflore_chorologie_donnee, '.
				(($protection) ? '	eflore_taxon_a_protection, eflore_protection, ' : '').
				'eflore_zg '.
				"WHERE ecd_id_version_projet_donnee_choro = $projet_choro_id ".
 				(($protection) ? 'AND ecd_ce_taxon = etap_id_taxon ' : '').				
				(($protection) ? 'AND ecd_ce_version_projet_taxon = etap_id_version_projet_taxon ' : '').
				(($protection) ? 'AND etap_id_protection = ept_id_protection ' : '').				
				(($protection) ? 'AND etap_id_version_projet_protection = ept_id_version_projet_protection ' : '').
				((isset($protection['statut'])) ? "AND ept_ce_statut IN ($protection[statut]) " : '').				
				((isset($protection['texte_application'])) ? "AND ept_ce_texte_application IN ($protection[texte_application]) " : '').
				'AND ecd_ce_zone_geo = ezg_id_zone_geo '.
				'AND ecd_ce_version_projet_zg = ezg_id_projet_zg '.
				'GROUP BY ecd_ce_zone_geo, ecd_ce_version_projet_zg';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterDonneesTaxon($choro_projet_id, $pr_nt, $nt)
	{
		$sql = 	'SELECT DISTINCT ezg_intitule_principal, ezg_code, ezg_couleur_rvb, eci_ce_notion_choro, eci_ce_version_projet_notion_choro '.
				'FROM eflore_chorologie_donnee, eflore_chorologie_information, eflore_zg '. 
				'WHERE ecd_id_version_projet_donnee_choro = '.$choro_projet_id.' '.
				'AND ecd_ce_version_projet_taxon = '.$pr_nt.' '.
				'AND ecd_ce_taxon = '.$nt.' '.
				'AND ecd_ce_zone_geo = ezg_id_zone_geo '.
				'AND ecd_ce_version_projet_zg = ezg_id_projet_zg '.
				'AND ecd_id_donnee_choro = eci_ce_donnee_choro '.
				'AND ecd_id_version_projet_donnee_choro = eci_ce_version_projet_donnee_choro '.
				'';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterZoneGeoNombre($projet_choro_id, $lettre = '*')
	{
		// +-------------------------------------------------------------------------------------------------------+
		// Récupération des différents projets de données choro utilisant le projet du taxon
		$sql = 	'SELECT COUNT(DISTINCT ecd_ce_zone_geo) '.
				'FROM eflore_chorologie_donnee '.(($lettre != '*') ? ', eflore_zg ' : '').
				'WHERE ecd_id_version_projet_donnee_choro = '.$projet_choro_id.' '.
				(($lettre != '*') ? 'AND ecd_ce_zone_geo = ezg_id_zone_geo ' : '').	
				(($lettre != '*') ? 'AND ecd_ce_version_projet_zg = ezg_id_projet_zg ' : '').
				(($lettre != '*') ? 'AND ezg_intitule_principal LIKE "'.$lettre.'%" ' : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterZoneGeo($projet_choro_id, $lettre = '*')
	{
		// +-------------------------------------------------------------------------------------------------------+
		// Récupération des différents projets de données choro utilisant le projet du taxon
		$sql = 	'SELECT DISTINCT  ezg_id_zone_geo, ezg_id_projet_zg, ezg_intitule_principal, ezg_code '.
				'FROM eflore_chorologie_donnee, eflore_zg '.
				'WHERE ecd_id_version_projet_donnee_choro = '.$projet_choro_id.' '.
				'AND ecd_ce_zone_geo = ezg_id_zone_geo '.	
				'AND ecd_ce_version_projet_zg = ezg_id_projet_zg '.
				(($lettre != '*') ? 'AND ezg_intitule_principal LIKE "'.$lettre.'%" ' : '').
				'ORDER BY ezg_intitule_principal ASC';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterTaxonsNbre($choro_projet_id, $zg_id = null, $zg_projet_id = null, $lettre = '*', $protection = false)
	{
		$sql = 	'SELECT COUNT(DISTINCT en_id_nom) '. 
				'FROM eflore_chorologie_donnee, eflore_selection_nom, '.
				(($protection) ? '	eflore_taxon_a_protection, eflore_protection, ' : '').
				(($lettre != '*') ? 'eflore_nom_intitule,  ' : '').
				'	eflore_nom '. 
				'WHERE ecd_id_version_projet_donnee_choro = '.$choro_projet_id.' '.
 				((!is_null($zg_projet_id)) ? '	AND ecd_ce_version_projet_zg = '.$zg_projet_id.' ' : '').
 				((!is_null($zg_projet_id)) ? '	AND ecd_ce_zone_geo = '.$zg_id.' ' : '').
 				(($protection) ? '	AND ecd_ce_taxon = etap_id_taxon ' : '').				
				(($protection) ? '	AND ecd_ce_version_projet_taxon = etap_id_version_projet_taxon ' : '').
				(($protection) ? '	AND etap_id_protection = ept_id_protection ' : '').				
				(($protection) ? '	AND etap_id_version_projet_protection = ept_id_version_projet_protection ' : '').
				((isset($protection['statut'])) ? "	AND ept_ce_statut IN ($protection[statut]) " : '').				
				((isset($protection['texte_application'])) ? "	AND ept_ce_texte_application IN ($protection[texte_application]) " : '').
 				'	AND ecd_ce_taxon = esn_id_taxon '.
 				'	AND ecd_ce_version_projet_taxon = esn_id_version_projet_taxon '.
 				'	AND esn_ce_statut = 3 '.
 				'	AND esn_id_nom = en_id_nom '.
 				'	AND esn_id_version_projet_nom = en_id_version_projet_nom '.
				(($lettre != '*') ? '	AND en_id_nom = eni_id_nom ' : '').
 				(($lettre != '*') ? '	AND en_id_version_projet_nom = eni_id_version_projet_nom ' : '').
 				(($lettre != '*') ? '	AND eni_id_valeur_format = 3 ' : '').
				(($lettre != '*') ? '	AND eni_intitule_nom LIKE "'.$lettre.'%" ' : '');
		//$this->setDebogage(true);
		$nbre = $this->executerSql($sql);
		return $nbre;
	}
	
	public function consulterTaxons($choro_projet_id, $zg_id = null, $zg_projet_id = null, $lettre = '*', $protection = false)
	{
		$sql = 	'SELECT DISTINCT eflore_selection_nom.*, eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang '.
				'FROM eflore_chorologie_donnee, eflore_selection_nom, eflore_nom, eflore_nom_rang, '.
				(($lettre != '*') ? 'eflore_nom_intitule,  ' : '').
				'	eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	eflore_nom_intitule_commentaire, '.
				(($protection) ? '	eflore_taxon_a_protection, eflore_protection, ' : '').
				'	eflore_nom_citation '.
				'WHERE '. 				
				'	ecd_id_version_projet_donnee_choro = '.$choro_projet_id.' '. 				
				((!is_null($zg_projet_id)) ? 'AND ecd_ce_version_projet_zg = '.$zg_projet_id.' ' : '').
 				((!is_null($zg_projet_id)) ? 'AND ecd_ce_zone_geo = '.$zg_id.' ' : '').
 				(($protection) ? 'AND ecd_ce_taxon = etap_id_taxon ' : '').				
				(($protection) ? 'AND ecd_ce_version_projet_taxon = etap_id_version_projet_taxon ' : '').
				(($protection) ? 'AND etap_id_protection = ept_id_protection ' : '').				
				(($protection) ? 'AND etap_id_version_projet_protection = ept_id_version_projet_protection ' : '').
				((isset($protection['statut'])) ? "AND ept_ce_statut IN ($protection[statut]) " : '').				
				((isset($protection['texte_application'])) ? "AND ept_ce_texte_application IN ($protection[texte_application]) " : '').
 				'	AND ecd_ce_taxon = esn_id_taxon '.
 				'	AND ecd_ce_version_projet_taxon = esn_id_version_projet_taxon '.
 				'	AND esn_ce_statut = 3 '.
 				'	AND en_id_nom = esn_id_nom '.
 				'	AND en_id_version_projet_nom = esn_id_version_projet_nom '.
				'	AND en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'	AND en_ce_citation_initiale = enci_id_citation '.
				'	AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_rang = enrg_id_rang '.
				(($lettre != '*') ? '	AND en_id_nom = eni_id_nom ' : '').
 				(($lettre != '*') ? '	AND en_id_version_projet_nom = eni_id_version_projet_nom ' : '').
 				(($lettre != '*') ? '	AND eni_id_valeur_format = 3 ' : '').
				(($lettre != '*') ? 'AND eni_intitule_nom LIKE "'.$lettre.'%" ' : '').
				'ORDER BY en_nom_genre, en_epithete_infra_generique, en_epithete_espece, en_epithete_infra_specifique'.
				(($lettre != '*') ? ', eni_intitule_nom ' : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNotionsTaxons($choro_projet_id, $zg_id = null, $zg_projet_id = null, $lettre = '*', $protection = false)
	{
		$sql = 	'SELECT DISTINCT eflore_selection_nom.*, eflore_nom.*, '.
				'	auteur_bex.enaia_intitule_abrege AS en_auteur_basio_ex, '.
				'	auteur_b.enaia_intitule_abrege AS en_auteur_basio, '.
				'	auteur_mex.enaia_intitule_abrege AS en_auteur_modif_ex, '.
				'	auteur_m.enaia_intitule_abrege AS en_auteur_modif, '.
				'	enci_ce_auteur_in, '.
				'	auteur_in.enaia_intitule_abrege AS en_auteur_in, '.
				'	enci_intitule_citation_origine, '.
				'	enci_annee_citation, '.
				'	enic_intitule_cn_origine, '.
				'	enic_intitule_cn_complet, '.
				'	enrg_id_rang, '.
				'	enrg_abreviation_rang, '.
				'	enrg_intitule_rang, '.
				' 	ecn_intitule_principal, '.
				'	ecn_code_notion '. 
				'FROM eflore_chorologie_donnee, eflore_chorologie_information, eflore_chorologie_notion, '.
				'	eflore_selection_nom, eflore_nom, eflore_nom_rang, '.
				(($lettre != '*') ? 'eflore_nom_intitule,  ' : '').
				'	eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	eflore_nom_intitule_commentaire, '.
				(($protection) ? '	eflore_taxon_a_protection, eflore_protection, ' : '').
				'	eflore_nom_citation '. 
				'WHERE ecd_id_version_projet_donnee_choro = '.$choro_projet_id.' '.
				((!is_null($zg_projet_id)) ? 'AND ecd_ce_version_projet_zg = '.$zg_projet_id.' ' : '').
 				((!is_null($zg_projet_id)) ? 'AND ecd_ce_zone_geo = '.$zg_id.' ' : '').
				(($protection) ? 'AND ecd_ce_taxon = etap_id_taxon ' : '').				
				(($protection) ? 'AND ecd_ce_version_projet_taxon = etap_id_version_projet_taxon ' : '').
				(($protection) ? 'AND etap_id_protection = ept_id_protection ' : '').				
				(($protection) ? 'AND etap_id_version_projet_protection = ept_id_version_projet_protection ' : '').
				((isset($protection['statut'])) ? "AND ept_ce_statut IN ($protection[statut]) " : '').
				((isset($protection['texte_application'])) ? "AND ept_ce_texte_application IN ($protection[texte_application]) " : ''). 				
				'	AND ecd_id_donnee_choro = eci_ce_donnee_choro '.
				'	AND ecd_id_version_projet_donnee_choro = eci_ce_version_projet_donnee_choro '.
				'	AND eci_ce_notion_choro = ecn_id_notion_choro '.
				'	AND eci_ce_version_projet_notion_choro = ecn_id_version_projet_notion_choro '.
 				'	AND ecd_ce_taxon = esn_id_taxon '.
 				'	AND ecd_ce_version_projet_taxon = esn_id_version_projet_taxon '.
 				'	AND esn_ce_statut = 3 '.
 				'	AND en_id_nom = esn_id_nom '.
 				'	AND en_id_version_projet_nom = esn_id_version_projet_nom '.
				'	AND en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'	AND en_ce_citation_initiale = enci_id_citation '.
				'	AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'	AND en_ce_rang = enrg_id_rang '.
 				(($lettre != '*') ? '	AND en_id_nom = eni_id_nom ' : '').
 				(($lettre != '*') ? '	AND en_id_version_projet_nom = eni_id_version_projet_nom ' : '').
 				(($lettre != '*') ? '	AND eni_id_valeur_format = 3 ' : '').
 				(($lettre != '*') ? 'AND eni_intitule_nom LIKE "'.$lettre.'%" ' : '').
				'ORDER BY en_nom_genre, en_epithete_infra_generique, en_epithete_espece, en_epithete_infra_specifique '.
				(($lettre != '*') ? ', eni_intitule_nom ' : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreChorologie.class.php,v $
* Revision 1.16  2007-09-21 15:02:47  jp_milcent
* Suppression du débogage.
*
* Revision 1.15  2007-09-20 12:55:59  jp_milcent
* Ajout de paramètrages aux requêtes SQL.
*
* Revision 1.14  2007-08-17 13:14:13  jp_milcent
* Limitation au niveau des statuts de protection.
*
* Revision 1.13  2007-07-11 17:10:21  jp_milcent
* Ajout d'une requete récupérant les noms retenus latins et les notions pour les données chorologiques d'une zone géo.
*
* Revision 1.12  2007-07-06 18:55:04  jp_milcent
* Mise en commentaire du débogage sql.
*
* Revision 1.11  2007-07-06 18:08:18  jp_milcent
* Récupération du nombre de zone géographique utilisé par un projet chorologique.
*
* Revision 1.10  2007-07-05 19:07:52  jp_milcent
* Amélioration et ajout de requêtes.
*
* Revision 1.9  2007-07-03 16:55:13  jp_milcent
* Ajout d'une requête pour créer une carte de "présence" par taxon.
*
* Revision 1.8  2007-07-02 15:33:01  jp_milcent
* Utilisation du Wrapper SQL pour l'ensemble des requêtes de ces modules.
*
* Revision 1.7  2007-06-29 16:58:42  jp_milcent
* Test du débogage.
*
* Revision 1.6  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.5  2007-06-27 17:07:17  jp_milcent
* Test de la gestion de relation entre tables.
*
* Revision 1.4  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
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