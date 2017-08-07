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
// CVS : $Id: adsi_configuration.inc.php,v 1.5 2006-03-22 13:18:00 alexandre_tb Exp $
/**
* Fichier de configuration général de l'application Administrateur de sites.
*
* Permet de définir certains paramètres valables pour toutes l'application 
* Administrateur de sites.
*
*@package Admin_site
*@subpackage Configuration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.5 $ $Date: 2006-03-22 13:18:00 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
// Chemin des fichiers à inclure.
/** <br> Chemin vers le dossier de Pear.*/
define('ADSI_CHEMIN_BIBLIOTHEQUE_PEAR','');
/** <br> Chemin vers le dossier des API.*/
define('ADSI_CHEMIN_BIBLIOTHEQUE_API', GEN_CHEMIN_API);
/** <br> Chemin vers le dossier des bibliothèques de l'appli Papyrus.*/
define('ADSI_CHEMIN_BIBLIOTHEQUE_GEN', GEN_CHEMIN_BIBLIO);
/** <br> Chemin vers le dossier des bibliothèques de l'appli Admin sites.*/
define('ADSI_CHEMIN_BIBLIOTHEQUE_ADSI', GEN_CHEMIN_APPLICATION.'admin_site/bibliotheque/');

// Chemin vers les dossiers de l'application
/** Chemin vers l'application Admin Site de Papyrus.*/
define('ADSI_CHEMIN_APPLICATION', GEN_CHEMIN_APPLICATION.'admin_site/');
/** Chemin vers les fichiers de traduction de l'application Admin Auth de Papyrus.*/
define('ADSI_CHEMIN_LANGUE', ADSI_CHEMIN_APPLICATION.'langues/');

define ('ADSI_I18N_DEFAUT', 'fr');
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adsi_configuration.inc.php,v $
* Revision 1.5  2006-03-22 13:18:00  alexandre_tb
* ajout de la constante ADSI_I18N_DEFAUT
*
* Revision 1.4  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.3.2.1  2006/02/28 14:02:11  ddelon
* Finition multilinguisme
*
* Revision 1.3  2005/02/28 10:59:38  jpm
* Modification des commentaires.
*
* Revision 1.2  2004/07/06 17:08:20  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 14:20:28  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.1  2004/05/07 08:21:39  jpm
* Ajout des constantes de définition des chemins des fichiers à inclure.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>