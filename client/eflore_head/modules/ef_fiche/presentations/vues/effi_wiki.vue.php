<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.                                                                   |
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
// CVS : $Id: effi_wiki.vue.php,v 1.8 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de vue du module eFlore-Fiche : Information
*
* Contient la génération de la vue pour l'onglet "Wiki".
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        David Delon <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.8 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueWiki extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('wiki');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}
	
	public function preparer()
	{
		
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		$NomRetenuFormatage = new NomFormatage($this->getDonnees('nom_retenu'));
		
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('TITRE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE));
		if ($this->getDonnees('nom_retenu_famille') != null) {
			$NomFamilleFormatage = new NomFormatage($this->getDonnees('nom_retenu_famille'));
			$squelette->setVariable('NOM_RETENU_FAMILLE', $NomFamilleFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
		}
		
		if ($this->getDonnees('url_modification') != null) {
			$squelette->setCurrentBlock('WIKI_TETE');
			$squelette->setVariable('WIKI_MODIF',$this->getDonnees('url_modification'));
			$squelette->setVariable('WIKI_RSS',$this->getDonnees('url_rss'));
			$squelette->parseCurrentBlock('WIKI_TETE');
		}
		$squelette->setVariable('WIKI_CONTENU_PAGE', $this->getDonnees('contenu_page'));
		$squelette->parseCurrentBlock();
		
		
						
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_wiki.vue.php,v $
* Revision 1.8  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.7  2007-01-17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.6  2007/01/15 11:32:03  ddelon
* mise en forme affichage wiki (backport)
*
* Revision 1.4.2.2  2006/11/21 19:03:54  jp_milcent
* Formatage du titre.
*
* Revision 1.4.2.1  2006/11/21 14:47:16  ddelon
* backport modif wiki depuis bracnhe principale
*
* Revision 1.5  2006/11/21 13:18:45  ddelon
* merge modif wiki decaisne dans branche principale
*
* Revision 1.3.2.2  2006/11/21 11:49:48  ddelon
* Wiki et eflore + flux rss
*
* Revision 1.3.2.1  2006/11/10 22:38:14  ddelon
* wiki eflore
*
* Revision 1.3  2006/07/12 16:02:28  jp_milcent
* Correction bogue titre.
*
* Revision 1.2  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.1  2006/05/29 13:56:10  ddelon
* Integration wiki dans eflore
*
* Revision 1.2  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.1  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
