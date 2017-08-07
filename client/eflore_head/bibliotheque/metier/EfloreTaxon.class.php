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
// CVS : $Id: EfloreTaxon.class.php,v 1.6 2007-08-23 08:04:16 jp_milcent Exp $
/**
* eflore_bp - EfloreTaxon.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.6 $ $Date: 2007-08-23 08:04:16 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreTaxon extends aEfloreModule {
	
	public function consulterNomRetenu($taxon_projet_id, $taxon_id, $relations = false)
	{
		$sql = 	'SELECT DISTINCT eflore_nom.*, '.
				(($relations) ? '	eflore_nom_relation.*, ' : '').				
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
				'	esn_id_taxon, '.
				'	esn_id_version_projet_taxon '.
				'FROM eflore_selection_nom, eflore_nom, eflore_nom_rang, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_bex, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_b, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_mex, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_m, '.
				'	eflore_naturaliste_intitule_abreviation AS auteur_in, '.
				'	eflore_nom_intitule_commentaire, '.
				(($relations) ? '	eflore_nom_relation, ' : '').				
				'	eflore_nom_citation '.
				
				'WHERE en_ce_auteur_basio_ex = auteur_bex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_basio = auteur_b.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif_ex = auteur_mex.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_auteur_modif = auteur_m.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_intitule_cn = enic_id_intitule_cn '.
				'AND en_ce_citation_initiale = enci_id_citation '.
				'AND enci_ce_auteur_in = auteur_in.enaia_id_intitule_naturaliste_abrege '.
				'AND en_ce_rang = enrg_id_rang '.
				'AND esn_ce_statut = 3 '.// = Nom retenu
				"AND esn_id_taxon IN ($taxon_id) ".
				"AND esn_id_version_projet_taxon = $taxon_projet_id ".
				'AND esn_id_nom = en_id_nom '.
				'AND esn_id_version_projet_nom = en_id_version_projet_nom '.
				(($relations) ? 'AND en_id_nom = enr_id_nom_1 ' : '').
				(($relations) ? 'AND en_id_version_projet_nom = enr_id_version_projet_nom_1 ' : '');
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterNbreTaxonParRang($taxon_projet_id, $historique = false, $rang = 0, $signe = '>')
	{
		$bdd = ($historique) ?	EF_BDD_NOM_HISTORIQUE : EF_BDD_NOM_PRINCIPALE;
		$sql = 	'SELECT DISTINCT en_ce_rang, enrg_intitule_rang, COUNT(esn_id_taxon) AS et_nombre '.
       			"FROM $bdd.eflore_selection_nom, $bdd.eflore_nom, $bdd.eflore_nom_rang ".
				"WHERE esn_id_version_projet_taxon = $taxon_projet_id ".
				'AND esn_ce_statut = 3 '.// = Nom retenu				
				'AND esn_id_nom = en_id_nom '.
				'AND esn_id_version_projet_nom = en_id_version_projet_nom '.
				"AND en_ce_rang $signe $rang ".
				'AND en_ce_rang = enrg_id_rang '.
				'GROUP BY en_ce_rang';
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterTaxonParRang($taxon_projet_id, $rang = 0)
	{
		$sql =	'SELECT DISTINCT '. 
				'	esn_id_nom, esn_id_version_projet_nom, '.
				'	en_ce_rang '.
				'FROM '. 
				'	eflore_taxon, '.
				'	eflore_selection_nom, '.
				'	eflore_nom '.
				'WHERE '.
				"en_ce_rang = $rang ".
				'AND en_id_nom = esn_id_nom '.
				'AND en_id_version_projet_nom = esn_id_version_projet_nom '.
				'AND esn_ce_statut = 3 '.
				'AND esn_id_version_projet_taxon = et_id_version_projet_taxon '.
				'AND esn_id_taxon = et_id_taxon '. 
				"AND et_id_version_projet_taxon = $taxon_projet_id ";
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterAvoirProtection($projet_taxon_id, $nt)
	{
		$sql = 	'SELECT * '.
				'FROM eflore_taxon_a_protection '.
				"WHERE etap_id_taxon = $nt ".
				"AND etap_id_version_projet_taxon = $projet_taxon_id ";
		//$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreTaxon.class.php,v $
* Revision 1.6  2007-08-23 08:04:16  jp_milcent
* Ajout de la recherche par rang et par protection.
*
* Revision 1.5  2007-08-17 13:14:13  jp_milcent
* Limitation au niveau des statuts de protection.
*
* Revision 1.4  2007-08-05 22:38:26  jp_milcent
* Modificaiton d'une requete pour pouvoir récupérer les relations des noms retenus.
*
* Revision 1.3  2007-08-04 21:51:21  jp_milcent
* Ajout de requêtes pour les stats des projets.
*
* Revision 1.2  2007-07-09 12:52:54  jp_milcent
* Ajout du statut du nom pour la requete sur les noms retenu.
*
* Revision 1.1  2007-07-05 19:07:52  jp_milcent
* Amélioration et ajout de requêtes.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
