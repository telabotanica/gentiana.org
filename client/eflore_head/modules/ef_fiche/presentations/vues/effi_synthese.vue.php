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
// CVS : $Id: effi_synthese.vue.php,v 1.44 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier de vue du module eFlore-Fiche : Synthèse
*
* Contient la génération de la vue pour l'onglet synthèse.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.44 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class VueSynthese extends aVue {

	public function __construct($Registre)
	{
		$this->setNom('synthese');
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
		$_SESSION['effi_ref_intitule'] = $ref_intitule;

		// Gestion du block des Noms vernaculaires
		if ($this->getDonnees('noms_verna_bool') != false) {
			// Attribution des noms verna recommandés ou typique
			$tab_noms_verna = $this->getDonnees('noms_verna');
			for($i = 0; $i < count($tab_noms_verna); $i++) {
				if ($i == (count($tab_noms_verna) - 1)) {
					$type = 'NOM_VERNA_FIN';
				} else {
					$type = 'NOM_VERNA';
				}
				$squelette->setCurrentBlock($type) ;
				$squelette->setVariable( 'NOM_VERNA_FR_RECOMMANDE', $tab_noms_verna[$i] );
				$squelette->parseCurrentBlock($type);
			}
			$squelette->setCurrentBlock('VERNA') ;
			$squelette->parseCurrentBlock('VERNA');
		} else {
			$squelette->setCurrentBlock('VERNA_INFO') ;
			$squelette->setVariable( 'NOM_VERNA_INFO', $this->getDonnees('noms_verna_info')  );
			$squelette->parseCurrentBlock('VERNA_INFO');
		}
		
		// Gestion du block correspondance
		$squelette->setCurrentBlock('CORRESPONDANCE') ;
		foreach ($this->getDonnees('referentiels') as $referentiel) {
			//echo '<pre>'.print_r($referentiel, true).'</pre>';
			$squelette->setCurrentBlock('CORRES_LIGNE') ;
			$NomCorresFormatage = new NomFormatage($referentiel['nom']);
			$ref_corres_intitule_court = $referentiel['pr_abreviation'];
			if ($referentiel['pr_id'] == EF_PR_BDNFF_ID || $referentiel['pr_id'] == EF_PR_BDNBE_ID) {
				// Si c'est une version de la BDNFF ou de la BDNBE nous affichons son code de version
				$ref_corres_intitule_court = $referentiel['pr_abreviation'].'  v'.$referentiel['prv_code'];
			}
			$squelette->setVariable('CORRES_REFERENTIEL', $ref_corres_intitule_court);
			$squelette->setVariable('CORRES_NOM', $NomCorresFormatage->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE));
			$squelette->setVariable('CORRES_URL', $this->getDonnees('url_page_courante'));
			$squelette->parseCurrentBlock('CORRES_LIGNE');
		}
		$squelette->parseCurrentBlock('CORRESPONDANCE');
		
		// Gestion du block Xper
		if ($this->getDonnees('xper_bool') != false) {
			$squelette->setCurrentBlock('XPER') ;
			foreach ($this->getDonnees('xper_bases') as $base) {
				$squelette->setCurrentBlock('XPER_LIGNE') ;
				$squelette->setVariable('XPER_BASE_NOM', $base['nom'] );
				$squelette->setVariable('XPER_BASE_URL', $base['url'] );
				$squelette->setVariable('XPER_BASE_RANG', $base['rang'] );
				$squelette->setVariable('XPER_BASE_TITRE', $base['titre'] );
				$squelette->parseCurrentBlock('XPER_LIGNE');
			}
			$squelette->parseCurrentBlock('CORRESPONDANCE');
		}
		
		// Gestion du block Classification
		$squelette->setCurrentBlock('CLASSIF_BODY') ;
		foreach ($this->getDonnees('classification') as $tab_classif) {
			if (is_object($tab_classif['nom'])) {
				$squelette->setCurrentBlock('CLASSIF_LIGNE_BODY') ;
				$NomClassifFormatage = new NomFormatage($tab_classif['nom']);
				$squelette->setVariable('CLASSIF_RANG', ucfirst($tab_classif['rang']));
				$squelette->setVariable('CLASSIF_NOM', $NomClassifFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
				$squelette->setVariable('CLASSIF_URL', $tab_classif['url']);
				$squelette->parseCurrentBlock('CLASSIF_LIGNE_BODY');
			}
		}
		$squelette->parseCurrentBlock('CLASSIF_BODY');

		// Gestion du block photo
		if ($this->getDonnees('photoflora_bool') != false) {
			foreach ($this->getDonnees('photoflora') as $photo_id => $photo_info) {
				$squelette->setCurrentBlock('PHOTOFLORA');
				$squelette->setVariable( 'PHOTOFLORA_IMG_ID', $photo_id );
				$squelette->setVariable( 'PHOTOFLORA_IMG_NORMALE_URL', $photo_info['url_normale'] );
				$squelette->setVariable( 'PHOTOFLORA_IMG_MINIATURE_URL', $photo_info['url_miniature'] );
				$squelette->setVariable( 'PHOTOFLORA_NOM_RETENU_NF', $this->getDonnees('nom_retenu_nf')  );
				$squelette->parseCurrentBlock('PHOTOFLORA');
			}
		}

		// Gestion du block choro
		if ($this->getDonnees('carto_bool') == true) {
			$squelette->setCurrentBlock('CARTO');
			foreach ($this->getDonnees('legende') as $legende) {
				$squelette->setCurrentBlock('LEGENDE_LIGNE');
				$rvb = $legende['couleur']['R'].','.$legende['couleur']['V'].','.$legende['couleur']['B'];
				$squelette->setVariable( 'LEGENDE_COULEUR', 'rgb('.$rvb.')' );
				$squelette->setVariable( 'LEGENDE_INTITULE', $legende['intitule'] );
				$squelette->parseCurrentBlock('LEGENDE_LIGNE');
			}
			$squelette->setVariable( 'NOM_RETENU_COMPLET', $this->getDonnees('nom_retenu_complet') );
			$squelette->setVariable( 'CARTE', $this->getDonnees('carte_france')  );
			$squelette->setVariable( 'CARTE_URL', $this->getDonnees('url_carte')  );
			$squelette->parseCurrentBlock('CARTO');
		} else {
			$squelette->setCurrentBlock('CARTO_INFO');
			$squelette->setVariable( 'CARTO_INFO', $this->getDonnees('carto_info') );
			$squelette->parseCurrentBlock('CARTO_INFO');
		}

		// Gestion du block Famille
		if ($this->getDonnees('nom_retenu_famille') != null) {
			$squelette->setCurrentBlock('FAMILLE');
			if (is_object($this->getDonnees('nom_retenu_famille'))) {
				$NomFamilleFormatage = new NomFormatage($this->getDonnees('nom_retenu_famille'));
				$squelette->setVariable( 'NOM_RETENU_FAMILLE', $NomFamilleFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
			} else {
				$squelette->setVariable( 'NOM_RETENU_FAMILLE', $this->getDonnees('nom_retenu_famille') );
			}
			$squelette->parseCurrentBlock('FAMILLE');
		}
		
		// Gestion du block Permalien
		if ($this->getDonnees('permalien_nn_bool') == true) {
			$squelette->setCurrentBlock('PERMALIEN_NN');
			$squelette->setVariable('URL_PERMALIEN_NN', $this->getDonnees('url_permalien_nn'));
			$squelette->parseCurrentBlock('PERMALIEN_NN');
		} else {
			$squelette->setCurrentBlock('PERMALIEN_NN_INFO');
			$squelette->setVariable('PERMALIEN_NN_INFO', $this->getDonnees('permalien_nn_info'));
			$squelette->parseCurrentBlock('PERMALIEN_NN_INFO');
		}
		$url_nom_retenu = $this->getDonnees('url_page_courante');
		if ($this->getDonnees('permalien_nt_bool') == true) {
			$squelette->setCurrentBlock('PERMALIEN_NT');
			$squelette->setVariable('URL_PERMALIEN_NT', $this->getDonnees('url_permalien_nt'));
			$squelette->parseCurrentBlock('PERMALIEN_NT');
		} else {
			$squelette->setCurrentBlock('PERMALIEN_NT_INFO');
			$squelette->setVariable('PERMALIEN_NT_INFO', $this->getDonnees('permalien_nt_info'));
			$squelette->parseCurrentBlock('PERMALIEN_NT_INFO');
		}

		// Gestion du block principal
		$squelette->setCurrentBlock();
		//echo '<pre>'.print_r($this->getDonnees('un_form_nom'), true).'</pre>';
		$squelette->setVariable('FORMULAIRE_RECHERCHE_NOM', $this->getDonnees('un_form_nom'));
		$squelette->setVariable('TITRE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE));
		$squelette->setVariable('REFERENTIEL', $ref_intitule_court);
		// Permalien pour le nom sélectionné
		$squelette->setVariable('URL_PERMALIEN_NOM_SELECTION', $this->getDonnees('url_permalien_nom_selection'));
		// Permalien pour le nom retenu
		$squelette->setVariable('URL_PERMALIEN_NOM_RETENU', $this->getDonnees('url_permalien_nom_retenu'));
		$squelette->setVariable( 'NVP', $this->getDonnees('nvp')  );
		$squelette->setVariable( 'NN', $this->getDonnees('nn')  );
		$squelette->setVariable( 'NT', $this->getDonnees('nt')  );
		$squelette->setVariable( 'NOM_SELECTION', $NomSelectionFormatage->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE) );
		$squelette->setVariable( 'NOM_SELECTION_NF', $this->getDonnees('nom_selection_nf') );
		$squelette->setVariable( 'NOM_SELECTION_SIMPLE', $NomSelectionFormatage->formaterNom(NomDeprecie::FORMAT_SIMPLE)  );
		$squelette->setVariable( 'NOM_SELECTION_NN', $this->getDonnees('nom_selection_code_nn')  );
		$squelette->setVariable( 'NOM_SELECTION_NT', $this->getDonnees('nom_selection_code_nt')  );
		// Création du formatage de ma référence biblio du nom sélectionné
		$ref_biblio = array();
		if ($this->getDonnees('nom_selection_auteur_principal') != '') {
			$ref_biblio[0] = $this->getDonnees('nom_selection_auteur_principal');
		}
		if ($this->getDonnees('nom_selection_annee') != '') {
			$ref_biblio[1] = $this->getDonnees('nom_selection_annee');
		}
		if ($this->getDonnees('nom_selection_ref_biblio') != '') {
			$ref_biblio[2] = $this->getDonnees('nom_selection_ref_biblio');
		}
		$squelette->setVariable( 'NOM_SELECTION_AUTEUR_ANNEE_REF_BIBLIO', implode(' - ', $ref_biblio) );
		$squelette->setVariable( 'URL_FORM_REF', $this->getDonnees('url_form_ref')  );
		
		$squelette->setVariable( 'NOM_RETENU', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_COMPLET_CODE));
		$squelette->setVariable( 'NOM_RETENU_NF', $this->getDonnees('nom_retenu_nf') );
		$squelette->setVariable( 'NOM_RETENU_SIMPLE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_SIMPLE) );
		$squelette->setVariable( 'NOM_RETENU_ULTRA_SIMPLE', $NomRetenuFormatage->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE) );
		$squelette->setVariable( 'NOM_RETENU_NN', $this->getDonnees('nom_retenu_code_nn') );
		$squelette->setVariable( 'NOM_RETENU_NT', $this->getDonnees('nom_retenu_code_nt') );
		// Création du formatage de ma référence biblio du nom retenu
		$ref_biblio = array();
		if ($this->getDonnees('nom_retenu_auteur_principal') != '') {
			$ref_biblio[0] = $this->getDonnees('nom_retenu_auteur_principal');
		}
		if ($this->getDonnees('nom_retenu_annee') != '') {
			$ref_biblio[1] = $this->getDonnees('nom_retenu_annee');
		}
		if ($this->getDonnees('nom_retenu_ref_biblio') != '') {
			$ref_biblio[2] = $this->getDonnees('nom_retenu_ref_biblio');
		}
		$squelette->setVariable( 'NOM_RETENU_AUTEUR_ANNEE_REF_BIBLIO', implode(' - ', $ref_biblio) );

		$squelette->setVariable( 'CODE_TAXONOMIQUE', $this->getDonnees('code_taxonomique') );
		
		$squelette->setVariable( 'URL_EXPORT_PDF', $this->getDonnees('url_export_pdf')  );
		
		$squelette->setVariable( 'EF_URL_JS', EF_URL_JS );
		
		$squelette->parseCurrentBlock();
	}
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_synthese.vue.php,v $
* Revision 1.44  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.43  2007-06-11 16:34:46  jp_milcent
* Correction problème des permaliens.
*
* Revision 1.40.2.4  2007-06-11 16:30:23  jp_milcent
* Ajout de permaliens spécifiques aux noms retenu et sélectionné.
*
* Revision 1.40.2.3  2007-06-11 16:12:50  jp_milcent
* Ajout de permalien aux noms retenu et sélectionné.
*
* Revision 1.42  2007-06-11 09:04:09  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.40.2.2  2007-06-11 09:01:08  jp_milcent
* Correction bogue : problème d'url pour les noms des correspondances.
*
* Revision 1.41  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.40.2.1  2007/02/07 10:46:29  jp_milcent
* Ajout de la BDNBE au test des correspondances.
*
* Revision 1.40  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.39  2007/01/12 16:20:48  jp_milcent
* Amélioration gestion des codes.
*
* Revision 1.38  2006/12/22 16:50:43  jp_milcent
* Amélioration de la gestion des permaliens : nous tenons comptes des taxons non géré par les référentiels.
*
* Revision 1.37.2.1  2006/11/21 09:47:05  jp_milcent
* Correction du problème des liens des noms correspondant.
*
* Revision 1.37  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.36.2.1  2006/07/27 12:26:28  jp_milcent
* Gestion d'un booléen permettant de savoir si on tient compte ou pas d'xper.
*
* Revision 1.36  2006/07/24 13:42:44  jp_milcent
* Modification intitulé du nom de la base de connaissance.
*
* Revision 1.35  2006/07/20 12:04:31  jp_milcent
* Ajout des noms avec l'auteur.
*
* Revision 1.34  2006/07/18 14:31:47  jp_milcent
* Correction de l'interface suite aux remarques de Daniel du 12 juillet 2006.
*
* Revision 1.33  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.32  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.31  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.30  2006/05/16 09:27:33  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.29  2006/05/11 12:55:07  jp_milcent
* Correction sur la gestion des photos de Photoflora.
*
* Revision 1.28  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.27  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.26  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.25.2.1  2006/03/10 14:59:50  jp_milcent
* Suppression de l'affichage de "Famille ?" pour les noms de rang supérieurs ou égal à la famille.
*
* Revision 1.25  2006/01/23 20:46:32  ddelon
* affichage langues disponibles
*
* Revision 1.24  2005/12/09 15:09:38  jp_milcent
* Suppression du passage par référence d'un objet.
*
* Revision 1.23  2005/12/09 14:52:16  jp_milcent
* Suppression du passage par référence de l'objet squelette.
*
* Revision 1.22  2005/12/08 17:28:19  jp_milcent
* Amélioration de l'affichage et utilisation du formatage des noms latins.
*
* Revision 1.21  2005/12/08 15:03:35  jp_milcent
* Amélioration de l'affichage. Changements cosmétiques.
*
* Revision 1.20  2005/12/06 18:02:12  jp_milcent
* Début du travail sur nouvelle interface synthèse.
*
* Revision 1.19  2005/12/05 15:36:00  jp_milcent
* Ajout du message d'information si la carto n'est pas disponible.
*
* Revision 1.18  2005/11/25 19:52:04  ddelon
* Amelioration affichage interface
*
* Revision 1.17  2005/11/24 16:23:26  jp_milcent
* Correction des permaliens suite à discussion.
*
* Revision 1.16  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.15  2005/10/27 13:27:59  jp_milcent
* Fin des améliorations de la première version...
*
* Revision 1.14  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.13  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.12  2005/10/21 16:28:54  jp_milcent
* Amélioration des onglets Synonymies et Synthèse.
*
* Revision 1.11  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.10  2005/10/13 16:25:05  jp_milcent
* Ajout de la classification à la synthèse.
*
* Revision 1.9  2005/10/13 08:27:09  jp_milcent
* Ajout d'une mini chorologie sur la page de synthèse.
* Déplacement des constantes de requete sql dans les fichiers de chaque classe DAO.
*
* Revision 1.8  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.7  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.6  2005/10/05 16:36:35  jp_milcent
* Débu et fin gestion de l'onglet Illustration.
* Amélioration de l'onglet Synthèse avec ajout d'une image.
*
* Revision 1.5  2005/09/28 16:29:31  jp_milcent
* Début et fin de gestion des onglets.
* Début gestion de la fiche Synonymie.
*
* Revision 1.4  2005/09/27 16:03:46  jp_milcent
* Fin de l'amélioration de la gestion des noms vernaculaires dans l'onglet Synthèse.
*
* Revision 1.3  2005/09/26 15:48:15  jp_milcent
* Fin de l'onglet synthèse pour la fiche d'un taxon.
*
* Revision 1.2  2005/09/16 16:41:45  jp_milcent
* Gestion de l'onglet Synthèse en cours.
* Création du modèle pour l'attribution des noms vernaculaires aux taxons.
*
* Revision 1.1  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>