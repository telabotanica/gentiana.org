<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.	                                                                |
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
// CVS : $Id: effi_synonymie.vue.php,v 1.22 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de vue du module eFlore-Fiche : Synonymie
*
* Contient la génération de la vue pour l'onglet Synonymie.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.22 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueSynonymie extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('synonymie');
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

		// Gestion du nom du référentiel
		$ref_intitule = $this->getDonnees('pr_intitule').' - '.$this->getDonnees('pr_abreviation').
						' ( version '.$this->getDonnees('prv_code').' )';
		$ref_intitule_court = 	$this->getDonnees('pr_abreviation').'  v'.$this->getDonnees('prv_code');

		// Block par basionymie
		if ($this->getDonnees('nom_selection_a_pr_basionyme') != '') {
			$squelette->setCurrentBlock('BASIONYMIE_RELATION');
			$squelette->setVariable( 'NOM_SELECTION_A_PR_BASIONYME', $this->getDonnees('nom_selection_a_pr_basionyme')  );
			$squelette->parseCurrentBlock('BASIONYMIE_RELATION');
		}
		if ($this->getDonnees('nom_selection_basionyme') == true) {
			$squelette->setCurrentBlock('BASIONYMIE_BOOL');
			$squelette->setVariable( 'NOM_SELECTION_BASIONYME', $this->getDonnees('nom_selection_basionyme') );
			$squelette->parseCurrentBlock('BASIONYMIE_BOOL');
		}

		// Block Synonymie
		$aso_type_syno = array('ST_NR', 'ST_I', 'ST_P', 'ST', 'SN', 'SI', 'SID', 'SASD', 'SP');
		foreach ($aso_type_syno as $abbr) {
			foreach ($this->getDonnees(strtolower($abbr)) as $nom) {
				$squelette->setCurrentBlock($abbr.'_LIGNE');
				$squelette->setVariable( 'SYNONYME_URL', $nom['url'] );
				$squelette->setVariable( 'SYNONYME_CODE', $nom['code'] );
				if ($nom['nom'] instanceof NomDeprecie) {
					$NomSynoFormatage = new NomFormatage($nom['nom']);
					$squelette->setVariable( 'SYNONYME_NOM', $NomSynoFormatage->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE) );
				} else {
					$squelette->setVariable( 'SYNONYME_NOM', 'Problème : '.$nom['code_nn'] );
				}
				$squelette->parseCurrentBlock($abbr.'_LIGNE');
			}
			$squelette->setCurrentBlock($abbr);
			$squelette->parseCurrentBlock($abbr);
		}

		// Block info
		if ($this->getDonnees('info') != '' ) {
			$squelette->setCurrentBlock('INFO');
			$squelette->setVariable( 'INFO', $this->getDonnees('info') );
			$squelette->parseCurrentBlock('INFO');
		}

		// Block principal
		$squelette->setCurrentBlock();
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('TITRE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE));
		if ($this->getDonnees('nom_retenu_famille') != null) {
			$NomFamilleFormatage = new NomFormatage($this->getDonnees('nom_retenu_famille'));
			$squelette->setVariable('NOM_RETENU_FAMILLE', $NomFamilleFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
		}
		$squelette->setVariable('REFERENTIEL', $ref_intitule_court);
		

		$squelette->setVariable( 'NOM_SELECTION', $NomSelectionFormatage->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE) );
		$squelette->setVariable( 'NOM_SELECTION_CODE', $this->getDonnees('nom_selection_code') );
		$squelette->setVariable( 'NOM_SELECTION_NN', $this->getDonnees('nom_selection_code_nn') );
		$squelette->setVariable( 'NOM_SELECTION_NT', $this->getDonnees('nom_selection_code_nt') );
		$squelette->setVariable( 'NOM_SELECTION_AUTEUR', $this->getDonnees('nom_selection_auteur') );
		$squelette->setVariable( 'NOM_SELECTION_AUTEUR_IN', $this->getDonnees('nom_selection_auteur_in') );
		$squelette->setVariable( 'NOM_SELECTION_ANNEE', $this->getDonnees('nom_selection_annee') );
		$squelette->setVariable( 'NOM_SELECTION_BIBLIO', $this->getDonnees('nom_selection_biblio') );
		$squelette->setVariable( 'NOM_SELECTION_CN', $this->getDonnees('nom_selection_cn') );

		$squelette->setVariable( 'NOM_RETENU', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE) );
		$squelette->setVariable( 'NOM_RETENU_CODE', $this->getDonnees('nom_retenu_code') );
		$squelette->setVariable( 'NOM_RETENU_URL', $this->getDonnees('nom_retenu_url') );
		$squelette->setVariable( 'NOM_RETENU_NN', $this->getDonnees('nom_retenu_code_nn') );
		$squelette->setVariable( 'NOM_RETENU_NT', $this->getDonnees('nom_retenu_code_nt') );
		$squelette->setVariable( 'NOM_RETENU_AUTEUR', $this->getDonnees('nom_retenu_auteur') );
		$squelette->setVariable( 'NOM_RETENU_ANNEE', $this->getDonnees('nom_retenu_annee') );
		$squelette->setVariable( 'NOM_RETENU_AUTEUR_IN', $this->getDonnees('nom_retenu_auteur_in') );
		$squelette->setVariable( 'NOM_RETENU_BIBLIO', $this->getDonnees('nom_retenu_biblio') );
		$squelette->setVariable( 'EF_URL_JS', EF_URL_JS );
		
		$squelette->parseCurrentBlock();
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_synonymie.vue.php,v $
* Revision 1.22  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.21  2007-06-11 15:44:51  jp_milcent
* Gestion d'une problème de cohérence de la BDD.
*
* Revision 1.20  2006-10-25 08:15:21  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.19.2.1  2006/09/04 14:21:36  jp_milcent
* Gestion des informations sur le taxon et le nom sélectionné dans l'onglet "Informations".
*
* Revision 1.19  2006/07/18 14:31:47  jp_milcent
* Correction de l'interface suite aux remarques de Daniel du 12 juillet 2006.
*
* Revision 1.18  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.17  2006/06/20 15:22:22  jp_milcent
* Appel du fichier JS directement dans le squelette.
*
* Revision 1.16  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.15  2006/05/16 09:27:33  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.14  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.13  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.12  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* Revision 1.11  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.10.4.1  2006/03/07 10:27:18  jp_milcent
* Ajout de la gestion des synonymes provisoires.
*
* Revision 1.10  2005/12/09 14:52:16  jp_milcent
* Suppression du passage par référence de l'objet squelette.
*
* Revision 1.9  2005/12/08 17:28:19  jp_milcent
* Amélioration de l'affichage et utilisation du formatage des noms latins.
*
* Revision 1.8  2005/12/06 18:02:12  jp_milcent
* Début du travail sur nouvelle interface synthèse.
*
* Revision 1.7  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.6  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.5  2005/10/21 16:28:54  jp_milcent
* Amélioration des onglets Synonymies et Synthèse.
*
* Revision 1.4  2005/10/13 16:25:05  jp_milcent
* Ajout de la classification à la synthèse.
*
* Revision 1.3  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.2  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
*
* Revision 1.1  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>