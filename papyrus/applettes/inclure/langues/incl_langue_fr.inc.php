<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | Ce logiciel est un programme informatique servant � g�rer du contenu et des applications web.        |                                                                           |
// |                                                                                                      |
// | Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et respectant les principes de  | 
// | diffusion des logiciels libres. Vous pouvez utiliser, modifier et/ou redistribuer ce programme sous  |
// | les conditions de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA sur le site    |
// | "http://www.cecill.info".                                                                            |
// |                                                                                                      |
// | En contrepartie de l'accessibilit� au code source et des droits de copie, de modification et de      |
// | redistribution accord�s par cette licence, il n'est offert aux utilisateurs qu'une garantie limit�e. |
// | Pour les m�mes raisons, seule une responsabilit� restreinte p�se sur l'auteur du programme, le       |
// | titulaire des droits patrimoniaux et les conc�dants successifs.                                      |
// |                                                                                                      |
// | A cet �gard l'attention de l'utilisateur est attir�e sur les risques associ�s au chargement, �       |
// | l'utilisation,  � la modification et/ou au d�veloppement et � la reproduction du logiciel par        |
// | l'utilisateur �tant donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � manipuler  |
// | et qui le r�serve donc � des d�veloppeurs et des professionnels avertis poss�dant des connaissances  |
// | informatiques approfondies. Les utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation   |
// | du logiciel � leurs besoins dans des conditions permettant d'assurer la s�curit� de leurs syst�mes   | 
// | et ou de leurs donn�es et, plus g�n�ralement, � l'utiliser et l'exploiter dans les m�mes conditions  |
// | de s�curit�.                                                                                         |
// |                                                                                                      |
// | Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez pris connaissance de la       |
// | licence CeCILL, et que vous en avez accept� les termes.                                              |
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
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affich� quand un probl�me a �t� rencontr� lors de l'inclusion.*/
define('CATEG_LG_ERREUR_INCLUSION', "Applette INCLURE : probl�me lors de la tentative d'inclusion de la page : %s");
/** Texte affich� quand un probl�me a �t� rencontr� pour la d�termination de l'encodage.*/
define('CATEG_LG_ERREUR_ENCODAGE', "Applette INCLURE : probl�me lors de la recherche de l'encodage de la page � inclure : %s");
/** Texte affich� quand un site n'a pas �t� index�.*/
define('CATEG_LG_ERREUR_SITE', "Applette INCLURE : le site interwiki '%s' n'est pas r�f�renc� dans le fichier de configuration avanc� de Papyrus.");
/** Texte affich� quand le param�tre "interwiki" est abscent.*/
define('CATEG_LG_ERREUR_INTERWIKI', "Applette INCLURE : le param�tre 'interwiki' est obligatoire dans '%s' !");
/** Texte affich� quand le param�tre "page" est abscent.*/
define('CATEG_LG_ERREUR_PAGE', "Applette INCLURE : le param�tre 'page' est obligatoire dans '%s' !");

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: incl_langue_fr.inc.php,v $
* Revision 1.4  2007-08-28 14:23:55  jp_milcent
* Am�lioration de la gestion de l'inclusion.
*
* Revision 1.3  2007-08-28 14:14:13  jp_milcent
* Correction de bogues emp�chant l'affichage.
*
* Revision 1.2  2006-12-08 15:57:30  jp_milcent
* Am�lioration de la gestion du d�bogage de l'applette inclure.
*
* Revision 1.1  2006/12/01 17:36:28  florian
* Ajout de l'apllette Inclure, provenant de l'action Inclure.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>