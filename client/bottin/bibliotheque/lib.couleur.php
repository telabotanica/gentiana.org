<?php


//vim: set expandtab tabstop=4 shiftwidth=4: 
// +-----------------------------------------------------------------------------------------------+
// | PHP version 4.0                                                                               |
// +-----------------------------------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group                                      |
// +-----------------------------------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,                                | 
// | that is bundled with this package in the file LICENSE, and is                                 |
// | available at through the world-wide-web at                                                    |
// | http://www.php.net/license/2_02.txt.                                                          |
// | If you did not receive a copy of the PHP license and are unable to                            |
// | obtain it through the world-wide-web, please send a note to                                   |
// | license@php.net so we can mail you a copy immediately.                                        |
// +-----------------------------------------------------------------------------------------------+
/**
* Fichier regroupant toutes les fonctions manipulant les  couleurs
*
*Toutes les fonctions sur les couleurs sont disponibles dans ce fichier.
*
*@package couleur
//Auteur original :
*@author iubito <sylvain_machefert@yahoo.fr> 
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2003
*@version       25 fevrier 2003
// +-----------------------------------------------------------------------------------------------+
//
// $Id: lib.couleur.php,v 1.1 2005/09/22 14:02:49 ddelon Exp $
// FICHIER : $RCSfile: lib.couleur.php,v $
// AUTEUR  : $Author: ddelon $
// VERSION : $Revision: 1.1 $
// DATE    : $Date: 2005/09/22 14:02:49 $
//
// +-----------------------------------------------------------------------------------------------+
// A FAIRE :
*/

/**
//==================================== FONCTION ==================================
* La fonction array couleur_hexadecimalAuRgb(string color) renvoie des valeurs de couleur en RGB.
*
*Cette fonction prend une valeur de couleur codée en hexadécimal et retourne 
*les valeurs RGB correspondantes sous forme de tableau.
*Exemple d'utilisation:
*$rgb = couleur_hexadecimalAuRgb("fffc49");
*echo "<br>couleur_hexadecimalAuRgb de 'fffc49' : ".$rgb['R']." ".$rgb['V']." ".$rgb['B'];
*
*@author iubito <sylvain_machefert@yahoo.fr> 
*@copyright     iubito - http://iubito.free.fr/ - 2003
*
*@param string $couleur représente une couleur codée en héxadécimal.
*
*@return array tableau associatif contenant les 3 valeurs RGB, avec clé du rouge 'R',
* du vert 'V' et enfin du bleu 'B'.
//==============================================================================
*/
function couleur_hexadecimalAuRgb($couleur_html)
{
    //gestion du #...
    if (substr($couleur_html, 0, 1) == "#") {
        $couleur_html = substr($couleur_html, 1, 6);
    }
    
    $tablo_rgb['R'] = hexdec(substr($couleur_html, 0, 2));
    $tablo_rgb['V'] = hexdec(substr($couleur_html, 2, 2));
    $tablo_rgb['B'] = hexdec(substr($couleur_html, 4, 2));
    
    return $tablo_rgb;
}


/**
//==================================== FONCTION ==================================
* La fonction string couleur_rgbAuHexadecimal(array tablo) renvoie la valeur d'une 
*couleur en héxadécimal.
*
*Cette fonction prend un tableau de valeurs d'une couleur codées en RGB et retourne 
*la valeur hexadécimal correspondante sous forme de chaîne.
*C'est la réciproque exacte de la fonction couleur_hexadecimalAuRgb.
*
*@author iubito <sylvain_machefert@yahoo.fr> 
*@copyright     iubito - http://iubito.free.fr/ - 2003
*
*@param array $tablo_RGB représente un tableau associatif avec les valeurs RGB
*d'une couleur.Les trois clés du tableau sont : R pour rouge, V pour vert et B pour bleu.
*
*@return string chaîne contenant la valeur de la couleur sous forme héxadécimale.
//==============================================================================
*/
function couleur_rgbAuHexadecimal($tablo_rgb)
{
    //Vérification des bornes...
    foreach($tablo_rgb as $cle => $valeur) {
        $tablo_rgb[$cle] = bornes($tablo_rgb[$cle],0,255);
    }
    //Le str_pad permet de remplir avec des 0
    //parce que sinon couleur_rgbAuHexadecimal(array(0,255,255)) retournerai #0ffff<=manque un 0 !
    return "#".str_pad(dechex(($tablo_rgb['R']<<16)|($tablo_rgb['V']<<8)|$tablo_rgb['B']),6,"0",STR_PAD_LEFT);
}

/**
//==================================== FONCTION ==================================
* La fonction int couleur_bornerNbre(int nb, int min, int max) borne des nombres.
*
*Cette fonction permet de borner la valeur d'un nombre entre un minimum $mini et
*un maximum $maxi.
*
*@author iubito <sylvain_machefert@yahoo.fr> 
*@copyright     iubito - http://iubito.free.fr/ - 2003
*
*@param integer $nbre le nombre à borner.
*@param integer $mini la borne minimum.
*@param integer $maxi la borne maximum.
*
*@return integer le nombre limité aux bornes si nécessaire.
//==============================================================================
*/
function couleur_bornerNbre($nbre, $mini, $maxi)
{
    if ($nbre < $mini) {
        $nbre = $mini;
    }
    
    if ($nbre > $maxi) {
        $nbre = $maxi;
    }
    
    return $nbre;
}

?>
