<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-consultation.                                                            |
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
// CVS : $Id: efsa_saisie_continue.action.php,v 1.4 2007-02-07 18:04:45 jp_milcent Exp $
/**
* Fichier contenant l'application de recherche
*
* Contient la page d'accueil de l'application de recherche.
*
*@package eflore
*@subpackage ef_saisie
//Auteur original :
*@author        David DELON <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.4 $ $Date: 2007-02-07 18:04:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionSaisieContinue {

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
		$tab_retour['url']->addQueryString(EF_LG_URL_ACTION, EF_LG_URL_ACTION_RECH_NOM);
		
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
		//echo '<pre>'.print_r($tab_projets, true).'</pre>';
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
		
		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		//echo '<pre>'.print_r($tab_retour, true).'</pre>';
		return $tab_retour;
		
 	}// Fin méthode executer()
 	
}// Fin classe ActionSaisieContinue()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efsa_saisie_continue.action.php,v $
* Revision 1.4  2007-02-07 18:04:45  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.3.2.1  2007/02/02 14:34:46  jp_milcent
* Correction ajout du nom valide.
*
* Revision 1.3  2006/12/27 14:07:13  jp_milcent
* Ajout de la sélection du référentiel.
*
* Revision 1.2  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.1.2.1  2006/04/21 20:50:27  ddelon
* Saisie continue
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>