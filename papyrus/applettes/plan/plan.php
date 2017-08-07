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
// CVS : $Id: plan.php,v 1.2 2006-12-13 10:53:36 jp_milcent Exp $
/**
* papyrus_bp - plan.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.2 $ $Date: 2006-12-13 10:53:36 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherPlan';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'\{\{[Pp]lan'.
													'(?:\s*'.
														'(?:'.
															'(site="[^"]*")|'.
															'(permalien="[^"]*")|'.
														')'.
													')+'.
													'\s*\}\}';

// --------------------------------------------------------------------------------------------------------
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'plan'.GEN_SEP.'configuration'.GEN_SEP.'plan_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette PLAN de Papyrus
if (file_exists(PLAN_CHEMIN_LANGUE.'plan_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once PLAN_CHEMIN_LANGUE.'plan_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once PLAN_CHEMIN_LANGUE.'plan_langue_'.PLAN_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherPlan() - Retourne la liste des pages du plan d'un site.
*
* Cette fonction retourne la liste des pages du plan d'un site.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string HTML la liste de menus.
*/
function afficherPlan($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_PLAN_']['erreurs'] = array();
	$GLOBALS['_PLAN_']['informations'] = array();
	$GLOBALS['_PLAN_']['sites'] = array();
	
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
	if (!isset($options['site'])) {
		$GLOBALS['_PLAN_']['erreurs'][] = sprintf(PLAN_LG_ERREUR_SITE, $balise);
	}
	if (!isset($options['permalien'])) {
		$options['permalien'] = false;
	}
	if (isset($options['permalien']) && $options['permalien'] != '' && $options['permalien'] != 'oui' && $options['permalien'] != 'non') {
		$GLOBALS['_PLAN_']['erreurs'][] = sprintf(PLAN_LG_ERREUR_PERMALIEN, $balise);
	} else {
		if ($options['permalien'] == 'oui') {
			$options['permalien'] = true;
		} else if ($options['permalien'] == 'non') {
			$options['permalien'] = false;
		}
	}
    
    //+----------------------------------------------------------------------------------------------------------------+
    // Récupération des données
    if (count($GLOBALS['_PLAN_']['erreurs']) == 0) {
		$tab_site = array_map('trim', explode(',', $options['site']));
		if (count($tab_site) == 0) {
			$GLOBALS['_PLAN_']['informations'][] = sprintf(PLAN_LG_INFO_ZERO_PAGE, $options['site']);
		} else {			
			foreach ($tab_site as $cle => $site) {
				$aso_site_info = GEN_lireInfoSitePrincipalCodeAlpha($GLOBALS['_GEN_commun']['pear_db'], $site, DB_FETCHMODE_ASSOC);
				$aso_site['abreviation'] = $site; 
				if (!empty($aso_site_info['gs_titre'])) {
					$titre = $aso_site_info['gs_titre'];
				} else {
					$titre = $aso_site_info['gs_nom'];
				}
				$aso_site['titre'] = htmlentities($titre);

				$url_site = new Pap_URL();
				$url_site->setUrlType('SITE');
				$url_site->setId($aso_site_info['gs_id_site']);
				$aso_site['url'] = $url_site->getUrl();

				$aso_menus = GEN_retournerTableauMenusSiteCodeAlpha($GLOBALS['_GEN_commun']['pear_db'], $site);
				$aso_site['pages'] = parserTableauMenus($aso_menus, $options['permalien']);
				$GLOBALS['_PLAN_']['sites'][] = $aso_site;
			}
		}
    }
    
	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes à l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_PLAN_']);
	// Démarre le buffer
	ob_start();
	// Inclusion du fichier
	include(PLAN_CHEMIN_SQUELETTE.PLAN_SQUELETTE_LISTE);
	// Récupérer le  contenu du buffer
	$sortie = ob_get_contents();
	// Arrête et détruit le buffer
	ob_end_clean();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Sortie
    return $sortie;
}

function parserTableauMenus($aso_menus, $permalien)
{
    $aso_arbo_site = array();
    foreach ($aso_menus as $menu_id => $menu_valeur) {
        if (    $menu_valeur['gm_date_fin_validite'] == '' 
                || $menu_valeur['gm_date_fin_validite'] == '0000-00-00 00:00:00' 
                || strtotime($menu_valeur['gm_date_fin_validite']) > time()) {
			// Initialisation
			$aso_page = array();
			$aso_page['url'] = PLAN_LG_INCONNU_URL;
			$aso_page['nom'] = PLAN_LG_INCONNU_NOM;
			$aso_page['titre'] = PLAN_LG_INCONNU_TITRE;
			$aso_page['sous_menus'] = 'fermer';

			// Création de l'url
			$une_url = new Pap_URL();
			$une_url->setId($menu_id);
			$aso_page['url'] = $une_url->getURL();
            
			// Construction de l'attribut title
			$title = '';
			if (!empty($menu_valeur['gm_titre'])) {
				$title = $menu_valeur['gm_titre'];
			} elseif (!empty($menu_valeur['gm_titre_alternatif'])) {
				$title = $menu_valeur['gm_titre_alternatif'];
			}
			$aso_page['titre'] = htmlentities($title);
			
			// Le nom
			$aso_page['nom'] = htmlentities($menu_valeur['gm_nom']);
			
			// Nous affichons ou pas le permalien
			if ($permalien) {
				$une_url->setPermalienBool(true);
				$aso_page['permalien_url'] = $une_url->getURL();
				$aso_page['permalien_nom'] = $une_url->getPermalien();
				$une_url->setPermalienBool(false);
			}
			
			// Nous ajoutons les sous-menus s'il y en a.
			$retour = parserTableauMenus($menu_valeur['sous_menus'], $permalien);
			if (count($retour) != 0) {
				$aso_page['sous_menus'] = 'ouvrir_liste';
				$aso_arbo_site[] = $aso_page;
				$aso_arbo_site = array_merge($aso_arbo_site, $retour);
				$aso_arbo_site[]['sous_menus'] = 'fermer_liste';
			} else {
				$aso_arbo_site[] = $aso_page;
			}
		}
	}
	return $aso_arbo_site;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: plan.php,v $
* Revision 1.2  2006-12-13 10:53:36  jp_milcent
* Correction dans la gestion des erreurs.
*
* Revision 1.1  2006/12/13 09:42:39  jp_milcent
* Ajout de l'applette Plan.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
