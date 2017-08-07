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
class AppletteXperVue extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('applette_xper');
		$this->setMoteurTpl(aVue::TPL_PHP);
		parent::__construct($Registre);
	}

	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette =& $this->getSquelette();

		// Nous enregistrons les infos pour l'affichage
		$squelette->set('info', $this->getRegistre()->get('vue_donnees'));
		
		return $squelette->analyser();
	}
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.3  2007-06-01 13:23:05  jp_milcent
* Fusion avec livraison Moquin-Tandon : 01 juin 2007
*
* Revision 1.2.4.1  2007-06-01 09:52:30  jp_milcent
* Utilisation du template php pour le module Xper.
*
* Revision 1.2  2006-10-25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.1.2.1  2006/09/18 13:08:34  jp_milcent
* Ajout d'une constante stockant le chemin vers les fichiers .jar de l'applette xper.
*
* Revision 1.1  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
