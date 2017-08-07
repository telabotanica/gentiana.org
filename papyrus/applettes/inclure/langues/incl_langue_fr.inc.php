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
// CVS : $Id: incl_langue_fr.inc.php,v 1.4 2007-08-28 14:23:55 jp_milcent Exp $
/**
* papyrus 
*
* Description...
*
*@package Applette
*@subpackage Inclure
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.4 $ $Date: 2007-08-28 14:23:55 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affiché quand un problème a été rencontré lors de l'inclusion.*/
define('CATEG_LG_ERREUR_INCLUSION', "Applette INCLURE : problème lors de la tentative d'inclusion de la page : %s");
/** Texte affiché quand un problème a été rencontré pour la détermination de l'encodage.*/
define('CATEG_LG_ERREUR_ENCODAGE', "Applette INCLURE : problème lors de la recherche de l'encodage de la page à inclure : %s");
/** Texte affiché quand un site n'a pas été indexé.*/
define('CATEG_LG_ERREUR_SITE', "Applette INCLURE : le site interwiki '%s' n'est pas référencé dans le fichier de configuration avancé de Papyrus.");
/** Texte affiché quand le paramètre "interwiki" est abscent.*/
define('CATEG_LG_ERREUR_INTERWIKI', "Applette INCLURE : le paramètre 'interwiki' est obligatoire dans '%s' !");
/** Texte affiché quand le paramètre "page" est abscent.*/
define('CATEG_LG_ERREUR_PAGE', "Applette INCLURE : le paramètre 'page' est obligatoire dans '%s' !");

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: incl_langue_fr.inc.php,v $
* Revision 1.4  2007-08-28 14:23:55  jp_milcent
* Amélioration de la gestion de l'inclusion.
*
* Revision 1.3  2007-08-28 14:14:13  jp_milcent
* Correction de bogues empéchant l'affichage.
*
* Revision 1.2  2006-12-08 15:57:30  jp_milcent
* Amélioration de la gestion du débogage de l'applette inclure.
*
* Revision 1.1  2006/12/01 17:36:28  florian
* Ajout de l'apllette Inclure, provenant de l'action Inclure.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>