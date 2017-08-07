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
// CVS : $Id: EfloreVernaculaire.class.php,v 1.8 2007-08-30 19:14:47 jp_milcent Exp $
/**
* eflore_bp - EfloreVernaculaire.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.8 $ $Date: 2007-08-30 19:14:47 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreVernaculaire extends aEfloreModule {

	public function consulterNomRadical($radical = null, $taxon_projet_id = null)
	{
		$radical = $this->echapperQuote($radical);
		$sql = 	'SELECT DISTINCT '.
				'el_nom_langue_principal, '.
				'el_code_langue, '.
				'ezg_intitule_principal, '.
				'ezg_code, '.
				'ev_id_nom_vernaculaire, '.
				'ev_intitule_nom_vernaculaire, '.
				'eva_notes_emploi_nom_vernaculaire, '.
				'eva_ce_emploi, '.
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
				((is_null($taxon_projet_id)) ? '' : "AND eva_id_version_projet_taxon_ref IN ($taxon_projet_id) ").
				((is_null($radical)) ? '' : "AND LOWER(ev_intitule_nom_vernaculaire) LIKE '$radical' "). 
				
				'ORDER BY ev_intitule_nom_vernaculaire ASC';
		//$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultats = $this->executerSql($sql);
		return $resultats;
	}
	
	public function consulterNomRadicalApproche($nom, $radical, $taxon_projet_id = null)
	{
		$radical = $this->echapperQuote($radical);
		$nom = $this->echapperQuote($nom);
		$sql = 	'SELECT DISTINCT '.
				'ev_intitule_nom_vernaculaire '.
								
				'FROM eflore_vernaculaire '.
				
				'WHERE '.
				'('.
				"	SOUNDEX( ev_intitule_nom_vernaculaire ) = SOUNDEX( '$nom' ) ".
				"	OR SOUNDEX( REVERSE( ev_intitule_nom_vernaculaire ) ) = SOUNDEX( REVERSE( '$nom' ) ) ".
				"	OR LOWER(ev_intitule_nom_vernaculaire) LIKE '$radical' ".
				')';
		//$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultats = $this->executerSql($sql);
		return $resultats;
	}
	
	public function consulterTaxonNomTypique($taxon_projet_id, $taxon_id)
	{
		$retour = '';
		$sql = 	'SELECT eflore_vernaculaire.ev_intitule_nom_vernaculaire '.
				'FROM eflore_vernaculaire_attribution, eflore_vernaculaire '.
				'WHERE eva_id_taxon_ref = '.$taxon_id.' '.
				'AND eva_id_version_projet_taxon_ref = '.$taxon_projet_id.' '.
				'AND eva_ce_emploi = 3 '.
				'AND eva_id_nom_vernaculaire = ev_id_nom_vernaculaire '.
				'AND eva_id_version_projet_nom_verna = ev_id_version_projet_nom_verna ';
		//$this->setDebogage(true);
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		$resultats = $this->executerSql($sql);
		foreach ($resultats as $resultat) {
			$retour .= $resultat['ev']['intitule_nom_vernaculaire'].', ';
		}
		return trim($retour, ', ');
	}

	public function consulterTaxonsNomTypique($liste_taxons_id)
	{
		$tab_resultats = array();
		foreach ($liste_taxons_id as $projet_taxon_id => $tab_taxons) {
			$tab_taxons_id = array();
			foreach ($tab_taxons as $taxon_id => $tab_taxon) {
				$tab_taxons_id[] = $taxon_id;
			}
			$sql = 	'SELECT eflore_vernaculaire.*, eva_id_taxon_ref, eva_id_version_projet_taxon_ref '.
					'FROM eflore_vernaculaire_attribution, eflore_vernaculaire '.
					'WHERE eva_id_taxon_ref IN ('.implode(',', $tab_taxons_id).') '.
					'AND eva_id_version_projet_taxon_ref = '.$projet_taxon_id.' '.
					'AND eva_ce_emploi = 3 '.
					'AND eva_id_nom_vernaculaire = ev_id_nom_vernaculaire '.
					'AND eva_id_version_projet_nom_verna = ev_id_version_projet_nom_verna ';
			//$this->setDebogage(true);
			$tab_resultats = array_merge($tab_resultats, $this->executerSql($sql));
		}
		
		return $tab_resultats;
	}
	
	public function consulterEmploi($emploi_id = null)
	{
		$sql = 	'SELECT * '.
				'FROM eflore_vernaculaire_conseil_emploi '.
				((is_null($emploi_id)) ? '' : "WHERE evce_id_emploi IN ($emploi_id) ");
		//$this->setDebogage(true);
		$resultats = $this->executerSql($sql);
		return $resultats;
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreVernaculaire.class.php,v $
* Revision 1.8  2007-08-30 19:14:47  jp_milcent
* Modificaiton de consulterNomRadical et ajout de la recherche sur les conseil d'emploi.
*
* Revision 1.7  2007-08-08 22:15:48  jp_milcent
* Simplification de la requête recherchant des correspondances.
*
* Revision 1.6  2007-08-05 22:40:10  jp_milcent
* Ajout des requêtes de recherche sur les noms vernaculaires.
*
* Revision 1.5  2007-07-05 19:07:52  jp_milcent
* Amélioration et ajout de requêtes.
*
* Revision 1.4  2007-07-02 15:33:01  jp_milcent
* Utilisation du Wrapper SQL pour l'ensemble des requêtes de ces modules.
*
* Revision 1.3  2007-06-29 16:23:31  jp_milcent
* Ajout de la gestion du wrapper SQL. Mise en classe abstraite de EfloreModule.
*
* Revision 1.2  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.1  2007-06-21 17:42:49  jp_milcent
* Ajout de méthodes mais nécessite de les uniformiser...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>