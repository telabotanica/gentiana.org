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
// CVS : $Id: pap_envoi.inc.php,v 1.11 2007-06-25 15:44:32 jp_milcent Exp $
/**
* Gestion de l'envoie des pages à afficher.
*
* Ce fichier envoi les données en les compressant si possible.
*
*@package Papyrus
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.11 $ $Date: 2007-06-25 15:44:32 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

function pap_compress_sortie($output) {
	return gzencode($output);
}

// Nous vérifions si le navigateur supporte la compression, HTTP_ACCEPT_ENCODING
if (strstr ($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') && function_exists('gzencode') ) {
	// Nous mettons en buffer la sortie et nous demandons l'appel de la fonction de compression (voir ci-dessus)
	ob_start ('pap_compress_sortie');
	// Nous prévenons le navigateur que le contenu est compressé avec gzip
	header ('Content-Encoding: gzip');
}

echo($GLOBALS['_GEN_commun']['sortie']);

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_envoi.inc.php,v $
* Revision 1.11  2007-06-25 15:44:32  jp_milcent
* Traduction des commentaires et mise en forme du code.
*
* Revision 1.10  2007-04-13 09:41:09  neiluj
* rÃ©parration cvs
*
* Revision 1.9  2006/06/08 09:00:06  ddelon
* Bug affichage wikini
*
* Revision 1.8  2006/05/10 16:02:49  ddelon
* Finition multilinguise et schizo flo
*
* Revision 1.7  2006/01/12 16:37:01  ddelon
* compression N**t*n
*
* Revision 1.6  2005/12/09 16:01:53  ddelon
* retablissement compression
*
* Revision 1.5  2005/11/25 14:33:08  ddelon
* desactivation compression
*
* Revision 1.4  2005/02/28 11:20:42  jpm
* Modification des auteurs.
*
* Revision 1.3  2004/10/15 18:29:19  jpm
* Modif pour gérer l'appli installateur de Papyrus.
*
* Revision 1.2  2004/06/16 15:07:56  jpm
* Correction d'un chemin et nom de fichier.
*
* Revision 1.1  2004/06/16 08:11:37  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.3  2004/04/28 12:04:31  jpm
* Changement du modèle de la base de données.
*
* Revision 1.2  2004/04/22 08:31:43  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.1  2004/04/09 16:19:23  jpm
* Ajout du fichier indépendant d'envoi avec gestion des tables i18n.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>