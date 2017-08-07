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
// CVS : $Id: efre_accueil.action.php,v 1.8 2007-02-07 18:04:44 jp_milcent Exp $
/**
* Fichier contenant l'application de recherche
*
* Contient la page d'accueil de l'application de recherche.
*
*@package eflore
*@subpackage ef_recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.8 $ $Date: 2007-02-07 18:04:44 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class ActionAccueil extends aAction {
	
	public function executer()
	{
		$tab_retour = array();
		// Ajout du titre provenant du fichier de config
		$tab_retour['titre_general'] = $GLOBALS['_EFLORE_']['titre'];
		// Ajout du code du référentiel
		if (!is_null($GLOBALS['_EFLORE_']['projets_affichables'])) {
			$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		} else {
			$tab_retour['titre_general_referentiel'] = 'Multi-projets';
		} 
		
		//Création d'une instance de recherche
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');
		// Création Formulaire recherche taxonomique
		$tab_retour['un_form_tax'] = $une_recherche->executer('form_taxon');
		
		// Envoie des données
		return $tab_retour;
		
	}// Fin méthode executer()
	
}// Fin classe ActionAccueil()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_accueil.action.php,v $
* Revision 1.8  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.7  2007/01/24 17:05:19  jp_milcent
* Ajout du format de sortie.
*
* Revision 1.6  2007/01/18 17:45:42  jp_milcent
* Fusion avec la livraison Moquin-Tandon : corrections bogue des sessions.
*
* Revision 1.5.6.1  2007/01/18 10:46:16  jp_milcent
* Gestion du titre "multi-projet".
*
* Revision 1.5  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.4  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.3  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.2.6.1  2006/03/09 13:32:06  jp_milcent
* Amélioration de la gestion du titre.
*
* Revision 1.2  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.3  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.2  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.1  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.2  2005/07/27 15:43:21  jp_milcent
* Début débogage avec gestion de l'appli hors Papyrus.
*
* Revision 1.1  2005/07/26 16:27:29  jp_milcent
* Début mise en place framework eFlore.
*
* Revision 1.1  2005/07/25 14:24:36  jp_milcent
* Début appli de consultation simplifiée.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>