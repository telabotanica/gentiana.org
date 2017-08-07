<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Ce logiciel est un programme informatique servant � g�rer du contenu et des applications web.        |                                                                           |
// |                                                                                                      |
// | Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et respectant les principes de  | 
// | diffusion des logiciels libres. Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous  |
// | les conditions de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA sur le site    |
// | "http://www.cecill.info".                                                                            |
// |                                                                                                      |
// | En contrepartie de l'accessibilit� au code source et des droits de copie, de modification et de      |
// | redistribution accord�s par cette licence, il n'est offert aux utilisateurs qu'une garantie limit�e. |
// | Pour les m�mes raisons, seule une responsabilit� restreinte p�se sur l'auteur du programme, le       |
// | titulaire des droits patrimoniaux et les conc�dants successifs.                                      |
// |                                                                                                      |
// | A cet �gard l'attention de l'utilisateur est attir�e sur les risques associ�s au chargement, �       |
// | l'utilisation,  � la modification et/ou au d�veloppement et � la reproduction du logiciel par        |
// | l'utilisateur �tant donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � manipuler  |
// | et qui le r�serve donc � des d�veloppeurs et des professionnels avertis poss�dant des connaissances  |
// | informatiques approfondies. Les utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation   |
// | du logiciel � leurs besoins dans des conditions permettant d'assurer la s�curit� de leurs syst�mes   | 
// | et ou de leurs donn�es et, plus g�n�ralement, � l'utiliser et l'exploiter dans les m�mes conditions  |
// | de s�curit�.                                                                                         |
// |                                                                                                      |
// | Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez pris connaissance de la       |
// | licence CeCILL, et que vous en avez accept� les termes.                                              |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: inclure.php,v 1.4 2007-08-28 14:23:55 jp_milcent Exp $
/**
* Applette : Inclure
*
* Retourne toutes les pages Papyrus appartenant � une cat�gorie donn�e.
*
*@package Applette
*@subpackage Inclure
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.4 $ $Date: 2007-08-28 14:23:55 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherInclure';
$GLOBALS['_GEN_commun']['info_applette_balise'] = '\{\{[Ii]nclure(?:\s*(?:(page="[^"]+")|(interwiki="[^"]+")|))+\s*\}\}';

// --------------------------------------------------------------------------------------------------------
//Utilisation de la biblioth�que Papyrus pap_meta.fonct.php inclue par Papyrus
//Utilisation de la biblioth�que PEAR NET_URL inclue par Papyrus
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'inclure'.GEN_SEP.'configuration'.GEN_SEP.'incl_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette CATEG de Papyrus
if (file_exists(INCL_CHEMIN_LANGUE.'incl_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite � la transaction avec le navigateur.*/
    require_once INCL_CHEMIN_LANGUE.'incl_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par d�faut.*/
    require_once INCL_CHEMIN_LANGUE.'incl_langue_'.INCL_I18N_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherInclure() - Retourne la liste des pages d'une cat�gorie.
*
* Cette fonction retourne la liste des pages appartenant � une cat�gorie donn�e.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string HTML la liste des listes de menus.
*/
function afficherInclure($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_INCLURE_']['informations'] = array();
	$GLOBALS['_INCLURE_']['erreurs'] = array();
	
    //+----------------------------------------------------------------------------------------------------------------+
	// Gestion des arguments
	$tab_arguments = $tab_applette_arguments;
	unset($tab_arguments[0]);
	foreach($tab_arguments as $argument) {
	    $tab_parametres = explode('=', $argument);
	    if ($tab_parametres[0] != '' && $tab_parametres[1] != '') {
	    	$options[$tab_parametres[0]] = trim($tab_parametres[1], '"');
	    } 
    }

	//+----------------------------------------------------------------------------------------------------------------+
    // Gestion des erreurs de param�trage
    $ok = true;
    if (!isset($options['interwiki'])) {
        $GLOBALS['_INCLURE_']['erreurs'][] = sprintf(CATEG_LG_ERREUR_INTERWIKI, $tab_applette_arguments[0]);
        $ok = false;
    } else {
    	if (!isset($GLOBALS['_INCLURE_']['site'][$options['interwiki']])) {
    	    $GLOBALS['_INCLURE_']['erreurs'][] = sprintf(CATEG_LG_ERREUR_SITE, $options['interwiki']);
        	$ok = false;
	    }
    }
    if (!isset($options['page'])) {
        $GLOBALS['_INCLURE_']['erreurs'][] = sprintf(CATEG_LG_ERREUR_PAGE, $tab_applette_arguments[0]);
        $ok = false;
    }
    
    
	//+----------------------------------------------------------------------------------------------------------------+
	// R�cup�ration des donn�es
    $GLOBALS['_INCLURE_']['sortie'] = '';
    if ($ok) {
		$href = $GLOBALS['_INCLURE_']['site'][$options['interwiki']]['url'];
		$href = sprintf($href, $options['page']);
	    
	    $contenu = file_get_contents($href);
	    
	    if ($contenu != false) {
		    $tab_matches = '';
		    preg_match($GLOBALS['_INCLURE_']['site'][$options['interwiki']]['preg'], $contenu, $tab_matches);
		    $tab_encodage = '';
		    if (preg_match('/charset=(.+)"/Ui', $contenu, $tab_encodage) ||�preg_match('/encoding="(.+)"/Ui', $contenu, $tab_encodage)) {
			    if (preg_match('/^(?:iso-8859-1|iso-8859-15)$/i', $GLOBALS['_INCLURE_']['encodage']) && preg_match('/utf-8/i', $tab_encodage[1])) {
			        $GLOBALS['_INCLURE_']['sortie'] = utf8_decode($tab_matches[1]);
			    } else {
			        $GLOBALS['_INCLURE_']['sortie'] = $tab_matches[1];
			    }
		    } else {
		    	$GLOBALS['_INCLURE_']['informations'][] = sprintf(CATEG_LG_ERREUR_ENCODAGE, $href);
		    }
	    } else {
	    	$GLOBALS['_INCLURE_']['informations'][] = sprintf(CATEG_LG_ERREUR_INCLUSION, $href);
	    }
    }
        
	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes � l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_INCLURE_']);
	// D�marre le buffer
	ob_start();
	// Inclusion du fichier
	include(INCL_CHEMIN_SQUELETTE.INCL_SQUELETTE_LISTE);
	// R�cup�rer le  contenu du buffer
	$sortie = ob_get_contents();
	// Arr�te et d�truit le buffer
	ob_end_clean();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Sortie
    return $sortie;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: inclure.php,v $
* Revision 1.4  2007-08-28 14:23:55  jp_milcent
* Am�lioration de la gestion de l'inclusion.
*
* Revision 1.3  2007-08-28 14:14:13  jp_milcent
* Correction de bogues emp�chant l'affichage.
*
* Revision 1.2  2006-12-08 15:57:30  jp_milcent
* Am�lioration de la gestion du d�bogage de l'applette inclure.
*
* Revision 1.1  2006/12/01 17:36:28  florian
* Ajout de l'apllette Inclure, provenant de l'action Inclure.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>