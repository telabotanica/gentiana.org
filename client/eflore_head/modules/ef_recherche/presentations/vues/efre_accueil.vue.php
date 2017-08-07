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
// CVS : $Id: efre_accueil.vue.php,v 1.9 2006-07-07 09:26:17 jp_milcent Exp $
/**
* La vue de l'action "accueil"
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
*@version       $Revision: 1.9 $ $Date: 2006-07-07 09:26:17 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueAccueil extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('accueil');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();		
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL', $this->getDonnees('titre_general'));
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORM_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('FORM_TAX', $this->getDonnees('un_form_tax'));
		$squelette->parseCurrentBlock();
		//echo '<pre>'.print_r($this->squelette, true).'</pre>';
	}
	
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_accueil.vue.php,v $
* Revision 1.9  2006-07-07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.8  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.7  2006/05/16 16:21:23  jp_milcent
* Ajout de l'onglet "Informations" au module ef_recherche permettant d'avoir des informations sur les référentiels tirées de la base de données.
*
* Revision 1.6  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.5.4.1  2006/03/09 17:41:34  jp_milcent
* Gestion d'un titre configurable.
*
* Revision 1.5  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.4.2.1  2005/12/13 13:00:59  jp_milcent
* Correction bogue "Only variables should be assigned by reference".
*
* Revision 1.4  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.3  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
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