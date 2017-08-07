<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant à gérer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est régi par la licence CeCILL soumise au droit français et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffusée par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilité au code source et des droits de copie,
// de modification et de redistribution accordés par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limitée.  Pour les mêmes raisons,
// seule une responsabilité restreinte pèse sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les concédants successifs.

// A cet égard  l'attention de l'utilisateur est attirée sur les risques
// associés au chargement,  à l'utilisation,  à la modification et/ou au
// développement et à la reproduction du logiciel par l'utilisateur étant 
// donné sa spécificité de logiciel libre, qui peut le rendre complexe à 
// manipuler et qui le réserve donc à des développeurs et des professionnels
// avertis possédant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invités à charger  et  tester  l'adéquation  du
// logiciel à leurs besoins dans des conditions permettant d'assurer la
// sécurité de leurs systèmes et ou de leurs données et, plus généralement, 
// à l'utiliser et l'exploiter dans les mêmes conditions de sécurité. 

// Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accepté les
// termes.
// ----
// CVS : $Id: adme_configuration.inc.php,v 1.6 2006-06-28 12:53:34 ddelon Exp $
/**
* Fichier de configuration général de l'application Administrateur de Menus.
*
* Permet de définir certains paramètres valables pour toutes l'application 
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
/** Constante stockant la valeur de la langue par défaut pour l'appli ADME.*/
define('ADME_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin des fichiers à inclure.
/** Chemin vers la bibliothèque PEAR.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_PEAR', '');
/** Chemin vers la bibliothèque API.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_API', GEN_CHEMIN_API);
/** Chemin vers la bibliothèque de Papyrus.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_GEN', GEN_CHEMIN_BIBLIO);

// Chemin vers les dossiers de l'application
/** Chemin vers l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_APPLICATION', GEN_CHEMIN_APPLICATION.'admin_menu/');
/** Chemin vers les images de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_IMAGE_INTERFACE', ADME_CHEMIN_APPLICATION.'presentations/images/interface/');
/** Chemin vers la bibliothèque de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_BIBLIOTHEQUE_ADME', ADME_CHEMIN_APPLICATION.'bibliotheque/');
/** Chemin vers les fichiers de traduction de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_LANGUE', ADME_CHEMIN_APPLICATION.'langues/');
/** Chemin vers les styles de l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_STYLE', ADME_CHEMIN_APPLICATION.'presentations/styles/');

// Chemin vers le dossier contenant les images des drapeaux des pays
/** Chemin vers le dossier contenant les images i18n l'application Admin Menus de Papyrus.*/
define('ADME_CHEMIN_IMAGE_DRAPEAUX', GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.'/'.GEN_DOSSIER_IMAGE.'/drapeaux/');

// Chemin (intégrant le nom du fichier) vers les images de l'interface de l'application
/** Chemin vers l'image ouvrir une branche.*/
define('ADME_IMAGE_PLUS',           ADME_CHEMIN_IMAGE_INTERFACE.'adme_ouvrir.png');
/** Chemin vers l'image fermer une branche.*/
define('ADME_IMAGE_MOINS',          ADME_CHEMIN_IMAGE_INTERFACE.'adme_fermer.png');
/** Chemin vers l'image voir la définition d'un menu.*/
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
/** Chemin vers l'image accéder à l'interface d'administration de l'application du menu courant.*/
define('ADME_IMAGE_TEXTE',          ADME_CHEMIN_IMAGE_INTERFACE.'adme_administrer.png');
/** Chemin vers l'image choix d'une traduction par défaut */
define('ADME_IMAGE_TRADUCTION_DEFAUT',ADME_CHEMIN_IMAGE_INTERFACE.'adme_radio_off.png');

/** Chemin vers l'image traduction par défaut */
define('ADME_IMAGE_TRADUCTION_DEFAUT_AFFICHAGE',ADME_CHEMIN_IMAGE_INTERFACE.'adme_radio_on.png');


// Nom des classes des images
/** Constante stockant le nom de la classe des fichiers icônes de 16x16px de ADME.*/
define('ADME_CLASS_IMG_ICONE', 'adme_img_icone');
/** Constante stockant le nom de la classe des fichiers plier-déplier de 9x9px de ADME.*/
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
* Changement de nom de Génésia en Papyrus.
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
