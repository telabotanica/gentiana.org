<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.	                                                                |
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
// CVS : $Id: effi_onglet.action.php,v 1.12 2007-02-07 18:04:44 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Onglets
*
* Contient la gestion des onglets du module eFlore-Fiche.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.12 $ $Date: 2007-02-07 18:04:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionOnglet extends aAction {
	
	/*** Méthodes : ***/
	
	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$dao_prv = new ProjetVersionDao;
		//$dao_prv->setDebogage(EF_DEBOG_SQL);
		$dao_pr = new ProjetDao;
		//$dao_pr->setDebogage(EF_DEBOG_SQL);
		
		// +------------------------------------------------------------------------------------------------------+
		// Construction du tableau contenant les infos sur les onglets
		$tab_retour['onglet_class_actif'] = 'menu_actif';
		$tab_retour['onglet_class_inactif'] = 'menu_inactif';
		$tab_retour['onglet_actif'] = $this->getRegistre()->get('onglet');
		$tab_retour['onglets_ordre'] = explode(',', $this->getRegistre()->get('onglet_ordre'));
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur la version et le projet courant
		$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_ID, (int)$_SESSION['nvp'] );
		if (isset($tab_prv[0])) {
			$une_version = $tab_prv[0];
			$tab_pr = $dao_pr->consulter( EF_CONSULTER_PR_ID, (int)$une_version->getCeProjet() );
			if (isset($tab_pr[0])) {
				$un_projet = $tab_pr[0];
				$tab_retour['pr_abreviation'] = $un_projet->getAbreviation();
				$tab_retour['pr_intitule'] = $un_projet->getIntitule();
				$tab_retour['prv_code'] = $une_version->getCode();
			}
		}
		$url = clone $GLOBALS['_EFLORE_']['url_permalien'];
		
		// +------------------------------------------------------------------------------------------------------+
		// Attribution des paramêtres spécifiques aux onglets
		foreach ($tab_retour['onglets_ordre'] as $c => $v) {

			// Construction de l'url courante
			$url->setPage($v);
			$tab_retour['onglets_info'][$v]['url'] = $url->getURL();
			// Attribution du nom à l'onglet
			$onglet_nom = '';
			$aso_i18n = $this->getRegistre()->get('module_i18n');
			if (isset($aso_i18n['onglets'][$v])) {
				$onglet_nom = $aso_i18n['onglets'][$v];
			}
			$tab_retour['onglets_info'][$v]['nom'] = $onglet_nom;
		}

		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		return $tab_retour;
		
	}// Fin méthode executer()
	
}// Fin classe ActionOnglet()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_onglet.action.php,v $
* Revision 1.12  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.11.6.1  2007/02/02 18:12:47  jp_milcent
* Ajout de nouveaux tests pour éviter les messages d'erreur.
*
* Revision 1.11  2006/07/12 17:09:29  jp_milcent
* Correction bogue onglet non sélectionné.
* Utilisation du Registre.
*
* Revision 1.10  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.9  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.8  2006/05/29 13:56:10  ddelon
* Integration wiki dans eflore
*
* Revision 1.7  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* Revision 1.6  2006/03/06 11:57:09  ddelon
* Reintegration correction bugs de la livraison bdnffV3_v4
*
* Revision 1.5  2006/01/23 11:15:39  ddelon
* Chorologie --> Repartition
*
* Revision 1.4  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.3  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
*
* Revision 1.2  2005/09/30 16:22:01  jp_milcent
* Fin de la gestion de l'onglet Noms Vernaculaires.
*
* Revision 1.1  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>