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
// CVS : $Id: effi_synonymie.action.php,v 1.24 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Synonymie
*
* Contient les infos pour l'onglet Synonymie.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.24 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionSynonymie extends aAction {
	
	/*** Méthodes : ***/
	
	public function executer()
	{
		// +------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		
		$dao_n = new NomDeprecieDao();
		//$dao_n->setDebogage(EF_DEBOG_SQL);
		$dao_nr = new NomRelationDao();
		//$dao_nr->setDebogage(EF_DEBOG_SQL);
		$dao_sn = new SelectionNomDao;
		//$dao_sn->setDebogage(EF_DEBOG_SQL);

		// +------------------------------------------------------------------------------------------------------+
		// Récupération d'infos générales
		$tab_retour['nn'] = $_SESSION['nn'];
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur la version et le projet courant
		$tab_retour['pr_abreviation'] = $_SESSION['cpr'];
		$tab_retour['pr_intitule'] = $_SESSION['ipr'];
		$tab_retour['prv_code'] = $_SESSION['cprv'];
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Intégration du moteur de recherche par nom latin		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');
				
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant
		$tab_retour['nt'] = $_SESSION['nt'];
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_retenu_nn'] = $_SESSION['NomRetenu']->getId('nom');
		$tab_retour['nom_retenu_code_nn'] = 'nn'.$_SESSION['NomRetenu']->getId('nom');
		$tab_retour['nom_retenu_code'] = $tab_retour['nom_retenu_code_nn'].'prv'.$_SESSION['NomRetenu']->getId('version_projet_nom');
		$tab_retour['nom_retenu_nt'] = $_SESSION['nt'];
		$tab_retour['nom_retenu_code_nt'] = 'nt'.$_SESSION['nt'];
		$tab_retour['nom_retenu_biblio'] = $_SESSION['NomRetenu']->retournerBiblio();
		$tab_retour['nom_retenu_annee'] = $_SESSION['NomRetenu']->retournerAnnee();
		$tab_retour['nom_retenu_auteur'] = $_SESSION['NomRetenu']->retournerAuteur();
		$tab_retour['nom_retenu_auteur_in'] = $_SESSION['NomRetenu']->retournerAuteurIn();
		// Création de l'url du nom retenu
		$permalien_nr = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$permalien_nr->setType('nn');
		$permalien_nr->setProjetCode($_SESSION['cpr']);
		$permalien_nr->setVersionCode($_SESSION['cprv']);
		$permalien_nr->setPage(EF_LG_URL_ACTION_SYNONYMIE);
		$permalien_nr->setTypeId($_SESSION['NomRetenu']->getId('nom'));
		$tab_retour['nom_retenu_url'] = $permalien_nr->getUrl();
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos et du basionyme sur le nom selectionné
		$tab_retour['nom_selection_nn'] = $_SESSION['nn'];
		$tab_retour['nom_selection_code_nn'] = 'nn'.$_SESSION['nn'];
		$tab_retour['nom_selection_code'] = $tab_retour['nom_selection_code_nn'].'prv'.$_SESSION['NomSelection']->getId('version_projet_nom');
		$tab_nom = $dao_n->consulter(EF_CONSULTER_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvpn']));
		$le_nom_selection = $tab_nom[0];
		$tab_retour['nom_selection'] = $le_nom_selection;
		$tab_retour['nom_selection_auteur_in'] = $le_nom_selection->retournerAuteurIn();
		$tab_retour['nom_selection_auteur'] = $le_nom_selection->retournerAuteur();
		$tab_retour['nom_selection_annee'] = $le_nom_selection->retournerAnnee();
		$tab_retour['nom_selection_biblio'] = $le_nom_selection->retournerBiblio();
		$tab_retour['nom_selection_cn'] = $le_nom_selection->retournerCommentaireNomenclatural();
		
		$tab_nr = $dao_nr->consulter(EF_CONSULTER_NR_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvp']));
		//echo '<pre>'.print_r($tab_nr, true).'</pre>';
		$tab_retour['nom_selection_a_pr_basionyme'] = 'Non renseigné!';
		$tab_retour['nom_selection_basionyme'] = false;
		foreach ($tab_nr as $une_relation) {
			// Nous vérifions si le nom est basionyme
			if ( $une_relation->getId('categorie_relation') == 7 AND $une_relation->getId('nom_2') == $_SESSION['nn']) {
				switch ($une_relation->getId('valeur_relation')) {
					case 3 :
						$tab_retour['nom_selection_basionyme'] = '['.'Basionyme'.']';
						break;
					case 4 :
						$tab_retour['nom_selection_basionyme'] = '['.'Basionyme d\'un synonyme taxonomique'.']';
						break;
					case 5 :
						$tab_retour['nom_selection_basionyme'] = '['.'Basionyme (synonyme remplacé)'.']';
						break;
				}
				$tab_retour['nom_selection_a_pr_basionyme'] = '';
			}
			// Répérage de la relation "a pour basionyme" : pas encore fait car bogue dans les données
			// TODO : corriger le bogue de l'intégration des données qui n'ajoute pas de relation de basionymie mais des "a pour parent..."
			if ( $une_relation->getId('categorie_relation') == 5 AND $une_relation->getId('valeur_relation') == 3 ) {
				$tab_n = $dao_n->consulter(EF_CONSULTER_NOM_ID, array((int)$une_relation->getId('nom_2'), (int)$une_relation->getId('version_projet_nom_2')));
				$le_basionyme = $tab_n[0];
				$tab_retour['nom_selection_a_pr_basionyme'] = $le_basionyme->formaterNom(EF_NOM_FORMAT_COMPLET);
			}
		}

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des données sur les noms du taxon sélectionné dont le nom retenu

		// Les infos sur les projets et version contenant le nom sélectionné
		$tab_sn_nn = $dao_sn->consulter(EF_CONSULTER_SN_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvpn']));
		$tab_projets = array();
		foreach($tab_sn_nn as $une_sn) {
			//echo '<pre>'.print_r($une_sn->getId('id_version'), true).'</pre>';
			if (!isset($tab_projets[$une_sn->getId('version_projet_taxon')])) {
				$tab_projets[$une_sn->getId('version_projet_taxon')] = $une_sn->getId('version_projet_taxon');
			}
			if ($une_sn->getId('version_projet_taxon') == $_SESSION['nvp']) {
				$_SESSION['nt'] = $une_sn->getId('taxon');
				$tab_retour['nom_selection_nt'] = $_SESSION['nt'];
				$tab_retour['nom_selection_code_nt'] = 'nt'.$_SESSION['nt'];
			}
		}
		unset($une_sn);

		// Création de l'url des synonymes
		$permalien_nn = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$permalien_nn->setType('nn');
		$permalien_nn->setProjetCode($_SESSION['cpr']);
		$permalien_nn->setVersionCode($_SESSION['cprv']);
		$permalien_nn->setPage(EF_LG_URL_ACTION_SYNONYMIE);
		
		// Récupération de la sélection de noms pour le taxon sélectionné
		$tab_sn_nt = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID, array((int)$_SESSION['nt'], (int)$_SESSION['nvp']));
		$tab_noms_id = array();
		$tab_noms = array();
		foreach($tab_sn_nt as $une_sn) {
			$tab_noms_id[] = $une_sn->getId('nom');
			$nom = array();
			$nom['id_nom'] = $une_sn->getId('nom');
			$nom['code_nn'] = 'nn'.$une_sn->getId('nom');
			$nom['code'] = $nom['code_nn'].'prv'.$une_sn->getId('version_projet_nom');
			$permalien_nn->setTypeId($une_sn->getId('nom'));
			$nom['url'] = $permalien_nn->getUrl();
			$nom['ce_statut'] = $une_sn->getCe('statut');
			$nom['code_num_1'] = $une_sn->getCodeNumerique1();
			$nom['code_num_2'] = $une_sn->getCodeNumerique2();
			$nom['code_alphanum_1'] = $une_sn->getCodeAlphanumerique1();
			$nom['code_alphanum_2'] = $une_sn->getCodeAlphanumerique2();
			$nom['commentaire_nomenclatural'] = $une_sn->getCommentaireNomenclatural();
			$nom['notes'] = $une_sn->getNotes();
			$tab_noms[$nom['id_nom']] = $nom;
		}

		// Récupération des infos sur chaque nom pour contstruire leur intitulé
		$tab_n = $dao_n->consulter(EF_CONSULTER_NOM_GROUPE_ID, array(implode(', ', $tab_noms_id), (int)$_SESSION['nvpn']));
		foreach($tab_n as $un_n) {
			$tab_noms[$un_n->getId('nom')]['nom'] = $un_n;//->formaterNom(EF_NOM_FORMAT_SIMPLE);
		}

		// Attribution des noms à différents tableaux en fonctio de leurs statuts
		foreach($tab_noms as $aso_nom) {
			//echo '<pre>'.print_r($aso_nom, true).'</pre>';
			switch ($aso_nom['ce_statut']) {
				case EF_SNS_NULL :
					$tab_retour['st_nr'][] = $aso_nom;
					break;
				case EF_SNS_INCONNU :
					$tab_retour['st_i'][] = $aso_nom;
					break;
				case EF_SNS_PROBLEME :
					$tab_retour['st_p'][] = $aso_nom;
					break;
				case EF_SNS_RETENU :
					$tab_retour['snr'][] = $aso_nom;
					break;
				case EF_SNS_SYNONYME_TAXONOMIQUE :
					$tab_retour['st'][] = $aso_nom; 
					break;
				case EF_SNS_SYNONYME_NOMENCLATURAL :
					$tab_retour['sn'][] = $aso_nom; 
					break;
				case EF_SNS_SYNONYME_INDETERMINE :
					$tab_retour['si'][] = $aso_nom; 
					break;
				case EF_SNS_INCLU_DANS :
					$tab_retour['sid'][] = $aso_nom; 
					break;
				case EF_SNS_AU_SENS_DE :
					$tab_retour['sasd'][] = $aso_nom; 
					break;
				case EF_SNS_SYNONYME_PROVISOIRE :
					$tab_retour['sp'][] = $aso_nom; 
					break;
			}
		}
		// Dans le cas, où seul le nom retenu est indiqué
		$tab_retour['info'] = '';
		if (count($tab_noms) == 1 && count($tab_retour['snr']) == 1) {
			$tab_retour['info'] = 'Aucune synonymie pour ce taxon dans ce référentiel';
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		return $tab_retour;
		
	}// Fin méthode executer()
	
}// Fin classe ActionSynonymie()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_synonymie.action.php,v $
* Revision 1.24  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.23  2007-01-24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.22  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.21.2.1  2006/09/04 14:21:36  jp_milcent
* Gestion des informations sur le taxon et le nom sélectionné dans l'onglet "Informations".
*
* Revision 1.21  2006/07/18 14:31:47  jp_milcent
* Correction de l'interface suite aux remarques de Daniel du 12 juillet 2006.
*
* Revision 1.20  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.19  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.18  2006/05/16 09:27:33  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.17  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.16  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
* Revision 1.15  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.13.2.2  2006/03/08 16:12:08  jp_milcent
* Ajout d'une nouvelle variable de session "nvpn" qui contient l'identifiant de la version du projet de nom du nom scientifique courrant.
*
* Revision 1.14  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.13.2.1  2006/03/07 10:29:02  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet.
* Mise en forme du code conformément à la charte de codage.
*
* Revision 1.13  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.12  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.11  2005/12/08 17:28:19  jp_milcent
* Amélioration de l'affichage et utilisation du formatage des noms latins.
*
* Revision 1.10  2005/12/06 18:02:12  jp_milcent
* Début du travail sur nouvelle interface synthèse.
*
* Revision 1.9  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.8  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.7  2005/10/21 16:28:54  jp_milcent
* Amélioration des onglets Synonymies et Synthèse.
*
* Revision 1.6  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.5  2005/10/13 16:25:05  jp_milcent
* Ajout de la classification à la synthèse.
*
* Revision 1.4  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.3  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
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