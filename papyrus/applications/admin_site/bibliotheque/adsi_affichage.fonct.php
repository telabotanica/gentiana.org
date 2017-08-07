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
// CVS : $Id: adsi_affichage.fonct.php,v 1.5 2005-02-28 11:07:00 jpm Exp $
/**
* Bibliothèque de fonctions de construction du xhtml de l'application Administrateur de Sites.
*
* Contient un ensemble de fonctions permettant à l'application Administrateur de Sites de généré son xhtml.
*
*@package Admin_site
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Date: 2005-02-28 11:07:00 $
// +------------------------------------------------------------------------------------------------------+
**/

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE des FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

/** Fonction ADMIN_contruirePage()- Génére le xhtml d'une page de l'application administrateur.
*
* Cette fonction formate de la même façon toutes les pages de l'application Administrateur
* avant de les renvoyer.
*
* @param  string   le titre du contenu de la page.
* @param  string   le corps du contenu de la page.
* @param  string   un message important à destination de l'utilisateur.
* return  string   le code XHTML à retourner.
*/
function ADMIN_contruirePage($titre, $texte, $message = '')
{
    // Page.
    $sortie = '';
    $sortie .= "\n";
    $sortie .= '<!-- Application page -->'."\n";
    $sortie .= str_repeat(' ', 12).'<h1>'.$titre.'</h1>'."\n";
    if (! empty ($message)) {
        $sortie .= $message;
    }
    $sortie .= $texte."\n";
    
    return $sortie;
}

// +- Fin du code source  --------------------------------------------------------------------------------+
/*
* $Log: adsi_affichage.fonct.php,v $
* Revision 1.5  2005-02-28 11:07:00  jpm
* Modification des auteurs.
*
* Revision 1.4  2005/02/28 10:59:07  jpm
* Modification des commentaires et copyright.
*
* Revision 1.3  2005/02/28 10:40:49  jpm
* Suppression d'une fonction inutile.
*
* Revision 1.2  2004/07/06 17:08:01  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 14:23:01  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.6  2004/05/07 16:33:39  jpm
* Modification de commentaires.
*
* Revision 1.5  2004/04/30 16:22:53  jpm
* Poursuite de l'administration des sites.
*
* Revision 1.4  2004/04/02 16:36:35  jpm
* Ajout d'une fonction générant des boutons pour les formulaires.
*
* Revision 1.3  2004/04/01 11:21:41  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.2  2004/03/24 20:02:25  jpm
* Modification de l'indentation du xhtml renvoyé.
*
* Revision 1.1  2004/03/24 10:01:33  jpm
* Changement de nom de la bibliothèque de fonction d'affichage du xhtml.
*
* Revision 1.1  2004/03/24 10:00:11  jpm
* Transfert de la fonction de contruction du xhtml de l'application dans ce fichier.
*
*
*/