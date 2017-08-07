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
// CVS : $Id: efre_recherche_nom_latin.vue.php,v 1.22 2007-02-07 10:52:35 jp_milcent Exp $
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
*@version       $Revision: 1.22 $ $Date: 2007-02-07 10:52:35 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueRechercheNomLatin extends aVue {

	public function __construct($Registre)
	{
		$this->setNom('recherche_nom_latin');
		parent::__construct($Registre);
		// Création du Squelette
		$this->setSquelette( new HTML_Template_IT( $this->getChemin() ) );
	}

	public function preparer()
	{
		// Récupération d'une référence au squelette
		$squelette = $this->getSquelette();
		
		$noms = $this->getDonnees('noms');
		
		
		// Tri pour gerer le tri des hybrides ou pas sans tenir compte du "x".
		function efre_rech_cmp($a, $b) {
			if (EF_TRI_HYBRIDE) {
				$a['intitule'] = preg_replace('/^(\S*) *x */Ui','$1', $a['intitule']);
				$b['intitule'] = preg_replace('/^(\S*) *x */Ui','$1', $b['intitule']);
			}
			
		    if ($a['intitule'] == $b['intitule']) {
       			return 0;
   			}
   			return ($a['intitule'] < $b['intitule']) ? -1 : 1;
		}
		usort($noms, 'efre_rech_cmp');
		
		// Trie pour mettre les taxons avant les synonymes
		$tab_tax = array();
		$tab_syn = array();
		foreach ($noms as $nom) {
			if ($nom['statut'] == EF_SNS_RETENU) {
				$tab_tax[] = $nom; 
			} else {
				$tab_syn[] = $nom;
			}
		}
		$noms = array_merge($tab_tax, $tab_syn);
		
		foreach ($noms as $nom) {

			// Définit le block courant
			if (EF_SNS_RETENU == $nom['statut']) {
				$block = 'NOM_RETENU';
			} else {
				$block = 'NOM_SYNONYME';
			}

			// Assigne les données au block courant
			$squelette->setCurrentBlock($block);
			// L'intitulé du nom
			$squelette->setVariable('EFLORE_NOM', $nom['intitule_affichage']);
			// L'url du nom
			$squelette->setVariable('EFLORE_URL_FICHE', $nom['url_fiche']);
			$squelette->parseCurrentBlock($block);

			$squelette->setCurrentBlock('NOM');
			$squelette->parseCurrentBlock('NOM');
		}
		
		if ($this->getDonnees('info') != null) {
			$squelette->setCurrentBlock('NOM_INFO');
			$squelette->setVariable( 'NOM_INFO', $this->getDonnees('info'));
			$squelette->parseCurrentBlock('NOM_INFO');
		} else {
			$squelette->setCurrentBlock('RESULTAT');
			$squelette->setVariable('RESULTAT_NBRE', count($noms));
			$squelette->parseCurrentBlock('RESULTAT');
		}
		
		// Gestion de la recherche approchée 
		$nom_approche = $this->getDonnees('nom_approche');
		if (isset($nom_approche) && $nom_approche != '') {		
			$squelette->setVariable('EFLORE_NOM_APPROCHE_URL', $this->getDonnees('url_approchee'));
			$squelette->setVariable('EFLORE_NOM_APPROCHE', $nom_approche );
			$squelette->setCurrentBlock('NOM_APPROCHE');
			$squelette->parseCurrentBlock('NOM_APPROCHE');
		}
		
		// Gestion du block principal
		$squelette->setCurrentBlock();
		$squelette->setVariable('TITRE_GENERAL_REFERENTIEL', $this->getDonnees('titre_general_referentiel'));
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('RADICAL', $this->getDonnees('radical') );
		$squelette->setVariable('NVP', $this->getDonnees('nvp') );
		$squelette->setVariable( 'EF_URL_JS', EF_URL_JS );
		/*
		if ($GLOBALS['eflore_referenciel'] == 0) {
			$squelette->setVariable('REFERENCIEL', 'Tous');
		} else {
			$referenciel = $GLOBALS['eflore_referenciel_nom'];
			$referenciel_nom = 	$referenciel['intitule'].' - '.$referenciel['abreviation'].
										' (version '.$referenciel['code'].')';
			$squelette->setVariable('REFERENCIEL', $referenciel_nom);
		}*/
		$squelette->parseCurrentBlock();		
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_nom_latin.vue.php,v $
* Revision 1.22  2007-02-07 10:52:35  jp_milcent
* Ajout de l'id de la version du projet pour l'OpenSearch.
*
* Revision 1.21  2006/07/20 09:45:27  jp_milcent
* Correction du bogue ayant fait sauter l'algo de trie des noms latins.
* Modification du trie pour afficher les taxons en premier.
* Ajout d'une constante permettant de tenir compte ou pas du "x" des hybrides dans le trie des noms.
*
* Revision 1.20  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.19  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.18  2006/06/20 15:26:10  jp_milcent
* Appel du fichier JS directement dans le squelette.
*
* Revision 1.17  2006/05/29 13:56:10  ddelon
* Integration wiki dans eflore
*
* Revision 1.16  2006/05/16 09:27:34  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.15  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.14  2005/12/21 16:10:30  jp_milcent
* Gestion des fichiers de localisation et simplification du code.
*
* Revision 1.13  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.12  2005/12/04 23:57:28  ddelon
* Recherche approchee
*
* Revision 1.11  2005/12/02 21:29:41  ddelon
* Limitation recherche nom verna
*
* Revision 1.10  2005/12/01 15:59:43  ddelon
* limitation recherche
*
* Revision 1.9  2005/11/28 22:28:15  ddelon
* traitement hybrides
*
* Revision 1.8  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.7  2005/11/25 14:09:41  ddelon
* Tri recherche nom latin
*
* Revision 1.6  2005/10/10 13:53:21  jp_milcent
* Amélioration de la gestion des sessions.
*
* Revision 1.5  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.4  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les référentiels.
*
* Revision 1.3  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
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