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
// CVS : $Id: effi_wiki.action.php,v 1.12 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Wiki
*
* Appel d'une page Wiki associee au taxon
* 
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        David Delon <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.12 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

if (!function_exists("GEN_stockerStyleExterne")) {
	function GEN_stockerStyleExterne ($nom, $chemin) {
		return;
	}
}

class ActionWiki extends aAction {
	
	public function executer()
	{
		// Initialisation des variables
		$tab_retour = array();
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		// Intégration du moteur de recherche par nom latin		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Récupération d'infos générales
		$tab_retour['nn'] = $_SESSION['nn'];
		$tab_retour['nom_retenu_simple'] = $_SESSION['NomRetenu']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];
		
		// L'url ci-dessous sert au wiki pour définir ses liens internes
		$permalien = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$permalien->setType('nn');
		$permalien->setProjetCode($_SESSION['cpr']);
		$permalien->setVersionCode($_SESSION['cprv']);
		$permalien->setPage('wiki');
		$permalien->setTypeId($_SESSION['nn']);
		$restore_url= clone $GLOBALS['_GEN_commun']['url']; 
		$GLOBALS['_GEN_commun']['url'] = $permalien;

		
		// Ajout du nom du wikini
		$GLOBALS['_GEN_commun']['info_application']->wikini = EF_WIKI_NOM;
		// Ajout du fichier contenant la fonction d'affichage du wikini
		require_once  EF_WIKI_CHEMIN_BIBLIO.'iw_integrateur.fonct.php';
		// Constitution du nom de la page wikini et ajout du handler wikini
		$_REQUEST['wiki'] = $_SESSION['cpr'].'nt'.$_SESSION['nt'].'/'.$_GET['handler'];
		// Récupération du contenu du wikini
		if ($_GET['handler']!='edit') {
			$tab_retour['url_modification']=$permalien->getUrl().'&wiki='.$_SESSION['nt'].'/edit';
			$permalien->setType('');
			$permalien->setTypeId('');
			$permalien->setVersionCode('');
			$permalien->setPage('rss');
			// Oui, c'est pas bo du tout :
			$tab_retour['url_rss']=str_replace('////','/',$permalien->getUrl());
		}
		$tab_retour['contenu_page'] = afficherPageWikini();

        // Argh le hack !
        $tab_retour['contenu_page']=str_replace('wiki?wiki','wiki&wiki',$tab_retour['contenu_page']);

// #ef_wiki_tete {float:right}
// #ef_wiki_page .commentsheader{display:none}
// #ef_wiki_page .footer{display:none}

		
		// +------------------------------------------------------------------------------------------------------+
		// Retour des données
		
		
		$GLOBALS['_GEN_commun']['url'] = $restore_url;
		return $tab_retour;
		
	}
	
}



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_wiki.action.php,v $
* Revision 1.12  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.11  2007-01-24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.10  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.9  2007/01/15 11:31:27  ddelon
* correction bug wiki (backport)
*
* Revision 1.8  2006/11/21 13:18:45  ddelon
* merge modif wiki decaisne dans branche principale
*
* Revision 1.7.2.2  2006/11/21 16:00:08  ddelon
* bug reecriture url globale
*
* Revision 1.7.2.1  2006/11/21 14:47:16  ddelon
* backport modif wiki depuis bracnhe principale
*
* Revision 1.5.2.3  2006/11/21 11:49:48  ddelon
* Wiki et eflore + flux rss
*
* Revision 1.5.2.2  2006/11/10 22:38:15  ddelon
* wiki eflore
*
* Revision 1.5.2.1  2006/09/06 11:46:36  jp_milcent
* Gestion du code du référentiel pour le titre avant de créer le formulaire de recherche.
* Si on le place après, le référentiel est faux!
*
* Revision 1.5  2006/07/20 15:10:40  jp_milcent
* Amélioration de la gestion du wikini : gestion de la creation du nom de la page dans l'action.
* Modification et amélioration des redirections du htaccess.
* Mise en constante du nom du wikini et du chemin vers le dossier bibliotheque de l'intégrateur wikini.
*
* Revision 1.4  2006/07/12 16:02:28  jp_milcent
* Correction bogue titre.
*
* Revision 1.3  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.2  2006/06/17 11:55:25  ddelon
* Bug chemin
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