<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Papyrus.                                                                        |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: adau_langue_fr.inc.php,v 1.4 2006-10-06 10:40:51 florian Exp $
/**
* Gestion des langues de l'application ADME
*
* Contient les constantes pour la langue française de l'application ADME.
*
*@package Admin_auth
*@subpackage Langues
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE des CONSTANTES                                      |
// +------------------------------------------------------------------------------------------------------+
define('ADAU_NOM_AUTH', 'Nom authentification');
define('ADAU_NOM_TABLE', 'Nom de la table annuaire');
define('ADAU_MODIFIER', 'Modifier');
define('ADAU_SUPPRIMER', 'Supprimer');
define('ADAU_SUPPRIMER_MESSAGE', 'Êtes vous sûr de vouloir supprimer cette identification ?');
define('ADAU_AJOUTER', 'Ajouter une authentification base de donnée');
define('ADAU_IDENTIFIEZ_VOUS','Veuillez vous identifier pour acc&egrave;der &agrave; ce menu.');
define('ADAU_NOM_FORM', 'Édition des informations d\'une identification');
define('ADAU_NOM_AUTH_ALERTE', 'Vous devez spécifier un nom');
define('ADAU_CHAMPS_REQUIS', 'Indique les champs requis');
define('ADAU_ABREVIATION', 'Abréviation');
define('ADAU_ABREVIATION_ALERTE', 'Vous devez indiquer une abréviation');
define('ADAU_DSN', 'Source des donnée (dsn)');
define('ADAU_DSN_ALERTE', 'Vous devez indiquer une source des données');
define('ADAU_NOM_TABLE_ALERTE', 'Vous devez indiquer le nom de la table annuaire');
define('ADAU_CHAMPS_LOGIN', 'Nom du champs login');
define('ADAU_CHAMPS_LOGIN_ALERTE', 'Vous devez indiquer le nom du champs login');
define('ADAU_CHAMPS_PASSE', 'Nom du champs mot de passe');
define('ADAU_CHAMPS_PASSE_ALERTE', 'Vous devez indiquer le nom du champs mot de passe');
define('ADAU_CRYPTAGE', 'Fonction de cryptage');
define('ADAU_CRYPTAGE_ALERTE', 'Vous devez indiquer un algorithme de cryptage');
define('ADAU_PARAMETRE', 'Paramètres');
define('ADAU_ANNULER', 'Annuler');
define('ADAU_VALIDER', 'Valider');
define('ADAU_SYMBOLE_CHP_OBLIGATOIRE', '*');


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adau_langue_fr.inc.php,v $
* Revision 1.4  2006-10-06 10:40:51  florian
* harmonisation des messages d'erreur de l'authentification
*
* Revision 1.3  2005/04/14 13:54:51  jpm
* Amélioration de l'interface et mise en conformité.
*
* Revision 1.2  2004/12/13 18:07:57  alex
* ajout de labels
*
* Revision 1.1  2004/12/06 11:31:37  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>