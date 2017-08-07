<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.0.4                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: ef_recherche.php,v 1.36 2007-07-17 07:47:26 jp_milcent Exp $
/**
* Fichier contenant l'application de recherche
*
* Contient la bascule entre la page d'accueil de l'application de recherche
* et les résultats d'une recherche.
*
*@package eflore
*@subpackage ef_recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.36 $ $Date: 2007-07-17 07:47:26 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier config du module ef_recherche. */
require_once EF_CHEMIN_MODULE.'ef_recherche/configuration/efre_config.inc.php';

// +-------------------------------------------------------------------------------------------------------------------+
// |                                               CORPS du PROGRAMME                                                  |
// +-------------------------------------------------------------------------------------------------------------------+
class EfRecherche extends aServiceDeprecie {
	
	public function __construct($Registre = null)
	{
		// Ajout du nom du service
		$this->setNom('recherche');
		// Gestion de la variable de session
		$this->gererSession();
		// Appel de la classe parente
		parent::__construct($Registre);
	}
	
	public function executer($action) 
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : début
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('debut_recherche_'.$action => microtime()));
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Vérification si l'action est "commune" ou pas
		if (!$retour = parent::executer($action)) {
			
			// +-------------------------------------------------------------------------------------------------------+
			// Initialisation des variables
			$classe_nom = str_replace(' ', '', ucwords(str_replace('_', ' ', $action)));
			$retour = '';
			
			// +-------------------------------------------------------------------------------------------------------+
			// Gestion de l'appel des actions
			$chemin_fichier_action = EFRE_CHEMIN_ACTION.'efre_'.$action.'.action.php';
			if (file_exists($chemin_fichier_action)) {
				include_once $chemin_fichier_action;
				$class_action_nom = 'Action'.$classe_nom;
				if (class_exists($class_action_nom)) {
					$this->getRegistre()->set('module_nom', $this->getNom());
					if (isset($GLOBALS['_EF_']['i18n'][$this->getNom()])) {
						$this->getRegistre()->set('module_i18n', $GLOBALS['_EF_']['i18n'][$this->getNom()]);
					}
					$une_action = new $class_action_nom($this->getRegistre());
					
					if (EF_BOOL_STOCKAGE_CACHE) {
						if ($une_action instanceof iActionAvecCache) {
							$cachefile = EF_CHEMIN_STOCKAGE_CACHE.$une_action->get_identifiant().'.cache.txt';
		 					if (file_exists($cachefile) ) {
								echo "/* Cached copy, generated ".date('Y M D H:i', filemtime($cachefile))." */\n";
		    					readfile($cachefile);
		    					exit;
							}
						}
					}
				
					if (method_exists($une_action,'executer')) {
						$tab_donnees = $une_action->executer();
					} else {
						trigger_error("Impossible de trouver la méthode d'action: executer().", E_USER_ERROR);
					}
				} else {
					trigger_error("Impossible de trouver la classe d'action: $class_action_nom.", E_USER_ERROR);
				}
			} else {
				trigger_error("Impossible de trouver le fichier d'action: $chemin_fichier_action.", E_USER_ERROR);
			}
	
			// +-------------------------------------------------------------------------------------------------------+
			// Gestion de la vue
			$chemin_fichier_vue = EFRE_CHEMIN_VUE.'efre_'.$action.'.vue.php';
			if (file_exists($chemin_fichier_vue)) {
				include_once $chemin_fichier_vue;
				$class_vue_nom = 'Vue'.$classe_nom;
				if (class_exists($class_vue_nom)) {
					// Construction de la vue
					// Ajout d'information au registre pour la vue
					$this->getRegistre()->set('vue_donnees', $tab_donnees);
					$this->getRegistre()->set('vue_format', $this->getFormat());
					$this->getRegistre()->set('vue_chemin_squelette', EFRE_CHEMIN_SQUELETTE);
					if (isset($_SESSION['cpr']) && $_SESSION['cpr']!='') {
						$this->getRegistre()->set('vue_chemin_squelette_projet', EFRE_CHEMIN_SQUELETTE.$_SESSION['cpr'].DIRECTORY_SEPARATOR);
					}
					// Construction de la vue
					$une_vue = new $class_vue_nom($this->getRegistre());
					// Envoie du rendu
					if ($une_vue->getUtiliseTpl()) {
						$une_vue->chargerSquelette();
						$une_vue->preparer();
					}
					$retour = $une_vue->retournerRendu();
				} else {
					trigger_error("Impossible de trouver la classe de vue: $class_vue_nom.", E_USER_ERROR);
				}
			} else {
				trigger_error("Impossible de trouver le fichier de vue: $chemin_fichier_vue.", E_USER_ERROR);
			}
		}
		// +-----------------------------------------------------------------------------------------------------------+
		// Mesure du temps d'éxecution : fin
		$GLOBALS['_EFLORE_']['chrono']->setTemps(array('fin_recherche_'.$action => microtime()));
		
		// Cache 
		if ($une_action instanceof iActionAvecCache) {
			 if (EF_BOOL_STOCKAGE_CACHE) {
				$fp = fopen($cachefile, 'w');
				fwrite($fp, $retour);
				fclose($fp);
			 }
			 echo $retour; // A revoir si besoin de 
			 exit;         // Cache generique
		}
		
		return $retour;
	}
	
	public function gererSession()
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Instanciation de la valeur de l'action par défaut
		if (!isset($_GET[EF_LG_URL_ACTION])) {
			$_GET[EF_LG_URL_ACTION] = 'accueil';
		}

		// +-----------------------------------------------------------------------------------------------------------+		
		// Initialisation de la base de données : les information sur les projets sont cherchées dans la base principale
		$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_PRINCIPAL;
		$GLOBALS['_EFLORE_']['bdd'] = EF_BDD_NOM_PRINCIPALE;
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Gestion des variables de session
		// TODO : vérifier s'il est vraiment nécessaire d'utiliser une variable de session ici!
		
		// Gestion de la récupération d'info depuis les paramêtres de l'url
		$_SESSION['npr'] = null;// Identifiant du projet
		$_SESSION['cpr'] = null;// Code du projet
		$_SESSION['ipr'] = null;// Intitulé du projet
		$_SESSION['nprv'] = null;// Identifiant de la version du projet
		$_SESSION['cprv'] = null;// Code la version du projet
		$_SESSION['nt'] = null;// Identifiant du taxon courrant auquel appartient le nom sélectionné
		$_SESSION['nvp'] = null;// Identifiant de la version du projet du taxon courrant
		$_SESSION['nn'] = null;// Identifiant du nom sélectionné
		$_SESSION['nvpn'] = null;// Identifiant de la version du projet de nom scientifique
		$_SESSION['NomRetenu'] = null;// Contient l'objet Nom correspondant au nom retenu du taxon courrant
		$_SESSION['NomSelection'] = null;// Contient l'objet Nom correspondant au nom sélectionné courrant
		
		// +-----------------------------------------------------------------------------------------------------------+
		//Gestion de la session spécial ef_recherche
		if (isset($GLOBALS['eflore_nom']) ) {
		    if (isset($_POST['eflore_nom']) AND $GLOBALS['eflore_nom'] != $_POST['eflore_nom']) {
		        $GLOBALS['eflore_nom'] = $_POST['eflore_nom'];
		    }
		} else {
		    if (isset($_POST['eflore_nom'])) {
		        $GLOBALS['eflore_nom'] = $_POST['eflore_nom'];
		    } else {
		        $GLOBALS['eflore_nom'] = '';
		    }
		}
		// Gestion de la session pour l'id du référenciel
		if (isset($GLOBALS['eflore_referenciel']) ) {
		    if (isset($_POST['eflore_referenciel']) AND $GLOBALS['eflore_referenciel'] != $_POST['eflore_referenciel']) {
		        $GLOBALS['eflore_referenciel'] = (int)$_POST['eflore_referenciel'];
		    }
		} else {
		    if (isset($_POST['eflore_referenciel'])) {
		        $GLOBALS['eflore_referenciel'] = (int)$_POST['eflore_referenciel'];
		    } else if (isset($_GET[EF_LG_URL_NVP])) {
		        $GLOBALS['eflore_referenciel'] = (int)$_GET[EF_LG_URL_NVP];
		    } else {
		        $GLOBALS['eflore_referenciel'] = (int)$GLOBALS['_EFLORE_']['projet_version_defaut'];
		    }
		}
		$_SESSION['nvp'] = $GLOBALS['eflore_referenciel'];
		
		// Gestion de la session pour le nom du référenciel
		if (!isset($GLOBALS['eflore_referenciel_nom'])) {
		    $GLOBALS['eflore_referenciel_nom'] = '';
		}
		
		// Gestion de la session pour le type du nom
		if (isset($GLOBALS['eflore_type_nom']) ) {
		    if (isset($_POST['eflore_type_nom']) AND $_POST['eflore_type_nom'] == 'nom_scientifique') {
		        $GLOBALS['eflore_type_nom_scientifique'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_vernaculaire'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_scientifique';
		    } elseif (isset($_GET['eflore_type_nom']) AND $_GET['eflore_type_nom'] == 'nom_vernaculaire') {
		    	$GLOBALS['eflore_type_nom_vernaculaire'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_scientifique'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_vernaculaire';
		    } elseif (isset($_POST['eflore_type_nom']) AND $_POST['eflore_type_nom'] == 'nom_vernaculaire') {
		        $GLOBALS['eflore_type_nom_vernaculaire'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_scientifique'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_vernaculaire';
		    }
		} else {
		    if (isset($_POST['eflore_type_nom']) AND $_POST['eflore_type_nom'] == 'nom_scientifique') {
		        $GLOBALS['eflore_type_nom_scientifique'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_vernaculaire'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_scientifique';
		    } elseif (isset($_GET['eflore_type_nom']) AND $_GET['eflore_type_nom'] == 'nom_vernaculaire') {
		    	$GLOBALS['eflore_type_nom_vernaculaire'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_scientifique'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_vernaculaire';
		    } elseif (isset($_POST['eflore_type_nom']) AND $_POST['eflore_type_nom'] == 'nom_vernaculaire') {
		        $GLOBALS['eflore_type_nom_vernaculaire'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_scientifique'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_vernaculaire';
		    } else {
		        $GLOBALS['eflore_type_nom_scientifique'] = 'checked="checked"';
		        $GLOBALS['eflore_type_nom_vernaculaire'] = '';
		        $GLOBALS['eflore_type_nom'] = 'nom_scientifique';
		    }
		}
		//Gestion de la session pour le rang
		if (isset($GLOBALS['eflore_rang']) ) {
		    if (isset($_POST['eflore_rang']) AND $GLOBALS['eflore_rang'] != $_POST['eflore_rang']) {
		        $GLOBALS['eflore_rang'] = (int)$_POST['eflore_rang'];
		    }
		} else {
			if (isset($_POST['eflore_rang'])) {
		      $GLOBALS['eflore_rang'] = (int)$_POST['eflore_rang'];
			} else if (isset($_GET[EF_LG_URL_RG])) {
		        $GLOBALS['eflore_rang'] = (int)$_GET[EF_LG_URL_RG];
		   } else {
				$GLOBALS['eflore_rang'] = (int)EF_RANG_DEFAUT_ID;
			}
		}
		//Gestion de la session pour la lettre de recherche des taxons
		if (isset($GLOBALS['eflore_lettre']) ) {
		    if (isset($_POST['eflore_lettre']) AND $GLOBALS['eflore_lettre'] != $_POST['eflore_lettre']) {
		        $GLOBALS['eflore_lettre'] = $_POST['eflore_lettre'];
		    }
		} else {
		    if (isset($_POST['eflore_lettre'])) {
		        $GLOBALS['eflore_lettre'] = $_POST['eflore_lettre'];
		    } else if (isset($_GET[EF_LG_URL_LE])) {
		        $GLOBALS['eflore_lettre'] = $_GET[EF_LG_URL_LE];
		    } else {
		        $GLOBALS['eflore_lettre'] = NULL;
		    }
		}
		
		$dao_pr = new ProjetDao;
		//$dao_pr->setDebogage(EF_DEBOG_SQL);
		$dao_prv = new ProjetVersionDao;
		//$dao_prv->setDebogage(EF_DEBOG_SQL);
		if (isset($_GET['cpr']) ) {
			$_SESSION['cpr'] = $_GET['cpr'];
			$tab_pr = $dao_pr->consulter( EF_CONSULTER_PR_ABBR, array($_GET['cpr']) );
			$un_projet = $tab_pr[0];
			$_SESSION['npr'] = $un_projet->getId('projet');
			$_SESSION['ipr'] = $un_projet->getIntitule();
			if (isset($_GET['cprv'])) {
				$_SESSION['cprv'] = $_GET['cprv'];
				$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_CODE, array((int)$_SESSION['npr'], $_GET['cprv']) );
				$une_version = $tab_prv[0];
				$_SESSION['nprv'] = $une_version->getId('version');
			} else {
				if (isset($_SESSION['npr'])) {
					$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_DERNIERE_VERSION, array((int)$_SESSION['npr']) );
					$une_version = $tab_prv[0];
					$_SESSION['nprv'] = $une_version->getId('version');
					$_SESSION['cprv'] = $une_version->getCode();
				}	
			}
		}
		
		// Gestion de la session pour l'id du référentiel
		if (isset($_SESSION['nvp']) ) {
			if (isset($_GET['nvp']) AND $_SESSION['nvp'] != $_GET['nvp']) {
				$_SESSION['nvp'] = (int)$_GET['nvp'];
				$this->gererSessionProjetEtVersion();
				//$GLOBALS['_DEBOGAGE_'] .= 'A1'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			} else if (isset($_POST['nvp']) AND $_SESSION['nvp'] != $_POST['nvp']) {
				$_SESSION['nvp'] = (int)$_POST['nvp'];
				$this->gererSessionProjetEtVersion();
				//$GLOBALS['_DEBOGAGE_'] .= 'A1'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			} else if (isset($_SESSION['nprv']) AND $_SESSION['nvp'] != $_SESSION['nprv']) {
				$_SESSION['nvp'] = (int)$_SESSION['nprv'];
				//$GLOBALS['_DEBOGAGE_'] .= 'A2'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			} else {
				$this->gererSessionProjetEtVersion();
				//$GLOBALS['_DEBOGAGE_'] .= 'A3'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];		
			}
		} else {
			if (isset($_GET['nvp'])) {
				$_SESSION['nvp'] = (int)$_GET['nvp'];
				$this->gererSessionProjetEtVersion();
				//$GLOBALS['_DEBOGAGE_'] .= 'B1'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			} else if (isset($_POST['nvp'])) {
				$_SESSION['nvp'] = (int)$_POST['nvp'];
				$this->gererSessionProjetEtVersion();
				//$GLOBALS['_DEBOGAGE_'] .= 'B1'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			} else if (isset($_SESSION['nprv'])) {
				$_SESSION['nvp'] = (int)$_SESSION['nprv'];
				//$GLOBALS['_DEBOGAGE_'] .= 'B2'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			} else {
				$_SESSION['nvp'] = (int)$GLOBALS['_EFLORE_']['projet_version_defaut'];
				$this->gererSessionProjetEtVersion();
				//$GLOBALS['_DEBOGAGE_'] .= 'B3'.$_SESSION['ipr'].'-'.$_SESSION['cpr'].'-'.$_SESSION['cprv'];
			}
		}
		
		// Gestion de la session pour l'intitulé du référentiel
		if (!isset($_SESSION['effi_ref_intitule'])) {
		    $_SESSION['effi_ref_intitule'] = '';
		}
		
		// Gestion de la session pour l'id du nom
		if (isset($_SESSION['nn']) ) {
			if (isset($_GET['nn']) AND $_SESSION['nn'] != $_GET['nn']) {
				$_SESSION['nn'] = $_GET['nn'];
			} else if (isset($_POST['nn']) AND $_SESSION['nn'] != $_POST['nn']) {
				$_SESSION['nn'] = $_POST['nn'];
			}
		} else {
			if (isset($_GET['nn'])) {
				$_SESSION['nn'] = $_GET['nn'];
			} else if (isset($_POST['nn'])) {
				$_SESSION['nn'] = $_POST['nn'];
			} else {
				$_SESSION['nn'] = '';
			}
		}
		
		// Gestion de la session pour l'id du taxon
		if (isset($_SESSION['nt'])) {		
			if (isset($_GET['nt']) AND $_SESSION['nt'] != $_GET['nt']) {
				$_SESSION['nt'] = (int)$_GET['nt'];
			} else if (isset($_POST['nt']) AND $_SESSION['nt'] != $_POST['nt']) {
				$_SESSION['nt'] = (int)$_POST['nt'];
			}
		} else {
			if (isset($_GET['nt'])) {
				$_SESSION['nt'] = (int)$_GET['nt'];
			} else if (isset($_POST['nt'])) {
				$_SESSION['nt'] = (int)$_POST['nt'];
			} else {
				$_SESSION['nt'] = '';
			}
		}
		
		// Aiguillage sur la base de données historique si nécessaire sinon on reste sur la principale
		// TODO : supprimer l'utilisation de cette valeur de $GLOBALS['_EFLORE_'] utile seulement le temps que les
		// requêtes de la classe carto_carte soit extrêtes.
		if (!empty($_SESSION['nvp'])) {
			$tab_versions = $dao_prv->consulter( EF_CONSULTER_PRV_ID, array((int)$_SESSION['nvp']));
			if (!$tab_versions[0]->verifierDerniereVersion()) {
				$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_HISTORIQUE;
				$GLOBALS['_EFLORE_']['bdd'] = EF_BDD_NOM_HISTORIQUE;
			}
		} else {
			trigger_error("Impossible de trouver l'identifiant de la version du projet.", E_USER_ERROR);
		}
		
		// Gestion de la session des identifiants complémentaires
		if ($_SESSION['nt'] == '') {
			if (isset($_SESSION['nn']) && $_SESSION['nn'] != '') {
				$dao_sn = new SelectionNomDao;
				//$dao_sn->setDebogage(EF_DEBOG_SQL);
				$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvp']));
				if (isset($tab_sn[0])) {
					$un_sn = $tab_sn[0];
					if (is_object($un_sn)) {
						$_SESSION['nt'] = $un_sn->getId('taxon');
						// Ajout de la variable de session nvpn stockant l'id de version du projet de nom scientifique
						$_SESSION['nvpn'] = $un_sn->getId('version_projet_nom');
					}
				} else {
					trigger_error("Aucune information ne correspond pour le nn : ".$_SESSION['nn'], E_USER_ERROR);
				}
			} else {
				//trigger_error("Impossible de trouver le numéro taxonomique.", E_USER_ERROR);
			}
		}
		
		if ($_SESSION['nn'] == '') {
			if (isset($_SESSION['nt']) && $_SESSION['nt'] != '') {
				$dao_sn = new SelectionNomDao;
				$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID_RETENU, array((int)$_SESSION['nt'], (int)$_SESSION['nvp']));
				if (isset($tab_sn[0])) {
					$un_sn = $tab_sn[0];
					if (is_object($un_sn)) {
						$_SESSION['nn'] = $un_sn->getId('nom');
						// Ajout de la variable de session nvpn stockant l'id de version du projet de nom scientifique
						$_SESSION['nvpn'] = $un_sn->getId('version_projet_nom');
					}
				} else {
					trigger_error("Aucune information ne correspond pour le nt : ".$_SESSION['nt'], E_USER_ERROR);
				}
			} else {
			}
		}
		
		if (isset($_SESSION['nn']) && $_SESSION['nn'] != '' && isset($_SESSION['nt']) && $_SESSION['nt'] != '') {			
			// Récupération des infos sur le taxon courrant
			// Récupération de l'objet Nom correspondant au nom retenu.
			$dao_sn = new SelectionNomDao;
			$dao_n = new NomDeprecieDao;
			$tab_sn_nt = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID, array( (int)$_SESSION['nt'], (int)$_SESSION['nvp'] ) );
			foreach($tab_sn_nt as $une_sn) {
				if ($une_sn->getCe('statut') == EF_SNS_RETENU) {
					$tab_nom_retenu = $dao_n->consulter( EF_CONSULTER_NOM_ID, array((int)$une_sn->getId('nom'), (int)$_SESSION['nvpn']));
					$_SESSION['NomRetenu'] = $tab_nom_retenu[0];
					break;
				}
			}
	
			// Récupération des infos sur le nom sélectionné courrant
			// Récupération de l'objet Nom correspondant au nom sélectionné courrant.		
			$dao_n = new NomDeprecieDao;
			$tab_nom_selection = $dao_n->consulter( EF_CONSULTER_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvpn']));
			if (isset($tab_nom_selection[0])) {
				$_SESSION['NomSelection'] = $tab_nom_selection[0];
			}
			
			// Création de l'url Eflore de base
			$url =& $GLOBALS['_EFLORE_']['url_permalien'];
			$url->setType('nn');
			$url->setTypeId($_SESSION['nn']);
			$url->setProjetCode($_SESSION['cpr']);
			$url->setVersionCode($_SESSION['cprv']);
			
			// +------------------------------------------------------------------------------------------------------+
			// Récupération des infos sur la classification
			$taxon_id = $_SESSION['nt'];
			$taxon_prv = $_SESSION['nvp'];
			$dao_tr = new TaxonRelationDao;
			//$dao_tr->setDebogage(EF_DEBOG_SQL);
			$type = EF_CONSULTER_TR_CATEGORIE_VALEUR_VERSION_ID;
			$tab_classification = array($taxon_id);
	
			do {
				$param = array((int)$taxon_id, (int)$taxon_prv, (int)EF_TC_RELATION_ID, (int)EF_TV_AVOIR_PERE_ID);
				$tab_tr = $dao_tr->consulter($type, $param);
				if (is_object($tab_tr[0])) {
					$taxon_id = $tab_tr[0]->getId('taxon_2');
					if ($taxon_id != 0) {
						$tab_classification[] = $taxon_id;
					}
				} else {
					// Aucune relation "enfant vers père" existante, du coup on arrête.
					$taxon_id = 0;
				}
			} while ($taxon_id != 0);
			//echo '<pre>'.print_r($tab_classification).'</pre>';
			
			$type = EF_CONSULTER_SN_STATUT_VERSION_TAXON_GROUPE_ID;
			$param = array(implode(', ', $tab_classification), (int)$_SESSION['nvp'], EF_SNS_RETENU);
			$tab_sn_classif = $dao_sn->consulter($type, $param);
			$tab_classif_nom_id = array();
			$tab_classif_taxon_nom = array();
			foreach($tab_sn_classif as $une_sn) {
				// TODO : Ici la version du projet devrait être enregistré pour chaque id de nom.
				$id_vpn = $une_sn->getId('version_projet_nom');
				$tab_classif_taxon_nom[$une_sn->getId('nom')] = $une_sn->getId('taxon');
				$tab_classif_nom_id[] = $une_sn->getId('nom');
			}
			// Création de l'url des noms supérieurs de la classification
			$url_classif = clone $GLOBALS['_EFLORE_']['url_permalien'];
			$url_classif->setType('nn');
			$url_classif->setProjetCode($_SESSION['cpr']);
			$url_classif->setVersionCode($_SESSION['cprv']);
	
			$tab_n = $dao_n->consulter(EF_CONSULTER_NOM_GROUPE_ID, array(implode(', ', $tab_classif_nom_id), (int)$id_vpn));
			$tab_classif_nom = array();
			if ($_SESSION['NomSelection'] instanceof NomDeprecie && $_SESSION['NomSelection']->getCe('rang') <= EF_RANG_FAMILLE_ID) {
				// Le nom à un rang supérieur ou égal à la famille, nous n'affichons donc pas la famille'
				$_SESSION['nom_retenu_famille'] = null;
			} else {
				// Le nom à un rang inférieur à la famille, nous affichons le doute
				$_SESSION['nom_retenu_famille'] = 'Famille ?';
			}
			foreach($tab_n as $un_n) {
				//echo $un_n->getId('nom').'-';
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['nom'] = $un_n;
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['nt'] = $tab_classif_taxon_nom[$un_n->getId('nom')];
				$url_classif->setTypeId($un_n->getId('nom'));
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['url'] = $url_classif->getURL();
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['rang'] = $un_n->enrg_intitule_rang;
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['abreviation'] = $un_n->enrg_abreviation_rang;
				if ($un_n->enrg_id_rang == EF_RANG_FAMILLE_ID) {
					$_SESSION['nom_retenu_famille'] = $un_n;
					$_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']] = $un_n;
				}
			}
			//echo '<pre>'.print_r($tab_classif_nom, true).'</pre>';
			$tab_classif = array();
			$j = 0;
			$nbre_parent = count($tab_classification)-1;
			for ($i = $nbre_parent; $i >= 0 ; $i--) {
				if (isset($tab_classif_nom[$tab_classification[$i]])) {
					$tab_classif[$j++] = $tab_classif_nom[$tab_classification[$i]];
				}
			}
			$_SESSION['classification'] = $tab_classif;
		}
		
		// Gestion de la session pour l'id du taxon
		if (isset($_SESSION['nt'])) {		
			if (isset($_GET['nt']) AND $_SESSION['nt'] != $_GET['nt']) {
				$_SESSION['nt'] = (int)$_GET['nt'];
			} else if (isset($_POST['nt']) AND $_SESSION['nt'] != $_POST['nt']) {
				$_SESSION['nt'] = (int)$_POST['nt'];
			}
		} else {
			if (isset($_GET['nt'])) {
				$_SESSION['nt'] = (int)$_GET['nt'];
			} else if (isset($_POST['nt'])) {
				$_SESSION['nt'] = (int)$_POST['nt'];
			} else {
				$_SESSION['nt'] = '';
			}
		}
		
		// Aiguillage sur la base de données historique si nécessaire sinon on reste sur la principale
		// TODO : supprimer l'utilisation de cette valeur de $GLOBALS['_EFLORE_'] utile seulement le temps que les
		// requêtes de la classe carto_carte soit extrêtes.
		if (!empty($_SESSION['nvp'])) {
			$tab_versions = $dao_prv->consulter( EF_CONSULTER_PRV_ID, array((int)$_SESSION['nvp']));
			if (!$tab_versions[0]->verifierDerniereVersion()) {
				$GLOBALS['_EFLORE_']['dsn'] = EF_DSN_HISTORIQUE;
				$GLOBALS['_EFLORE_']['bdd'] = EF_BDD_NOM_HISTORIQUE;
			}
		} else {
			trigger_error("Impossible de trouver l'identifiant de la version du projet.", E_USER_ERROR);
		}
		
		// Gestion de la session des identifiants complémentaires
		if ($_SESSION['nt'] == '') {
			if (isset($_SESSION['nn']) && $_SESSION['nn'] != '') {
				$dao_sn = new SelectionNomDao;
				//$dao_sn->setDebogage(EF_DEBOG_SQL);
				$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvp']));
				if (isset($tab_sn[0])) {
					$un_sn = $tab_sn[0];
					if (is_object($un_sn)) {
						$_SESSION['nt'] = $un_sn->getId('taxon');
						// Ajout de la variable de session nvpn stockant l'id de version du projet de nom scientifique
						$_SESSION['nvpn'] = $un_sn->getId('version_projet_nom');
					}
				} else {
					trigger_error("Aucune information ne correspond pour le nn : ".$_SESSION['nn'], E_USER_ERROR);
				}
			} else {
				//trigger_error("Impossible de trouver le numéro taxonomique.", E_USER_ERROR);
			}
		}
		
		if ($_SESSION['nn'] == '') {
			if (isset($_SESSION['nt']) && $_SESSION['nt'] != '') {
				$dao_sn = new SelectionNomDao;
				$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID_RETENU, array((int)$_SESSION['nt'], (int)$_SESSION['nvp']));
				if (isset($tab_sn[0])) {
					$un_sn = $tab_sn[0];
					if (is_object($un_sn)) {
						$_SESSION['nn'] = $un_sn->getId('nom');
						// Ajout de la variable de session nvpn stockant l'id de version du projet de nom scientifique
						$_SESSION['nvpn'] = $un_sn->getId('version_projet_nom');
					}
				} else {
					trigger_error("Aucune information ne correspond pour le nt : ".$_SESSION['nt'], E_USER_ERROR);
				}
			} else {
				//trigger_error("Impossible de trouver le numéro nomenclatural.", E_USER_ERROR);
			}
		}
		
		if (isset($_SESSION['nn']) && $_SESSION['nn'] != '' && isset($_SESSION['nt']) && $_SESSION['nt'] != '') {			
			// Récupération des infos sur le taxon courrant
			// Récupération de l'objet Nom correspondant au nom retenu.
			$dao_sn = new SelectionNomDao;
			$dao_n = new NomDeprecieDao;
			$tab_sn_nt = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID, array( (int)$_SESSION['nt'], (int)$_SESSION['nvp'] ) );
			foreach($tab_sn_nt as $une_sn) {
				if ($une_sn->getCe('statut') == EF_SNS_RETENU) {
					$tab_nom_retenu = $dao_n->consulter( EF_CONSULTER_NOM_ID, array((int)$une_sn->getId('nom'), (int)$_SESSION['nvpn']));
					$_SESSION['NomRetenu'] = $tab_nom_retenu[0];
					break;
				}
			}
	
			// Récupération des infos sur le nom sélectionné courrant
			// Récupération de l'objet Nom correspondant au nom sélectionné courrant.		
			$dao_n = new NomDeprecieDao;
			$tab_nom_selection = $dao_n->consulter( EF_CONSULTER_NOM_ID, array((int)$_SESSION['nn'], (int)$_SESSION['nvpn']));
			if (isset($tab_nom_selection[0])) {
				$_SESSION['NomSelection'] = $tab_nom_selection[0];
			}
			
			// Création de l'url Eflore de base
			$url =& $GLOBALS['_EFLORE_']['url_permalien'];
			$url->setType('nn');
			$url->setTypeId($_SESSION['nn']);
			$url->setProjetCode($_SESSION['cpr']);
			$url->setVersionCode($_SESSION['cprv']);
			
			// +------------------------------------------------------------------------------------------------------+
			// Récupération des infos sur la classification
			$taxon_id = $_SESSION['nt'];
			$taxon_prv = $_SESSION['nvp'];
			$dao_tr = new TaxonRelationDao;
			//$dao_tr->setDebogage(EF_DEBOG_SQL);
			$type = EF_CONSULTER_TR_CATEGORIE_VALEUR_VERSION_ID;
			$tab_classification = array($taxon_id);
	
			do {
				$param = array((int)$taxon_id, (int)$taxon_prv, (int)EF_TC_RELATION_ID, (int)EF_TV_AVOIR_PERE_ID);
				$tab_tr = $dao_tr->consulter($type, $param);
				if (is_object($tab_tr[0])) {
					$taxon_id = $tab_tr[0]->getId('taxon_2');
					if ($taxon_id != 0) {
						$tab_classification[] = $taxon_id;
					}
				} else {
					// Aucune relation "enfant vers père" existante, du coup on arrête.
					$taxon_id = 0;
				}
			} while ($taxon_id != 0);
			//echo '<pre>'.print_r($tab_classification).'</pre>';
			
			$type = EF_CONSULTER_SN_STATUT_VERSION_TAXON_GROUPE_ID;
			$param = array(implode(', ', $tab_classification), (int)$_SESSION['nvp'], EF_SNS_RETENU);
			$tab_sn_classif = $dao_sn->consulter($type, $param);
			$tab_classif_nom_id = array();
			$tab_classif_taxon_nom = array();
			foreach($tab_sn_classif as $une_sn) {
				// TODO : Ici la version du projet devrait être enregistré pour chaque id de nom.
				$id_vpn = $une_sn->getId('version_projet_nom');
				$tab_classif_taxon_nom[$une_sn->getId('nom')] = $une_sn->getId('taxon');
				$tab_classif_nom_id[] = $une_sn->getId('nom');
			}
			// Création de l'url des noms supérieurs de la classification
			$url_classif = clone $GLOBALS['_EFLORE_']['url_permalien'];
			$url_classif->setType('nn');
			$url_classif->setProjetCode($_SESSION['cpr']);
			$url_classif->setVersionCode($_SESSION['cprv']);
	
			$tab_n = $dao_n->consulter(EF_CONSULTER_NOM_GROUPE_ID, array(implode(', ', $tab_classif_nom_id), (int)$id_vpn));
			$tab_classif_nom = array();
			if ($_SESSION['NomSelection'] instanceof NomDeprecie && $_SESSION['NomSelection']->getCe('rang') <= EF_RANG_FAMILLE_ID) {
				// Le nom à un rang supérieur ou égal à la famille, nous n'affichons donc pas la famille'
				$_SESSION['nom_retenu_famille'] = null;
			} else {
				// Le nom à un rang inférieur à la famille, nous affichons le doute
				$_SESSION['nom_retenu_famille'] = 'Famille ?';
			}
			foreach($tab_n as $un_n) {
				//echo $un_n->getId('nom').'-';
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['nom'] = $un_n;
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['nt'] = $tab_classif_taxon_nom[$un_n->getId('nom')];
				$url_classif->setTypeId($un_n->getId('nom'));
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['url'] = $url_classif->getURL();
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['rang'] = $un_n->enrg_intitule_rang;
				$tab_classif_nom[$tab_classif_taxon_nom[$un_n->getId('nom')]]['abreviation'] = $un_n->enrg_abreviation_rang;
				if ($un_n->enrg_id_rang == EF_RANG_FAMILLE_ID) {
					$_SESSION['nom_retenu_famille'] = $un_n;
					$_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']] = $un_n;
				}
			}
			//echo '<pre>'.print_r($tab_classif_nom, true).'</pre>';
			$tab_classif = array();
			$j = 0;
			$nbre_parent = count($tab_classification)-1;
			for ($i = $nbre_parent; $i >= 0 ; $i--) {
				if (isset($tab_classif_nom[$tab_classification[$i]])) {
					$tab_classif[$j++] = $tab_classif_nom[$tab_classification[$i]];
				}
			}
			$_SESSION['classification'] = $tab_classif;
		}
	}
	
	private function gererSessionProjetEtVersion()
	{
		$dao_pr = new ProjetDao;
		//$dao_pr->setDebogage(EF_DEBOG_SQL);
		$dao_prv = new ProjetVersionDao;
		//$dao_prv->setDebogage(EF_DEBOG_SQL);
		$tab_prv = $dao_prv->consulter( EF_CONSULTER_PRV_ID, array((int)$_SESSION['nvp']) );
		$une_version = $tab_prv[0];
		$_SESSION['cprv'] = $une_version->getCode();
		$tab_pr = $dao_pr->consulter( EF_CONSULTER_PR_ID, array($une_version->getCe('projet')) );
		$un_projet = $tab_pr[0];
		$_SESSION['cpr'] = $un_projet->getAbreviation();
		$_SESSION['ipr'] = $un_projet->getIntitule();
	}
}
/* +--Fin du code -----------------------------------------------------------------------------------------------------+
*
* $Log: ef_recherche.php,v $
* Revision 1.36  2007-07-17 07:47:26  jp_milcent
* Renommage de l'ancienne classe aService en aServiceDeprecie.
*
* Revision 1.35  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.34  2007-02-07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.33  2007/01/30 16:19:48  ddelon
* Retablissement instruction formatage supprimÃ©e par erreur
*
* Revision 1.32  2007/01/30 16:15:20  ddelon
* Gestion squelette par projet et ajout nouveau squelette pour flore afrique du nord (backport de la livraison moquin_tandon vers HEAD)
*
* Revision 1.31  2007/01/30 16:04:16  ddelon
* Gestion squelette par projet et ajout nouveau squelette pour flore afrique du nord (backport de la livraison moquin_tandon vers HEAD)
*
* Revision 1.30  2007/01/24 16:10:27  jp_milcent
* Utilisation du format passé en paramêtre de l'url.
*
* Revision 1.29  2007/01/18 17:47:31  jp_milcent
* Corrections bogue des sessions non pris en compte lors de la fusion.
*
* Revision 1.28  2007/01/18 17:45:42  jp_milcent
* Fusion avec la livraison Moquin-Tandon : corrections bogue des sessions.
*
* Revision 1.27.2.3  2007/01/30 13:01:49  ddelon
* Gestion squelette par projet et ajout nouveau squelette pour flore afrique du nord
*
* Revision 1.27.2.2  2007/01/18 17:41:39  jp_milcent
* Correction problème du nt et du nn non défini pour la page d'accueil.
*
* Revision 1.27.2.1  2007/01/18 13:50:35  jp_milcent
* Amélioration de la gestion des sessions.
* Mise en commun entre ef_fiche et ef_recherche.
*
* Revision 1.27  2007/01/12 16:22:02  jp_milcent
* Amélioration de la gestion des sessions.
*
* Revision 1.26  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.25.2.2  2006/10/19 14:32:43  jp_milcent
* Correction problème de gestion du projet pour le titre.
*
* Revision 1.25.2.1  2006/10/06 15:09:15  jp_milcent
* Gestion de la session dans une méthode spécifique.
*
* Revision 1.25  2006/07/07 09:59:13  jp_milcent
* Correction bogue changement nom classe ActionAvecCache en iActionAvecCache.
*
* Revision 1.24  2006/07/07 09:53:21  jp_milcent
* Correction de bogues dûs au changement de nom des classes du noyau.
*
* Revision 1.23  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.22  2006/07/05 15:11:22  jp_milcent
* Modification du module de recherche suite à remarque de Daniel du 29 juin 2006.
*
* Revision 1.21  2006/05/16 09:20:43  ddelon
* correction gestion cache
*
* Revision 1.20  2006/05/15 19:51:07  ddelon
* parametrage cache
*
* Revision 1.19  2006/05/11 10:28:27  jp_milcent
* Début modification de l'interface d'eFlore pour la livraison Decaisne.
*
* Revision 1.18  2006/05/11 09:43:37  ddelon
* Action cache
*
* Revision 1.17  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.16  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.15.4.1  2006/03/08 17:19:07  jp_milcent
* Amélioration de la gestion de la configuration du moteur de recherche.
* Gestion du projet par défaut et de la version par défaut dans le fichier de config et les arguments de Papyrus.
*
* Revision 1.15  2005/12/06 09:47:26  ddelon
* Recherche vernaculaire (extension) + recherche approche
*
* Revision 1.14  2005/11/28 16:53:01  jp_milcent
* Restriction du nombre de variables de session.
*
* Revision 1.13  2005/10/11 09:40:59  jp_milcent
* Ajout des onglets Accueil et Aide pour permettre l'affichage d'info sous les moteurs de recherche et l'ajout futur de l'onglet Options...
*
* Revision 1.12  2005/10/10 13:53:21  jp_milcent
* Amélioration de la gestion des sessions.
*
* Revision 1.11  2005/09/14 16:57:58  jp_milcent
* Début gestion des fiches, onglet synthèse.
* Amélioration du modèle et des objets DAO.
*
* Revision 1.10  2005/09/12 16:22:44  jp_milcent
* Fin de gestion de la recherche des noms latins pour tous les référentiels.
*
* Revision 1.9  2005/08/19 08:34:36  jp_milcent
* Gestion de la recherche par taxon en cours...
*
* Revision 1.8  2005/08/17 15:37:50  jp_milcent
* Gestion de la rechercher par taxon en cours...
*
* Revision 1.7  2005/08/11 10:15:49  jp_milcent
* Fin de gestion des noms verna avec requête rapide.
* Début gestion choix aplhabétique des taxons.
*
* Revision 1.6  2005/08/05 15:13:35  jp_milcent
* Gestion de l'affichage des résultats des recherches taxonomiques (en cours).
*
* Revision 1.5  2005/08/04 15:51:45  jp_milcent
* Implémentation de la gestion via DAO.
* Fin page d'accueil.
* Fin formulaire recherche taxonomique.
*
* Revision 1.4  2005/08/03 15:52:31  jp_milcent
* Fin gestion des résultats recherche nomenclaturale.
* Début gestion formulaire taxonomique.
*
* Revision 1.3  2005/08/01 16:18:39  jp_milcent
* Début gestion résultat de la recherche par nom.
*
* Revision 1.2  2005/07/27 15:43:21  jp_milcent
* Début débogage avec gestion de l'appli hors Papyrus.
*
* Revision 1.1  2005/07/26 16:27:29  jp_milcent
* Début mise en place framework eFlore.
*
* Revision 1.1  2005/07/25 14:24:36  jp_milcent
* Début appli de consultation simplifiée.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>