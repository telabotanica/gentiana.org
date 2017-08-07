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
// CVS : $Id: effi_onglet.vue.php,v 1.3 2006-07-07 09:26:17 jp_milcent Exp $
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
		// Cr�ation du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	/*** M�thodes : ***/
	
	public function preparer()
	{
		// R�cup�ration d'une r�f�rence au squelette
		$squelette = $this->getSquelette();
		foreach ($this->getDonnees('onglets_ordre') as $c => $v) {
			// Assigne les donn�es au block ONGLET
			$squelette->setCurrentBlock('ONGLET') ;
			// Attribution de la class � l'onglet
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
* $Log: effi_onglet.vue.php,v $
* Revision 1.3  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.2  2005/12/09 14:52:16  jp_milcent
* Suppression du passage par r�f�rence de l'objet squelette.
*
* Revision 1.1  2005/09/28 16:29:31  jp_milcent
* D�but et fin de gestion des onglets.
* D�but gestion de la fiche Synonymie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>