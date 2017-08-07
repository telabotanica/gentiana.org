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
// CVS : $Id: efsa_information_numero_nomenclatural.vue.php,v 1.4 2006-07-07 09:26:17 jp_milcent Exp $
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
*@version       $Revision: 1.4 $ $Date: 2006-07-07 09:26:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueInformationNumeroNomenclatural extends aVue {

	public function __construct($donnees = array(), $format = NULL, $chemin = NULL)
	{
		$this->setNom('information_numero_nomenclatural');
		parent::__construct($donnees, $format, $chemin);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}

	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		
		//$squelette->setVariable('EFLORE_NUMERO_NOMENCLATURAL_SELECTION', $this->getDonnees('eflore_numero_nomenclatural_selection'));
		//$squelette->setVariable('EFLORE_NUMERO_TAXONOMIQUE', $this->getDonnees('eflore_numero_taxonomique'));		
			
		//$squelette->setVariable('EFLORE_NUMERO_NOMENCLATURAL_RETENU', $this->getDonnees('eflore_numero_nomenclatural_retenu'));
		$squelette->setVariable('EFLORE_NOM_RETENU', $this->getDonnees('eflore_nom_retenu'));
		
		$squelette->setVariable('EFLORE_NOM', $this->getDonnees('eflore_nom'));
			
		$squelette->setVariable('EFLORE_NOM_RETENU_FAMILLE', $this->getDonnees('eflore_nom_retenu_famille'));
			
			
		$retour = $this->retournerRendu();
		
		return $retour;
		
	}
		
		

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efsa_information_numero_nomenclatural.vue.php,v $
* Revision 1.4  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.3  2006/05/11 09:43:37  ddelon
* Action cache
*
* Revision 1.2  2006/04/26 16:57:04  ddelon
* Fusion bdnbe + saisie assistee
*
* Revision 1.1.2.1  2006/04/25 12:44:51  ddelon
* saisie en masse
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>