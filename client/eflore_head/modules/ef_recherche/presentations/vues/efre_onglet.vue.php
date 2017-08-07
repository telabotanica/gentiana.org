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
// CVS : $Id: efre_onglet.vue.php,v 1.3 2006-07-07 09:26:17 jp_milcent Exp $
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
*@version       $Revision: 1.3 $ $Date: 2006-07-07 09:26:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueOnglet extends aVue {
	
	/*** Constructeurs : ***/
	
	public function __construct($Registre)
	{
		$this->setNom('onglet');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	/*** Méthodes : ***/
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		foreach ($this->getDonnees('onglets_ordre') as $c => $v) {
			// Assigne les données au block ONGLET
			$squelette->setCurrentBlock('ONGLET') ;
			// Attribution de la class à l'onglet
			if ($this->getDonnees('onglet_actif') == $v) {
				$squelette->setVariable('ONGLET_CLASS', $this->getDonnees('onglet_class_actif'));
			} else {
				$squelette->setVariable('ONGLET_CLASS', $this->getDonnees('onglet_class_inactif'));
			}
			$aso_info = $this->getDonnees('onglets_info');
			$squelette->setVariable('ONGLET_URL', $aso_info[$v]['url']);
			$squelette->setVariable('ONGLET_NOM', $aso_info[$v]['nom']);
			$squelette->parseCurrentBlock('ONGLET');
		}	
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_onglet.vue.php,v $
* Revision 1.3  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.2  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.1.2.1  2005/12/13 13:00:59  jp_milcent
* Correction bogue "Only variables should be assigned by reference".
*
* Revision 1.1  2005/10/11 09:40:59  jp_milcent
* Ajout des onglets Accueil et Aide pour permettre l'affichage d'info sous les moteurs de recherche et l'ajout futur de l'onglet Options...
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>