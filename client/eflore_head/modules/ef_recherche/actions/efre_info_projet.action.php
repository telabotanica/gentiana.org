<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id$
/**
* Fichier contenant les informations sur les projets disponible dans le moteur de recherche.
*
* 
*
*@package eflore
*@subpackage ef_recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionInfoProjet {
	
	public function executer()
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_PRINCIPAL;
		$dao_projet = new ProjetDao();
		//$dao_projet->setDebogage(EF_DEBOG_SQL);				
		$dao_version = new ProjetVersionDao();
		//$dao_version->setDebogage(EF_DEBOG_SQL);
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Récupération des données
		if (isset($GLOBALS['_EFLORE_']['projets_affichables'])) {
			// Nous avons configuré l'affichage de projets précis.
			$type = EF_CONSULTER_PR_ID_REFERENTIEL_BOTA;
			$param = array(1, $GLOBALS['_EFLORE_']['projets_affichables']);			
		} else {
			// Nous affichons tous les projets de synonymie-taxonomie marqué comme consultable.
			$type = EF_CONSULTER_REFERENTIEL_BOTA;
			$param = array(1);
		}
		$tab_projets = $dao_projet->consulter($type, $param);
		
		for($i = 0; $i < count($tab_projets); $i++) {
			$tab_retour['referentiels'][$i]['intitule'] = $tab_projets[$i]->getIntitule();
			$tab_retour['referentiels'][$i]['abreviation'] = $tab_projets[$i]->getAbreviation();
			$tab_retour['referentiels'][$i]['description'] = $tab_projets[$i]->getDescriptionProjet();
			$tab_retour['referentiels'][$i]['url'] = $tab_projets[$i]->getLienWeb();
		 	$tab_versions = $dao_version->consulter( EF_CONSULTER_VERSION_PROJET, array($tab_projets[$i]->getId('projet')));
		 	
		 	for($j = 0; $j < count($tab_versions); $j++) {
		 		if (!isset($GLOBALS['_EFLORE_']['projet_version_unique']) || 
		 			$GLOBALS['_EFLORE_']['projet_version_unique'] == $tab_versions[$j]->getId('version')) {
		 			
					$tab_retour['referentiels'][$i]['versions'][$j]['code'] = $tab_versions[$j]->getCode();
					$tab_retour['referentiels'][$i]['versions'][$j]['id'] = $tab_versions[$j]->getId('version');
					if (!$tab_versions[$j]->verifierDerniereVersion()) {
						$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_HISTORIQUE;
					} else {
						$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_PRINCIPAL;
					}
					$dao_nom = new NomDeprecieDao();
					//$dao_nom->setDebogage(EF_DEBOG_SQL);
					$dao_nom_rang = new NomRangDao();
					//$dao_nom_rang->setDebogage(EF_DEBOG_SQL);
					$type = EF_CONSULTER_NOM_NBRE_PAR_RANG;
					$param = array((int)$tab_versions[$j]->getId('version'));
					$tab_nbre_noms_rang = $dao_nom->consulter($type, $param);
					$tab_stat = array();
					foreach ($tab_nbre_noms_rang as $Nom) {
						if ($Nom->getCe('rang') != 0) {
							$type = EF_CONSULTER_RANG_ID;
							$param = array((int)$Nom->getCe('rang'));
							$tab_rang = $dao_nom_rang->consulter($type, $param);
							if (isset($tab_rang[0])) {
								$Rang = $tab_rang[0];
								if (is_object($Rang)) {
									$tab_stat[ucfirst($Rang->getIntitule())] = $Nom->nombre;
								}
							}
						}
					}
					$tab_retour['referentiels'][$i]['versions'][$j]['stats'] = $tab_stat;
					
					// Le tableau généré est trop grand!
					// TODO : il faudrait réaliser une image d'un graphique
					/*
					$type = EF_CONSULTER_NOM_NBRE_PAR_ANNEE;
					$param = array((int)$tab_versions[$j]->getId('version'));
					$tab_nbre_noms_annee = $dao_nom->consulter($type, $param);
					*/
					//$tab_stat_annee = array();
					/*
					foreach ($tab_nbre_noms_annee as $Nom) {
						if ($Nom->enci_annee_citation != '' 
							&& $Nom->enci_annee_citation != null
							&& preg_match('/^\d{4}$/', $Nom->enci_annee_citation)) {
							$tab_stat_annee[$Nom->enci_annee_citation] = $Nom->nombre;
						} else {
							$tab_stat_annee['?'] += $Nom->nombre;
						}
					}
					ksort($tab_stat_annee);
					//echo '<pre>'.print_r($tab_stat_annee, true).'</pre>';
					*/
					//$tab_retour['referentiels'][$i]['versions'][$j]['stats_annee'] = $tab_stat_annee;
		 		}
			}
		}
		
		return $tab_retour;
	}
	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.7  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.6  2007-06-11 12:46:51  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.2.6.2  2007-06-08 13:01:09  jp_milcent
* Correction problème d'affichage des statistiques.
*
* Revision 1.5  2007-06-08 13:55:08  jp_milcent
* Modification du nom d'une variable.
*
* Revision 1.4  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.3  2007/01/19 14:33:32  jp_milcent
* Ajout de tests pour éviter les erreurs.
*
* Revision 1.2.6.1  2007/01/19 10:42:31  jp_milcent
* Correction bogue : ajout de test pour éviter les messages d'erreurs.
*
* Revision 1.2  2006/05/19 15:10:07  jp_milcent
* Amélioration de la gestion des informations sur les projets.
* Début gestion d'un graphique du nombre de noms publiés par année.
*
* Revision 1.1  2006/05/16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
