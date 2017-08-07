<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: effi_illustration.vue.php,v 1.17 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de vue du module eFlore-Fiche : Illustration
*
* Contient la génération de la vue pour l'onglet "Illustration".
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.17 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueIllustration extends aVue {
	
	public function __construct($Registre)
	{
		$this->setNom('illustration');
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

		// Gestion du block Photoflora
		if ($this->getDonnees('photoflora_bool') != false) {
			foreach ($this->getDonnees('photoflora') as $photo_id => $photo_info) {
				$squelette->setCurrentBlock('PHOTOFLORA_IMG');
				// Ajout de &nbsp;
				foreach ($photo_info as $cle => $val) {
					if ($val == '') {
						$photo_info[$cle] = '&nbsp;';
					}
				}
				$squelette->setVariable( 'PHOTOFLORA_IMG_ID', $photo_info['dc:identifier'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_NORMALE_URL', $photo_info['url_normale'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_MINIATURE_URL', $photo_info['url_miniature'] );
				//$squelette->setVariable( 'PHOTOFLORA_IMG_CLASS', $photo_info['class'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_TITRE', $photo_info['dc:title'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_AUTEUR', $photo_info['dc:creator'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_CONTRIBUTEUR', $photo_info['dc:contributor'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_TYPE', $photo_info['dc:type'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_DATE_CREATION', $photo_info['dcterms:created'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_DATE_SOUMISSION', $photo_info['dcterms:dateSubmitted'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_LICENCE', $photo_info['dcterms:licence'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_LIEU', $photo_info['dcterms:spatial'] );
				
				$squelette->setVariable( 'PHOTOFLORA_IMG_HAUTEUR', $photo_info['hauteur'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_LARGEUR', $photo_info['largeur'] );
				$squelette->setVariable( 'NOM_RETENU_ULTRA_SIMPLE', $this->getDonnees('nom_retenu_ultra_simple') );
				$squelette->parseCurrentBlock('PHOTOFLORA_IMG');
			}
			$squelette->setCurrentBlock('PHOTOFLORA');
			$squelette->parseCurrentBlock('PHOTOFLORA');
			$squelette->setCurrentBlock('PHOTOFLORA_INTRO');
			$squelette->setVariable( 'PHOTOFLORA_URL_ACCUEIL', $this->getDonnees('photoflora_url_accueil') );
			$squelette->setVariable( 'PHOTOFLORA_URL_TAXON', $this->getDonnees('photoflora_url_taxon') );
			$squelette->setVariable( 'NOM_RETENU_ULTRA_SIMPLE', $this->getDonnees('nom_retenu_ultra_simple') );
			$squelette->parseCurrentBlock('PHOTOFLORA_INTRO');
			
		} else {
			$squelette->setCurrentBlock('PHOTOFLORA_INFO');
			$squelette->setVariable( 'PHOTOFLORA_INFO', $this->getDonnees('photoflora_info') );
			$squelette->parseCurrentBlock('PHOTOFLORA_INFO');
		}
		
		// Gestion du block Tela Botanica
		if ($this->getDonnees('telabotanica_bool') != false) {
			foreach ($this->getDonnees('telabotanica') as $photo_id => $photo_info) {
				$squelette->setCurrentBlock('TB_IMG');
				// Ajout de &nbsp;
				foreach ($photo_info as $cle => $val) {
					if ($val == '') {
						$photo_info[$cle] = '&nbsp;';
					}
				}
				$squelette->setVariable( 'TB_IMG_NORMALE_URL', $photo_info['url_normale'] );
				$squelette->setVariable( 'TB_IMG_MINIATURE_URL', $photo_info['url_miniature'] );
				//$squelette->setVariable( 'PHOTOFLORA_IMG_CLASS', $photo_info['class'] );
				$squelette->setVariable( 'TB_IMG_ID', $photo_info['dc:identifier'] );
				$squelette->setVariable( 'TB_IMG_TITRE', $photo_info['dc:title'] );
				$squelette->setVariable( 'TB_IMG_AUTEUR', $photo_info['dc:creator'] );
				$squelette->setVariable( 'TB_IMG_CONTRIBUTEUR', $photo_info['dc:contributor'] );
				$squelette->setVariable( 'TB_IMG_TYPE', $photo_info['dc:type'] );
				$squelette->setVariable( 'TB_IMG_DATE_CREATION', $photo_info['dcterms:created'] );
				$squelette->setVariable( 'TB_IMG_DATE_SOUMISSION', $photo_info['dcterms:dateSubmitted'] );
				$squelette->setVariable( 'TB_IMG_LICENCE', $photo_info['dcterms:licence'] );
				$squelette->setVariable( 'TB_IMG_LIEU', $photo_info['dcterms:spatial'] );
				
				$squelette->setVariable( 'TB_IMG_HAUTEUR', $photo_info['hauteur'] );
				$squelette->setVariable( 'TB_IMG_LARGEUR', $photo_info['largeur'] );
				$squelette->setVariable( 'TB_RETENU_ULTRA_SIMPLE', $this->getDonnees('nom_retenu_ultra_simple') );
				$squelette->parseCurrentBlock('TB_IMG');
			}
			if (count($this->getDonnees('telabotanica')) == 0) {
				$squelette->setCurrentBlock('TB_INFO');
				$squelette->setVariable( 'TB_INFO', $this->getDonnees('telabotanica_info') );
				$squelette->parseCurrentBlock('TB_INFO');
			}
			$squelette->setCurrentBlock('TELABOTANICA');
			$squelette->parseCurrentBlock('TELABOTANICA');
		}

		// Gestion du block Yahoo
		if ($this->getDonnees('yahoo_resultat_nbre') > 0) {
			// Yahoo : traitement de chaque image
			foreach ($this->getDonnees('yahoo_resultats') as $photo_info) {
				$squelette->setCurrentBlock('YAHOO_IMG');
				$squelette->setVariable( 'YAHOO_IMG_NORMALE_URL', $photo_info['ClickUrl'] );
				$squelette->setVariable( 'YAHOO_IMG_MINIATURE_URL', $photo_info['Thumbnail']->Url );
				$squelette->setVariable( 'YAHOO_IMG_PAGE_WEB', $photo_info['RefererUrl'] );
				$squelette->setVariable( 'YAHOO_IMG_FORMAT', $photo_info['FileFormat'] );
				$squelette->setVariable( 'YAHOO_IMG_HAUTEUR', $photo_info['Height'] );
				$squelette->setVariable( 'YAHOO_IMG_LARGEUR', $photo_info['Width'] );
				$squelette->setVariable( 'YAHOO_IMG_MINIATURE_HAUTEUR_MAX', $this->getDonnees('yahoo_miniature_hauteur_max') );
				$squelette->setVariable( 'YAHOO_IMG_MINIATURE_LARGEUR_MAX', $this->getDonnees('yahoo_miniature_largeur_max') );
				$squelette->setVariable( 'YAHOO_IMG_CLASS', $photo_info['class'] );
				$squelette->setVariable( 'YAHOO_IMG_JS_HAUTEUR', $photo_info['Height_js'] );
				$squelette->setVariable( 'YAHOO_IMG_JS_LARGEUR', $photo_info['Width_js'] );
				$squelette->parseCurrentBlock('YAHOO_IMG');
			}
			// Yahoo : affichage de la liste des images
			$squelette->setCurrentBlock('YAHOO');
			$squelette->parseCurrentBlock('YAHOO');
		} else {
			$squelette->setCurrentBlock('YAHOO_INFO');
			$squelette->setVariable( 'YAHOO_INFO', $this->getDonnees('yahoo_info') );
			$squelette->parseCurrentBlock('YAHOO_INFO');
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
		$squelette->setVariable( 'NOM_RETENU_ULTRA_SIMPLE', $this->getDonnees('nom_retenu_ultra_simple') );
		$squelette->parseCurrentBlock();
	}

}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_illustration.vue.php,v $
* Revision 1.17  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.16  2006-11-15 10:53:50  jp_milcent
* Fin des réglages de l'utilisation du service XML venant de Photoflora.
*
* Revision 1.15  2006/11/14 20:41:38  jp_milcent
* Début des modifications du fonctionnement de l'affichage des illustrations en provenance de Photoflora.
*
* Revision 1.14  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.13.2.2  2006/10/19 16:29:20  jp_milcent
* Amélioration de la gestion des images.
*
* Revision 1.13.2.1  2006/10/19 15:04:14  jp_milcent
* Amélioration de l'affichage du message d'erreur image introuvable pour le projet "eflore".
*
* Revision 1.13  2006/07/12 17:15:20  jp_milcent
* Correction problème "info indisponible" pour les images TB.
*
* Revision 1.12  2006/07/12 14:43:23  jp_milcent
* Ajout de la gestion des illustrations provennant du réseau TB.
*
* Revision 1.11  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.10  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.9  2006/05/19 12:04:18  jp_milcent
* Exclusion des noms supérieur à l'espèce de la BDNFF v3.02 pour les correspondances de noms retenus.
*
* Revision 1.8  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.7  2005/12/09 14:52:16  jp_milcent
* Suppression du passage par référence de l'objet squelette.
*
* Revision 1.6  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.5  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.4  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.3  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.2  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.1  2005/10/05 16:36:35  jp_milcent
* Débu et fin gestion de l'onglet Illustration.
* Amélioration de l'onglet Synthèse avec ajout d'une image.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>