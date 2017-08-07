<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of project_name.                                                                |
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
// CVS : $Id: efre_onglet.action.php,v 1.7 2006-07-12 17:09:29 jp_milcent Exp $
/**
* project_name
*
* 
*
*@package project_name
*@subpackage 
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.7 $ $Date: 2006-07-12 17:09:29 $
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
		// Construction du tableau contenant les infos sur les onglets
		$tab_retour['onglet_class_actif'] = 'menu_actif';
		$tab_retour['onglet_class_inactif'] = 'menu_inactif';
		$tab_retour['onglets_ordre'] = array('accueil', 'info_projet');
		
		// +------------------------------------------------------------------------------------------------------+
		// Attribution des paramêtres spécifiques aux onglets
		foreach ($tab_retour['onglets_ordre'] as $c => $v) {

			// Construction de l'url courante
			$url_onglet = clone $GLOBALS['_EFLORE_']['url_base'];
			$url_onglet->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_RECHERCHE);
			$url_onglet->addQueryString(EF_LG_URL_ACTION, $v);
			$tab_retour['onglets_info'][$v]['url'] = $url_onglet->getURL();
			unset($url_onglet);

			// Attribution du nom à l'onglet
			$onglet_nom = '';
			$aso_i18n = $this->getRegistre()->get('module_i18n');
			if (isset($aso_i18n['onglets'][$v])) {
				$onglet_nom = $aso_i18n['onglets'][$v];
			}
			$tab_retour['onglets_info'][$v]['nom'] = $onglet_nom;
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Gestion de l'onglet actif
		switch ($this->getRegistre()->get('onglet')) {
			case 'recherche_nom' :
			case 'recherche_taxon' :
				$tab_retour['onglet_actif'] = 'accueil';
				break;
			default :
				$tab_retour['onglet_actif'] = $this->getRegistre()->get('onglet');
		}

		

		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		return $tab_retour;
		
	}// Fin méthode executer()
	
}// Fin classe ActionOnglet()


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_onglet.action.php,v $
* Revision 1.7  2006-07-12 17:09:29  jp_milcent
* Correction bogue onglet non sélectionné.
* Utilisation du Registre.
*
* Revision 1.6  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.5  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.4  2006/05/16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
* Revision 1.3  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.2  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.1  2005/10/11 09:40:59  jp_milcent
* Ajout des onglets Accueil et Aide pour permettre l'affichage d'info sous les moteurs de recherche et l'ajout futur de l'onglet Options...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>