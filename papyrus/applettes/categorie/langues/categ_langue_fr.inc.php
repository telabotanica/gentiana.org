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
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Texte affich� quand l'auteur est inconnu.*/
define('CATEG_LG_INCONNU_AUTEUR', 'Anonyme');
/** Texte affich� quand le titre est vide.*/
define('CATEG_LG_INCONNU_TITRE', 'Titre inconnu');
/** Texte affich� quand le param�tre "mots" est abscent.*/
define('CATEG_LG_ERREUR_MOTS', "Applette CATEGORIE : le param�tre 'mots' est obligatoire!");
/** Texte affich� quand on n'a pas de page � afficher'.*/
define('CATEG_LG_INFO_ZERO_PAGE', "Applette CATEGORIE : aucune page n'a �t� trouv� pour : %s !");

/** Mois de janvier.*/
define('CATEG_LG_MOIS_01', 'janvier');
/** Mois de f�vrier.*/
define('CATEG_LG_MOIS_02', 'f�vrier');
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
/** Mois d'ao�t'.*/
define('CATEG_LG_MOIS_08', 'ao�t');
/** Mois de septembre.*/
define('CATEG_LG_MOIS_09', 'septembre');
/** Mois d'octobre.*/
define('CATEG_LG_MOIS_10', 'octobre');
/** Mois de novembre.*/
define('CATEG_LG_MOIS_11', 'novembre');
/** Mois de d�cembre.*/
define('CATEG_LG_MOIS_12', 'd�cembre');
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