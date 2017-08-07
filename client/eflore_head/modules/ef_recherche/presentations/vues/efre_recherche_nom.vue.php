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
// CVS : $Id: efre_recherche_nom.vue.php,v 1.7 2006-07-07 09:26:17 jp_milcent Exp $
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
*@version       $Revision: 1.7 $ $Date: 2006-07-07 09:26:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueRechercheNom extends aVue {

	public function __construct($Registre)
	{
		if ($GLOBALS['eflore_type_nom'] == 'nom_scientifique') {
			$this->setNom('recherche_nom_latin');
		} else {
			$this->setNom('recherche_nom_verna');
		}
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		if ($GLOBALS['eflore_type_nom'] == 'nom_scientifique') {
			include_once EFRE_CHEMIN_VUE.'efre_recherche_nom_latin.vue.php';
			$une_vue = new VueRechercheNomLatin($this->getRegistre());
		} else {
			include_once EFRE_CHEMIN_VUE.'efre_recherche_nom_verna.vue.php';
			$une_vue = new VueRechercheNomVerna($this->getRegistre());
		}
		$une_vue->chargerSquelette();
		$une_vue->preparer();
		$this->setSquelette( $une_vue->getSquelette() );
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_nom.vue.php,v $
* Revision 1.7  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.6  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.5  2005/12/21 16:10:30  jp_milcent
* Gestion des fichiers de localisation et simplification du code.
*
* Revision 1.4  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.3  2005/10/10 13:53:21  jp_milcent
* Amélioration de la gestion des sessions.
*
* Revision 1.2  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>