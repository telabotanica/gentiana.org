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
// CVS : $Id: pap_cache.fonct.php,v 1.1 2004-06-15 15:08:02 jpm Exp $
/**
* Biblioth�que de fonctions utilis�es dans le cadre de la gestion du cache.
*
* Contient des fonctions permettant de g�rer le cache.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.1 $ $Date: 2004-06-15 15:08:02 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/** Fonction GEN_concatenerTaleauAsso() - Retourne une chaine des valeurs et cl�s du tableau.
*
* Cette fonction prend un tableau associatif en param�tre dont elle concat�ne les cl�s et valeurs,
* puis ces paires cl�-valeur entre elles.
* Il est possible de d�finir la chaine utilis�e pour li�e une cl� avec sa valeur et la chaine liant 
* les paires cl�-valeur.
* 
* @param string chaine utilis� pour faire la liaison entre les cl�s et les valeurs du tableau associatif.
* @param string chaine utilis� pour faire la liaison entre chaque paire cl�-valeur du tableau associatif.
* @param array  le tableau associatif � transformer en chaine.
* @return string la chaine des des cl�s et valeurs du tableau associatif concat�n�s.
*/
function GEN_concatenerTaleauAsso($liaison_cle_val, $liaison_paire, $tableau_associatif)
{
    $tab_sortie = array();
    foreach( $tableau_associatif as $cle => $valeur ) {
        $tab_sortie[] = $cle.$liaison_cle_val.$valeur;
    }
    return implode($liaison_paire, $tab_sortie);
}

/** Fonction GEN_donnerMD5UriPostSession() - Retourne une chaine des valeurs de l'Uri, du Post et du Session.
*
* Cette fonction retourne une valeur md5 d'une chaine contenant la concat�nation de l'URI et des paires 
* cl�-valeur des tableaux $_POST et $_SESSION. Les donn�es des tableaux sont ajout�s � l'URI en utilisant "=" 
* pour s�par� les cl�s des valeurs et "&" pour s�parer les paires cl�-valeur.
* 
* @return string la valeur md5 de la chaine concat�nant l'uri aux paires cl�-valeur des tableaux _POST et _SESSION.
*/
function GEN_donnerMD5UriPostSession()
{
    $chaine_variable_post = GEN_concatenerTaleauAsso('=', '&', $_POST);
    $chaine_variable_session = GEN_concatenerTaleauAsso('=', '&', $_SESSION);
    return md5($_SERVER['REQUEST_URI'].'&'.$chaine_variable_post.'&'.$chaine_variable_session);
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_cache.fonct.php,v $
* Revision 1.1  2004-06-15 15:08:02  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.2  2004/04/09 16:23:20  jpm
* Am�lioration de la gestion du cache c�t� serveur avec prise en compte des variables de session.
*
* Revision 1.1  2004/04/08 12:21:21  jpm
* Ajout de fonction utilis�es dans le cadre de la mise en cache d'une page g�n�r�e par G�n�sia.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>