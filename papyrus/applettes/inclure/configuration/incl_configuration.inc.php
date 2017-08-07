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
// CVS : $Id: incl_configuration.inc.php,v 1.2 2006-12-08 15:57:30 jp_milcent Exp $
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
*@version       $Revision: 1.2 $ $Date: 2006-12-08 15:57:30 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_INCLURE_'] = array();

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Variable contenant les sites pouvant �tre inclus.*/
$GLOBALS['_INCLURE_']['site'] = $GLOBALS['_PAPYRUS_']['inclure_sites'];
/** Variable contenant l'encodage de la page courrante de Papyrus.*/
$GLOBALS['_INCLURE_']['encodage'] = $GLOBALS['_PAPYRUS_']['page']['jeu_de_caracteres'];

/** Constante stockant la valeur de la langue par d�faut pour l'applette INCL.*/
define('INCL_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin des fichiers � inclure.
/** Chemin vers la biblioth�que PEAR.*/
define('INCL_CHEMIN_BIBLIOTHEQUE_PEAR', PAP_CHEMIN_API_PEAR);

// Chemin vers les dossiers de l'applette
/** Chemin vers l'applette Inclure de Papyrus.*/
define('INCL_CHEMIN_APPLETTE', GEN_CHEMIN_APPLETTE.'inclure'.GEN_SEP);
/** Chemin vers les fichiers de traduction de l'applette Inclure de Papyrus.*/
define('INCL_CHEMIN_LANGUE', INCL_CHEMIN_APPLETTE.'langues'.GEN_SEP);
/** Chemin vers les fichiers de la bibliotheque de l'applette Inclure de Papyrus.*/
define('INCL_CHEMIN_BIBLIO', INCL_CHEMIN_APPLETTE.'bibliotheque'.GEN_SEP);
/** Chemin vers les fichiers squelettes de l'applette Inclure de Papyrus.*/
define('INCL_CHEMIN_SQUELETTE', INCL_CHEMIN_APPLETTE.'squelettes'.GEN_SEP);

// Configuration du rendu
/** Nom du fichier de squelette � utiliser pour la liste des pages.*/
define('INCL_SQUELETTE_LISTE', 'incl_liste.tpl.html');

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: incl_configuration.inc.php,v $
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