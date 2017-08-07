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
// CVS : $Id: redirection.php,v 1.1.4.1 2007-12-07 10:07:49 alexandre_tb Exp $
/**
* papyrus_bp - redirection.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.1.4.1 $ $Date: 2007-12-07 10:07:49 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'lancerRedirection';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'\{\{[Rr]edirection'.
													'(?:\s*'.
														'(?:'.
															'(url="[^"]*")|'.
														')'.
													')+'.
													'\s*\}\}';

// --------------------------------------------------------------------------------------------------------
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'redirection'.GEN_SEP.'configuration'.GEN_SEP.'redi_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette REDI de Papyrus
if (file_exists(REDI_CHEMIN_LANGUE.'redi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once REDI_CHEMIN_LANGUE.'redi_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once REDI_CHEMIN_LANGUE.'redi_langue_'.REDI_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction lancerRedirection() - Redirige vers une nouvelle URL.
*
* Cette fonction redirige l'utilisateur vers une nouvelle url.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return null on est redirigé.
*/
function lancerRedirection($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
	$sortie = '';
	$GLOBALS['_REDIRECTION_']['erreurs'] = array();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Gestion des arguments
	$balise = $tab_applette_arguments[0];
    $tab_arguments = $tab_applette_arguments;
	unset($tab_arguments[0]);
    foreach($tab_arguments as $argument) {
    	if ($argument != '') {
	    	$tab_parametres = explode('=', $argument,2);
	    	$options[$tab_parametres[0]] = trim($tab_parametres[1], '"');
    	}
    }
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Gestion des erreurs de paramètrage
	if (!isset($options['url'])) {
		$GLOBALS['_REDIRECTION_']['erreurs'][] = sprintf(REDI_LG_ERREUR_URL, $balise);
	}
	if (isset($options['url']) && $options['url'] == '') {
		$GLOBALS['_REDIRECTION_']['erreurs'][] = sprintf(REDI_LG_ERREUR_URL_VIDE, $balise);
	}
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Redirection
    if (count($GLOBALS['_REDIRECTION_']['erreurs']) == 0) {
		$options['url'] = preg_replace('/&amp;/', '&', $options['url']);
		header('Location: '.$options['url']);
		exit();
    } else {
    	//+----------------------------------------------------------------------------------------------------------------+
	    // Extrait les variables et les ajoutes à l'espace de noms local
		// Gestion des squelettes
		extract($GLOBALS['_REDIRECTION_']);
		// Démarre le buffer
		ob_start();
		// Inclusion du fichier
		include(REDI_CHEMIN_SQUELETTE.REDI_SQUELETTE_PRINCIPAL);
		// Récupérer le  contenu du buffer
		$sortie = ob_get_contents();
		// Arrête et détruit le buffer
		ob_end_clean();
		
		//+----------------------------------------------------------------------------------------------------------------+
		// Sortie
	    return $sortie;
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: redirection.php,v $
* Revision 1.1.4.1  2007-12-07 10:07:49  alexandre_tb
* correction du bug quand l'url destination comprend des =
*
* Revision 1.1  2006/12/13 10:52:30  jp_milcent
* Ajout de l'applette Rediection.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
