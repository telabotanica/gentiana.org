<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Ce logiciel est un programme informatique servant à gérer du contenu et des applications web.        |                                                                           |
// |                                                                                                      |
// | Ce logiciel est régi par la licence CeCILL soumise au droit français et respectant les principes de  | 
// | diffusion des logiciels libres. Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous  |
// | les conditions de la licence CeCILL telle que diffusée par le CEA, le CNRS et l'INRIA sur le site    |
// | "http://www.cecill.info".                                                                            |
// |                                                                                                      |
// | En contrepartie de l'accessibilité au code source et des droits de copie, de modification et de      |
// | redistribution accordés par cette licence, il n'est offert aux utilisateurs qu'une garantie limitée. |
// | Pour les mêmes raisons, seule une responsabilité restreinte pèse sur l'auteur du programme, le       |
// | titulaire des droits patrimoniaux et les concédants successifs.                                      |
// |                                                                                                      |
// | A cet égard l'attention de l'utilisateur est attirée sur les risques associés au chargement, à       |
// | l'utilisation,  à la modification et/ou au développement et à la reproduction du logiciel par        |
// | l'utilisateur étant donné sa spécificité de logiciel libre, qui peut le rendre complexe à manipuler  |
// | et qui le réserve donc à des développeurs et des professionnels avertis possédant des connaissances  |
// | informatiques approfondies. Les utilisateurs sont donc invités à charger  et  tester  l'adéquation   |
// | du logiciel à leurs besoins dans des conditions permettant d'assurer la sécurité de leurs systèmes   | 
// | et ou de leurs données et, plus généralement, à l'utiliser et l'exploiter dans les mêmes conditions  |
// | de sécurité.                                                                                         |
// |                                                                                                      |
// | Le fait que vous puissiez accéder à cet en-tête signifie que vous avez pris connaissance de la       |
// | licence CeCILL, et que vous en avez accepté les termes.                                              |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: categ_configuration.inc.php,v 1.2 2006-12-07 18:16:45 jp_milcent Exp $
/**
* papyrus 
*
* Description...
*
*@package Applette
*@subpackage Identification
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.2 $ $Date: 2006-12-07 18:16:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_CATEGORIE_'] = array();

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'applette CATEG.*/
define('CATEG_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Categorie de Papyrus.*/
define('CATEG_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'categorie'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Categorie de Papyrus.*/
define('CATEG_CHEMIN_LANGUE', CATEG_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Categorie de Papyrus.*/
define('CATEG_CHEMIN_BIBLIO', CATEG_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Categorie de Papyrus.*/
define('CATEG_CHEMIN_SQUELETTE', CATEG_CHEMIN_APPLETTE.'squelettes'.GEN_SEP);

// Configuration du rendu
/** Nom du fichier de squelette à utiliser pour la liste des pages.*/
define('CATEG_SQUELETTE_LISTE', 'categ_liste.tpl.html');

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: categ_configuration.inc.php,v $
* Revision 1.2  2006-12-07 18:16:45  jp_milcent
* Mise à jour commentaires.
* Simplification.
*
* Revision 1.1  2006/12/01 16:34:50  florian
* Ajout de l'apllette Categorie, provenant de l'action Categorie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>