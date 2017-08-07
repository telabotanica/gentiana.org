<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2005 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Chorologie.                                                              |
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
// CVS : $Id: iw_encodage.fonct.php,v 1.1 2005-08-18 10:20:09 ddelon Exp $
/**
* Fonctions manipulant les encodages
*
* Fichiers contenant des fonctions manipulant l'encodage.
*
*@package IntegrateurWikini
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2005
*@version       $Revision: 1.1 $ $Date: 2005-08-18 10:20:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE DES FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

/**
* La fonction remplacerEntiteHTLM() remplace des caract�res par les entit�s html.
*
* Cette fonction retourne un texte dans lequel touts les caract�res correspondant
* � des entit�s html sont remplac�s par la valeur de l'entit�, � l'exception
* des caract�res <, >, & et ".
* Cela permet de remplacer toutes les entit�s dans une chaine contenant du html.
*
*@param string la cha�ne html � parsser.
*@return string contient la cha�ne html avec les entit�s int�gr�es.
*/

function remplacerEntiteHTLM($texte)
{
    $texte_retour = '';
    $tab_entites = get_html_translation_table(HTML_ENTITIES);
    unset($tab_entites['"']);
    unset($tab_entites['<']);
    unset($tab_entites['>']);
    unset($tab_entites['&']);
    $tab_entites[' & '] = ' &amp; ';
    return strtr($texte, $tab_entites);
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: iw_encodage.fonct.php,v $
* Revision 1.1  2005-08-18 10:20:09  ddelon
* Integrateur Wikini et Acces PEAR
*
* Revision 1.2  2005/05/19 15:11:49  jpm
* Ajout du remplacement des & par des &amp;
*
* Revision 1.1  2005/03/02 17:47:05  jpm
* Ajout des fichiers necessaires � l'int�grateur de wikini.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>