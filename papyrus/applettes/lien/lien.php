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
// CVS : $Id: lien.php,v 1.1 2006-12-08 20:08:59 jp_milcent Exp $
/**
* papyrus_bp - lien.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.1 $ $Date: 2006-12-08 20:08:59 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherLien';
$GLOBALS['_GEN_commun']['info_applette_balise'] = '\{\{[Ll]ien(?:\s*(?:((?:menu|site)="[^"]+")|(titre="[^"]+")|))+\s*\}\}';

// --------------------------------------------------------------------------------------------------------
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'lien'.GEN_SEP.'configuration'.GEN_SEP.'lien_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette LIEN de Papyrus
if (file_exists(LIEN_CHEMIN_LANGUE.'lien_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once LIEN_CHEMIN_LANGUE.'lien_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once LIEN_CHEMIN_LANGUE.'lien_langue_'.LIEN_I18N_DEFAUT.'.inc.php';
}


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherLien() - Retourne le lien d'un menu ou d'un site.
*
* Cette fonction retourne un lien vers un menu ou un site. Le lien est créé dynamiquement et donc toujours à jour.
* Il est possible d'utiliser les code numérique ou alphanumérique.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string XHTML le lien.
*/
function afficherLien($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_LIEN_']['url'] = '';
	$GLOBALS['_LIEN_']['titre'] = LIEN_LG_ERREUR_TITRE;
    $GLOBALS['_LIEN_']['erreurs'] = array();

	//+----------------------------------------------------------------------------------------------------------------+
	// Gestion des arguments
    $tab_arguments = $tab_applette_arguments;
	unset($tab_arguments[0]);
    foreach($tab_arguments as $argument) {
	    $tab_parametres = explode('=', $argument);
	    $options[$tab_parametres[0]] = trim($tab_parametres[1], '"'); 
    }
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Gestion des erreurs de paramètrage
    if (!isset($options['menu']) && !isset($options['site']) ) {
        $GLOBALS['_LIEN_']['erreur'] = LIEN_LG_ERREUR_SITE_MENU;
    } else {
    	if (isset($options['menu'])) {
    		$niveau = 'menu';
    		$identifiant = $options['menu']; 
    	} else if (isset($options['site'])) {
    		$niveau = 'site';
    		$identifiant = $options['site'];
    	} 
    }

    //+----------------------------------------------------------------------------------------------------------------+
    // Récupération des données
	$bdd =& $GLOBALS['_GEN_commun']['pear_db'];
	$id_langue = $GLOBALS['_GEN_commun']['i18n']; //identifiant de la langue choisie
	if (isset($id_langue) && ($id_langue != '')) {
		$langue_url = $id_langue;
	} else {
		$langue_url = GEN_I18N_ID_DEFAUT;
	}
	$une_url = new Pap_URL();
	// Les sites
	if ($niveau == "site") {
		if (preg_match('/^[0-9]+$/', $identifiant)) {
			$aso_site = GEN_lireInfoSiteI18nCodeAlpha($bdd, GEN_retournerSiteCodeAlpha($bdd, $identifiant), $langue_url, DB_FETCHMODE_ASSOC);
		} else {
			$aso_site = GEN_lireInfoSiteI18nCodeAlpha($bdd, $identifiant, $langue_url, DB_FETCHMODE_ASSOC);
		}
		
        if (isset($options['titre'])) {
        	$GLOBALS['_LIEN_']['titre'] = $options['titre'];
        } else {
        	if (!empty($aso_site['gs_titre'])) {
				$GLOBALS['_LIEN_']['titre'] = $aso_site['gs_titre'];
        	} else {
				$GLOBALS['_LIEN_']['titre'] = $aso_site['gs_nom'];
        	}
        }
    	$une_url->setUrlType('SITE');
    	$une_url->setId($aso_site['gs_id_site']);
	}
	// Les menus
	if ($niveau == "menu") {
		if (preg_match('/^[0-9]+$/', $identifiant)) {
			$aso_menu = GEN_lireInfoMenu($bdd, GEN_retournerIdMenuParCodeNum($bdd, $identifiant), DB_FETCHMODE_ASSOC);
		} else {
			$aso_menu = GEN_lireInfoMenu($bdd, GEN_retournerIdMenuParCodeNum($bdd, GEN_retournerMenuCodeNum($bdd, $identifiant)), DB_FETCHMODE_ASSOC);
		}
        if (isset($options['titre'])) {
        	$GLOBALS['_LIEN_']['titre'] = $options['titre'];
        } else {
        	if (!empty($aso_menu['gm_titre'])) {
				$GLOBALS['_LIEN_']['titre'] = $aso_menu['gm_titre'];
            } elseif (!empty($aso_menu['gm_titre_alternatif'])) {
				$GLOBALS['_LIEN_']['titre'] = $aso_menu['gm_titre_alternatif'];
            } elseif (!empty($aso_menu['gm_nom'])) {
				$GLOBALS['_LIEN_']['titre'] = $aso_menu['gm_nom'];
            }
        }
    	$une_url->setId($aso_menu['gm_id_menu']);
    }
	    
	if ($langue_url != GEN_I18N_ID_DEFAUT) {
		$une_url->addQueryString(GEN_URL_CLE_I18N, $langue_url);
	} 
	$GLOBALS['_LIEN_']['url'] = $une_url->getURL();
	$GLOBALS['_LIEN_']['titre'] = htmlentities($GLOBALS['_LIEN_']['titre']);
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes à l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_LIEN_']);
	// Démarre le buffer
	ob_start();
	// Inclusion du fichier
	include(LIEN_CHEMIN_SQUELETTE.LIEN_SQUELETTE_LISTE);
	// Récupérer le  contenu du buffer
	$sortie = ob_get_contents();
	// Arrête et détruit le buffer
	ob_end_clean();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Sortie
    return $sortie;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: lien.php,v $
* Revision 1.1  2006-12-08 20:08:59  jp_milcent
* Ajout de l'apllette Lien.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
