<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-recherche.                                                               |
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
// CVS : $Id: efre_recherche_taxon.action.php,v 1.25 2007-06-19 10:32:57 jp_milcent Exp $
/**
* eFlore
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
*@version       $Revision: 1.25 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Inclusion des classes nécessaires
include_once EFRE_CHEMIN_ACTION.'efre_form_taxon.action.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class ActionRechercheTaxon extends aAction {

	public function executer()
	{
		// +-------------------------------------------------------------------------------------------------------------+
		// Aiguillage sur la base de données principale ou historique
		$dao_version = new ProjetVersionDao();
		//$dao_version->setDebogage(EF_DEBOG_SQL);
		if (!empty($GLOBALS['eflore_referenciel'])) {
			$tab_versions = $dao_version->consulter( EF_CONSULTER_PRV_ID, array((int)$GLOBALS['eflore_referenciel']));
			if (isset($tab_versions[0]) && !$tab_versions[0]->verifierDerniereVersion()) {
				$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_HISTORIQUE;
			}
		}
		
		// Initialisation des variables
		$tab_retour = array();
		// Initialisation des DAO après l'aiguillage de la base de données
		$dao_taxon = new TaxonDao();
		//$dao_taxon->setDebogage(EF_DEBOG_SQL);
		$dao_nom = new NomDeprecieDao();
		//$dao_nom->setDebogage(EF_DEBOG_SQL);

		// +-------------------------------------------------------------------------------------------------------------+		
		// Ajout du titre provenant du fichier de config
		$tab_retour['titre_general'] = $GLOBALS['_EFLORE_']['titre'];
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		
		// +-------------------------------------------------------------------------------------------------------------+
		// Ajout du paramêtre action à l'url courante.
		$tab_retour['url_classif'] = clone $GLOBALS['_EFLORE_']['url_base'];
		$tab_retour['url_classif']->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_RECHERCHE);
		$tab_retour['url_classif']->addQueryString(EF_LG_URL_ACTION, EF_LG_URL_ACTION_RECH_TAX);
		$tab_retour['url_fiche'] = clone $GLOBALS['_EFLORE_']['url_base'];
		$tab_retour['url_fiche']->addQueryString(EF_LG_URL_MODULE, EF_LG_URL_MODULE_FICHE);
		$tab_retour['url_fiche']->addQueryString(EF_LG_URL_ACTION, EF_LG_URL_ACTION_SYNTHESE);
		
		// +-------------------------------------------------------------------------------------------------------------+
		// Récupération des données
		// Gestion de la liste alphabétique des noms de taxon
		$alphabet_nom = 'alphabet_'.$GLOBALS['eflore_rang'].'_'.$GLOBALS['eflore_referenciel'];
		//echo $alphabet_nom;
		//echo '<pre>'.print_r($_SESSION[$alphabet_nom], true).'</pre>';
		
		if (!isset($_SESSION[$alphabet_nom]) || is_null($_SESSION[$alphabet_nom])) {
			// Initialisation des variables.
			$GLOBALS['eflore_lettre'] = null;
			$_SESSION['taxons'] = array();
			$_SESSION['taxons_nbre'] = 0;
			
			$type = EF_CONSULTER_TAXON_VERSION_RANG;
			$param = array($GLOBALS['eflore_rang'], (int)$GLOBALS['eflore_referenciel']);
			$tab_version_taxons = $dao_taxon->consulter($type, $param);

			if (count($tab_version_taxons) > 0) {
				$tab_taxons_nom_retenu_id = array();
				foreach ($tab_version_taxons as $taxon) {
					$tab_taxons_nom_retenu_id[] = $taxon->getIdNomRetenu();
				}
				$type = EF_CONSULTER_NOM_GROUPE_ID;
				$param = array(implode(', ', $tab_taxons_nom_retenu_id), (int)$GLOBALS['eflore_referenciel']);
				$tab_noms = $dao_nom->consulter($type, $param);
				sort($tab_noms);
				$_SESSION[$alphabet_nom] = array();
				foreach ($tab_noms as $nom) {
					$lettre = substr($nom->formaterNom(), 0, 1);
					if (is_string($lettre)) {
						if ($lettre != false && !array_key_exists($lettre, $_SESSION[$alphabet_nom])) {
							$_SESSION[$alphabet_nom][$lettre] = 1;
						} else {
							$_SESSION[$alphabet_nom][$lettre]++;
						}
					} else {
						$e = 	"Le nom ".$nom->getId('nom')." a un problème d'intitulé :".$nom->formaterNom().
								"La note du nom est : ".$nom->getNotes();
						trigger_error($e, E_USER_WARNING);
					}
				}
			} else {
				$_SESSION[$alphabet_nom] = null;
			}
		}
		
		// Si nous avons pu créer une liste alphabétique nous poursuivons en recherchant les taxons à afficher
		if (!is_null($_SESSION[$alphabet_nom])) {
			// Initialisation des variables.
			$nt = 0;
			// +----------------------------------------------------------------------------------------------------------+
			// Mesure du temps d'éxecution : taxons ouverts
			$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_debut' => microtime()));
			
			// Attribution de la lettre à rechercher 
			if (!isset($GLOBALS['eflore_lettre']) || is_null($GLOBALS['eflore_lettre'])) {
				reset($_SESSION[$alphabet_nom]);
				ksort($_SESSION[$alphabet_nom]);
				$GLOBALS['eflore_lettre'] = key($_SESSION[$alphabet_nom]);
			}
			
			if (isset($_GET['nt'])) {
				// L'utilisateur déploie la classification pour un taxon donné (= $nt)
				$nt = (int)$_GET['nt'];

				// Récupération des fils du taxon ouvert courant
				$param = array($GLOBALS['eflore_referenciel'], (int)$nt);
				//$dao_taxon->setDebogage(EF_DEBOG_SQL);
				$tab_taxons = $dao_taxon->consulter(EF_CONSULTER_TAXON_CLASSIF_FILS, $param);
				//echo '<pre>'.print_r($nt, true).'</pre>';
				
				// Récupération d'info sur le taxons père du taxon ouvert courant
				$tab_taxon_mere_info = array();
				$tab_taxon_mere_info = $this->consulterInfo( $_SESSION['taxons'], (int)$nt );
				//echo '<pre>'.print_r($tab_taxon_mere_info, true).'</pre>';
				if (!is_null($tab_taxon_mere_info)) {
					$nn = $tab_taxon_mere_info['id_nom_retenu'];
				} else {
					trigger_error('Numéro nomenclatural du père inconnu!', E_USER_NOTICE);
				}
			} else {
				// Initialisation des variables pour le premier accès pour une lettre donnée
				$_SESSION['taxons'] = array();
				$_SESSION['taxons_nbre'] = 0;
				$_SESSION['nt_liste'] = null;
				$nn = 'depart';
								
				//$dao_taxon->setDebogage(EF_DEBOG_SQL);
				if ($GLOBALS['eflore_rang'] == EF_RANG_FAMILLE_ID) {
					$param = array($GLOBALS['eflore_lettre'].'%', (int)EF_RANG_FAMILLE_ID, (int)$GLOBALS['eflore_referenciel']);
					$tab_taxons = $dao_taxon->consulter(EF_CONSULTER_TAXON_LETTRE_SUPRAGENRE, $param);
				} else {
					$param = array($GLOBALS['eflore_lettre'].'%', (int)EF_RANG_GENRE_ID, (int)$GLOBALS['eflore_referenciel']);
					$tab_taxons = $dao_taxon->consulter(EF_CONSULTER_TAXON_LETTRE_GENRE, $param);
				}
			}
			
			// +----------------------------------------------------------------------------------------------------------+
			// Mesure du temps d'éxecution : taxons ouverts
			$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_ouverts' => microtime()));
			//echo '<pre>'.print_r($_SESSION['nt_liste'], true).'</pre>';
			// Création ou supression de la liste des taxons ouverts
			if ( isset($_GET['plier']) && $_GET['plier'] == 1 ) {
				//	Suppression
				//echo 'ici'.$nt;
				$nbre_taxons = $GLOBALS['nt_liste'][$nt];
				$_SESSION['taxons'] = $this->supprimerInfo($_SESSION['taxons'], (int)$nt);
				$_SESSION['taxons_nbre'] -= $nbre_taxons;
				unset($_SESSION['nt_liste'][$nt]);
			} else if ( !isset($_SESSION['nt_liste'][$nt]) ) {
				// Création
				$nbre_taxons = count($tab_taxons);
				$_SESSION['nt_liste'][$nt] = $nbre_taxons;
				// Cumul du nombre de taxon affiché
				$_SESSION['taxons_nbre'] += $nbre_taxons;		
				
				if ( isset($_SESSION['nt_liste'][$nt]) && $_SESSION['nt_liste'][$nt] > 0 ) {
					// Attribution de la lettre courrante
					$tab_retour['lettre'] =& $GLOBALS['eflore_lettre'].'%';
					
					// Tri et attribution de l'alphabet de recherche courant
					ksort($_SESSION[$alphabet_nom]);
					$tab_retour['alphabet'] =& $_SESSION[$alphabet_nom];
					
					// Récupération des infos sur les taxons trouvés
					$tab_taxons_nom_retenu_id = array();
					$tab_taxons_id = array();
					$tab_taxons_complet = array();
					$rang_courant_id = 0;
					foreach ($tab_taxons as $un_taxon) {
						$tab_taxon = array();
						
						$tab_taxons_nom_retenu_id[] = $un_taxon->getIdNomRetenu();
						$tab_taxons_id[] = $un_taxon->getId('taxon');
						
						$tab_taxon['id'] = $un_taxon->getId('taxon');
						$tab_taxon['id_nom_retenu'] = $un_taxon->getIdNomRetenu();
						$tab_taxon['id_rang'] = $un_taxon->getIdRang();
						$rang_courant_id = $tab_taxon['id_rang'];
						// Url pour se rendre à la fiche
						$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NVP, $un_taxon->getId('version_projet_taxon'));
						$tab_retour['url_fiche']->addQueryString(EF_LG_URL_NN, $un_taxon->getIdNomRetenu());
						$tab_taxon['url_fiche'] = $tab_retour['url_fiche']->getURL();
						// Url pour naviguer dans la classif
						$tab_retour['url_classif']->addQueryString(EF_LG_URL_NVP, $GLOBALS['eflore_referenciel']);
						$tab_retour['url_classif']->addQueryString(EF_LG_URL_RG, $GLOBALS['eflore_rang']);
						$tab_retour['url_classif']->addQueryString(EF_LG_URL_LE, $GLOBALS['eflore_lettre']);
						$tab_retour['url_classif']->addQueryString(EF_LG_URL_NT, $un_taxon->getId('taxon'));
						$tab_taxon['url_classif'] = $tab_retour['url_classif']->getURL();
						if ( $tab_taxon['id_rang'] < 250 ) {
							$tab_taxon['fils_nbre'] = 1;
						} else {
							$tab_taxon['fils_nbre'] = 0;
						}
						$tab_taxon['nom'] = '';
						$tab_taxons_complet[$un_taxon->getIdNomRetenu()] = $tab_taxon; 
					}
					
					// +----------------------------------------------------------------------------------------------------+
					// Mesure du temps d'éxecution : taxons nbre fils
					$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_nbre_fils' => microtime()));
					if ( $rang_courant_id >= 250 ) {
						// Récupération du nombre de fils
						$param = array( (int)$GLOBALS['eflore_referenciel'], implode(', ', $tab_taxons_id) );
						// +-------------------------------------------------------------------------------------------------+
						// Mesure du temps d'éxecution : 
						$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_nbre_fils_rqute_deb' => microtime()));
						$tab_taxons_fils = $dao_taxon->consulter(EF_CONSULTER_TAXON_CLASSIF_FILS_NBRE_GROUPE_ID, $param);
						// +-------------------------------------------------------------------------------------------------+
						// Mesure du temps d'éxecution : 
						$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_nbre_fils_rqute_fin' => microtime()));
						
						// Attribution du nombre de fils aux tableaux des taxons
						foreach ($tab_taxons_fils as $un_taxon_fils) {
							//echo '<pre>'.print_r($un_taxon_fils, true).'</pre>';
							if (isset($un_taxon_fils->nbre)) {
								$tab_taxons_complet[$un_taxon_fils->getIdNomRetenu()]['fils_nbre'] = $un_taxon_fils->nbre;
							}					
						}
					}
					
					// +----------------------------------------------------------------------------------------------------+
					// Mesure du temps d'éxecution : taxons nom
					$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_nom' => microtime()));
					
					// Récupération des noms
					//$dao_nom->setDebogage(EF_DEBOG_SQL);
					$type = EF_CONSULTER_NOM_GROUPE_ID;
					$param = array(implode(', ', $tab_taxons_nom_retenu_id), (int)$GLOBALS['eflore_referenciel']);
					$tab_noms = $dao_nom->consulter($type, $param);
					
					// Attribution des noms aux tableaux des taxons
					foreach ($tab_noms as $un_nom) {
						$tab_taxons_complet[$un_nom->getId('nom')]['nom'] = $un_nom->formaterNom();
					}
					//echo '<pre>'.print_r($tab_taxons_complet, true).'</pre>';
					// +----------------------------------------------------------------------------------------------------+
					// Mesure du temps d'éxecution : insertion info
					$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_insertion_info' => microtime()));
					
					foreach ($tab_taxons_complet as $cle_taxon_cplt => $un_taxon_cplt) {
						$_SESSION['taxons'] = $this->ajouterInfo($_SESSION['taxons'], $nn, $cle_taxon_cplt, $un_taxon_cplt);
					}
				} else {
					$tab_retour['info'][] = 'Aucun taxon trouvés!';
				}
			}
		} else {
			$tab_retour['info'][] = 'Aucun taxons ne semble exister pour ce rang dans ce référentiel!';
		}
		// Attribution à la variable globale de l'appli de certaines infos
		$tab_retour['taxons'] = $_SESSION['taxons'];
		$tab_retour['taxons_nbre'] = $_SESSION['taxons_nbre'];

		// +-------------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : taxons fin
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('taxons_fin' => microtime()));
		
		// Récupération des infos pour le formulaire recherche taxonomique
		//$un_form_taxon = new ActionFormTaxon();
		//$tab_retour = array_merge($un_form_taxon->executer(), $tab_retour);
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Intégration du moteur de recherche des taxons	
		//$RegistreFormTaxon = Registre::getInstance();
		$this->getRegistre()->set('vue_donnees', $tab_retour);
		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche taxonomique
		$tab_retour['un_form_taxon'] = $une_recherche->executer('form_taxon');
		//echo '<pre>'.print_r($tab_retour['taxons'], true).'</pre>';
		// +-------------------------------------------------------------------------------------------------------------+
		// Retour des données
		return $tab_retour;
		
 	}// Fin méthode executer()
 	
 	private function supprimerInfo( $tab_taxons, $nt)
	{
		foreach ( $tab_taxons as $cle => $taxon ) {
			if ( $taxon['id'] == $nt ) {
				unset($tab_taxons[$cle]['fils']);
			} else if ( isset($taxon['fils']) ) {
				$tab_taxons[$cle]['fils'] = $this->supprimerInfo( $taxon['fils'], $nt );
			}
		}
		return $tab_taxons;
	}
	
	private function consulterInfo( $tab_taxons, $nt)
	{
		foreach ($tab_taxons as $taxon) {
			if ($taxon['id'] == $nt) {
				return $taxon;
			} else if (isset($taxon['fils'])) {
				$tab_retour = $this->consulterInfo( $taxon['fils'], $nt);
				if (is_array($tab_retour)) {
					return $tab_retour;
				}
			}
		}
	}
	
	private function ajouterInfo( $tab_taxons, $nn_pere, $nn_fils, $taxon_fils )
	{
		if ( $nn_pere == 'depart' ) {
			foreach ($taxon_fils as $c => $v) {
				$tab_taxons[$nn_fils][$c] = $v;
			}
		} else {		
			foreach ($tab_taxons as $cle => $taxon) {
				if ( $cle == $nn_pere ) {
					foreach ($taxon_fils as $c => $v) {
						$tab_taxons[$nn_pere]['fils'][$nn_fils][$c] = $v;
					}
					return $tab_taxons;
				} else if (isset($tab_taxons[$cle]['fils'])) {
					$tab_taxons[$cle]['fils'] = $this->ajouterInfo( $tab_taxons[$cle]['fils'], $nn_pere, $nn_fils, $taxon_fils );
				}
			}
		}
		return $tab_taxons;
	}
 	
}//Fin classe ActionRechercheTaxon()


/* +--Fin du code -----------------------------------------------------------------------------------------------------+
*
* $Log: efre_recherche_taxon.action.php,v $
* Revision 1.25  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.24  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.23  2007/01/24 17:41:48  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.22  2007/01/19 16:55:44  jp_milcent
* Fusion Moquin-Tandon : gestion des erreurs dans les lettres.
*
* Revision 1.21.6.4  2007/02/02 14:34:14  jp_milcent
* Ajout de la vérification de l'existence d'une variable.
*
* Revision 1.21.6.3  2007/01/19 16:56:13  jp_milcent
* Suppression de code de débogage.
*
* Revision 1.21.6.2  2007/01/19 16:31:15  jp_milcent
* Ajout de la note sur le nom.
*
* Revision 1.21.6.1  2007/01/19 16:25:59  jp_milcent
* Correction problème les familles ne s'affiche pas car un nom est null.
*
* Revision 1.21  2006/07/20 13:16:24  jp_milcent
* Légère mise en forme.
*
* Revision 1.20  2006/07/07 15:19:21  jp_milcent
* Correction de mise en page.
*
* Revision 1.19  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.18  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.17  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.16  2005/12/15 16:01:21  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.15.2.1  2005/12/15 14:59:40  jp_milcent
* Prêt pour mise en ligne bdnffv3 et v4.
*
* Revision 1.15  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.14  2005/10/10 07:28:07  jp_milcent
* Utilisation du webservice Yahoo-Image.
*
* Revision 1.13  2005/09/29 16:16:14  jp_milcent
* Fin de la gestion de la synonymie.
* Début de la gestion des noms vernaculaires.
*
* Revision 1.12  2005/09/13 16:25:23  jp_milcent
* Fin de gestion des interfaces de recherche.
*
* Revision 1.11  2005/09/12 08:19:14  jp_milcent
* Fin de la gestion de l'arborescence.
*
* Revision 1.10  2005/09/05 15:53:30  jp_milcent
* Ajout de la gestion du bouton plus et moins.
* Optimisation en cours.
*
* Revision 1.9  2005/09/02 14:31:13  jp_milcent
* Résolution bogue du non affichage des taxons suivant celui cliqué.
*
* Revision 1.8  2005/08/31 16:40:58  jp_milcent
* Correction de quelques bogues sur la navigation dans la classification.
*
* Revision 1.7  2005/08/30 16:11:13  jp_milcent
* La recherche dans la classification fonctionne de manière récursive.
*
* Revision 1.6  2005/08/26 16:45:09  jp_milcent
* Amélioration de la navigation dans la classif.
*
* Revision 1.5  2005/08/22 16:10:41  jp_milcent
* Gestion de l'arborescence de la classif en cours...
*
* Revision 1.4  2005/08/19 13:54:11  jp_milcent
* Début de gestion de la navigation au sein de la classification.
*
* Revision 1.3  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.2  2005/08/17 15:37:50  jp_milcent
* Gestion de la rechercher par taxon en cours...
*
* Revision 1.1  2005/08/11 10:15:48  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.1  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* +-- Fin du code -----------------------------------------------------------------------------------------------------+
*/
?>