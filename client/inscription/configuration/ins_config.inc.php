<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1																					  |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)							   	          |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or										  |
// | modify it under the terms of the GNU Lesser General Public										      |
// | License as published by the Free Software Foundation; either										  |
// | version 2.1 of the License, or (at your option) any later version.								      |
// |																									  |
// | This library is distributed in the hope that it will be useful,									  |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of									      |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU									  |
// | Lesser General Public License for more details.													  |
// |																									  |
// | You should have received a copy of the GNU Lesser General Public									  |
// | License along with this library; if not, write to the Free Software								  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA							  |
// +------------------------------------------------------------------------------------------------------+
/**
* Fichier de configuration de l'inscription
*
* A éditer de façon spécifique à chaque déploiement
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author		Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Id: ins_config.inc.php,v 1.3 2005/05/13 13:49:15 alex Exp $
// +------------------------------------------------------------------------------------------------------+
*/


/**
//=========================DEFINITION DE VARIABLES =================================
* Définition des variables globales
//==================================================================================
*/

$GLOBALS['AUTH'] =& $GLOBALS['_GEN_commun']['pear_auth'] ;

/**
//==================================== LES URLS ==================================
* Constantes liées à l'utilisation des url
//==================================================================================
*/
$GLOBALS['ins_url'] =& $GLOBALS['_GEN_commun']['url'] ;
$GLOBALS['ins_db'] =& $GLOBALS['_GEN_commun']['pear_db'] ;
define('INS_CHEMIN_FICHIER', 'client/inscription/') ;

/**
//==================================== CONSTANTES ==================================
* Constantes des noms de tables et de champs dans l'annuaire
//==================================================================================
*/
define('INS_ANNUAIRE', 'annuaire') ;
define ('INS_CHAMPS_ID', 'a_id') ;
define ('INS_CHAMPS_MAIL', 'a_mail');// Nom du champs mail
define ('INS_CHAMPS_LOGIN', 'a_nom_wikini') ;
define ('INS_CHAMPS_NOM', 'a_nom') ;
define ('INS_CHAMPS_PRENOM', 'a_prenom') ;
define ('INS_CHAMPS_PASSE', 'a_mot_de_passe') ;
define ('INS_CHAMPS_PAYS', 'a_ce_pays') ;
define ('PROJET_PRENOM', 'a_prenom') ;             // Nom du champs prénom
define ('PROJET_DPT', 'carto_DEPARTEMENT') ;       // Nom de la table département
define ('INS_TABLE_PAYS', 'carto_PAYS') ;          // Nom de la table pays
define ('INS_CHAMPS_ID_PAYS', 'CP_ID_Pays') ;
define ('INS_CHAMPS_LABEL_PAYS', 'CP_Intitule_pays') ;
define ('INS_CHAMPS_PAYS_LG', 'CP_Langue_intitule') ;// Langue de l'intitule du pays
define ('INS_CHAMPS_CODE_POSTAL', 'a_code_postal') ;
define ('INS_CHAMPS_VILLE', 'a_ville') ;
define ('INS_CHAMPS_ADRESSE_1', 'a_adresse1') ;
define ('INS_CHAMPS_ADRESSE_2', 'a_adresse2') ;
define ('INS_CHAMPS_REGION', 'a_region') ;
define ('INS_CHAMPS_DPT', 'a_numero_dpt') ;
define ('INS_CHAMPS_SITE_WEB', 'a_site_internet') ;
define ('INS_CHAMPS_TELEPHONE', 'a_telephone') ;
define ('INS_CHAMPS_FAX', 'a_fax') ;
define ('INS_CHAMPS_STRUCTURE', 'a_structure') ;
define ('INS_CHAMPS_DATE', 'a_date_inscription') ;
define ('INS_CHAMPS_LETTRE', 'a_lettre') ;  // Le champs qui indique si l'usager est inscrit à la lettre d'inscription

/**
//==================================== PARAMETRAGE =================================
* Pour régler certaines fonctionnalité de l'application
//==================================================================================
*/
// Indique le type de cryptage du mot de passe à appliquer (doit être identique à PEAR_AUTH)
define ('INS_MDP_CRYPTYPE', 'md5');// Choix : md5 seulement

define ('INS_MAIL_ADMIN_APRES_INSCRIPTION', 'Association Gentiana <gentiana@gentiana.org>') ;
define ('INS_MAIL_ADMIN_APRES_INSCRIPTION_SUJET', '[Gentiana] Inscription') ;

define ('INS_UTILISE_LISTE', false);// Mettre à false si pas de liste d'actu
define ('INS_MAIL_INSCRIPTION_LISTE', 'actu-subscribe@tela-botanica.org') ;
define ('INS_MAIL_DESINSCRIPTION_LISTE', 'actu-unsubscribe@tela-botanica.org') ;

// Liste des personne recevant le mail après inscription
$GLOBALS['mail_admin'] = array ('Pierre SALEN <p.salen@gentiana.org>', 'Jean-Pascal MILCENT <jpm@tela-botanica.org>') ;   

/**
//==================================== PARAMETRAGE =================================
* Pour gérer la réécriture d'url de l'inscription
* Cela nécessite une ligne dans le fichier .htaccess, par exemple
* RewriteRule ^ins([0-9a-z]*)$ papyrus.php?menu=22&id=$1 [L]
* Cela sert à racourcir l'URL de confirmation d'inscription
//==================================================================================
*/
define ('INS_UTILISE_REECRITURE_URL', 1) ;      // mettre à 1 si on souhaite utiliser la réécriture
if (INS_UTILISE_REECRITURE_URL) {
    define ('INS_URL_PREFIXE', '_ins_') ;         // Indique le préfixe de l'url http://www.mondomaine.org/prefix____
}

define ('INS_UTILISE_STAT', false);
define ('INS_TABLE_STATISTIQUE', 'ins_STATS') ;
define ('INS_STATS_CHAMPS_DATE', 'IS_DATE') ;
define ('INS_STATS_CHAMPS_ACTION', 'IS_ACTION') ;

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ins_config.inc.php,v $
* Revision 1.3  2005/05/13 13:49:15  alex
* ajout de la réécriture d'url et des statistiques
*
* Revision 1.2  2005/03/21 16:50:31  alex
* mille et une corrction
*
* Revision 1.1  2005/03/04 10:39:41  tam
* installation
*
* Revision 1.1  2004/07/06 15:42:17  alex
* en cours
*
* Revision 1.4  2004/07/06 15:31:33  alex
* en cours
*
* Revision 1.3  2004/06/30 10:00:53  alex
* ajout de champs pour gérer les pays
*
* Revision 1.2  2004/06/18 09:20:54  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>