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
// CVS : $Id: pap_connecte_bdd.inc.php,v 1.4 2007-04-13 09:41:09 neiluj Exp $
/**
* Connection à la base de données et inclusions des classes générées par DataObject de Pear.
*
* Ce fichier permet de se connecter à la base de données et d'inclure les classes représentant les tables
* de la base de données de Papyrus. Ces tables sont générées par DataObject de Pear.
*
*@package Papyrus
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $ $Date: 2007-04-13 09:41:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/** <br> Inclusion de la classe PEAR d'abstraction de base de donnée. */
require_once PAP_CHEMIN_API_PEAR.'DB.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Connexion à la base de données.

$db = DB::connect(PAP_DSN) ;
$_GEN_commun['pear_db'] = $db;
if (DB::isError($db)) {
    $msg_erreur_connection = 'Impossible de se connecter à la base de données.';
    die(BOG_afficherErreurSql(__FILE__, __LINE__, $db->getMessage(), 'connexion à la base de données',$msg_erreur_connection));
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_connecte_bdd.inc.php,v $
* Revision 1.4  2007-04-13 09:41:09  neiluj
* rÃ©parration cvs
*
* Revision 1.3  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.2  2004/10/15 18:29:19  jpm
* Modif pour gérer l'appli installateur de Papyrus.
*
* Revision 1.1  2004/06/16 08:11:22  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.5  2004/05/10 13:24:16  jpm
* Correction gestion de l'erreur impossible de se connecter.
*
* Revision 1.4  2004/05/01 11:41:31  jpm
* Ajout de la variable globale $_GEN_commun['pear_db'] devant être utilisé à la place de $db.
*
* Revision 1.3  2004/04/28 12:04:31  jpm
* Changement du modèle de la base de données.
*
* Revision 1.2  2004/04/22 08:25:05  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.1  2004/04/21 16:24:29  jpm
* Ajout d'un fichier spécifique pour la connexion à la base de données et incluant les classes DataObject de Pear.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>