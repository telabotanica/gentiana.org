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
// CVS : $Id: effi_chorologie.action.php,v 1.34 2007-06-19 10:32:57 jp_milcent Exp $
/**
* Fichier d'action du module eFlore-Fiche : Chorologie
*
* Contient les infos pour l'onglet Chorologie.
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.34 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Définitions des constantes spécifiques à la carto

/** Constantes de connexion aux bases de données MySQL */
//Il faut mettre dans la constante ci-dessous la même valeur que pour la constante 
//BD_OFFICIEL si on ne veut pas mettre les tables de chorologie dans 
//une base différente.
define('BD_GENERALE', $GLOBALS['_EFLORE_']['bdd']);//Nom de la base des tables de la carto (et éventuellement de chorologie)

/** Constantes des noms de champs de la table MySQL : carto_DEPARTEMENT_FR */
define('CD_BD_TABLE', BD_GENERALE.'.carto_DEPARTEMENT');
define('CD_NOM_TABLE', 'carto_DEPARTEMENT');
define('CD_ID', 'CD_ID_Departement');
define('CD_NOM', 'CD_Intitule_departement');
define('CD_R', 'CD_Couleur_R');
define('CD_V', 'CD_Couleur_V');
define('CD_B', 'CD_Couleur_B');
define('CD_PAYS', 'CD_ID_Pays');

/** Constantes des noms de champs de la table MySQL : carto_DEPARTEMENT_FR */
define('CP_BD_TABLE', BD_GENERALE.'.carto_PAYS');
define('CP_NOM_TABLE', 'carto_PAYS');
define('CP_ID', 'CP_ID_Pays');
define('CP_NOM', 'CP_Intitule_pays');
define('CP_R', 'CP_Couleur_R');
define('CP_V', 'CP_Couleur_V');
define('CP_B', 'CP_Couleur_B');
define('CP_CONTINENT', 'CP_ID_Continent');

// +-------------------------------------------------------------------------------------------------------------------+
// Définition de chemin d'accès et de nom de fichier pour la Cartographie
/** Constante stockant le chemin d'accès et le nom du fichier récupérant l'image de la carte et la renvoyant au client.*/
// Inutile pour cette appli...
//define('CAR_CHEMIN_CARTE', 'carto.php?session='.session_name());
/** Constante stockant le chemin d'accès et le nom du fichier récupérant l'image de la carte et la renvoyant au client.*/
define('CAR_CHEMIN_TMP', EF_CHEMIN_CARTE_STOCKAGE);

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class ActionChorologie extends aAction {
	
	public function executer($parametres = null)
	{
		// +-----------------------------------------------------------------------------------------------------------+
		// Initialisation des variables
		$tab_retour = array();
		$tableau_dep_taxons = array();
		$tab_zones = array();
		$dao_n = new NomDeprecieDao();
		//$dao_n->setDebogage(EF_DEBOG_SQL);
		$dao_sn = new SelectionNomDao;
		//$dao_sn->setDebogage(EF_DEBOG_SQL);
		$dao_cd = new ChorologieDonneeDao;
		//$dao_cd->setDebogage(EF_DEBOG_SQL);
		$dao_ci = new ChorologieInformationDao;
		//$dao_ci->setDebogage(EF_DEBOG_SQL);
		$dao_zg = new ZgDaoDeprecie;
		//$dao_zg->setDebogage(EF_DEBOG_SQL);

		// +-----------------------------------------------------------------------------------------------------------+
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		// Intégration du moteur de recherche par nom latin
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}
		
		// Nous vérifions que nous avons à faire à un taxon dont le rang posséde des données choro
		switch ($_SESSION['nvp']) {
			case 25: // BDNFF v4.02
			case 32: // BDAFN v0
			case 26: // BDNBE v0
			case 38: // BDNBE v1
				$rang_max = 240;
				break;
			case 29 : // BDNFM v2006.01
				$rang_max = 160;
				break;
			default :
				$rang_max = 240;
		}
		$tab_retour['carto_bool'] = false;
		
		if ($_SESSION['NomRetenu']->getCe('rang') >= $rang_max) {
			// +-------------------------------------------------------------------------------------------------------+
			// Gestion de la légende
			switch ($_SESSION['nvp']) {
				case 25: // BDNFF v4.02
				case 32: // BDAFN v0
				case 26: // BDNBE v0
				case 38: // BDNBE v1
					$aso_legende[0] = array('intitule' => 'Zone géographique non renseignée', 
											'couleur' => array('R' => 128, 'V' => 128, 'B' => 128),
											'rvb' => '128-128-128' );
					$aso_legende[3] = array('intitule' => 'Présent', 
											'couleur' => array('R' => 160, 'V' => 255, 'B' => 125),
											'rvb' => '160-255-125' );
					$aso_legende[4] = array('intitule' => 'Présence à confirmer', 
											'couleur' => array('R' => 255, 'V' => 255, 'B' => 50),
											'rvb' => '255-255-50' );
					$aso_legende[5] = array('intitule' => 'Disparu ou douteux', 
											'couleur' => array('R' => 248, 'V' => 128, 'B' => 23),
											'rvb' => '248-128-23' );
					$aso_legende[6] = array('intitule' => 'Cité par erreur comme présent', 
											'couleur' => array('R' => 255, 'V' => 40, 'B' => 80),
											'rvb' => '255-40-80' );
					$aso_legende[10] = array('intitule' => 'Présence non signalée', 
											'couleur' => array('R' => 255, 'V' => 255, 'B' => 255),
											'rvb' => '255-255-255' );
					break;
			case 29 :// BDNFM v2006.01
					$aso_legende[0] = array('intitule' => 'Zone géographique non renseignée', 
											'couleur' => array('R' => 128, 'V' => 128, 'B' => 128) );
					$aso_legende[3] = array('intitule' => 'Présent', 
													'couleur' => array('R' => 160, 'V' => 255, 'B' => 125) );
					$aso_legende[4] = array('intitule' => 'Présence probable à confirmer', 
													'couleur' => array('R' => 255, 'V' => 255, 'B' => 50) );
					$aso_legende[5] = array('intitule' => 'Présence douteuse ou incertaine', 
													'couleur' => array('R' => 248, 'V' => 128, 'B' => 23) );
					$aso_legende[6] = array('intitule' => 'Présence uniquement à l\'état cultivé', 
													'couleur' => array('R' => 162, 'V' => 91, 'B' => 28) );
					$aso_legende[7] = array('intitule' => 'Cité par erreur', 
													'couleur' => array('R' => 255, 'V' => 40, 'B' => 80) );
					$aso_legende[10] = array('intitule' => 'Présence non signalée', 
													'couleur' => array('R' => 255, 'V' => 255, 'B' => 255) );
					break;
				default:
					$aso_legende = array();
			}
			$tab_retour['legende'] = $aso_legende;
			
			// +-------------------------------------------------------------------------------------------------------+
			// Récupération des différents projets de données choro utilisant le projet du taxon
			$type = EF_CONSULTER_CD_PROJET_CHORO_VERSION;
			$param = array((int)$_SESSION['nvp']);
			$tab_cd = $dao_cd->consulter( $type, $param );
			$tab_id_projet_donnee_choro = array();
			foreach($tab_cd as $une_cd) {
				$tab_id_projet_donnee_choro[] = $une_cd->getId('version_projet_donnee_choro');
			}

			// +-------------------------------------------------------------------------------------------------------+
			// Nous vérifions qu'il y ait des données
			if (count($tab_id_projet_donnee_choro) > 0) {
				$tab_retour['carto_bool'] = true;
				// +---------------------------------------------------------------------------------------------------+
				// Gestion des différentes zones géo renseignés pour le projet courrant de chorologie
				// TODO : gérer de multiple projet de données choro. Pour l'instant on utilise $tab_id_projet_donnee_choro[0]
				$tableau_zg = array();
				$tableau_zg_prv = array();
				$tableau_zg_id = array();
				$type = EF_CONSULTER_CD_ZG_CHORO_VERSION;
				$param = array((int)$tab_id_projet_donnee_choro[0], (int)$_SESSION['nvp']);
				$tab_cd = $dao_cd->consulter( $type, $param );
				foreach($tab_cd as $une_cd) {
					$id = $une_cd->getCe('zone_geo').'-'.$une_cd->getCe('version_projet_zg');
					$tableau_zg[$id]['id'] = $une_cd->getCe('zone_geo');
					$tableau_zg[$id]['version'] = $une_cd->getCe('version_projet_zg');
					// Ajout des différentes version de projets de zg dans un tableau
					if (!isset($tableau_zg_prv[$une_cd->getCe('version_projet_zg')])) {
						$tableau_zg_prv[$une_cd->getCe('version_projet_zg')] = $une_cd->getCe('version_projet_zg');
					}
					// Ajout des différents id de zg
					$tableau_zg_id[$une_cd->getCe('version_projet_zg')][] = $une_cd->getCe('zone_geo');
				}
				$type = EF_CONSULTER_ZG_GROUPE_VERSION_ID;
				foreach ($tableau_zg_prv as $zg_prv) {
					$param = array( (int)$zg_prv, implode(', ', $tableau_zg_id[$zg_prv]) );
					$tab_zg = $dao_zg->consulter( $type , $param );
					foreach ($tab_zg as $une_zg) {
						$id = $une_zg->getId('zone_geo').'-'.$zg_prv;
						$tableau_zg[$id]['code'] = $une_zg->getCode();
						//echo $une_zg->getCode().'|';
						$tableau_dep_taxons[$une_zg->getCode()] = $aso_legende[10]['couleur'];
						// Nouveau système : classe Cartographie
						$tab_zones[$une_zg->getCode()] = array(	'nom' => $une_zg->getIntitulePrincipal(),
											 					'rvb_fond'	=> $une_zg->getCouleurRvb(),
											 					'rvb_carte'	=> $aso_legende[10]['rvb']);
					}
				}
				
				// +---------------------------------------------------------------------------------------------------+
				// Gestion de la présence du taxon sur la zone géo
				$tab_retour['projet_id'] = $tab_id_projet_donnee_choro[0];
				$tableau_cd_id = array();
				$tableau_cd_prv = array();
				$tableau_ci_zg = array();
				$type = EF_CONSULTER_CD_VERSION_CHORO_TAXON;
				$param = array($tab_id_projet_donnee_choro[0], (int)$_SESSION['nt'], (int)$_SESSION['nvp']);
				$tab_cd = $dao_cd->consulter( $type, $param );		
				//echo '<pre>'.print_r($tab_cd, true).'</pre>';
				if (isset($tab_cd[0]) && is_object($tab_cd[0])) {
					foreach($tab_cd as $une_cd) {
						// Ajout des différentes version de projets de donnée choro dans un tableau
						if (!isset($tableau_cd_prv[$une_cd->getId('version_projet_donnee_choro')])) {
							$tableau_cd_prv[$une_cd->getId('version_projet_donnee_choro')] = array();
						}
						// Ajout des différents id de donnée choro
						$tableau_cd_prv[$une_cd->getId('version_projet_donnee_choro')][$une_cd->getId('donnee_choro')] = $une_cd->getCe('zone_geo').'-'.$une_cd->getCe('version_projet_zg');
					}
					
					$type = EF_CONSULTER_CI_GROUPE_DONNEE_VERSION_ID;
					foreach ($tableau_cd_prv as $cd_prv => $tableau_cd_id) {
						$param = array( (int)$cd_prv, implode(', ', array_keys($tableau_cd_id)) );
						$tab_ci = $dao_ci->consulter( $type , $param );
						foreach($tab_ci as $une_ci) {
							switch ($une_ci->getCe('version_projet_notion_choro')) {
								case EF_PRV_NOTION_CHORO_DEFAUT_ID :
									$id_zg = strtoupper($tableau_zg[$tableau_cd_id[$une_ci->getCe('donnee_choro')]]['code']);
									break;
								default :
									$id_zg = $tableau_zg[$tableau_cd_id[$une_ci->getCe('donnee_choro')]]['code'];
							}
							//echo $id_zg.'|';
							$tableau_dep_taxons[$id_zg] = $aso_legende[$une_ci->getCe('notion_choro')]['couleur'];
							// Nouveau système : classe Cartographie
							$tab_zones[$id_zg]['rvb_carte'] = $aso_legende[$une_ci->getCe('notion_choro')]['rvb'];
						}
					}
				} else {
				// Affichage de la carte dans tous les cas.
				//	$tab_retour['carto_bool'] = false;
				}
				//echo '<pre>'.print_r($tableau_dep_taxons, true).'</pre>';
			}
			
			// +-------------------------------------------------------------------------------------------------------+
			// Gestion de la carto
			if ($tab_retour['carto_bool'] == true) {
				if ($_SESSION['nvp'] == 26 || $_SESSION['nvp'] == 38) {
					// Définition du fichier contenant le fond de carte
					if (isset($parametres['carte'])) {
						$fichier_carte_fond = $parametres['carte'];
					} else {
						$fichier_carte_fond = 'europe.png';
					}

					// Définition du nom de la carte
					$type_carte = str_replace('.png', '', $fichier_carte_fond); 
					$nom_carte = $type_carte.'_'.$_SESSION['cpr'].'_'.$_SESSION['cprv'].'_nt'.$_SESSION['nt'].'.png';
								
					// Nous créons un nouvel objet carte.
					$CarteEurope = new Cartographie();
		
					// Nous définissons la formule de coloriage de la carte
					$CarteEurope->setFormuleColoriage('legende');
					// Nous définissons le fichier contenant le fond de carte
					$CarteEurope->setCarteFondFichier($fichier_carte_fond);
					// Nous définissons le dossier contenant les fonds de carte
					$CarteEurope->setCarteFondDossier(EF_CHEMIN_CARTE_SRC);
					// Nous définissons le fichier contenant le fond de carte
					$CarteEurope->setCarteStockageDossier(EF_CHEMIN_CARTE_STOCKAGE);
					// Nous définissons le fichier contenant les informations sur les zones géographiques
					$CarteEurope->setCarteZoneInfo($tab_zones);
					// Lancement de la création de la carte
					$CarteEurope->creerCarte($nom_carte);
					
					$tab_retour['carte_france'] = sprintf(EF_URL_CARTO, $nom_carte);
				} else if ($_SESSION['nvp'] == 29) {
					// Instanciation du tableau contenant les infos sur la table des zones géo.
					$info_table_zg['nom_table_zone'] = CD_BD_TABLE;
					$info_table_zg['nom_chp_id_zone'] = CD_ID;
					$info_table_zg['nom_chp_nom_zone'] = CD_NOM;
					$info_table_zg['nom_chp_rouge'] = CD_R;
					$info_table_zg['nom_chp_vert'] = CD_V;
					$info_table_zg['nom_chp_bleu'] = CD_B;
					$info_table_zg['nom_chp_zone_sup'] = '';
					$info_table_zg['tableau_valeurs_zone'] = $tableau_dep_taxons;
					
					// Instanciation du tableau contenant les champs de la table action
					$info_table_action = array();
								
					// Création d'une variable contenant l'intitulé du type de fichier carte
					$type_carte = '';
					
					// Définition de fichiers
					if (isset($parametres['carte_masque'])) {
						$fichier_carte_fr_dpt_masque = $parametres['carte_masque'];
					} else {
						$fichier_carte_fr_dpt_masque = 'mascareignes_masque.png';
					}
					if (isset($parametres['carte'])) {
						$fichier_carte_fr_dpt = $parametres['carte'];
					} else {
						$fichier_carte_fr_dpt = 'mascareignes.png';
					}
					$type_carte = str_replace('.png', '', $fichier_carte_fr_dpt);
								
					//Nous créons un nouvel objet carte.
					$france = new Carto_Carte(  'france', 'fr', 'Mascareignes', $fichier_carte_fr_dpt_masque, $fichier_carte_fr_dpt, 
					                            EF_CHEMIN_CARTE_SRC, $info_table_zg, $info_table_action);
		
					//Les valeurs de coordonnées x et y du clic sur l'image, sont renvoyée automatiquement par le formulaire de la carte.
					//A la première exécution du script ces variables sont vides.
					if (isset($image_x)) {
						$france->image_x = $image_x;
					}
					if (isset($image_y)) {
						$france->image_y = $image_y;
					}
					// Inutile dans notre cas :
					$france->historique_cartes = '';
					$france->liste_zone_carte = array();
					$france->url = '#';
					
					//Nous définissons les couleurs de la carte:
					$france->definirFormuleColoriage('legende');;
					$france->definirCouleurs($aso_legende[0]['couleur']['R'], $aso_legende[0]['couleur']['V'], $aso_legende[0]['couleur']['B']);
					
					// +-----------------------------------------------------------------------------------------------+
					// Gestion de la création de la CARTE
					$nom_carte = $type_carte.'_'.$_SESSION['cpr'].'_'.$_SESSION['cprv'].'_nt'.$_SESSION['nt'].'.png';
					$france->creerCarte($nom_carte);
					$tab_retour['carte_france'] = sprintf(EF_URL_CARTO, $nom_carte);
				} else if ($_SESSION['nvp'] == 32) {
					// Instanciation du tableau contenant les infos sur la table des zones géo.
					$info_table_zg['nom_table_zone'] = 'carto_PAYS ';
					$info_table_zg['nom_chp_id_zone'] = 'CP_ID_Pays';
					$info_table_zg['nom_chp_nom_zone'] = 'CP_Intitule_pays';
					$info_table_zg['nom_chp_rouge'] = 'CP_Couleur_R';
					$info_table_zg['nom_chp_vert'] = 'CP_Couleur_V';
					$info_table_zg['nom_chp_bleu'] = 'CP_Couleur_B';
					$info_table_zg['nom_chp_zone_sup'] = 'CP_ID_Continent';
					$info_table_zg['tableau_valeurs_zone'] = $tableau_dep_taxons;
				
					// Instanciation du tableau contenant les champs de la table action
					$info_table_action = array();
								
					// Création d'une variable contenant l'intitulé du type de fichier carte
					$type_carte = '';
					
					// Définition de fichiers
					if (isset($parametres['carte_masque'])) {
						$fichier_carte_fr_dpt_masque = $parametres['carte_masque'];
					} else {
						$fichier_carte_fr_dpt_masque = 'afrique_masque.png';
					}
					if (isset($parametres['carte'])) {
						$fichier_carte_fr_dpt = $parametres['carte'];
					} else {
						$fichier_carte_fr_dpt = 'afrique.png';
					}
					
					$type_carte = str_replace('.png', '', $fichier_carte_fr_dpt);
								
					//Nous créons un nouvel objet carte.
					$france = new Carto_Carte(  'afrique', '1', 'Afrique', $fichier_carte_fr_dpt_masque, $fichier_carte_fr_dpt, 
					                            EF_CHEMIN_CARTE_SRC, $info_table_zg, $info_table_action);
		
					//Les valeurs de coordonnées x et y du clic sur l'image, sont renvoyée automatiquement par le formulaire de la carte.
					//A la première exécution du script ces variables sont vides.
					if (isset($image_x)) {
						$france->image_x = $image_x;
					}
					if (isset($image_y)) {
						$france->image_y = $image_y;
					}
					// Inutile dans notre cas :
					$france->historique_cartes = '';
					$france->liste_zone_carte = array();
					$france->url = '#';
					
					//Nous définissons les couleurs de la carte:
					$france->definirFormuleColoriage('legende');;
					$france->definirCouleurs($aso_legende[0]['couleur']['R'], $aso_legende[0]['couleur']['V'], $aso_legende[0]['couleur']['B']);
					
					// +-----------------------------------------------------------------------------------------------+
					// Gestion de la création de la CARTE
					$nom_carte = $type_carte.'_'.$_SESSION['cpr'].'_'.$_SESSION['cprv'].'_nt'.$_SESSION['nt'].'.png';
					$france->creerCarte($nom_carte);
					$tab_retour['carte_france'] = sprintf(EF_URL_CARTO, $nom_carte);
				} else {
					// Instanciation du tableau contenant les infos sur la table des zones géo.
					$info_table_zg['nom_table_zone'] = CD_BD_TABLE;
					$info_table_zg['nom_chp_id_zone'] = CD_ID;
					$info_table_zg['nom_chp_nom_zone'] = CD_NOM;
					$info_table_zg['nom_chp_rouge'] = CD_R;
					$info_table_zg['nom_chp_vert'] = CD_V;
					$info_table_zg['nom_chp_bleu'] = CD_B;
					$info_table_zg['nom_chp_zone_sup'] = CD_PAYS;
					$info_table_zg['tableau_valeurs_zone'] = $tableau_dep_taxons;
					
					// Instanciation du tableau contenant les champs de la table action
					$info_table_action = array();
								
					// Création d'une variable contenant l'intitulé du type de fichier carte
					$type_carte = '';
					
					// Définition de fichiers
					if (isset($parametres['carte_masque'])) {
						$fichier_carte_fr_dpt_masque = $parametres['carte_masque'];
					} else {
						$fichier_carte_fr_dpt_masque = 'france_masque.png';
					}
					if (isset($parametres['carte'])) {
						$fichier_carte_fr_dpt = $parametres['carte'];
					} else {
						$fichier_carte_fr_dpt = 'france.png';
					}
					$type_carte = str_replace('.png', '', $fichier_carte_fr_dpt);
								
					//Nous créons un nouvel objet carte.
					$france = new Carto_Carte(  'france', 'fr', 'France', $fichier_carte_fr_dpt_masque, $fichier_carte_fr_dpt, 
					                            EF_CHEMIN_CARTE_SRC, $info_table_zg, $info_table_action);
		
					//Les valeurs de coordonnées x et y du clic sur l'image, sont renvoyée automatiquement par le formulaire de la carte.
					//A la première exécution du script ces variables sont vides.
					if (isset($image_x)) {
						$france->image_x = $image_x;
					}
					if (isset($image_y)) {
						$france->image_y = $image_y;
					}
					// Inutile dans notre cas :
					$france->historique_cartes = '';
					$france->liste_zone_carte = array();
					$france->url = '#';
					
					//Nous définissons les couleurs de la carte:
					$france->definirFormuleColoriage('legende');;
					$france->definirCouleurs($aso_legende[0]['couleur']['R'], $aso_legende[0]['couleur']['V'], $aso_legende[0]['couleur']['B']);
					
					// +-----------------------------------------------------------------------------------------------+
					// Gestion de la création de la CARTE
					$nom_carte = $type_carte.'_'.$_SESSION['cpr'].'_'.$_SESSION['cprv'].'_nt'.$_SESSION['nt'].'.png';
					$france->creerCarte($nom_carte);
					$tab_retour['carte_france'] = sprintf(EF_URL_CARTO, $nom_carte);
				}
			}
		}
		
		if ($tab_retour['carto_bool'] == false) {
			// Le taxon est supérieur à l'espèce, ou ne possède pas de données chorologiques, nous n'affichons pas de carte.
			$tab_retour['carto_info'] = 'Cartographie indisponible';
		}
		return $tab_retour;

	}// Fin méthode executer()
	
}// Fin classe ActionChorologie()

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_chorologie.action.php,v $
* Revision 1.34  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.33  2007-06-11 15:32:50  jp_milcent
* Correction problème entre ancienne api et nouvelle version 1.1.1
*
* Revision 1.32  2007-02-12 18:35:30  jp_milcent
* Début utilisation de la nouvelle classe de cartographie.
*
* Revision 1.31  2007/02/07 18:04:44  jp_milcent
* Fusion avec la livraison Moquin-Tandon.
*
* Revision 1.28.2.1  2007/02/07 10:45:45  jp_milcent
* Suppression des messages d'erreurs dû à des variables indéfinies.
*
* Revision 1.30  2007/01/24 17:34:13  jp_milcent
* Ajout du format de rendu pour le moteur de recherche.
*
* Revision 1.29  2007/01/24 17:03:58  jp_milcent
* Ajout de la BDNBE v1.00
*
* Revision 1.28  2007/01/17 17:04:36  jp_milcent
* Correction de la gestion de la chorologie.
* Début simplification.
*
* Revision 1.27  2007/01/15 14:43:56  jp_milcent
* Mise en forme.
*
* Revision 1.26  2007/01/15 14:43:03  jp_milcent
* Fusion AFN et BDNFM.
*
* Revision 1.25  2007/01/15 11:47:10  ddelon
* Carto afrique
*
* Revision 1.24  2006/12/18 17:03:55  jp_milcent
* Gestion de la choro pour la BDNFM.
*
* Revision 1.23  2006/10/25 08:15:22  jp_milcent
* Fusion avec la livraison Decaisne.
*
* Revision 1.22.2.5  2006/09/15 10:38:12  jp_milcent
* Changement légende.
*
* Revision 1.22.2.4  2006/09/13 09:22:15  jp_milcent
* Modification de la légende "erreur"
*
* Revision 1.22.2.3  2006/09/12 15:42:07  jp_milcent
* Ajout de la notion "erreur" à la chorologie.
*
* Revision 1.22.2.2  2006/09/06 11:46:36  jp_milcent
* Gestion du code du référentiel pour le titre avant de créer le formulaire de recherche.
* Si on le place après, le référentiel est faux!
*
* Revision 1.22.2.1  2006/08/30 10:06:35  jp_milcent
* Nous utilisons les codes de zones géographiques en majuscule.
*
* Revision 1.22  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.21  2006/05/29 16:11:49  jp_milcent
* Modification interface selon remarque de Daniel du 29 mai 2006.
*
* Revision 1.20  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.19  2006/04/14 12:07:58  jp_milcent
* Modification pour gérer la chorologie de la BDNBE.
*
* Revision 1.17.2.2  2006/04/14 11:56:39  jp_milcent
* Modification pour gérer la chorologie de la BDNBE.
*
* Revision 1.18  2006/04/10 17:22:40  jp_milcent
* Fusion avec la livraison bdnbe_v1.
*
* Revision 1.17.2.1  2006/03/10 14:59:07  jp_milcent
* Modification de la couleur  (en jaune) pour les zones "présence à confirmer".
*
* Revision 1.17  2006/03/03 17:29:17  jp_milcent
* Amélioration de la gestion des variables de session.
* Ajout du nouveau projet indépendant de la BDNFF : BDNBE.
*
* Revision 1.16  2005/12/15 16:01:22  jp_milcent
* Fusion de la branche bdnff_v3_v4 vers la branche principale.
*
* Revision 1.15  2005/12/09 17:29:06  jp_milcent
* Suppression du code inutile!
*
* Revision 1.14  2005/12/05 15:50:27  jp_milcent
* Correction des intitulés de la légende.
*
* Revision 1.13  2005/12/05 15:40:29  jp_milcent
* Si le taxon ne possède pas de données chorologiques, nous affichons un message d'erreur.
*
* Revision 1.12  2005/12/01 11:12:31  jp_milcent
* Utilisation de la constante indiquant le nom de la base de donnée courante d'eFlore pour indiquer les tables de la carto.
*
* Revision 1.11  2005/11/29 10:15:56  jp_milcent
* Amelioration de la gestion de la chorologie.
* Correction bogue grande carte à la place de la petite.
*
* Revision 1.10  2005/11/28 13:57:23  jp_milcent
* Ajout de lignes pour le débogage.
*
* Revision 1.9  2005/11/24 16:01:12  jp_milcent
* Suite correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.8  2005/11/23 18:07:23  jp_milcent
* Début correction des bogues du module Fiche suite à mise en ligne eFlore Beta.
*
* Revision 1.7  2005/10/25 12:50:04  jp_milcent
* Fin amélioration générale.
*
* Revision 1.6  2005/10/20 16:37:49  jp_milcent
* Amélioration de l'onglet Synthèse.
*
* Revision 1.5  2005/10/19 16:46:48  jp_milcent
* Correction de bogue liés à la modification des urls.
*
* Revision 1.4  2005/10/13 08:27:09  jp_milcent
* Ajout d'une mini chorologie sur la page de synthèse.
* Déplacement des constantes de requete sql dans les fichiers de chaque classe DAO.
*
* Revision 1.3  2005/10/11 17:30:31  jp_milcent
* Amélioration gestion de la chorologie en cours.
*
* Revision 1.2  2005/10/05 16:36:35  jp_milcent
* Débu et fin gestion de l'onglet Illustration.
* Amélioration de l'onglet Synthèse avec ajout d'une image.
*
* Revision 1.1  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>