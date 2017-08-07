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
// CVS : $Id: gallerie.php,v 1.2 2006-12-08 16:00:11 jp_milcent Exp $
/**
* papyrus_bp - gallerie.php
*
* Le code provient de "Simple Image Gallery" (in content items) Plugin for Joomla 1.0.x - Version 1.0
* License: http://www.gnu.org/copyleft/gpl.html
* Authors: Fotis Evangelou - George Chouliaras
* Project page at http://www.joomlaworks.gr - Demos at http://demo.joomlaworks.gr
* ***Last update: December 5th, 2006***
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.2 $ $Date: 2006-12-08 16:00:11 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherGallerie';
$GLOBALS['_GEN_commun']['info_applette_balise'] = '\{\{[Gg]allerie(?:\s*(?:(dossier="[^"]+")|(largeur="[^"]+")|(hauteur="[^"]+")|(qualite="[^"]+")|))+\s*\}\}';

/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_CLIENT.'gallerie'.GEN_SEP.'configuration'.GEN_SEP.'gall_config.inc.php';

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
function afficherGallerie($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_GALLERIE_']['erreur'] = '';
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Gestion des arguments
	$tab_arguments = $tab_applette_arguments;
	unset($tab_arguments[0]);
    foreach($tab_arguments as $argument) {
	    $tab_parametres = explode('=', trim($argument));
	    $options[$tab_parametres[0]] = trim($tab_parametres[1], '"'); 
    }

	//+----------------------------------------------------------------------------------------------------------------+
    // Gestion des erreurs de paramètrage
    if (!isset($options['dossier'])) {
        $GLOBALS['_GALLERIE_']['erreur'] = "Applette GALLERIE : le paramètre 'dossier' est obligatoire !";
    }
    if (!isset($options['largeur'])) {
        $options['largeur'] = 160;
    }
    if (!isset($options['hauteur'])) {
        $options['hauteur'] = 160;
    }
    if (!isset($options['qualite'])) {
        $options['qualite'] = 70;
    }

    //+----------------------------------------------------------------------------------------------------------------+
    // Récupération des données	
	$noimage = 0;
	$GLOBALS['_GALLERIE_']['dossier'] = PAP_CHEMIN_RACINE.$options['dossier'];
	if (is_dir($GLOBALS['_GALLERIE_']['dossier'])) {
		if ($dh = opendir($GLOBALS['_GALLERIE_']['dossier'])) {
			while (($f = readdir($dh)) !== false) {
				if((substr(strtolower($f),-3) == 'jpg') || (substr(strtolower($f),-3) == 'gif') || (substr(strtolower($f),-3) == 'png')) {
					$noimage++;
					$images[] = array('filename' => $f);
					array_multisort($images, SORT_ASC, SORT_REGULAR); 
				}
			}
			closedir($dh);
		}
	} else {
		$GLOBALS['_GALLERIE_']['erreur'] = "Applette GALLERIE : le dossier d'images est introuvable à : ".$GLOBALS['_GALLERIE_']['dossier'];
	}
   
   if($noimage) {
   		$GLOBALS['_GALLERIE_']['css']['chemin'] = GALL_CHEMIN_STYLES;
   		$GLOBALS['_GALLERIE_']['css']['largeur'] = $options['largeur']+10;
   		$GLOBALS['_GALLERIE_']['script']['chemin'] = GALL_CHEMIN_SCRIPTS;
   		$GLOBALS['_GALLERIE_']['images'] = array();
   		foreach($images as $image) {
			if ($image['filename'] != '') {
				$aso_img['fichier_nom'] = $image['filename'];
				$aso_img['url_img'] = $options['dossier'].'/'.$image['filename'];
				$aso_img['url_img_mini'] = preg_replace('/papyrus\.php$/', '', PAP_URL).GALL_CHEMIN_SCRIPTS.'showthumb.php?img='.urlencode(PAP_CHEMIN_RACINE.$options['dossier'].'/'.$image['filename']).'&amp;width='.$options['largeur'].'&amp;height='.$options['hauteur'].'&amp;quality='.$options['qualite']; 
				$GLOBALS['_GALLERIE_']['images'][] = $aso_img;
			}
     	}
	}
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Gestion des squelettes
    // Extrait les variables et les ajoutes à l'espace de noms local
	extract($GLOBALS['_GALLERIE_']);
	// Démarre le buffer
	ob_start();
	// Inclusion du fichier
	include(GALL_CHEMIN_SQUELETTE.GALL_SQUELETTE_LISTE);
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
* $Log: gallerie.php,v $
* Revision 1.2  2006-12-08 16:00:11  jp_milcent
* Correction bogue : variable indéfinie.
*
* Revision 1.1  2006/12/07 17:29:20  jp_milcent
* Ajout de l'applette Gallerie dans Client car elle n'a pas un rapport direct avec Papyrus.
*
* Revision 1.2  2006/12/07 16:25:23  jp_milcent
* Ajout de la gestion de messages d'erreur.
* Ajout de la gestion des squelettes.
*
* Revision 1.1  2006/12/07 15:39:47  jp_milcent
* Ajout de l'applette Gallerie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>