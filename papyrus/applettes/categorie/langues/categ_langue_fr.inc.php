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
// CVS : $Id: categ_langue_fr.inc.php,v 1.3 2006-12-07 18:12:26 jp_milcent Exp $
/**
* papyrus 
*
* Description...
*
*@package Applette
*@subpackage Categorie
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.3 $ $Date: 2006-12-07 18:12:26 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affiché quand l'auteur est inconnu.*/
define('CATEG_LG_INCONNU_AUTEUR', 'Anonyme');
/** Texte affiché quand le titre est vide.*/
define('CATEG_LG_INCONNU_TITRE', 'Titre inconnu');
/** Texte affiché quand le paramètre "mots" est abscent.*/
define('CATEG_LG_ERREUR_MOTS', "Applette CATEGORIE : le paramètre 'mots' est obligatoire!");
/** Texte affiché quand on n'a pas de page à afficher'.*/
define('CATEG_LG_INFO_ZERO_PAGE', "Applette CATEGORIE : aucune page n'a été trouvé pour : %s !");

/** Mois de janvier.*/
define('CATEG_LG_MOIS_01', 'janvier');
/** Mois de février.*/
define('CATEG_LG_MOIS_02', 'février');
/** Mois de mars.*/
define('CATEG_LG_MOIS_03', 'mars');
/** Mois d'avril.*/
define('CATEG_LG_MOIS_04', 'avril');
/** Mois de mai.*/
define('CATEG_LG_MOIS_05', 'mai');
/** Mois de juin.*/
define('CATEG_LG_MOIS_06', 'juin');
/** Mois de juillet.*/
define('CATEG_LG_MOIS_07', 'juillet');
/** Mois d'août'.*/
define('CATEG_LG_MOIS_08', 'août');
/** Mois de septembre.*/
define('CATEG_LG_MOIS_09', 'septembre');
/** Mois d'octobre.*/
define('CATEG_LG_MOIS_10', 'octobre');
/** Mois de novembre.*/
define('CATEG_LG_MOIS_11', 'novembre');
/** Mois de décembre.*/
define('CATEG_LG_MOIS_12', 'décembre');
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: categ_langue_fr.inc.php,v $
* Revision 1.3  2006-12-07 18:12:26  jp_milcent
* Ajout de messages d'erreurs.
*
* Revision 1.2  2006/12/07 17:51:48  jp_milcent
* Ajout d'un fichier de langue.
*
* Revision 1.1  2006/12/01 16:34:50  florian
* Ajout de l'apllette Categorie, provenant de l'action Categorie.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>