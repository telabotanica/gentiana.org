<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or                                        |
// | modify it under the terms of the GNU Lesser General Public                                           |
// | License as published by the Free Software Foundation; either                                         |
// | version 2.1 of the License, or (at your option) any later version.                                   |
// |                                                                                                      |
// | This library is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU                                    |
// | Lesser General Public License for more details.                                                      |
// |                                                                                                      |
// | You should have received a copy of the GNU Lesser General Public                                     |
// | License along with this library; if not, write to the Free Software                                  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: FIC_manipulation.fonct.php,v 1.3 2004-10-19 15:57:03 jpm Exp $
/**
* Bibliothèque de fonctions permettant de manipuler des fichier ou des dossiers.
*
* Contient des fonctions permettant de manipuler des fichier ou des dossiers.
*
*@package Fichier
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2004-10-19 15:57:03 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/**
* Fonction supprimerDossier() - Supprime un fichier ou un dossier et tout son contenu.
*
* Fonction récursive supprimant tout le contenu d'un dossier.
* Auteur d'origine : Aidan Lister (http://aidan.dotgeek.org/lib/?file=function.rmdirr.php)
* Traduction française et ajout gestion séparateur : Jean-Pascal Milcent
*
* @author      Aidan Lister <aidan@php.net>
* @author      Jean-Pascal Milcent <jpm@tela-botanica.org>
* @version     1.0.0
* @param       string   le chemin du dossier à supprimer.
* @param       string   le caractère représentant le séparateur dans un chemin d'accès.
* @return      bool     retoure TRUE en cas de succès, FALSE dans le cas contraire.
*/
function supprimerDossier($dossier_nom, $separateur = '/')
{
    // Simple suppression d'un fichier
    if (is_file($dossier_nom)) {
        return unlink($dossier_nom);
    }
    
    if (is_dir($dossier_nom)) {
        // Analyse du dossier
        $dossier = dir($dossier_nom);
        while (false !== $entree = $dossier->read()) {
            // Nous sautons les pointeurs
            if ($entree == '.' || $entree == '..') {
                continue;
            }
            
            // Suppression du dossier ou appel récursif de la fonction
            if (is_dir($dossier_nom.$separateur.$entree)) {
                supprimerDossier($dossier_nom.$separateur.$entree, $separateur);
            } else {
                unlink($dossier_nom.$separateur.$entree);
            }
        }
        // Nettoyage
        $dossier->close();
        return rmdir($dossier_nom);
    } else {
        return false;
    }
}

/**
* Fonction creerDossier() - Créer une structure de dossier.
*
* Fonction récursive créant une structure de dossiers.
* Auteur d'origine : Aidan Lister (http://aidan.dotgeek.org/lib/?file=function.mkdirr.php)
* Traduction française et ajout gestion séparateur : Jean-Pascal Milcent
*
* @author      Aidan Lister <aidan@php.net>
* @version     1.0.0
* @param       string   la structure de dossier à créer.
* @param       string   le mode de création du répertoire.
* @param       string   le caractère représentant le séparateur dans un chemin d'accès.
* @return      bool     retourne TRUE en cas de succès, FALSE dans le cas contraire.
*/

function creerDossier($chemin, $mode = null, $separateur = '/')
{
    // Check if directory already exists
    if (is_dir($chemin) || empty($chemin)) {
        return true;
    }
    
    // Ensure a file does not already exist with the same name
    if (is_file($chemin)) {
        trigger_error('mkdirr() File exists', E_USER_WARNING);
        return false;
    }
    
    // Crawl up the directory tree
    $chemin_suite = substr($chemin, 0, strrpos($chemin, $separateur));
    if (creerDossier($chemin_suite, $mode, $separateur)) {
        if (!file_exists($chemin)) {
            return @mkdir($chemin, $mode);
        }
    }
    
    return false;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: FIC_manipulation.fonct.php,v $
* Revision 1.3  2004-10-19 15:57:03  jpm
* Ajout de test pour éviter les message d'erreur.
*
* Revision 1.2  2004/10/18 10:12:22  jpm
* Traduction commentaires...
*
* Revision 1.1  2004/10/18 10:09:12  jpm
* Ajout d'une fonction permettant de supprimer récursivement un répertoire.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>