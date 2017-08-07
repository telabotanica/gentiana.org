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
* Titre
*
* Description
*
*@package eFlore
*@subpackage ef_fiche
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
class AppletteXperAction extends aAction {

	public function executer()
	{
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables		
		$tab_retour = array();
		$tab_retour['base'] = $_GET['base'];
		$tab_retour['url_eflore'] = EF_URL;
		$tab_retour['url_xper_base'] = EF_URL_XPER_BASE;
		$tab_retour['url_xper_jar'] = EF_URL_XPER_JAR;
		
		// Gestion des fichiers jar de l'applette
		$tab_fichiers = explode(',', EF_URL_XPER_JAR_FICHIER);
		foreach ($tab_fichiers as $fichier) {
			$tab_retour['url_xper_jar_fichier'] .= EF_URL_XPER_JAR.$fichier.', ';
		}
		$tab_retour['url_xper_jar_fichier'] = preg_replace('/, $/', '', $tab_retour['url_xper_jar_fichier']);
		
		
		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		//echo '<pre>'.print_r($tab_retour, true).'</pre>';
		return $tab_retour;
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.2.4.1  2007-06-01 09:52:31  jp_milcent
* Utilisation du template php pour le module Xper.
*
* Revision 1.2  2006-10-25 08:15:23  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.1.2.1  2006/09/18 13:08:35  jp_milcent
* Ajout d'une constante stockant le chemin vers les fichiers .jar de l'applette xper.
*
* Revision 1.1  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
