<?php
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
/**
* Fichier de configuration de l'annuaire
*
* A éditer de façon spécifique à chaque déploiement
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Id: ann_config.inc.php,v 1.2 2005/03/08 09:43:34 alex Exp $
// +------------------------------------------------------------------------------------------------------+
*/

// Paramêtres indiquant que l'on est en français pourpermettre la mise en majuscule des caractères accentués
setlocale(LC_CTYPE, 'fr_FR');

/**
//=========================DEFINITION DE VARIABLES =================================
* Définition des variables globales
//==================================================================================
*/
$GLOBALS['AUTH'] =& $GLOBALS['_GEN_commun']['pear_auth'] ;
$GLOBALS['ann_db'] =& $GLOBALS['_GEN_commun']['pear_db'] ;

/**
//==================================== LES URLS ==================================
* Constantes liées à l'utilisation des url
//==================================================================================
*/
$GLOBALS['ann_url'] =& $GLOBALS['_GEN_commun']['url'];//l'url de base de l'application, un objet Net_URL
                                           // Créer cet objet par $GLOBALS['ins_url'] = new Net_URL('http://....') ;
define('ANN_URL_ACTUALITE', 'http://www.gentiana.org/page:20') ;
/** Variable définissant la lettre par défaut du parcour alphabétique.*/
define('ANN_LETTRE_DEFAUT', 'A') ;// une lettre de l'aphabet ou "tous"

/**
//==================================== LES CHEMINS =================================
* Constantes définissant les chemins d'accé au différents fichiers inclus dans les
* applications.
//==================================================================================
*/
define('ANN_CHEMIN_APPLI','client/annuaire/');//le chemin vers l'application courrante
define('ANN_CHEMIN_LIBRAIRIE', ANN_CHEMIN_APPLI.'bibliotheque/');//le chemin de la librairie de fichier php

/**
//==================================== CONSTANTES ==================================
* Constantes des noms de tables et de champs dans l'annuaire
//==================================================================================
*/
define ('ANN_ANNUAIRE', 'annuaire');
define ('ANN_CHAMPS_NOM', 'a_nom'); // Nom du champs nom
define ('ANN_CHAMPS_MAIL', 'a_mail'); // Nom du champs mail
define ('ANN_CHAMPS_PRENOM', 'a_prenom'); // Nom du champs prénom
define ('ANN_CHAMPS_ID', 'a_id'); // Nom du champs id
define ('ANN_CHAMPS_DATE_INS', 'a_date_inscription');
define ('ANN_CHAMPS_CODE_POSTAL', 'a_code_postal');
define ('ANN_CHAMPS_VILLE', 'a_ville');
define ('ANN_CHAMPS_PAYS', 'a_ce_pays');

define ('ANN_TABLE_PAYS', 'carto_PAYS');
define ('ANN_GC_ID', 'CP_ID_Pays');
define ('ANN_GC_NOM', 'CP_Intitule_pays');

define ('ANN_TABLE_DEPARTEMENT', 'carto_DEPARTEMENT') ;

/**
//==================================== CONSTANTES==================================
* Constantes contenant des mails
//==================================================================================
*/
define ('ANN_MAIL_ADMIN', 'Pierre SALEN <p.salen@gentiana.org>, Jean-Pascal MILCENT<jpm@tela-botanica.org>') ;
?>