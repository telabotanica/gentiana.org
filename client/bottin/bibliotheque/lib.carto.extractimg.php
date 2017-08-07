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
* Fichier permettant de générer l'entête HTTP des images de la carto.
*
*Ce fichier permet de construire l'image de la carto et de la faire passer dans les entête HTTP.
*
*@package lib.carto
//Auteur original :
*@author        Luc LAMBERT
//Autres auteurs :
*@author        Nicolas MATHIEU
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2003
*@version       01 juillet 2002
// +-----------------------------------------------------------------------------------------------+
//
// $Id: lib.carto.extractimg.php,v 1.1 2005/09/22 14:02:49 ddelon Exp $
// FICHIER : $RCSfile: lib.carto.extractimg.php,v $
// AUTEUR  : $Author: ddelon $
// VERSION : $Revision: 1.1 $
// DATE    : $Date: 2005/09/22 14:02:49 $
//
// +-----------------------------------------------------------------------------------------------+
// A FAIRE :
// 
*/

$image = imagecreatefrompng('tmp/carto/'.$fichier.'.png');
chmod ('tmp/carto/'.$fichier.'.png', 755) ;

header('Expires: Wen, 01 Dec 1999 01:00:00 GMT');// Date du passé
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');// toujours modifié
header('Cache-Control: no-cache, must-revalidate');// HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
header ('content-type:image/png');
imagepng($image);
unlink('tmp/carto/'.$fichier.'.png');
//Nous nettoyons le dossier tmp des fichiers qu'il contient:
$poignet_de_dossier = opendir('tmp/carto/');
while ($fichier_dechet = readdir($poignet_de_dossier)) {
    if ($fichier_dechet != '.' && $fichier_dechet != '..') {
        unlink(CAR_CHEMIN_TMP.$fichier_dechet);
    }
}
closedir($poignet_de_dossier);
exit();

//-- Fin du code source  ------------------------------------------------------------
/*
* $Log: lib.carto.extractimg.php,v $
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.2  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.1  2004/12/15 13:30:20  alex
* version initiale
*
* Revision 1.7  2003/03/04 08:09:39  jpm
* Ajout suppression des fichiers carto du dossier carto temporaire.
*
* Revision 1.6  2003/02/21 13:50:57  jpm
* Mise à jour nouvel objet Carto_Carte.
*
* Revision 1.5  2003/02/14 07:56:45  jpm
* Ajout d'un entête.
* Ajout de requêtes HTTP pour éviter le cache.
*
*
*
*/
?>