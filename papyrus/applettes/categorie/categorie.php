<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Ce logiciel est un programme informatique servant à gérer du contenu et des applications web.        |                                                                           |
// |                                                                                                      |
// | Ce logiciel est régi par la licence CeCILL soumise au droit français et respectant les principes de  | 
// | diffusion des logiciels libres. Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous  |
// | les conditions de la licence CeCILL telle que diffusée par le CEA, le CNRS et l'INRIA sur le site    |
// | "http://www.cecill.info".                                                                            |
// |                                                                                                      |
// | En contrepartie de l'accessibilité au code source et des droits de copie, de modification et de      |
// | redistribution accordés par cette licence, il n'est offert aux utilisateurs qu'une garantie limitée. |
// | Pour les mêmes raisons, seule une responsabilité restreinte pèse sur l'auteur du programme, le       |
// | titulaire des droits patrimoniaux et les concédants successifs.                                      |
// |                                                                                                      |
// | A cet égard l'attention de l'utilisateur est attirée sur les risques associés au chargement, à       |
// | l'utilisation,  à la modification et/ou au développement et à la reproduction du logiciel par        |
// | l'utilisateur étant donné sa spécificité de logiciel libre, qui peut le rendre complexe à manipuler  |
// | et qui le réserve donc à des développeurs et des professionnels avertis possédant des connaissances  |
// | informatiques approfondies. Les utilisateurs sont donc invités à charger  et  tester  l'adéquation   |
// | du logiciel à leurs besoins dans des conditions permettant d'assurer la sécurité de leurs systèmes   | 
// | et ou de leurs données et, plus généralement, à l'utiliser et l'exploiter dans les mêmes conditions  |
// | de sécurité.                                                                                         |
// |                                                                                                      |
// | Le fait que vous puissiez accéder à cet en-tête signifie que vous avez pris connaissance de la       |
// | licence CeCILL, et que vous en avez accepté les termes.                                              |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: categorie.php,v 1.5 2006-12-12 13:32:00 jp_milcent Exp $
/**
* Applette : Catégorie
*
* Retourne toutes les pages Papyrus appartenant à une catégorie donnée.
*
*@package Applette
*@subpackage Categorie
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.5 $ $Date: 2006-12-12 13:32:00 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherCategorie';
$GLOBALS['_GEN_commun']['info_applette_balise'] = '\{\{[Cc]ategorie(?:\s*(?:(mots="[^"]+")|))+\s*\}\}';

// --------------------------------------------------------------------------------------------------------
//Utilisation de la bibliothèque Papyrus pap_meta.fonct.php inclue par Papyrus
//Utilisation de la bibliothèque PEAR NET_URL inclue par Papyrus
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'categorie'.GEN_SEP.'configuration'.GEN_SEP.'categ_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette CATEG de Papyrus
if (file_exists(CATEG_CHEMIN_LANGUE.'categ_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once CATEG_CHEMIN_LANGUE.'categ_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once CATEG_CHEMIN_LANGUE.'categ_langue_'.CATEG_I18N_DEFAUT.'.inc.php';
}


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherCategorie() - Retourne la liste des pages d'une catégorie.
*
* Cette fonction retourne la liste des pages appartenant à une catégorie donnée.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string HTML la liste des listes de menus.
*/
function afficherCategorie($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	
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
    $GLOBALS['_CATEGORIE_']['erreur'] = '';
    if (!isset($options['mots'])) {
        $GLOBALS['_CATEGORIE_']['erreur'] = CATEG_LG_ERREUR_MOTS;
    }
    
    //+----------------------------------------------------------------------------------------------------------------+
    // Récupération des données
    $tab_mots = explode(',', $options['mots']);
    for ($i = 0; $i < count($tab_mots); $i++) {
        // Suppression des espaces, tabulations... en début et fin de chaine
        $tab_mots[$i] = trim($tab_mots[$i]);
    }
    $aso_info_menu = GEN_lireInfoMenuCategorie($_GEN_commun['pear_db'], $tab_mots);
	if (count($aso_info_menu) == 0) {
		$GLOBALS['_CATEGORIE_']['information'] = sprintf(CATEG_LG_INFO_ZERO_PAGE, $options['mots']);
	} else {
		foreach ($aso_info_menu as $id_menu => $un_menu) {
	        // Initialisation
	        $aso_page = array();
			$aso_page['url'] = '#';
			$aso_page['auteur'] = CATEG_LG_INCONNU_AUTEUR;
			$aso_page['titre'] = CATEG_LG_INCONNU_TITRE;
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
	        $GLOBALS['_CATEGORIE_']['pages'][] = $aso_page;
	    }
	}
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes à l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_CATEGORIE_']);
	// Démarre le buffer
	ob_start();
	// Inclusion du fichier
	include(CATEG_CHEMIN_SQUELETTE.CATEG_SQUELETTE_LISTE);
	// Récupérer le  contenu du buffer
	$sortie = ob_get_contents();
	// Arrête et détruit le buffer
	ob_end_clean();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Sortie
    return $sortie;
}

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE DES FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+
if (!function_exists('_traduireMois')) {
	function _traduireMois($mois_numerique)
	{
	    switch ($mois_numerique) {
	        case '01' :
	            return CATEG_LG_MOIS_01;
	        case '02' :
	            return CATEG_LG_MOIS_02;
	        case '03' :
	            return CATEG_LG_MOIS_03;
	        case '04' :
	            return CATEG_LG_MOIS_04;
	        case '05' :
	            return CATEG_LG_MOIS_05;
	        case '06' :
	            return CATEG_LG_MOIS_06;
	        case '07' :
	            return CATEG_LG_MOIS_07;
	        case '08' :
	            return CATEG_LG_MOIS_08;
	        case '09' :
	            return CATEG_LG_MOIS_09;
	        case '10' :
	            return CATEG_LG_MOIS_10;
	        case '11' :
	            return CATEG_LG_MOIS_11;
	        case '12' :
	            return CATEG_LG_MOIS_12;
	        default:
	            return '';
	    }
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: categorie.php,v $
* Revision 1.5  2006-12-12 13:32:00  jp_milcent
* Ajout d'un test pour vérifier la non existence de la fonction.
*
* Revision 1.4  2006/12/08 20:10:41  jp_milcent
* Amélioration de l'expression régulière.
*
* Revision 1.3  2006/12/07 18:16:21  jp_milcent
* Gestion des squelettes.
*
* Revision 1.2  2006/12/01 17:37:46  florian
* Amélioration de la gestion des arguments de l'applette dans l'expression régulière.
*
* Revision 1.1  2006/12/01 16:34:50  florian
* Ajout de l'apllette Categorie, provenant de l'action Categorie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>