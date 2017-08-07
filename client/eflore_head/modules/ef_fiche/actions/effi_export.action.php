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
class ActionExport extends aAction implements iActionAvecCache {
	
	public function get_identifiant()
	{
		return 'fiche_export_nvpn'.$_SESSION['nvpn'].'_nn'.$_SESSION['nn'];
	}
	
	public function executer()
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();

		// Gestion de l'encodage des données pour l'export en PDF
		$encodage_defaut = $GLOBALS['_EFLORE_']['encodage'];
		if (EF_LANGUE_UTF8 && $GLOBALS['_EFLORE_']['encodage'] == 'HTML-ENTITIES') {
			$GLOBALS['_EFLORE_']['encodage'] = 'ISO-8859-15';
		}
		
		$ActionSynthese = new ActionSynthese($this->getRegistre());
		$tab_retour = $ActionSynthese->executer();
		
		$ActionSynonymie = new ActionSynonymie;
		$tab_retour = array_merge($tab_retour, $ActionSynonymie->executer());

		// Gestion de l'encodage des données pour l'export en PDF
		if (EF_LANGUE_UTF8 && $GLOBALS['_EFLORE_']['encodage'] == 'ISO-8859-15') {
			$GLOBALS['_EFLORE_']['encodage'] = $encodage_defaut;
		}
		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		//echo '<pre>'.print_r($tab_retour, true).'</pre>';
		return $tab_retour;

	}// Fin méthode executer()

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.5  2007-06-11 12:46:27  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.4.6.1  2007-06-08 09:41:03  jp_milcent
* Début gestion encodage pour le pdf.
*
* Revision 1.4  2006-07-12 09:05:24  jp_milcent
* Correction pour gérer le registre.
*
* Revision 1.3  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.2  2006/05/16 14:01:41  jp_milcent
* Gestion du cache pour l'export pdf et la fiche synthèse.
*
* Revision 1.1  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
