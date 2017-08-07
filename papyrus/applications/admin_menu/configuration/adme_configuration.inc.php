<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant � g�rer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilit� au code source et des droits de copie,
// de modification et de redistribution accord�s par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
// seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les conc�dants successifs.

// A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
// associ�s au chargement,  � l'utilisation,  � la modification et/ou au
// d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
// donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
// manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
// avertis poss�dant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
// logiciel � leurs besoins dans des conditions permettant d'assurer la
// s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
// � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

// Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accept� les
// termes.
// ----
// CVS : $Id: adme_configuration.inc.php,v 1.6 2006-06-28 12:53:34 ddelon Exp $
/**
* Fichier de configuration g�n�ral de l'application Administrateur de Menus.
*
* Permet de d�finir certains param�tres valables pour toutes l'application 
* Administrateur de Menus.
*
*@package Admin_menu
*@subpackage Configuration
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.6 $ $Date: 2006-06-28 12:53:34 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par d�faut pour l'appli ADME.*/
define('ADME_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin des fichiers � inclure.
/** Chemin vers la biblioth�que PEAR.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_PEAR', '');
/** Chemin vers la biblioth�que API.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_API', GEN_CHEMIN_API);
/** Chemin vers la biblioth�que de Papyrus.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_GEN', GEN_CHEMIN_BIBLIO);

// Chemin vers les dossiers de l'application
/** Chemin vers l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_APPLICATION', GEN_CHEMIN_APPLICATION.'admin_menu/');
/** Chemin vers les images de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_IMAGE_INTERFACE', ADME_CHEMIN_APPLICATION.'presentations/images/interface/');
/** Chemin vers la biblioth�que de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_ADME', ADME_CHEMIN_APPLICATION.'bibliotheque/');
/** Chemin vers les fichiers de traduction de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_LANGUE', ADME_CHEMIN_APPLICATION.'langues/');
/** Chemin vers les styles de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_STYLE', ADME_CHEMIN_APPLICATION.'presentations/styles/');

// Chemin vers le dossier contenant les images des drapeaux des pays
/** Chemin vers le dossier contenant les images i18n l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_IMAGE_DRAPEAUX', GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.'/'.GEN_DOSSIER_IMAGE.'/drapeaux/');

// Chemin (int�grant le nom du fichier) vers les images de l'interface de l'application
/** Chemin vers l'image ouvrir une branche.*/
define('ADME_IMAGE_PLUS',           ADME_CHEMIN_IMAGE_INTERFACE.'adme_ouvrir.png');
/** Chemin vers l'image fermer une branche.*/
define('ADME_IMAGE_MOINS',          ADME_CHEMIN_IMAGE_INTERFACE.'adme_fermer.png');
/** Chemin vers l'image voir la d�finition d'un menu.*/
define('ADME_IMAGE_VOIR',           ADME_CHEMIN_IMAGE_INTERFACE.'adme_modifier.png');
/** Chemin vers l'image monter un menu.*/
define('ADME_IMAGE_FLECHE_HAUT',    ADME_CHEMIN_IMAGE_INTERFACE.'adme_monter.png');
/** Chemin vers l'image descendre un menu.*/
define('ADME_IMAGE_FLECHE_BAS',     ADME_CHEMIN_IMAGE_INTERFACE.'adme_descendre.png');
/** Chemin vers l'image diminuer un menu.*/
define('ADME_IMAGE_FLECHE_GAUCHE',    ADME_CHEMIN_IMAGE_INTERFACE.'adme_diminuer.png');
/** Chemin vers l'image augmenter un menu.*/
define('ADME_IMAGE_FLECHE_DROITE',     ADME_CHEMIN_IMAGE_INTERFACE.'adme_augmenter.png');
/** Chemin vers l'image supprimer un menu.*/
define('ADME_IMAGE_SUPPRIMER',      ADME_CHEMIN_IMAGE_INTERFACE.'adme_supprimer.png');
/** Chemin vers l'image ajouter un menu.*/
define('ADME_IMAGE_NOUVEAU',        ADME_CHEMIN_IMAGE_INTERFACE.'adme_ajouter.png');
/** Chemin vers l'image acc�der � l'interface d'administration de l'application du menu courant.*/
define('ADME_IMAGE_TEXTE',          ADME_CHEMIN_IMAGE_INTERFACE.'adme_administrer.png');
/** Chemin vers l'image choix d'une traduction par d�faut */
define('ADME_IMAGE_TRADUCTION_DEFAUT',ADME_CHEMIN_IMAGE_INTERFACE.'adme_radio_off.png');

/** Chemin vers l'image traduction par d�faut */
define('ADME_IMAGE_TRADUCTION_DEFAUT_AFFICHAGE',ADME_CHEMIN_IMAGE_INTERFACE.'adme_radio_on.png');


// Nom des classes des images
/** Constante stockant le nom de la classe des fichiers ic�nes de 16x16px de ADME.*/
define('ADME_CLASS_IMG_ICONE', 'adme_img_icone');
/** Constante stockant le nom de la classe des fichiers plier-d�plier de 9x9px de ADME.*/
define('ADME_CLASS_IMG_PD', 'adme_img_plier_deplier');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adme_configuration.inc.php,v $
* Revision 1.6  2006-06-28 12:53:34  ddelon
* Multilinguisme : menu par defaut
*
* Revision 1.5  2005/07/08 21:13:15  ddelon
* Gestion indentation menu
*
* Revision 1.4  2004/11/09 13:00:06  jpm
* Changement de noms des images.
*
* Revision 1.3  2004/11/09 12:51:16  jpm
* Ajout de commentaires.
*
* Revision 1.2  2004/07/06 17:07:42  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 14:39:44  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.7  2004/05/07 16:32:46  jpm
* Correction erreur de chemin.
*
* Revision 1.6  2004/05/07 09:53:58  jpm
* Ajout de commentaires et de nouvelles constantes.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
