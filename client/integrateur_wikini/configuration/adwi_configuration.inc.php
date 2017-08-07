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
// CVS : $Id: adwi_configuration.inc.php,v 1.2 2005-09-09 09:37:17 ddelon Exp $
/**
* Fichier de configuration général de l'application Administration des wikini
*
* Permet de définir certains paramètres valables pour toutes l'application 
* Administrateur des Wikni
*
*@package Admin_Wikini
*@subpackage Configuration
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        David Delon <david.delon@clapas.net>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.2 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Constante stockant la valeur de la langue par défaut pour l'appli ADAP.*/
define('ADWI_I18N_DEFAUT', GEN_I18N_ID_DEFAUT);

// Chemin des fichiers à inclure.
/** Chemin vers la bibliothèque PEAR.*/
define('ADWI_CHEMIN_BIBLIOTHEQUE_PEAR', '');
/** Chemin vers la bibliothèque API.*/
define('ADWI_CHEMIN_BIBLIOTHEQUE_API', GEN_CHEMIN_API);
/** Chemin vers la bibliothèque de Papyrus.*/
define('ADWI_CHEMIN_BIBLIOTHEQUE_GEN', GEN_CHEMIN_BIBLIO);



// Chemin vers les dossiers de l'application
/** Chemin vers l'application Admin Auth de Papyrus.*/
define('ADWI_CHEMIN_APPLICATION', GEN_CHEMIN_CLIENT.'integrateur_wikini/');
/** Chemin vers la bibliothèque de l'application gestion des Wikini de Papyrus.*/
define('ADWI_CHEMIN_BIBLIOTHEQUE', ADWI_CHEMIN_APPLICATION.'bibliotheque/');
/** Chemin vers la reference Wikini de l'application gestion des Wikini de Papyrus.*/
define('ADWI_CHEMIN_BIBLIOTHEQUE_WIKINI', ADWI_CHEMIN_BIBLIOTHEQUE.'wikini/');
/** Chemin vers les fichiers de traduction de l'application Admin Auth de Papyrus.*/
define('ADWI_CHEMIN_LANGUE', ADWI_CHEMIN_APPLICATION.'langues/');
/** Constante stockant le chemin du dossier contenant les sites Wikini.*/
define('ADWI_CHEMIN_WIKINI', GEN_CHEMIN_WIKINI);



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adwi_configuration.inc.php,v $
* Revision 1.2  2005-09-09 09:37:17  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/08/25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2004/12/13 18:07:33  alex
* version initiale
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
