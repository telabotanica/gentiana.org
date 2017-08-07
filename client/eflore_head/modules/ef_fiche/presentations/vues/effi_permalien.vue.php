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
// CVS : $Id: effi_permalien.vue.php,v 1.11 2007-06-19 10:32:57 jp_milcent Exp $
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
*@version       $Revision: 1.11 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VuePermalien extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('permalien');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		$NomSelectionFormatage = new NomFormatage($this->getDonnees('nom_selection'));
		$NomRetenuFormatage = new NomFormatage($this->getDonnees('nom_retenu'));
	
		// Gestion du block Permalien nn
		if ($this->getDonnees('permalien_nn_bool') == true) {
			$squelette->setCurrentBlock('PERMALIEN_NN');
			$squelette->setVariable( 'URL_PERMALIEN_NN_PRV', $this->getDonnees('url_permalien_nn_prv') );
			$squelette->setVariable( 'URL_PERMALIEN_NN_PRV_DEFAUT', $this->getDonnees('url_permalien_nn_prv_defaut') );
			$squelette->setVariable( 'PROJET_INTITULE', $this->getDonnees('pr_intitule') );
			$squelette->setVariable( 'PROJET_ABREVIATION', $this->getDonnees('pr_abreviation') );
			$squelette->setVariable( 'PROJET_VERSION_CODE', $this->getDonnees('prv_code') );
			$squelette->parseCurrentBlock('PERMALIEN_NN');
		} else {
			$squelette->setCurrentBlock('PERMALIEN_NN_INFO');
			$squelette->setVariable( 'PERMALIEN_NN_INFO', $this->getDonnees('permalien_nn_info') );
			$squelette->parseCurrentBlock('PERMALIEN_NN_INFO');
		}

		// Gestion du block Permalien nt
		if ($this->getDonnees('permalien_nt_bool') == true) {
			$squelette->setCurrentBlock('PERMALIEN_NT');
			$squelette->setVariable( 'URL_PERMALIEN_NT_PRV', $this->getDonnees('url_permalien_nt_prv') );
			$squelette->setVariable( 'URL_PERMALIEN_NT_PRV_DEFAUT', $this->getDonnees('url_permalien_nt_prv_defaut') );
			$squelette->setVariable( 'PROJET_INTITULE', $this->getDonnees('pr_intitule') );
			$squelette->setVariable( 'PROJET_ABREVIATION', $this->getDonnees('pr_abreviation') );
			$squelette->setVariable( 'PROJET_VERSION_CODE', $this->getDonnees('prv_code') );
			$squelette->parseCurrentBlock('PERMALIEN_NT');
		} else {
			$squelette->setCurrentBlock('PERMALIEN_NT_INFO');
			$squelette->setVariable( 'PERMALIEN_NT_INFO', $this->getDonnees('permalien_nt_info') );
			$squelette->parseCurrentBlock('PERMALIEN_NT_INFO');
		}

		// Gestion du block principal
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('TITRE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE));
		if ($this->getDonnees('nom_retenu_famille') != null) {
			$NomFamilleFormatage = new NomFormatage($this->getDonnees('nom_retenu_famille'));
			$squelette->setVariable('NOM_RETENU_FAMILLE', $NomFamilleFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
		}
		$squelette->setVariable( 'NOM_RETENU_SIMPLE', $this->getDonnees('nom_retenu_simple') );
		$squelette->parseCurrentBlock();
	}
} 


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_permalien.vue.php,v $
* Revision 1.11  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.10  2007-01-24 17:34:34  jp_milcent
* Ajout du moteur de recherche en haut de page.
*
* Revision 1.9  2007/01/19 17:44:04  jp_milcent
* Fusion avec la livraison Moquin-Tandon : corrections bogue double liste.
*
* Revision 1.8.2.1  2007/01/19 17:42:54  jp_milcent
* Correction bogue : affichage d'une liste du à IT
*
* Revision 1.8  2006/12/22 16:50:43  jp_milcent
* Amélioration de la gestion des permaliens : nous tenons comptes des taxons non géré par les référentiels.
*
* Revision 1.7  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.6  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.5  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.4  2005/12/09 14:52:16  jp_milcent
* Suppression du passage par référence de l'objet squelette.
*
* Revision 1.3  2005/11/24 16:23:26  jp_milcent
* Correction des permaliens suite à discussion.
*
* Revision 1.2  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.1  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>