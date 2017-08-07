<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Integrateur Wikini.                                                             |
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
// CVS : $Id: iw_affichage_xhtml.fonct.php,v 1.2 2005-08-25 08:59:12 ddelon Exp $
/**
* Fichier permettant d'inclure les données dans du XHTML.
*
* Fichier contenant des fonctions retournant du XHTML une fois les données passées en paramêtre incluse à l 'intérieur.
*
*@package IntegrateurWikini
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.2 $ $Date: 2005-08-25 08:59:12 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/**
* Fonction inclusion_html() - Gestion des inclusions XHTML dans le code PHP.
*
* Cette fonction retourne du XHTML à insérer dans le code PHP.
*
* @param string le type d'inclusion de XHTML à retourner.
* @param array le tableau des paramêtre à inclure dans le XHTML à retourner.
* @return string contient du XHTML à insérer dans le code PHP.
*/
function inclusion_html($type_inclusion, $variable = array()){
    $html_renvoyer = '';
    
    switch ($type_inclusion){
        // +------------------------------------------------------------------------------------------------------+
        // LES TITRES
        // +------------------------------------------------------------------------------------------------------+
        // LES TEXTES
        // +------------------------------------------------------------------------------------------------------+
        // LES PIEDS DE PAGES
        case "pied_page" :
            break;
    }//fin du switch
    
    return remplacerEntiteHTLM($html_renvoyer);
}//fin fonction inclusion_html

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iw_affichage_xhtml.fonct.php,v $
* Revision 1.2  2005-08-25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/08/18 10:20:08  ddelon
* Integrateur Wikini et Acces PEAR
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>