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
// CVS : $Id: effi_synthese.action.php,v 1.72 2007-07-24 12:25:00 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Synthèse
*
*
* Contient les infos pour l'onglet synthèse etc. et etc
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.72 $ $Date: 2007-07-24 12:25:00 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class ActionSynthese extends aAction implements iActionAvecCache {

	public function get_identifiant()
	{
		return 'fiche_synthese_nvpn'.$_SESSION['nvpn'].'_nn'.$_SESSION['nn'];
	}
	
	public function executer()
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$ancien_dsn = $GLOBALS['_EFLORE_']['dsn'];
		$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_PRINCIPAL;
		$rang_nom_selection = null;
		$tab_retour = array();
		$tab_retour['photoflora_bool'] = false;
		$dao_n = new NomDeprecieDao();
		//$dao_n->setDebogage(EF_DEBOG_SQL);
		$dao_sn = new SelectionNomDao;
		//$dao_sn->setDebogage(EF_DEBOG_SQL);
		$dao_prv = new ProjetVersionDao;
		//$dao_prv->setDebogage(EF_DEBOG_SQL);
		$dao_pr = new ProjetDao;
		//$dao_pr->setDebogage(EF_DEBOG_SQL);
		
		// +-----------------------------------------------------------------------------------------------------------+
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
		// Gestion des correspondances

		// Les infos sur les projets et version contenant le nom sélectionné
		$bdd = array(EF_BDD_NOM_PRINCIPALE, EF_BDD_NOM_HISTORIQUE);
		$tab_projets_total = array();
		foreach ($bdd as $nom_bdd) {
			$tab_projets_local = array();
			$dao_sn->setBddCourante($nom_bdd);
			$dao_n->setBddCourante($nom_bdd);
			$type = EF_CONSULTER_SN_NOM_ID;
			//Bidouille : pour chercher un nom dans la version 3.02 de la BDNFF présente dans la base historique
			$nom_prv_id = $_SESSION['nvpn'];
			if ($nom_bdd == EF_BDD_NOM_HISTORIQUE && 
				$_SESSION['nvpn'] == EF_PRV_DERNIERE_VERSION_BDNFF_ID && 
				$_SESSION['nn'] < $this->getRegistre()->get('nn_virtuel_depart')) {
				$nom_prv_id = 3;
			}
			//Bidouille : pour chercher un nom dans la version 0.00 de la BDNBE présente dans la base historique
			if ($nom_bdd == EF_BDD_NOM_HISTORIQUE && 
				$_SESSION['nvpn'] == 38 && 
				$_SESSION['nn'] < $this->getRegistre()->get('nn_virtuel_depart')) {
				$nom_prv_id = 26;
			}
			$param = array((int)$_SESSION['nn'], (int)$nom_prv_id);
			$tab_sn_principale = $dao_sn->consulter($type, $param);
			//echo '<pre>'.print_r($tab_sn_principale, true).'</pre>';
			foreach($tab_sn_principale as $une_sn) {
				//echo '<pre>'.print_r($une_sn->getId('id_version'), true).'</pre>';
				if (!isset($tab_projets_total[$une_sn->getId('version_projet_taxon')]) && $une_sn->getId('version_projet_taxon') != $_SESSION['nvp']) {
					$tab_projets_total[$une_sn->getId('version_projet_taxon')] = 1;
					$tab_projets_local[$une_sn->getId('version_projet_taxon')] = $une_sn;
				}
			}
			//echo '<pre>'.print_r($tab_projets, true).'</pre>';
			foreach($tab_projets_local as $id => $une_sn) {
				// Récupération des objets nécessaires
				$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_ID, (int)$id );
				$une_version = $tab_prv[0];
	
				$tab_pr = $dao_pr->consulter( EF_CONSULTER_PR_ID, (int)$une_version->getCe('projet') );
				$un_projet = $tab_pr[0];
	
				// Récupération des données nécessaires
				$aso_referentiel = array();
				$aso_referentiel['pr_id'] = $un_projet->getId('projet');
				$aso_referentiel['pr_intitule'] = $un_projet->getIntitule();
				$aso_referentiel['pr_abreviation'] = $un_projet->getAbreviation();
				$aso_referentiel['prv_code'] = $une_version->getCode();
				$aso_referentiel['taxon_id'] = $une_sn->getId('taxon');
				$aso_referentiel['taxon_prv_id'] = $une_sn->getId('version_projet_taxon');
				$aso_referentiel['nom_id'] = $une_sn->getId('nom');
				$aso_referentiel['nom_prv_id'] = $une_sn->getId('version_projet_nom');
				
				// Création de l'url
				$url_corres = clone $GLOBALS['_EFLORE_']['url_permalien'];
				$url_corres->setType('nn');
				$url_corres->setProjetCode($aso_referentiel['pr_abreviation']);
				$url_corres->setVersionCode($aso_referentiel['prv_code']);
				$url_corres->setTypeId($aso_referentiel['nom_id']);
				$aso_referentiel['url'] = $url_corres->getURL();
				
				// Si le nom sélectionné n'est pas le nom retenu nous le cherchons
				if ($une_sn->getCe('statut') != EF_SNS_RETENU) {
					$type = EF_CONSULTER_SN_VERSION_TAXON_ID_RETENU;
					$param = array((int)$aso_referentiel['taxon_id'], (int)$aso_referentiel['taxon_prv_id']);
					$tab_sn_corres = $dao_sn->consulter($type, $param);
					$aso_referentiel['nom_id'] = null;
					if (!empty($tab_sn_corres) && is_array($tab_sn_corres)) {
						$une_sn_corres = $tab_sn_corres[0];
						$aso_referentiel['nom_id'] = $une_sn_corres->getId('nom');
					} else {
						$message = "Le taxon ".$aso_referentiel['taxon_id']." du projet ".$aso_referentiel['taxon_prv_id']." n'a pas de nom retenu!";
						trigger_error($message, E_USER_NOTICE);
					}
				}
				// Nous récupérons les infos sur le nom	retenu s'il existe
				$aso_referentiel['nom'] = new NomDeprecie;
				$aso_referentiel['nom_nf'] = null;
				if (!is_null($aso_referentiel['nom_id'])) {		
					$type = EF_CONSULTER_NOM_ID;
					$param = array((int)$aso_referentiel['nom_id'], (int)$aso_referentiel['nom_prv_id']);
					$tab_n_corres = $dao_n->consulter($type, $param);
					$aso_referentiel['nom'] = $tab_n_corres[0];
					$aso_referentiel['nom_nf'] = $tab_n_corres[0]->formaterNom();
				}
				
				// Attribution des infos sur le référentiel à la liste des référentiels
				if (!($aso_referentiel['nom_prv_id'] == 3 && $aso_referentiel['nom']->getCe('rang') <= EF_RANG_GENRE_ID)) {
					// Si nous avons à faire à la version précédente de la BDNFF et que le nom est égal ou supérieur au 
					// genre nous n'affichons pas l'information. Car ces noms n'ont pas les mêmes numéros d'une version 
					// à l'autre.
					$tab_retour['referentiels'][] = $aso_referentiel;
				}		
			}
		}
			
		// +------------------------------------------------------------------------------------------------------+
		// Gestion de la base d'historique ou principale
		$GLOBALS['_EFLORE_']['dsn'] = $ancien_dsn;					

		$dao_n = new NomDeprecieDao();
		//$dao_n->setDebogage(EF_DEBOG_SQL);
		$dao_sn = new SelectionNomDao;
		//$dao_sn->setDebogage(EF_DEBOG_SQL);
		$dao_prv = new ProjetVersionDao;
		//$dao_prv->setDebogage(EF_DEBOG_SQL);
		$dao_pr = new ProjetDao;
		//$dao_pr->setDebogage(EF_DEBOG_SQL);
		$dao_va = new VernaculaireAttributionDao;
		//$dao_va->setDebogage(EF_DEBOG_SQL);
		$dao_v = new VernaculaireDao;
		//$dao_v->setDebogage(EF_DEBOG_SQL);
		$dao_lv = new LangueValeurDao;
		//$dao_lv->setDebogage(EF_DEBOG_SQL);
		$dao_tr = new TaxonRelationDao;
		//$dao_tr->setDebogage(EF_DEBOG_SQL);

		// +------------------------------------------------------------------------------------------------------+
		// Recherchons nous les images sur Photoflora?
		if ($_SESSION['nvp'] == EF_PRV_DERNIERE_VERSION_BDNFF_ID) {
			$tab_retour['photoflora_bool'] = true;
		}

		// +------------------------------------------------------------------------------------------------------+
		// Gestion du nt général et pour photoflora
		$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvp']));
		foreach($tab_sn as $une_sn) {
			if ($tab_retour['photoflora_bool']) {
				$un_sn = $tab_sn[0];
				$photoflora['nt'] = $un_sn->getId('taxon');
			}
			if ($une_sn->getId('version_projet_taxon') == $_SESSION['nvp']) {
				$_SESSION['nt'] = $une_sn->getId('taxon');
			}
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le nom selectionné
		$tab_retour['nn'] = $_SESSION['nn'];
		$param = array((int)$_SESSION['nn'], (int)$_SESSION['nvpn']);
		$tab_nom = $dao_n->consulter(EF_CONSULTER_NOM_ID, $param);
		$tab_retour['nom_selection'] = $tab_nom[0];
		$rang_nom_selection = $tab_nom[0]->getCe('rang');
		$tab_retour['nom_selection_nf'] = $tab_nom[0]->formaterNom();
		$tab_retour['nom_selection_ref_biblio'] = $tab_nom[0]->retournerBiblio();
		$tab_retour['nom_selection_annee'] = $tab_nom[0]->retournerAnnee();
		$tab_retour['nom_selection_auteur_principal'] = $tab_nom[0]->retournerAuteurPrincipal();
		$tab_retour['nom_selection_nn'] = $_SESSION['nn'];
		$tab_retour['nom_selection_code_nn'] = $_SESSION['cpr'].$_SESSION['nn'];
		$tab_retour['nom_selection_nt'] = $_SESSION['nt'];
		$tab_retour['nom_selection_code_nt'] = $_SESSION['cpr'].$_SESSION['nt'];

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des données sur les noms du taxon sélectionné
		$tab_sn_nt = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID, array((int)$_SESSION['nt'], (int)$_SESSION['nvp']));
		foreach($tab_sn_nt as $une_sn) {
			if ($une_sn->getId('version_projet_taxon') == $_SESSION['nvp']) {
				if ($une_sn->getCe('statut') == EF_SNS_RETENU) {
					$ma_sn_retenu = clone $une_sn;
				}
			}
		}

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le nom retenu
		$tab_retour['nt'] = $_SESSION['nt'];
		$tab_retour['nvp'] = $_SESSION['nvp'];
		$tab_retour['code_taxonomique'] = 	'nt'.$_SESSION['nt'].'-'.$tab_retour['pr_abreviation'].'-v'.$tab_retour['prv_code'];

		$tab_retour['nom_retenu_nn'] = $ma_sn_retenu->getId('nom');
		$tab_retour['nom_retenu_code_nn'] = 'nn'.$ma_sn_retenu->getId('nom');
		$tab_retour['nom_retenu_nt'] = $ma_sn_retenu->getId('taxon');
		$tab_retour['nom_retenu_code_nt'] = 'nt'.$ma_sn_retenu->getId('taxon');
		$tab_nom_retenu = $dao_n->consulter(EF_CONSULTER_NOM_ID, array((int)$tab_retour['nom_retenu_nn'], (int)$_SESSION['nvpn']));
		$le_nom_retenu = $tab_nom_retenu[0];
		$tab_retour['nom_retenu'] = $le_nom_retenu;
		$tab_retour['nom_retenu_nf'] = $le_nom_retenu->formaterNom();
		$tab_retour['nom_retenu_ref_biblio'] = $le_nom_retenu->retournerBiblio();
		$tab_retour['nom_retenu_annee'] = $le_nom_retenu->retournerAnnee();
		$tab_retour['nom_retenu_auteur_principal'] = $le_nom_retenu->retournerAuteurPrincipal();

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur les noms vernaculaires
		$tab_retour['noms_verna_bool'] = false;
		$tab_va = $dao_va->consulter(EF_CONSULTER_VA_VERSION_TAXON_ID, array((int)$_SESSION['nt'], (int)$_SESSION['nvp']));
		$tab_noms_verna_id = array();
		$aso_nva = array();
		$aso_noms_verna = array();
		foreach($tab_va as $une_va) {
			if ($une_va->getCe('emploi') == EF_VERNA_EMPLOI_RECOMMANDE_ID) {
				$id = $une_va->getId('nom_vernaculaire');
				$id_projet = $une_va->getId('version_projet_nom_verna');
				$aso_noms_verna[$id_projet][$id] = $id;
			}
		}
		
		// Récupération des noms vernaculaire du taxon affiché
		if (count($aso_noms_verna) > 0) {
			foreach($aso_noms_verna as $id_projet_nva => $aso_nva) {
				$tab_retour['noms_verna_bool'] = true;
				$tab_v = $dao_v->consulter( EF_CONSULTER_V_GROUPE_ID, array(implode(', ', array_keys($aso_nva)), (int)$id_projet_nva));
				$tab_noms_verna = array();
				foreach($tab_v as $un_v) {
					// Nous recherchons uniquement les noms vernaculaires français
					if (	($un_v->getCe('langue') == EF_LG_ISO_639_1_FR_ID && 
							$un_v->getCe('version_projet_langue') == EF_LG_ISO_639_1_VERSION_ID)
							|| 
							($un_v->getCe('langue') == EF_LG_ISO_639_2B_FR_ID && 
							$un_v->getCe('version_projet_langue') == EF_LG_ISO_639_2B_VERSION_ID)
							|| 
							($un_v->getCe('langue') == EF_LG_ISO_639_2T_FR_ID && 
							$un_v->getCe('version_projet_langue') == EF_LG_ISO_639_2T_VERSION_ID)
							) {
						// Récupération des infos générales sur le nom verna
						$id = $un_v->getId('nom_vernaculaire');
						$tab_retour['noms_verna'][] = $un_v->getIntitule();
					}
				}
			}
		} else {
			$tab_retour['noms_verna_info'] = 'Aucun nom commun pour ce taxon dans ce référentiel !';
		}
		$tab_retour['noms_verna_intitule'] = array('intitule', 'genre_nbre', 'zg_intitule', 'notes');

		// +------------------------------------------------------------------------------------------------------+
		// Constitution de l'url des permaliens
		$tab_retour['permalien_nn_bool'] = false;
		$tab_retour['permalien_nn_info'] = 'Ce nom est généré dynamiquement et n\'est pas géré par ce référentiel !';
		$tab_retour['permalien_nt_bool'] = false;
		$tab_retour['permalien_nt_info'] = 'Ce taxon est généré dynamiquement et n\'est pas géré par ce référentiel !';

		// Nom sélectionné
		$permalien_nn = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$permalien_nn->setType('nn');
		$permalien_nn->setProjetCode($tab_retour['pr_abreviation']);
		$permalien_nn->setVersionCode($tab_retour['prv_code']);
		$permalien_nn->setTypeId($_SESSION['nn']);
		$permalien_nn->setPage(EF_LG_URL_ACTION_SYNTHESE);

		// Permalien de la page courrante pour les "noms correspondant"
		$tab_retour['url_page_courante'] = $permalien_nn->getUrl();
		$tab_retour['url_permalien_nom_selection'] = $tab_retour['url_page_courante'];
		
		// Gestion des noms virtuels et des permaliens.
		if (!$this->getRegistre()->get('nn_virtuel_depart') || $_SESSION['nn'] < $this->getRegistre()->get('nn_virtuel_depart')) {
			$tab_retour['permalien_nn_bool'] = true;
			if (EF_PRV_DERNIERE_VERSION_BDNFF_ID == $_SESSION['nvpn']) {
				$tab_retour['url_permalien_nn'] = $permalien_nn->getUrlReferentielDefaut();
			} else {
				$tab_retour['url_permalien_nn'] = $permalien_nn->getUrl();
			}
		}
		
		// Permalien de la page courrante pour le "nom retenu"
		$permalien_nt = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$permalien_nt->setType('nt');
		$permalien_nt->setProjetCode($tab_retour['pr_abreviation']);
		$permalien_nt->setVersionCode($tab_retour['prv_code']);
		$permalien_nt->setTypeId($_SESSION['nt']);
		$permalien_nt->setPage(EF_LG_URL_ACTION_SYNTHESE);
		$tab_retour['url_permalien_nom_retenu'] = $permalien_nt->getUrl();
		$permalien_nt->setPage('');
		// Taxon
		if (!$this->getRegistre()->get('nt_virtuel_depart') || $_SESSION['nt'] < $this->getRegistre()->get('nt_virtuel_depart')) {
			$tab_retour['permalien_nt_bool'] = true;
			
			if (EF_PRV_DERNIERE_VERSION_BDNFF_ID == $_SESSION['nvp']) {
				$tab_retour['url_permalien_nt'] = $permalien_nt->getUrlReferentielDefaut();
			} else {
				$tab_retour['url_permalien_nt'] = $permalien_nt->getUrl();
			}
		}
						
		// +-----------------------------------------------------------------------------------------------------------+
		// Constitution de l'url de l'export au format PDF
		$permalien_export_pdf = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$permalien_export_pdf->setType('nn');
		$permalien_export_pdf->setProjetCode($tab_retour['pr_abreviation']);
		$permalien_export_pdf->setVersionCode($tab_retour['prv_code']);
		$permalien_export_pdf->setTypeId($_SESSION['nn']);
		$permalien_export_pdf->setPage(EF_LG_URL_ACTION_EXPORT);
		$permalien_export_pdf->setFormat(EF_LG_URL_FORMAT_PDF);
		$tab_retour['url_export_pdf'] = $permalien_export_pdf->getUrl();

		// +------------------------------------------------------------------------------------------------------+
		// Photoflora
		if ($tab_retour['photoflora_bool']) {
			$tab_retour['photoflora_url'] = sprintf(EF_URL_PHOTOFLORA_TAXON, $_SESSION['nt']);
			$Illustrations = new EfloreIllustration('photoflora', $_SESSION['cpr'], $_SESSION['cprv'], 'nt', $_SESSION['nt']);
			$projet_photo = 'photoflora';
			$tab_retour[$projet_photo] = $Illustrations->chercherIllustrationsServiceXml(sprintf(EF_URL_PHOTOFLORA_SERVICE, $_SESSION['nt']));
			foreach ($tab_retour[$projet_photo] as $cle => $illustration) {
				if (preg_match(EF_URL_PHOTOFLORA_REGEXP, $illustration['about'], $match)) {
					$abreviation = $match[1];
					$fichier = $match[2];
					$tab_retour[$projet_photo] = '';
					$tab_retour[$projet_photo][$cle]['url_normale'] = sprintf(EF_URL_PHOTOFLORA_IMG_MAX, $abreviation, $fichier);
			      	$tab_retour[$projet_photo][$cle]['url_miniature'] = sprintf(EF_URL_PHOTOFLORA_IMG_MIN, $abreviation, $fichier);;
					// La variable "fichier_local" est utilisée pour l'export!
			      	$tab_retour[$projet_photo][$cle]['fichier_local'] = EF_CHEMIN_IMG_STOCKAGE.$projet_photo.DIRECTORY_SEPARATOR.$fichier;
					if (EF_BOOL_STOCKAGE_IMG) {
						$fichier_local = $tab_retour[$projet_photo][$cle]['fichier_local'];
						if (!file_exists($fichier_local)) {
							if ($img = file_get_contents($tab_retour['photoflora'][$cle]['url_miniature'])) {
								if (!$resource = fopen($fichier_local, 'a')) {
			         				trigger_error("Impossible d'ouvrir le fichier ($fichier_local)", E_USER_ERROR);
			   					} else {
									if (fwrite($resource, $img) === FALSE) {
			       						trigger_error("Impossible d'écrire dans le fichier ($fichier_local)", E_USER_ERROR);
									} else {
										$tab_retour[$projet_photo][$cle]['url_miniature'] = sprintf(EF_URL_IMG, $projet_photo.'/'.$fichier);
									}
								}
							}
						}
						
					}
					// Priorite aux images en png
					if (strstr($fichier, '.png')) {
						break;
					}
					$tab_retour['photoflora_bool'] = true;
				} else {
					$e = "L'url de photoflora a changée, modifié la configuration!";
					trigger_error($e, E_USER_WARNING);
				}
			}
		}

		// +------------------------------------------------------------------------------------------------------+
		// Chorologie : mini carte
		$une_action = new ActionChorologie($this->getRegistre());
		switch ($_SESSION['nvp']) {
			case 26 :
			case 38 :
				$param = array('carte' => 'europe_reduite.png', 'carte_masque' => 'europe_masque_reduite.png');
				break;
			case 29 :
				$param = array('carte' => 'mascareignes_reduite.png', 'carte_masque' => 'mascareignes_masque_reduite.png');
				break;
			case 32 :
				$param = array('carte' => 'afrique_reduite.png', 'carte_masque' => 'afrique_masque_reduite.png');
				break;
			default:
				$param = array('carte' => 'france_reduite.png', 'carte_masque' => 'france_masque_reduite.png');
		}
		$tab_donnee_choro = $une_action->executer($param);
		$tab_retour = array_merge($tab_retour, $tab_donnee_choro);
		
	    // Chorologie : url carte
		$chorologie_url = clone $GLOBALS['_EFLORE_']['url_permalien'];
		$chorologie_url->setType('nn');
		$chorologie_url->setProjetCode($tab_retour['pr_abreviation']);
		$chorologie_url->setVersionCode($tab_retour['prv_code']);
		$chorologie_url->setTypeId($_SESSION['nn']);
		$chorologie_url->setPage('chorologie');
		$tab_retour['url_carte'] = $chorologie_url->getUrl();
		

		// +------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur la classification
		$tab_retour['classification'] = $_SESSION['classification'];
		$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille'];
		
		// +------------------------------------------------------------------------------------------------------+
		// Base de connaissance XPER
		$tab_retour['xper_bool'] = false;
		if ($this->getRegistre()->get('projet_xper')) {
			$tab_retour['xper_bool'] = true;
			if (count($_SESSION['classification']) > 0) {
				foreach ($_SESSION['classification'] as $classif_taxon) {
					if ($classif_taxon['nt'] != '') {
						$aso_xper_nt[] = $classif_taxon['nt'];
						$aso_xper_abrev[$classif_taxon['nt']] = $classif_taxon['abreviation'];
					}	
				}
				$dao_tat = new TaxonATxtDao();
				//$dao_tat->setDebogage(EF_DEBOG_SQL);
				$dao_it = new InfoTxtDao();
				//$dao_it->setDebogage(EF_DEBOG_SQL);			
				$type = EF_CONSULTER_TAXON_A_TXT_VERSION_GROUPE_ID;
				$param = array(implode(', ', $aso_xper_nt), (int)$_SESSION['nvp']);
				$tab_tat = $dao_tat->consulter( $type, $param );
				//echo '<pre>'.print_r($tab_tat, true).'</pre>';
				foreach ($tab_tat as $TaxonATxt) {
					if ($TaxonATxt->getId('version_projet_txt') == EF_PRV_INFO_TXT_XPER_ID) {
						$type = EF_CONSULTER_INFO_TXT_VERSION_ID;
						$param = array((int)$TaxonATxt->getId('texte'), (int)$TaxonATxt->getId('version_projet_txt'));
						$tab_it = $dao_it->consulter( $type, $param );
						//echo '<pre>'.print_r($tab_it, true).'</pre>';
						foreach ($tab_it as $InfoTxt) {
							$base_xper = array();
							$base_xper['titre'] = $InfoTxt->getTitre();
							$base_xper['nom'] = preg_replace('/\.xpd$/', '', $InfoTxt->getNomFichier());
							$base_xper['url'] = sprintf(EF_URL_XPER_APPLETTE, $base_xper['nom']);
							$base_xper['rang'] = $aso_xper_abrev[$TaxonATxt->getId('taxon')]['abreviation'];
							$tab_retour['xper_bases'][] = $base_xper;
						}
					}
				}
			}
		}
		
		// +------------------------------------------------------------------------------------------------------+
		// Envoie des données
		//echo '<pre>'.print_r($tab_retour, true).'</pre>';
		return $tab_retour;

	}// Fin méthode executer()

}// Fin classe ActionSynthese()


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_synthese.action.php,v $
* Revision 1.72  2007-07-24 12:25:00  jp_milcent
* Fusion depuis Moquin-Tandon.
* Correction d'orthographe.
*
* Revision 1.71  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.70  2007-06-11 16:34:46  jp_milcent
* Correction problème des permaliens.
*
* Revision 1.62.2.3  2007-06-11 16:30:23  jp_milcent
* Ajout de permaliens spécifiques aux noms retenu et sélectionné.
*
* Revision 1.69  2007-06-11 12:46:27  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.62.2.2  2007-06-11 09:01:08  jp_milcent
* Correction bogue : problème d'url pour les noms des correspondances.
*
* Revision 1.68  2007-06-11 09:04:09  jp_milcent
* Fusion avec la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.67  2007-02-09 16:54:36  jp_milcent
* Nouveau module Zone Géo basé sur la version 1.2.
*
* Revision 1.66  2007/02/07 18:08:13  jp_milcent
* Nous n'affichons plus les correspondances pour les noms virtuels.
*
* Revision 1.65  2007/02/07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.64  2007/01/24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.63  2007/01/24 17:03:58  jp_milcent
* Ajout de la BDNBE v1.00
*
* Revision 1.62.2.1  2007/02/07 10:45:45  jp_milcent
* Suppression des messages d'erreurs dû à des variables indéfinies.
*
* Revision 1.62  2007/01/17 18:22:34  jp_milcent
* Correction bogue : confusion entre les différents projets de noms verna.
*
* Revision 1.61  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.60  2007/01/17 17:03:51  jp_milcent
* Modification de la gestion des noms et taxons virtuels des projets.
*
* Revision 1.59  2007/01/15 14:37:36  jp_milcent
* Fusion de la carto : Afrique du Nord.
*
* Revision 1.58  2007/01/15 11:46:59  ddelon
* Carto afrique
*
* Revision 1.57  2007/01/12 16:18:40  jp_milcent
* Correction bogue : mauvaise manip pendant fusion
*
* Revision 1.56  2007/01/12 15:22:15  jp_milcent
* Correction bogue : les permaliens étaient affichées sous forme courte pour les projets autres que BDNFF.
*
* Revision 1.55  2007/01/12 15:19:28  jp_milcent
* Fusion avec la branche passy.
*
* Revision 1.54  2006/12/22 16:51:19  jp_milcent
* Amélioration de la gestion des permaliens : nous tenons comptes des taxons non géré par les référentiels.
* Correction bogue : erreur sql liée à xper.
*
* Revision 1.53.2.3  2007/01/12 21:49:06  ddelon
* Carto afrique
*
* Revision 1.53.2.2  2006/11/21 09:47:05  jp_milcent
* Correction du problème des liens des noms correspondant.
*
* Revision 1.53.2.1  2006/11/20 13:42:57  jp_milcent
* Correction erreur génération image png pour le pdf.
*
* Revision 1.53  2006/11/15 11:35:15  jp_milcent
* Correction de la gestion de l'image vis à vis du nouveau service xml.
*
* Revision 1.52  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.51.2.4  2006/09/06 11:15:19  jp_milcent
* Ajout d'une constante pour l'id de la version du projet Xper.
*
* Revision 1.51.2.3  2006/08/29 09:24:21  jp_milcent
* Correction bogue et ajout d'un message (notice) si un nom synonyme ne possède pas de nom retenu. Initialisation de variables.
*
* Revision 1.51.2.2  2006/07/28 14:06:15  jp_milcent
* Correction bogue lien pdf érroné pour les projets autre que BDNFF.
*
* Revision 1.51.2.1  2006/07/27 12:26:54  jp_milcent
* Gestion de la classification et des noms de famille dans le fichier principal.
*
* Revision 1.51  2006/07/24 13:42:58  jp_milcent
* Modification intitulé du nom de la base de connaissance.
*
* Revision 1.50  2006/07/20 12:04:31  jp_milcent
* Ajout des noms avec l'auteur.
*
* Revision 1.49  2006/07/18 14:31:47  jp_milcent
* Correction de l'interface suite aux remarques de Daniel du 12 juillet 2006.
*
* Revision 1.48  2006/07/11 16:19:19  jp_milcent
* Intégration de l'appllette Xper.
*
* Revision 1.47  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.46  2006/06/20 16:28:21  jp_milcent
* Amélioration export.
* Meilleure gestion des images png à modifier.
*
* Revision 1.45  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.44  2006/05/19 12:04:18  jp_milcent
* Exclusion des noms supérieur à l'espèce de la BDNFF v3.02 pour les correspondances de noms retenus.
*
* Revision 1.43  2006/05/16 14:01:41  jp_milcent
* Gestion du cache pour l'export pdf et la fiche synthèse.
*
* Revision 1.42  2006/05/16 09:27:34  jp_milcent
* Gestion des correspondances.
* Ajout du plier/deplier.
*
* Revision 1.41  2006/05/11 13:02:12  jp_milcent
* Correction sur la gestion des photos de Photoflora.
*
* Revision 1.40  2006/05/11 12:55:07  jp_milcent
* Correction sur la gestion des photos de Photoflora.
*
* Revision 1.39  2006/05/11 10:28:26  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.38  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.37  2006/04/14 12:07:58  jp_milcent
* Modification pour gérer la chorologie de la BDNBE.
*
* Revision 1.34.2.5  2006/04/14 11:56:39  jp_milcent
* Modification pour gérer la chorologie de la BDNBE.
*
* Revision 1.36  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.34.2.4  2006/03/10 14:59:50  jp_milcent
* Suppression de l'affichage de "Famille ?" pour les noms de rang supérieurs ou égal à la famille.
*
* Revision 1.34.2.3  2006/03/08 17:19:07  jp_milcent
* Amélioration de la gestion de la configuration du moteur de recherche.
* Gestion du projet par défaut et de la version par défaut dans le fichier de config et les arguments de Papyrus.
*
* Revision 1.34.2.2  2006/03/08 16:12:08  jp_milcent
* Ajout d'une nouvelle variable de session "nvpn" qui contient l'identifiant de la version du projet de nom du nom scientifique courrant.
*
* Revision 1.35  2006/03/07 11:07:08  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnbe_v1.
*
* Revision 1.34.2.1  2006/03/07 10:29:02  jp_milcent
* Correction des requêtes SQL : ajout de l'identifiant de la version du projet.
* Mise en forme du code conformément à la charte de codage.
*
* Revision 1.34  2006/03/06 11:57:09  ddelon
* Reintegration correction bugs de la livraison bdnffV3_v4
*
* Revision 1.33  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.32  2006/01/23 20:46:32  ddelon
* affichage langues disponibles
*
* Revision 1.31  2005/12/27 15:06:13  ddelon
* Image Costes en premier
*
* Revision 1.30  2005/12/21 17:15:33  jp_milcent
* Fusion avec les corrections de la branche livraison_bdnff_v3_v4.
*
* Revision 1.29.2.2  2005/12/20 15:55:16  jp_milcent
* Correction bogue : erreur nom de variable.
*
* Revision 1.29.2.1  2005/12/20 15:51:04  jp_milcent
* Correction bogue  : la sélection du nt ne doit pas se faire sur la requete union mais dans la base de données correspondant à la version.
*
* Revision 1.29  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.28  2005/12/09 17:26:51  jp_milcent
* Suppression d'une fonction inutile sur le DOM pour Photoflora.
*
* Revision 1.27  2005/12/08 17:28:19  jp_milcent
* Amélioration de l'affichage et utilisation du formatage des noms latins.
*
* Revision 1.26  2005/12/08 15:03:35  jp_milcent
* Amélioration de l'affichage. Changements cosmétiques.
*
* Revision 1.25  2005/12/06 18:02:12  jp_milcent
* Début du travail sur nouvelle interface synthèse.
*
* Revision 1.24  2005/12/05 15:37:05  jp_milcent
* Correction d'une boucle infini si le taxon ne possède pas de relation hiérarchique.
*
* Revision 1.23  2005/11/25 19:52:04  ddelon
* Amelioration affichage interface
*
* Revision 1.22  2005/11/25 14:11:41  jp_milcent
* Tentative de correction d'un bogue lié à la ligne 302.
*
* Revision 1.21  2005/11/24 16:23:26  jp_milcent
* Correction des permaliens suite à discussion.
*
* Revision 1.20  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.19  2005/10/27 12:11:16  ddelon
* test cvs
*
* Revision 1.18  2005/10/27 12:07:32  jp_milcent
* Ajout de lien sur la classification.
*
* Revision 1.17  2005/10/27 11:59:33  ddelon
* test cvs
*
* Revision 1.16  2005/10/26 16:36:25  jp_milcent
* Amélioration des pages Synthèses, Synonymie et Illustrations.
*
* Revision 1.15  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.14  2005/10/21 16:28:54  jp_milcent
* Amélioration des onglets Synonymies et Synthèse.
*
* Revision 1.13  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.12  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.11  2005/10/18 17:17:20  jp_milcent
* Début de la gestion des url d'eFlore.
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
* Revision 1.7  2005/10/05 16:36:35  jp_milcent
* Débu et fin gestion de l'onglet Illustration.
* Amélioration de l'onglet Synthèse avec ajout d'une image.
*
* Revision 1.6  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
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