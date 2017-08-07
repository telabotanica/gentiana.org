<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
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
// CVS : $Id: EfloreProtection.class.php,v 1.10 2007-08-20 15:33:57 jp_milcent Exp $
/**
* eflore_bp - EfloreProtection.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.10 $ $Date: 2007-08-20 15:33:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreProtection extends aEfloreModule {

	public function recupererProtections($nt, $projet_taxon_id, $limitation = false)
	{
		$tab_retour = array();
		$Taxon = new EfloreTaxon();
		$tab_taxons = $Taxon->consulterAvoirProtection($projet_taxon_id, $nt);
		
		// Si nous avons trouvé des taxons avec des protections
		if (isset($tab_taxons)) {
			// Gestion de la limitation à certains textes et statuts
			$limit_statut = null;
			$limit_txt = null;
			if ($limitation) {
				foreach (explode(',', $limitation['statut']) as $val) {
					$limit_statut[trim($val)] = trim($val);
				}
				foreach (explode(',', $limitation['texte_application']) as $val) {
					$limit_txt[trim($val)] = trim($val);
				}
			}

			$tab_protections = false;
			if ($tab_taxons) {
				$tab_protections_total = array();
				foreach ($tab_taxons as $taxon) {
					$tab_protections_total[$taxon['etap']['id']['version_projet_protection']][] = $taxon['etap']['id']['protection'];
				}
				foreach ($tab_protections_total as $projet_protection_id => $tab_protections) {
					$tab_protections = $this->consulterProtection($projet_protection_id, implode(',', $tab_protections));
				}
			}
			
			$aso_zg = array();
			$aso_statut = array();
			$aso_txt_appli = array();
			if ($tab_protections) {
				foreach ($tab_protections as $protection) {
					if (isset($limit_statut) && !isset($limit_statut[$protection['ept']['ce']['statut']])) {
						continue;
					} else if (isset($limit_txt) && !isset($limit_txt[$protection['ept']['ce']['texte_application']])) {
						continue;
					}
					$aso_retour = array();
					$aso_retour['nom_scientifique'] = $protection['ept']['nom_scientifique'];
					$aso_retour['nom_vernaculaire'] = $protection['ept']['nom_vernaculaire'];
					$aso_retour['notes'] = $protection['ept']['notes'];
					
					$aso_retour['zg'] = $protection['ept']['ce']['zone_geo'].'-'.$protection['ept']['ce']['version_projet_zg'];
					if (!isset($aso_zg[$protection['ept']['ce']['version_projet_zg']][$protection['ept']['ce']['zone_geo']])) {
						$aso_zg[$protection['ept']['ce']['version_projet_zg']][$protection['ept']['ce']['zone_geo']] = $protection['ept']['ce']['zone_geo'];
					}
					$aso_retour['statut'] = $protection['ept']['ce']['statut'];
					if (!isset($aso_statut[$aso_retour['statut']])) {
						$aso_statut[$aso_retour['statut']] = $aso_retour['statut'];
					}
					
					$aso_retour['txt_appli'] = $protection['ept']['ce']['texte_application'];
					if (!isset($aso_txt_appli[$aso_retour['txt_appli']])) {
						$aso_txt_appli[$aso_retour['txt_appli']] = $aso_retour['txt_appli'];
					}
					
					$tab_retour[] = $aso_retour;
				}
			}
			
			// Gestion des zones géo
			if (count($aso_zg) > 0) {
				$Zg = new EfloreZoneGeographique();
				foreach ($aso_zg as $projet_zg_id => $tab_zones_geo_id) {
					$tab_zg = $Zg->consulterZg($projet_zg_id, implode(',',$tab_zones_geo_id));
				}
				$aso_zg = array();
				foreach ($tab_zg as $zg) {
					$id = $zg['ezg']['id']['zone_geo'].'-'.$zg['ezg']['id']['projet_zg'];
					$aso_zg[$id]['intitule'] = $zg['ezg']['intitule_principal'];
					$aso_zg[$id]['abreviation'] = $zg['ezg']['code'];
				}
			}
			
			// Gestion des statuts
			if (count($aso_statut) > 0) {
				$tab_statuts = $this->consulterProtectionStatut(implode(',', $aso_statut));
				$aso_statut = array();
				foreach ($tab_statuts as $statut) {
					$id = $statut['epts']['id']['statut'];
					$aso_statut[$id]['intitule'] = $statut['epts']['intitule'];
					$aso_statut[$id]['abreviation'] = $statut['epts']['abreviation'];
					$aso_statut[$id]['description'] = $statut['epts']['description'];
				}
			}
			
			// Gestion des textes d'application
			if (count($aso_txt_appli) > 0) {
				$tab_textes = $this->consulterProtectionTexte(implode(',',$aso_txt_appli));
				$aso_txt_appli = array();
				foreach ($tab_textes as $txt) {
					$id = $txt['eptt']['id']['texte'];
					$aso_txt_appli[$id]['intitule'] = $txt['eptt']['intitule'];
					$aso_txt_appli[$id]['abreviation'] = $txt['eptt']['abreviation'];
					$aso_txt_appli[$id]['description'] = $txt['eptt']['description'];
					$aso_txt_appli[$id]['url'] = $txt['eptt']['url_texte_loi'];
					$aso_txt_appli[$id]['nor'] = $txt['eptt']['nor'];
				}
			}
			
			// Mise à jour complémentaire du tableau de sortie
			foreach ($tab_retour as $cle => $aso_retour) {
				if (count($aso_zg) > 0) {
					$aso_retour['zg_intitule'] = $aso_zg[$aso_retour['zg']]['intitule'];
					$aso_retour['zg_abreviation'] = $aso_zg[$aso_retour['zg']]['abreviation'];
				}
				if (count($aso_statut) > 0) {
					$aso_retour['statut_intitule'] = $aso_statut[$aso_retour['statut']]['intitule'];
					$aso_retour['statut_abreviation'] = $aso_statut[$aso_retour['statut']]['abreviation'];
					$aso_retour['statut_description'] = $aso_statut[$aso_retour['statut']]['description'];
				}
				if (count($aso_txt_appli) > 0) {
					$aso_retour['txt_appli_intitule'] = $aso_txt_appli[$aso_retour['txt_appli']]['intitule'];
					$aso_retour['txt_appli_abreviation'] = $aso_txt_appli[$aso_retour['txt_appli']]['abreviation'];
					$aso_retour['txt_appli_description'] = $aso_txt_appli[$aso_retour['txt_appli']]['description'];
					$aso_retour['txt_appli_url'] = $aso_txt_appli[$aso_retour['txt_appli']]['url'];
					$aso_retour['txt_appli_nor'] = $aso_txt_appli[$aso_retour['txt_appli']]['nor'];
				}
				
				$tab_retour[$cle] = $aso_retour;
			}
			return $tab_retour;
		} else {
			return false;
		}
	}
	
	public function consulterProtection($protection_projet_id, $protection_id) 
	{
		$sql = 	'SELECT eflore_protection.* '.
				'FROM eflore_protection '.
				"WHERE ept_id_version_projet_protection = $protection_projet_id ".
				"AND ept_id_protection IN ($protection_id) ";
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterProtectionStatut($statut_id)
	{
		$sql = 	'SELECT * '.
			'FROM eflore_protection_statut '.
			"WHERE epts_id_statut IN ($statut_id) ";
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
	
	public function consulterProtectionTexte($texte_id) 
	{
		$sql = 	'SELECT * '.
				'FROM eflore_protection_texte '.
				"WHERE eptt_id_texte IN ($texte_id) ";
		$this->getWrapperSql()->setMode(EfloreAdaptateurSql::RESULTAT_TABLEAU_MULTIPLE);
		//$this->setDebogage(true);
		$resultat = $this->executerSql($sql);
		return $resultat;
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreProtection.class.php,v $
* Revision 1.10  2007-08-20 15:33:57  jp_milcent
* Ajout de tests sur les tableaux vides pour éviter les erreurs.
*
* Revision 1.9  2007-08-17 13:14:13  jp_milcent
* Limitation au niveau des statuts de protection.
*
* Revision 1.8  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.7  2007-06-11 12:44:52  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.6  2007-06-01 15:11:39  jp_milcent
* Correction bogue : plus de création de fichier sql de stockage des requêtes.
*
* Revision 1.5  2007-05-11 15:34:51  jp_milcent
* Modification de nom de méthodes.
*
* Revision 1.4  2007/02/09 16:54:36  jp_milcent
* Nouveau module Zone Géo basé sur la version 1.2.
*
* Revision 1.3  2007/02/07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.2.2.1  2007/02/02 18:11:04  jp_milcent
* Ajout du décodage utf8.
*
* Revision 1.2  2007/01/08 18:45:40  jp_milcent
* Correction problème zg, template et amélioration du rendu.
*
* Revision 1.1  2007/01/03 19:43:22  jp_milcent
* Ajout d'une classe métier pour le module Protection.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>