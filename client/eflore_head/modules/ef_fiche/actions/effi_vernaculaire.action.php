<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.                                                                   |
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
// CVS : $Id: effi_vernaculaire.action.php,v 1.18 2007-07-24 14:30:30 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Vernaculaire
*
* Contient les infos pour l'onglet Vernaculaire.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.18 $ $Date: 2007-07-24 14:30:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionVernaculaire extends aAction {
	
	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();

		// +-----------------------------------------------------------------------------------------------------------+
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		// Intégration du moteur de recherche par nom latin		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération d'infos générales
		$tab_retour['nn'] = $_SESSION['nn'];
		$tab_retour['nom_retenu_simple'] = $_SESSION['NomRetenu']->formaterNom(EF_NOM_FORMAT_SIMPLE);
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];
				
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur les noms vernaculaires
		$dao_va = new VernaculaireAttributionDao;
		//$dao_va->setDebogage(EF_DEBOG_SQL);
		$dao_v = new VernaculaireDao;
		//$dao_v->setDebogage(EF_DEBOG_SQL);
		$dao_vce = new VernaculaireConseilEmploiDao;
		//$dao_vce->setDebogage(EF_DEBOG_SQL);
		$dao_l = new LangueDao;
		//$dao_l->setDebogage(EF_DEBOG_SQL);
		$dao_lv = new LangueValeurDao;
		//$dao_lv->setDebogage(EF_DEBOG_SQL);
		$dao_zg = new ZgDaoDeprecie;
		//$dao_zg->setDebogage(EF_DEBOG_SQL);
		$tab_retour['noms_verna_bool'] = false;
		$tab_va = $dao_va->consulter(EF_CONSULTER_VA_VERSION_TAXON_ID, array((int)$_SESSION['nt'], (int)$_SESSION['nvp']));
		$aso_noms_verna = array();
		foreach($tab_va as $une_va) {
			$id = $une_va->getId('nom_vernaculaire');
			$id_projet = $une_va->getId('version_projet_nom_verna');
			$aso_noms_verna[$id_projet][$id]['version_projet_zg'] = $une_va->getCe('version_projet_zg');
			$aso_noms_verna[$id_projet][$id]['zone_geo'] = $une_va->getCe('zone_geo');
			$aso_noms_verna[$id_projet][$id]['emploi'] = $une_va->getCe('emploi');
		}
		// Récupération des noms vernaculaire du taxon affiché
		if (count($aso_noms_verna) > 0) {
			foreach($aso_noms_verna as $id_projet_nva => $aso_nva) {
				$tab_retour['noms_verna_bool'] = true;
				
				$tab_v = $dao_v->consulter( EF_CONSULTER_V_GROUPE_ID, array(implode(', ', array_keys($aso_nva)), (int)$id_projet_nva));
				
				foreach($tab_v as $un_v) {
					// Récupération des infos générales sur le nom verna
					$id = $un_v->getId('nom_vernaculaire');
					$tab_retour['noms_verna'][$id]['intitule'] = $un_v->getIntitule();
					if (!empty($un_v->getNotes)) {
						$tab_retour['noms_verna'][$id]['notes'] = $un_v->getNotes;
					} else {
						$tab_retour['noms_verna'][$id]['notes'] = '';
					}
	
					// Récupération des infos sur le conseil d'emploi
					$type = EF_CONSULTER_VCE_ID;
					$param = array( (int)$aso_nva[$id]['emploi'] );
					$tab_vce = $dao_vce->consulter( $type , $param );
					if (isset($tab_vce[0]) && $tab_vce[0]->getIntitule() != '') {
						$un_ce = $tab_vce[0];
						$tab_retour['noms_verna'][$id]['emploi'] = ' ';
						if ($un_ce->getIntitule() != 'Non renseigné') {
							$tab_retour['noms_verna'][$id]['emploi'] = $un_ce->getIntitule();
						}
					} else {
						$tab_retour['noms_verna'][$id]['emploi'] = 'Problème';
					}
					
					// Récupération des infos sur la zone géo d'utilisation du nom verna
					$type = EF_CONSULTER_ZG_VERSION_ID;
					$param = array( (int)$aso_nva[$id]['version_projet_zg'], (int)$aso_nva[$id]['zone_geo'] );
					$tab_zg = $dao_zg->consulter( $type , $param );
					//echo '<pre>'.print_r($tab_zg, true).'</pre>';
					if (isset($tab_zg[0]) && $tab_zg[0]->getIntitulePrincipal() != '') {
						$tab_retour['noms_verna'][$id]['zg_intitule'] = $tab_zg[0]->getIntitulePrincipal();
						$tab_retour['noms_verna'][$id]['zg_code'] = $tab_zg[0]->getCode();
					} else {
						$tab_retour['noms_verna'][$id]['zg_intitule'] = 'Problème';
						$tab_retour['noms_verna'][$id]['zg_code'] = '!';						
					}
	
					// Récupération des infos sur le genre et le nombre du nom verna
					$type = EF_CONSULTER_LV_CATEGORIE_VALEUR_ID;
					$param = array($un_v->getCe('categorie_genre_nombre'), $un_v->getCe('valeur_genre_nombre'));
					$tab_lv = $dao_lv->consulter( $type, $param );
					$tab_retour['noms_verna'][$id]['genre_nbre'] = ' ';
					if ($tab_lv[0]->getId('valeur') != 3 && $tab_lv[0]->getId('valeur') != 0) {// Genre et nombre non renseigné.
						$tab_retour['noms_verna'][$id]['genre_nbre'] = $tab_lv[0]->getIntitule();
					}
					
					// Récupération des infos sur la langue du nom verna
					$type = EF_CONSULTER_L_VERSION_ID;
					$param = array($un_v->getCe('langue'), $un_v->getCe('version_projet_langue'));
					$tab_l = $dao_l->consulter( $type, $param );
					if (isset($tab_l[0]) && $tab_l[0]->getNomPrincipal() != '') {
						$tab_retour['noms_verna'][$id]['lg_intitule'] = $tab_l[0]->getNomPrincipal();
						$tab_retour['noms_verna'][$id]['lg_code'] = $tab_l[0]->getCode();
					} else {
						$tab_retour['noms_verna'][$id]['lg_intitule'] = 'Problème';
						$tab_retour['noms_verna'][$id]['lg_code'] = '!';
					}
				}
			}
		} else {
			$tab_retour['noms_verna_info'] = 'Aucun nom commun pour ce taxon dans ce référentiel !';
		}
		// Tableau indiquant l'ordre d'apparition des colonnes
		$tab_retour['noms_verna_intitule'] = array('lg_intitule', 'zg_intitule', 'intitule', 'genre_nbre', 'emploi', 'notes');
		
		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		//echo '<pre>'.print_r($tab_retour, true).'</pre>';
		return $tab_retour;
		
	}// Fin méthode executer()
	
}// Fin classe ActionVernaculaire()


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_vernaculaire.action.php,v $
* Revision 1.18  2007-07-24 14:30:30  jp_milcent
* Fusion depuis Moquin-Tandon.
* Correction d'orthographe.
*
* Revision 1.17  2007-06-11 15:32:50  jp_milcent
* Correction problème entre ancienne api et nouvelle version 1.1.1
*
* Revision 1.16  2007-06-11 12:46:27  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.13.2.1  2007-06-07 14:00:21  jp_milcent
* Correction problème d'utf8 du au destructeur de la classe aModeleDao pris en comtpe trop tôt.
*
* Revision 1.15  2007-02-09 16:54:36  jp_milcent
* Nouveau module Zone Géo basé sur la version 1.2.
*
* Revision 1.14  2007/01/24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.13  2007/01/17 18:22:34  jp_milcent
* Correction bogue : confusion entre les différents projets de noms verna.
*
* Revision 1.12  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.11.2.1  2006/09/06 11:46:36  jp_milcent
* Gestion du code du référentiel pour le titre avant de créer le formulaire de recherche.
* Si on le place après, le référentiel est faux!
*
* Revision 1.11  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.10  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.9  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.8  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.7  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.6  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.5  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.4  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.3  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.2  2005/09/30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
* Revision 1.1  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>