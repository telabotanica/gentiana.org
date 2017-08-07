<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Recherche.                                                                |
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
// CVS : $Id: efre_form_taxon.action.php,v 1.9 2006-07-05 15:11:22 jp_milcent Exp $
/**
* Formulaire de recherche taxonomique
*
* Contient le formulaire de recherche taxonomique.
*
*@package eflore
*@subpackage ef_recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.9 $ $Date: 2006-07-05 15:11:22 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionFormTaxon {

	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_PRINCIPAL;
		$dao_projet = new ProjetDao();
		//$dao_projet->setDebogage(EF_DEBOG_SQL);				
		$dao_version = new ProjetVersionDao();
		//$dao_version->setDebogage(EF_DEBOG_SQL);

		// +------------------------------------------------------------------------------------------------------+
		// Ajout du paramêtre action à l'url courante.
		$tab_retour['url'] = $GLOBALS['_EFLORE_']['url'];
		$tab_retour['url']->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_RECHERCHE);
		$tab_retour['url']->addQueryString(EF_LG_URL_ACTION, EF_LG_URL_ACTION_RECH_TAX);
		
		// +------------------------------------------------------------------------------------------------------+
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
			$tab_retour['referenciels'][$i]['intitule'] = $tab_projets[$i]->getIntitule();
			$tab_retour['referenciels'][$i]['abreviation'] = $tab_projets[$i]->getAbreviation();
		 	$tab_versions = $dao_version->consulter( EF_CONSULTER_VERSION_PROJET, array($tab_projets[$i]->getId('projet')));
		 	for($j = 0; $j < count($tab_versions); $j++) {
		 		if (!isset($GLOBALS['_EFLORE_']['projet_version_unique']) || 
		 			$GLOBALS['_EFLORE_']['projet_version_unique'] == $tab_versions[$j]->getId('version')) {
					$tab_retour['referenciels'][$i]['versions'][$j]['code'] = $tab_versions[$j]->getCode();
					$tab_retour['referenciels'][$i]['versions'][$j]['id'] = $tab_versions[$j]->getId('version');
		 		}
			}
		}

		$dao_rang = new NomRangDao();
		$tab_famille = $dao_rang->consulter(EF_CONSULTER_RANG_FAMILLE);
		$tab_genre = $dao_rang->consulter(EF_CONSULTER_RANG_GENRE);
		$tab_retour['rangs'] = array_merge($tab_famille, $tab_genre);
		
		return $tab_retour;
 	}// Fin méthode executer()
 	
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_form_taxon.action.php,v $
* Revision 1.9  2006-07-05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.8  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.7  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.6.2.1  2006/03/08 18:21:31  jp_milcent
* Gestion de la suppression du menu déroulant si un seul référentiel.
* Correction du bogue empéchant le résumé de s'afficher pour la recherche par arbre des taxons.
*
* Revision 1.6  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.5  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.4.2.1  2005/12/08 17:50:34  jp_milcent
* Passage v3+v4 en cours.
*
* Revision 1.4  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.3  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.2  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.2  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.1  2005/08/03 15:52:31  jp_milcent
* Fin gestion des résultats recherche nomenclaturale.
* Début gestion formulaire taxonomique.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>