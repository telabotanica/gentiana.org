<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of papyrus_bp.                                                                         |
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
// CVS : $Id: nouveaute.php,v 1.3 2006-12-13 09:27:42 jp_milcent Exp $
/**
* papyrus_bp - nouveaute.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.3 $ $Date: 2006-12-13 09:27:42 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherNouveaute';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'\{\{[Nn]ouveaute'.
													'(?:\s*'.
														'(?:'.
															'(nombre="[^"]+")|'.
															'(categorie="[^"]+")|'.
															'(type="[^"]+")|'.
															'(site="[^"]+")|'.
														')'.
													')+'.
													'\s*\}\}';

// --------------------------------------------------------------------------------------------------------
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'nouveaute'.GEN_SEP.'configuration'.GEN_SEP.'nouv_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette NOUV de Papyrus
if (file_exists(NOUV_CHEMIN_LANGUE.'nouv_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once NOUV_CHEMIN_LANGUE.'nouv_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once NOUV_CHEMIN_LANGUE.'nouv_langue_'.NOUV_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherNouveaute() - Retourne la liste des pages modifiées récement.
*
* Cette fonction retourne la liste des pages modifiées récement.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string HTML la liste de menus.
*/
function afficherNouveaute($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_NOUVEAUTE_']['erreurs'] = array();
	$GLOBALS['_NOUVEAUTE_']['informations'] = array();
	$GLOBALS['_NOUVEAUTE_']['pages'] = array();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Gestion des arguments
	$balise = $tab_applette_arguments[0];
    $tab_arguments = $tab_applette_arguments;
	unset($tab_arguments[0]);
    foreach($tab_arguments as $argument) {
    	if ($argument != '') {
	    	$tab_parametres = explode('=', $argument);
	    	$options[$tab_parametres[0]] = trim($tab_parametres[1], '"');
    	}
    }
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Gestion des erreurs de paramètrage
	if (!isset($options['nombre'])) {
		$GLOBALS['_NOUVEAUTE_']['erreurs'][] = sprintf(NOUV_LG_ERREUR_NOMBRE, $balise);
	}
	if (!isset($options['type'])) {
		$options['type'] = '';
	}
	if (isset($options['type']) && $options['type'] != '' && $options['type'] != 'mineure' && $options['type'] != 'majeure') {
		$GLOBALS['_NOUVEAUTE_']['erreurs'][] = sprintf(NOUV_LG_ERREUR_TYPE, $balise);
	} else {
		if ($options['type'] == 'mineure') {
			$options['type'] = 1;
		} else if ($options['type'] == 'majeure') {
			$options['type'] = 2;
		}
	}
	if (!isset($options['site'])) {
		$options['site'] = '';
	}
	if (!isset($options['categorie'])) {
		$options['categorie'] = '';
	}
	
    //+----------------------------------------------------------------------------------------------------------------+
    // Récupération des données
    if (count($GLOBALS['_NOUVEAUTE_']['erreurs']) == 0) {
		$aso_info_menu = GEN_lireInfoMenuContenuDate($GLOBALS['_GEN_commun']['pear_db'], $options['type'], $options['site'], $options['categorie']);
		if (count($aso_info_menu) == 0) {
			$GLOBALS['_NOUVEAUTE_']['informations'][] = sprintf(NOUV_LG_INFO_ZERO_PAGE, $options['mots']);
		} else {
			$i = 0;
			foreach ($aso_info_menu as $id_menu => $un_menu) {
				// On stope l'affichage si le nombre de nouveauté demandé est atteint.
				if ($i == $options['nombre']) {
					break;
				} else {
					$i++;
				}
				
		        // Initialisation
		        $aso_page = array();
				$aso_page['url'] = NOUV_LG_INCONNU_URL;
				$aso_page['auteur'] = NOUV_LG_INCONNU_AUTEUR;
				$aso_page['contributeur'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['titre'] = NOUV_LG_INCONNU_TITRE;
				$aso_page['heure'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['minute'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['seconde'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['jours'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['mois'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['annee'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['description'] = NOUV_LG_INCONNU_GENERAL;
				$aso_page['resumer'] = NOUV_LG_INCONNU_GENERAL;
				
				// Création de l'url
				$une_url = new Pap_URL();
				$une_url->setId($id_menu);
		        $aso_page['url'] = $une_url->getURL();
	
		        // Affichage du type de modification de la page 
		        if ($un_menu->gmc_ce_type_modification = 1) {
	                $aso_page['type'] = 'mineure';
	            } elseif ($un_menu->gmc_ce_type_modification = 2) {
	                $aso_page['type'] = 'majeure';
	            }
	            
		        // Affichage de l'auteur(s)
		        if ($un_menu->gm_auteur != '') {
		        	$aso_page['auteur'] = $un_menu->gm_auteur;
		    	}
		        
		        // Affichage des contributeur(s)
				if (!empty($un_menu->gm_contributeur)) {
					$sortie .= '<dt class="page_contributeur"> Contributeur(s)&nbsp;: '.'</dt>'."\n";
					$sortie .= '<dd>'.$un_menu->gm_contributeur.'</dd>'."\n";
					$aso_page['contributeur'] = $un_menu->gm_contributeur;
				}
	            
		        // Affichage du titre
				if (!empty($un_menu->gm_titre)) {
	                $aso_page['titre'] = $un_menu->gm_titre;
	            } elseif (!empty($un_menu->gm_titre_alternatif)) {
	                $aso_page['titre'] = $un_menu->gm_titre_alternatif;
	            } else {
	                $aso_page['titre'] = $un_menu->gm_nom;
	            }
	            
		        // Affichage de l'horaire de la création de la page
				if (($heure = date('G', strtotime($un_menu->gm_date_creation)) ) != 0 ) {
					$aso_page['heure'] = $heure;
					$minute = date('i', strtotime($un_menu->gm_date_creation));
					$aso_page['minute'] = $minute;
					if (($seconde = date('s', strtotime($un_menu->gm_date_creation)) ) != 0 ) {
						$aso_page['seconde'] = $seconde;
					}
				}
				
				// Affichage de la date de la création de la page
				if (($jour = date('d', strtotime($un_menu->gm_date_creation)) ) != 0 ) {
					$aso_page['jour'] = $jour;
				}
				if (($mois = _traduireMois(date('m', strtotime($un_menu->gm_date_creation))) ) != '' ) {
					$aso_page['mois'] = $mois;
		        }
		        if (($annee = date('Y', strtotime($un_menu->gm_date_creation)) ) != 0 ) {
		            $aso_page['annee'] = $annee;
		        }
	
				// Affichage de la description
				if (!empty($un_menu->gm_description_libre)) {
					$aso_page['decription'] = $un_menu->gm_description_libre;
				}
	            
		        // Affichage du résumé de la modification
		        if (!empty($un_menu->gmc_resume_modification)) {
		        	$aso_page['resumer'] = $un_menu->gmc_resume_modification;
		        }
		        
		        $GLOBALS['_NOUVEAUTE_']['pages'][] = $aso_page;
		    }
		}
    }
    
	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes à l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_NOUVEAUTE_']);
	// Démarre le buffer
	ob_start();
	// Inclusion du fichier
	include(NOUV_CHEMIN_SQUELETTE.NOUV_SQUELETTE_LISTE);
	// Récupérer le  contenu du buffer
	$sortie = ob_get_contents();
	// Arrête et détruit le buffer
	ob_end_clean();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Sortie
    return $sortie;
}

if (!function_exists('_traduireMois')) {
	function _traduireMois($mois_numerique)
	{
	    switch ($mois_numerique) {
	        case '01' :
	            return NOUV_LG_MOIS_01;
	        case '02' :
	            return NOUV_LG_MOIS_02;
	        case '03' :
	            return NOUV_LG_MOIS_03;
	        case '04' :
	            return NOUV_LG_MOIS_04;
	        case '05' :
	            return NOUV_LG_MOIS_05;
	        case '06' :
	            return NOUV_LG_MOIS_06;
	        case '07' :
	            return NOUV_LG_MOIS_07;
	        case '08' :
	            return NOUV_LG_MOIS_08;
	        case '09' :
	            return NOUV_LG_MOIS_09;
	        case '10' :
	            return NOUV_LG_MOIS_10;
	        case '11' :
	            return NOUV_LG_MOIS_11;
	        case '12' :
	            return NOUV_LG_MOIS_12;
	        default:
	            return '';
	    }
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: nouveaute.php,v $
* Revision 1.3  2006-12-13 09:27:42  jp_milcent
* Ajout d'une valeur pour l'url vide.
*
* Revision 1.2  2006/12/13 09:26:44  jp_milcent
* Ajout d'une valeur pour les champs vides.
*
* Revision 1.1  2006/12/12 17:16:22  jp_milcent
* Ajout de l'applette Nouveaute.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
