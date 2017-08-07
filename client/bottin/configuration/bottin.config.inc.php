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
// CVS : $Id: bottin.config.inc.php,v 1.16 2007/04/11 08:30:12 neiluj Exp $
/**
* Fichier de configuration de l'application d'inscription/annuaire
*
* A éditer de façon spécifique à chaque déploiement
*
*@package ins_annuaire
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.16 $ $Date: 2007/04/11 08:30:12 $
// +------------------------------------------------------------------------------------------------------+
*/
//================================= CONSTANTES DB ==================================
/** Nom de la table Annuaire */
define ('INS_ANNUAIRE', 'annuaire');
/** Nom de la table des départements */ 
define ('INS_TABLE_DPT', 'gen_departement');
/** Nom de la table des pays */
define ('INS_TABLE_PAYS', 'gen_i18n_pays');
/** Champs identifiant */
define ('INS_CHAMPS_ID', 'a_id');                   
/** Champs adresse mail */
define ('INS_CHAMPS_MAIL', 'a_mail');
/** Champs nom */
define ('INS_CHAMPS_NOM', 'a_nom');
/** Champs prénom */
define ('INS_CHAMPS_PRENOM', 'a_prenom');
/** Champs description */
define ('INS_CHAMPS_DESCRIPTION','a_description');
/** Champs mot de passe */
define ('INS_CHAMPS_PASSE', 'a_mot_de_passe');
/** Champs identifiant pays */
define ('INS_CHAMPS_PAYS', 'a_ce_pays');
/** Champs code postal */
define ('INS_CHAMPS_CODE_POSTAL', 'a_code_postal');
/** Champs département */
define ('INS_CHAMPS_DEPARTEMENT', 'a_numero_dpt');
/** Champs adresse 1 */
define ('INS_CHAMPS_ADRESSE_1', 'a_adresse1');
/** Champs adresse 2 */
define ('INS_CHAMPS_ADRESSE_2', 'a_adresse2');
/** Champs ville */
define ('INS_CHAMPS_VILLE', 'a_ville');
/** Champs date de l'inscription */
define ('INS_CHAMPS_DATE_INSCRIPTION', 'a_date_inscription');
/** Champs pour désigner si c'est l'inscription d'une structure */
define ('INS_CHAMPS_EST_STRUCTURE', 'a_est_structure');
/** Champs sigle de la structure */
define ('INS_CHAMPS_SIGLE_STRUCTURE', 'a_sigle_structure');
/** Champs numéro de téléphone */
define ('INS_CHAMPS_TELEPHONE', 'a_telephone');
/** Champs numéro de fax */
define ('INS_CHAMPS_FAX', 'a_fax');
/** Champs d'appartenance à une structure */
define ('INS_CHAMPS_STRUCTURE', 'a_ce_structure');
/** Champs identifiant du pays de la table des pays*/
define ('INS_CHAMPS_ID_PAYS', 'gip_id_pays');
/** Champs nom du pays de la table des pays*/
define ('INS_CHAMPS_LABEL_PAYS', 'gip_nom_pays_traduit');
/** Champs qui contient la localisation */
define ('INS_CHAMPS_I18N_PAYS', ' gip_id_i18n') ;
/** Champs identifiant du département de la table des departement*/
define ('INS_CHAMPS_ID_DEPARTEMENT','gd_id_departement');
/** Champs nom du département de la table des departement*/
define ('INS_CHAMPS_NOM_DEPARTEMENT','gd_nom');
/** Champs pour l'abonnement à une liste, laisser vide si vous ne souhaitez pas d'inscription' */
define ('INS_CHAMPS_LETTRE', 'a_lettre');
/** Champs de la date d'inscription */
define ('INS_CHAMPS_DATE', 'a_date_inscription');
/** Champs du site Internet*/
define ('INS_CHAMPS_SITE_INTERNET', 'a_site_internet');
/** Champs pour la vue sur carto*/
define ('INS_CHAMPS_VISIBLE', 'a_voir_sur_carto');
/** Champs pour la vue sur carto*/
define ('INS_CHAMPS_NUM_AGREMENT', 'a_num_agrement_fpc');
/** Champs pour le logo*/
define ('INS_CHAMPS_LOGO', 'a_logo');


if (INS_CHAMPS_LETTRE != '') {
	/** adresse d'inscription à la newsletter */
	define ('INS_MAIL_INSCRIPTION_LISTE', 'newsletter-subscribe@domaine.org');
	/** adresse de désinscription à la newsletter */
	define ('INS_MAIL_DESINSCRIPTION_LISTE', 'newsletter-unsubscribe@domaine.org');
}

//teste si l'on est dans l'application Papyrus
if (!defined('PAP_VERSION')) { //pas dans Papyrus
	//================================ BASE DE DONNEES =================================
	define ('INS_PROTOCOLE', 'mysql') ;
	define ('INS_UTILISATEUR', '') ;
	define ('INS_MOT_DE_PASSE_DB', '') ;
	define ('INS_HOTE', 'localhost') ;
	define ('INS_BASE', '') ;
	define ('INS_TYPE_ENCODAGE','MD5');
	
	// Formation du dsn
	$dsn = INS_PROTOCOLE.'://'.INS_UTILISATEUR.':'.INS_MOT_DE_PASSE_DB.'@'.INS_HOTE.'/'.INS_BASE;

	include_once PAP_CHEMIN_RACINE.'api/pear/DB.php'; //appel de la librairie DB de PEAR
	/** Variable globale contenant l'objet d'accès à la base de donnée */
	$GLOBALS['ins_db'] =& DB::connect($dsn);
	
	//=============================== AUTHENTIFICATION =================================
	include_once PAP_CHEMIN_RACINE.'api/pear/Auth.php'; //appel de la librairie Auth de PEAR
	/** Nom de la session PHP */
	define ('INS_NOM_SESSION','Educ-Envir.org'); 
	/** Durée de la session PHP */
	define ('INS_DUREE_SESSION',3600*12);
	/** Tableau des parametres de l'authentification */
	$params = array(
		 'dsn' => $dsn,
	     'table' => INS_ANNUAIRE,
		 'usernamecol' => INS_CHAMPS_MAIL,
		 'passwordcol' => INS_CHAMPS_MOT_DE_PASSE
	);
	/** Variable globale contenant l'objet d'authentification de l'application, un objet AUTH*/
	$GLOBALS['AUTH']=  new Auth($GLOBALS['ins_db'], $params );
	$GLOBALS['AUTH']->setSessionname(INS_NOM_SESSION);
	$GLOBALS['AUTH']->setExpire(INS_DUREE_SESSION);
	$GLOBALS['AUTH']->setShowLogin(false);
	
	//==================================== LES URLS ====================================
	include_once PAP_CHEMIN_RACINE.'api/pear/Net_URL.php'; //appel de la librairie Net_URL de PEAR
	/** Variable globale contenant l'objet d'accès à l'URL de base de l'application, un objet Net_URL*/
	$GLOBALS['ins_url'] = new Net_URL('http://localhost/');

	//===================================== CHEMINS ====================================
	/** Chemin de l'application (mettre un / à la fin) */
	define ('INS_CHEMIN_APPLI', '/');

	//===================================== LANGUES ====================================
	/** Choix de la langue par défaut de l'application */
	define ('INS_LANGUE_DEFAUT', 'fr'); 
	include_once INS_CHEMIN_APPLI.'langues/ins_annuaire.langue.'.INS_LANGUE_DEFAUT.'.inc.php'; //appel du fichier de constantes des langues
	
	
} else { //dans Papyrus
	//================================ BASE DE DONNEES =================================
	/** Variable globale contenant l'objet d'accès à la base de données de l'application, un objet DB*/
	$GLOBALS['ins_db'] =& $GLOBALS['_GEN_commun']['pear_db'];

	//=========================AUTHENTIFICATION=================================
	/** Variable globale contenant l'objet d'authentification de l'application, un objet AUTH*/
	$GLOBALS['AUTH'] =& $GLOBALS['_GEN_commun']['pear_auth'];
	
	//==================================== LES URLS ====================================
	/** Variable globale contenant l'objet d'accès à l'URL de base de l'application, un objet Net_URL*/
	$GLOBALS['ins_url'] =& $GLOBALS['_GEN_commun']['url'];

	//===================================== CHEMINS ====================================
	/** Chemin de l'application (mettre un / à la fin) */
	define ('INS_CHEMIN_APPLI', 'client/bottin/');

	//===================================== LANGUES ====================================
	/** Choix de la langue par défaut de l'application */
	define ('INS_LANGUE_DEFAUT', $GLOBALS['_GEN_commun']['i18n']) ;
	include_once INS_CHEMIN_APPLI.'langues/bottin.langue_'.INS_LANGUE_DEFAUT.'.inc.php'; //appel du fichier de constantes des langues
}


/** Définir la présence d'un formulaire d'inscription de structure (mettre à 1 pour oui, 0 pour non */

/** Définir la présence d'un formulaire d'inscription de structure (mettre à 1 pour oui, 0 pour non */


/** Définir la nécessité d'envoyer un message de confirmation d'inscription (mettre à 1 pour oui, 0 pour non */
define ('INS_MAIL_VALIDATION_INSCRIPTION', 1);

/** Adresse de messagerie de l'administrateur, pour suivre les inscriptions */
define ('INS_MAIL_ADMIN_APRES_INSCRIPTION', 'jpm@tela-botanica.org');

$GLOBALS['mail_admin'] = array ('jpm@tela-botanica.org') ;   // Liste des personne recevant le mail
   
/** Sujet du message envoyé pour l'inscription */
define ('INS_MAIL_ADMIN_APRES_INSCRIPTION_SUJET', '[nom] Inscription');

/** L'inscription génère t'elle l'inscription à un Spip? Mettre à 1 pour oui , et 0 pour non */
define ('INS_UTILISE_SPIP', 0);    
if (INS_UTILISE_SPIP) {
	/** Chemin d'accès au Spip */
	define ('INS_CHEMIN_SPIP', '');
}

/** L'inscription génère t'elle l'inscription à un Wikini? Mettre à 1 pour oui , et 0 pour non */
define ('INS_UTILISE_WIKINI', 1);
if (INS_UTILISE_WIKINI) {
	/** Le nom du champs contenant le nom wikini dans l'annuaire */
	define ('INS_CHAMPS_NOM_WIKINI', 'a_nom_wikini');
	
	/** Le nom Wiki est il genere automatiquement */
	define ('INS_NOM_WIKINI_GENERE', 1) ;
}

/** L'inscription utilise t'elle le module projet? Mettre à 1 pour oui , et 0 pour non */
define ('INS_UTILISE_MODULE_PROJET', 1) ;
if (INS_UTILISE_MODULE_PROJET) {
    define ('INS_CHEMIN_PROJET', 'client/projet/') ;
}

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
    define ('INS_URL_PREFIXE', 'ins_') ;         // Indique le préfixe de l'url http://www.mondomaine.org/prefix____
}

define ('INS_GOOGLE_KEY', 'ABQIAAAAh5MiVKCtb2JEli5I8GRSIhRbQSKaqiLzq_1FqOv3C6TjQ0qw7BS-0YnGUkxsLmj6a2a1z7YsKC-pYg');
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: bottin.config.inc.php,v $
* Revision 1.16  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.14  2006/12/01 13:23:17  florian
* integration annuaire backoffice
*
* Revision 1.13  2006/09/20 14:56:41  alexandre_tb
* correction de la valeur par défaut INS_CHAMPS_I18N_PAYS
*
* Revision 1.12  2006/09/12 15:44:18  alexandre_tb
* suppression du $GLOBALS['mail_admin'] en double
*
* Revision 1.11  2006/09/12 15:40:33  alexandre_tb
* modification des valeurs par défaut
* utilisation de gen_i18n_pays pour la table des pays
*
* Revision 1.10  2006/06/29 07:47:22  alexandre_tb
* ajout du tableau mail_admin
*
* Revision 1.9  2006/04/28 12:44:05  florian
* integration bazar
*
* Revision 1.8  2006/04/10 09:51:28  alexandre_tb
* ajout de la constante INS_NOM_WIKINI_GENERE.
*
* Revision 1.7  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.6  2006/03/15 11:04:27  alexandre_tb
* ajout du tableau mail_admin qui contient la liste des administrateurs qui recevront un double du mail d'inscription
*
* Revision 1.5  2005/12/19 13:16:38  alexandre_tb
* généricité du fichier de config
*
* Revision 1.4  2005/12/19 11:06:01  alexandre_tb
* modification dans la table annuaire
*
* Revision 1.3  2005/11/17 18:48:02  florian
* corrections bugs + amÃ©lioration de l'application d'inscription
*
* Revision 1.2  2005/09/29 13:56:48  alexandre_tb
* En cours de production. Reste à gérer les news letters et d'autres choses.
*
* Revision 1.1  2005/09/27 13:56:18  alexandre_tb
* version initiale, les autres fichiers de configurations devraient progressivement disparaitre.
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
