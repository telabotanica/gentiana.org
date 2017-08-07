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
// CVS : $Id: mot_cles.php,v 1.2 2006-12-12 17:17:12 jp_milcent Exp $
/**
* papyrus_bp - mot_cles.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.2 $ $Date: 2006-12-12 17:17:12 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherMotCles';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'\{\{[Mm]otCles'.
													'(?:\s*'.
														'(?:'.
															'(mots="[^"]+")|'.
															'(categorie="[^"]+")|'.
															'(condition="(?i:et|ou)")|'.
															'(mots_condition="(?i:et|ou)")|'.
															'(categorie_condition="(?i:et|ou)")|'.
															'(ordre="(?i:asc|desc)")|'.
														')'.
													')+'.
													'\s*\}\}';

// --------------------------------------------------------------------------------------------------------
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'mot_cles'.GEN_SEP.'configuration'.GEN_SEP.'mocl_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette MOCL de Papyrus
if (file_exists(MOCL_CHEMIN_LANGUE.'mocl_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once MOCL_CHEMIN_LANGUE.'mocl_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once MOCL_CHEMIN_LANGUE.'mocl_langue_'.MOCL_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherMotCles() - Retourne la liste des pages pour un mot clés donné.
*
* Cette fonction retourne la liste des pages pour un mot clés donné.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string HTML la liste des listes de menus.
*/
function afficherMotCles($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_MOT_CLES_']['erreurs'] = array();
	$GLOBALS['_MOT_CLES_']['informations'] = array();
	$GLOBALS['_MOT_CLES_']['pages'] = array();
	
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
	if (!isset($options['mots'])) {
		$GLOBALS['_MOT_CLES_']['erreurs'][] = MOCL_LG_ERREUR_MOTS;
	}
	if (!isset($options['categorie']) && isset($options['categorie_condition'])) {
		$GLOBALS['_MOT_CLES_']['erreurs'][] = sprintf(MOCL_LG_ERREUR_MOTS_CATEG, $balise);
	}
	if (!isset($options['categorie'])) {
		$options['categorie'] = '';
	}
    // Les conditions étant écrites en français, ce qui suit les traduit, "et" devient "AND" etc.
	$tab_condition_type = array('condition', 'mots_condition', 'categorie_condition');
	foreach ($tab_condition_type as $type) {
		if (isset($options[$type])) {
			if (strtolower($options[$type]) == 'et') {
				$options[$type] = 'AND';
			} elseif (strtolower($options[$type]) == 'ou') {
				$options[$type] = 'OR';
			}
		}
	}
	if (!isset($options['mots_condition']) && isset($options['condition'])) {
		$options['mots_condition'] = $options['condition'];
	}
	if (!isset($options['categorie_condition']) && isset($options['condition'])) {
		$options['categorie_condition'] = $options['condition'];
	}
	if (!isset($options['categorie_condition']) && !isset($options['condition']) && isset($options['mots_condition'])) {
		$options['categorie_condition'] = $options['mots_condition'];
	}
	if (!isset($options['ordre'])) {
		$options['ordre'] = 'ASC';
	}
	
    //+----------------------------------------------------------------------------------------------------------------+
    // Récupération des données
    // Récupération des infos sur les mots
	$tab_mots = explode(',', $options['mots']);
	for ($i = 0; $i < count($tab_mots); $i++) {
		// Suppression des espaces, tabulations... en début et fin de chaine
		$tab_mots[$i] = trim($tab_mots[$i]);
	}
	
	// Récupération des infos sur les catégories
	$tab_cat = explode(',', $options['categorie']) ;
	for ($i = 0; $i < count($tab_cat); $i++) {
		// Suppression des espaces, tabulations... en début et fin de chaine
		$tab_cat[$i] = trim($tab_cat[$i]);
	}
		
	$aso_info_menu = GEN_lireInfoMenuMeta($GLOBALS['_GEN_commun']['pear_db'], $tab_mots, $tab_cat, $options['mots_condition'], $options['categorie_condition'], $options['ordre']);
	if (count($aso_info_menu) == 0) {
		$GLOBALS['_MOT_CLES_']['informations'][] = sprintf(CATEG_LG_INFO_ZERO_PAGE, $options['mots']);
	} else {
		foreach ($aso_info_menu as $id_menu => $un_menu) {
	        // Initialisation
	        $aso_page = array();
			$aso_page['url'] = '#';
			$aso_page['auteur'] = MOCL_LG_INCONNU_AUTEUR;
			$aso_page['titre'] = MOCL_LG_INCONNU_TITRE;
			$aso_page['heure'] = '';
			$aso_page['minute'] = '';
			$aso_page['seconde'] = '';
			$aso_page['jours'] = '';
			$aso_page['mois'] = '';
			$aso_page['annee'] = '';
			
			// Création de l'url
			$une_url = new Pap_URL();
			$une_url->setId($id_menu);
	        $aso_page['url'] = $une_url->getURL();
	        
	        // Affichage de l'auteur(s)
	        if ($un_menu->gm_auteur != '') {
	        	$aso_page['auteur'] = $un_menu->gm_auteur;
	    	}
	        
	        // Affichage du titre
	        if ($un_menu->gm_titre != '') {
				$aso_page['titre'] = $un_menu->gm_titre;
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
	        $GLOBALS['_MOT_CLES_']['pages'][] = $aso_page;
	    }
	}

	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes à l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_MOT_CLES_']);
	// Démarre le buffer
	ob_start();
	// Inclusion du fichier
	include(MOCL_CHEMIN_SQUELETTE.MOCL_SQUELETTE_LISTE);
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
	            return MOCL_LG_MOIS_01;
	        case '02' :
	            return MOCL_LG_MOIS_02;
	        case '03' :
	            return MOCL_LG_MOIS_03;
	        case '04' :
	            return MOCL_LG_MOIS_04;
	        case '05' :
	            return MOCL_LG_MOIS_05;
	        case '06' :
	            return MOCL_LG_MOIS_06;
	        case '07' :
	            return MOCL_LG_MOIS_07;
	        case '08' :
	            return MOCL_LG_MOIS_08;
	        case '09' :
	            return MOCL_LG_MOIS_09;
	        case '10' :
	            return MOCL_LG_MOIS_10;
	        case '11' :
	            return MOCL_LG_MOIS_11;
	        case '12' :
	            return MOCL_LG_MOIS_12;
	        default:
	            return '';
	    }
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: mot_cles.php,v $
* Revision 1.2  2006-12-12 17:17:12  jp_milcent
* Correction de l'expression régulière.
*
* Revision 1.1  2006/12/12 13:32:27  jp_milcent
* Ajout de l'applette MotCles.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
