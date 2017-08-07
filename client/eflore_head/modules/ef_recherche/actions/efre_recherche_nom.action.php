<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: efre_recherche_nom.action.php,v 1.8 2007-02-07 18:04:44 jp_milcent Exp $
/**
* eFlore
*
* 
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
class ActionRechercheNom extends aAction {

	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$dao_version = new ProjetVersionDao();
		//$dao_version->setDebogage(EF_DEBOG_SQL);		
		
		// Aiguillage sur la base de données principale ou historique
		if (!empty($GLOBALS['eflore_referenciel'])) {
			$tab_versions = $dao_version->consulter( EF_CONSULTER_PRV_ID, array((int)$GLOBALS['eflore_referenciel']));
			if (isset($tab_versions[0])) {
				if (!$tab_versions[0]->verifierDerniereVersion()) {
					$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_HISTORIQUE;
				}
			}
		}
		
		// Aiguillage sur le type de recherche
		if ($GLOBALS['eflore_type_nom'] == 'nom_scientifique') {
			include_once EFRE_CHEMIN_ACTION.'efre_recherche_nom_latin.action.php';
			$une_action = new ActionRechercheNomLatin($this->getRegistre());
		} else {
			include_once EFRE_CHEMIN_ACTION.'efre_recherche_nom_verna.action.php';
			$une_action = new ActionRechercheNomVerna($this->getRegistre());
		}

		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $une_action->executer();
		
 	}// Fin méthode executer()
 	
}//Fin classe ActionRechercheNom()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_nom.action.php,v $
* Revision 1.8  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.7  2007/01/24 17:35:02  jp_milcent
* Correction pour gérer correctement le format de sortie.
*
* Revision 1.6.6.1  2007/02/02 18:12:27  jp_milcent
* Ajout d'un nouveau test pour éviter les messages d'erreur.
*
* Revision 1.6  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.5  2005/12/21 16:10:30  jp_milcent
* Gestion des fichiers de localisation et simplification du code.
*
* Revision 1.4  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.3.2.1  2005/12/08 17:50:34  jp_milcent
* Passage v3+v4 en cours.
*
* Revision 1.3  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.2  2005/10/10 13:53:21  jp_milcent
* Amélioration de la gestion des sessions.
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.5  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.4  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.3  2005/08/03 15:52:31  jp_milcent
* Fin gestion des résultats recherche nomenclaturale.
* Début gestion formulaire taxonomique.
*
* Revision 1.2  2005/08/02 16:19:33  jp_milcent
* Amélioration des requetes de recherche de noms.
*
* Revision 1.1  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>