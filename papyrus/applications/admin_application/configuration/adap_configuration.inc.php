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
// CVS : $Id: adap_configuration.inc.php,v 1.1 2004-12-13 18:07:33 alex Exp $
/**
* Fichier de configuration général de l'application Administration des applications.
*
* Permet de définir certains paramètres valables pour toutes l'application 
* Administrateur des applications.
*
*@package Admin_application
*@subpackage Configuration
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.1 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'appli ADAP.*/
define('ADAP_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin des fichiers à inclure.
/** Chemin vers la bibliothèque PEAR.*/
define('ADAP_CHEMIN_BIBLIOTHEQUE_PEAR', '');
/** Chemin vers la bibliothèque API.*/
define('ADAP_CHEMIN_BIBLIOTHEQUE_API', GEN_CHEMIN_API);
/** Chemin vers la bibliothèque de Papyrus.*/
define('ADAP_CHEMIN_BIBLIOTHEQUE_GEN', GEN_CHEMIN_BIBLIO);

// Chemin vers les dossiers de l'application
/** Chemin vers l'application Admin Auth de Papyrus.*/
define('ADAP_CHEMIN_APPLICATION', GEN_CHEMIN_APPLICATION.'admin_application/');
/** Chemin vers les images de l'application Admin Auth de Papyrus.*/
define('ADAP_CHEMIN_IMAGE_INTERFACE', ADAP_CHEMIN_APPLICATION.'presentations/images/interface/');
/** Chemin vers la bibliothèque de l'application Admin Auth de Papyrus.*/
define('ADAP_CHEMIN_BIBLIOTHEQUE', ADAP_CHEMIN_APPLICATION.'bibliotheque/');
/** Chemin vers les classes de l'application Admin Auth de Papyrus.*/
define('ADAP_CHEMIN_CLASSES', ADAP_CHEMIN_APPLICATION.'classes/');
/** Chemin vers les fichiers de traduction de l'application Admin Auth de Papyrus.*/
define('ADAP_CHEMIN_LANGUE', ADAP_CHEMIN_APPLICATION.'langues/');
/** Chemin vers les styles de l'application Admin Auth de Papyrus.*/
define('ADAP_CHEMIN_STYLE', ADAP_CHEMIN_APPLICATION.'presentations/styles/');



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adap_configuration.inc.php,v $
* Revision 1.1  2004-12-13 18:07:33  alex
* version initiale
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
