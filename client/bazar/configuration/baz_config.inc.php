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
// CVS : $Id: baz_config.inc.php,v 1.30 2007-07-04 10:04:40 alexandre_tb Exp $
/**
* Fichier de configuration du bazar
*
* A éditer de façon spécifique à chaque déploiement
*
*@package bazar
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.30 $ $Date: 2007-07-04 10:04:40 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                             LES CONSTANTES DES ACTIONS DE BAZAR                                      |
// +------------------------------------------------------------------------------------------------------+

define ('BAZ_VOIR_TOUTES_ANNONCES', 1) ;
define ('BAZ_ACTION_VOIR_VOS_ANNONCES', 2);
define ('BAZ_DEPOSER_ANNONCE', 3) ;
define ('BAZ_ANNONCES_A_VALIDER', 4) ;
define ('BAZ_GERER_DROITS', 5) ;
define ('BAZ_ADMINISTRER_ANNONCES', 6) ;
define ('BAZ_MODIFIER_FICHE', 7) ;
if (!defined('BAZ_VOIR_FICHE')) define ('BAZ_VOIR_FICHE', 8) ;
define ('BAZ_SUPPRIMER_FICHE', 9) ;
define ('BAZ_ACTION_NOUVEAU', 10) ;
define ('BAZ_ACTION_NOUVEAU_V', 11) ;
define ('BAZ_ACTION_MODIFIER', 12) ;
define ('BAZ_ACTION_MODIFIER_V', 13) ;
define ('BAZ_ACTION_SUPPRESSION', 14) ;
define ('BAZ_ACTION_PUBLIER', 15) ;
define ('BAZ_ACTION_PAS_PUBLIER', 16) ;
define ('BAZ_S_INSCRIRE', 17);
define ('BAZ_VOIR_FLUX_RSS', 18);

// Constante des noms des variables
define ('BAZ_VARIABLE_VOIR', 'vue');
define ('BAZ_VARIABLE_ACTION', 'action');
/** Indique les onglets de vues à afficher.*/
define ('BAZ_VOIR_AFFICHER', '2,5,6');// Indiquer les numéros des vues séparés par des virgules.
/** Permet d'indiquer la vue par défaut si la variable vue n'est pas défini dans l'url ou dans les paramêtre du menu Papyrus.*/
define ('BAZ_VOIR_DEFAUT', '2');
define ('BAZ_VOIR_CONSULTER', 1);
define ('BAZ_VOIR_MES_FICHES', 2);
define ('BAZ_VOIR_S_ABONNER', 3);
define ('BAZ_VOIR_SAISIR', 4);
define ('BAZ_VOIR_ADMIN', 5);
define ('BAZ_VOIR_GESTION_DROITS', 6);


//==================================== LES FLUX RSS==================================
// Constantes liées aux flux RSS
//==================================================================================

define('BAZ_CREER_FICHIERS_XML',0);      //0=ne cree pas le fichier XML dans rss/; 1=cree le fichier XML dans rss/
define('BAZ_RSS_NOMSITE','gentiana.org');    //Nom du site indiqué dans les flux rss
define('BAZ_RSS_ADRESSESITE','http://www.gentiana.org/');   //Adresse Internet du site indiquÃƒÂ© dans les flux rss
define('BAZ_RSS_DESCRIPTIONSITE','Gentiana, Société botanique dauphinoise Dominique Villars.');    //Description du site indiquée dans les flux rss
define('BAZ_RSS_LOGOSITE','http://www.gentiana.org/sites/gentiana/generique/images/graphisme/logo_gentiana.png');     //Logo du site indiqué dans les flux rss
define('BAZ_RSS_MANAGINGEDITOR', 'p.salen@gentiana.org') ;     //Managing editor du site
define('BAZ_RSS_WEBMASTER', 'p.salen@gentiana.org') ;     //Mail Webmaster du site
define('BAZ_RSS_CATEGORIE', 'Botanique'); //catégorie du flux RSS


//==================================== PARAMETRAGE =================================
// Pour régler certaines fonctionnalité de l'application
//==================================================================================

define ('BAZ_ETAT_VALIDATION', 0); 
//Valeur par défaut d'état de la fiche annonce après saisie 
//Mettre 0 pour 'en attente de validation d'un administrateur'
//Mettre 1 pour 'directement validée en ligne'

define ('BAZ_TAILLE_MAX_FICHIER', 2000*1024);
//Valeur maximale en octets pour la taille d'un fichier joint à télécharger

define ('BAZ_TYPE_AFFICHAGE_LISTE', 'jma');
$GLOBALS['_BAZAR_']['db'] =& $GLOBALS['_GEN_commun']['pear_db'];
$GLOBALS['AUTH'] =& $GLOBALS['_GEN_commun']['pear_auth'];
	
define ('BAZ_ANNUAIRE','annuaire'); //Table annuaire
define ('BAZ_CHAMPS_ID','a_id'); //Champs index sur la table annuaire
define ('BAZ_CHAMPS_NOM','a_nom'); //Champs nom sur la table annuaire
define ('BAZ_CHAMPS_PRENOM','a_prenom'); //Champs prenom sur la table annuaire
define ('BAZ_CHAMPS_EST_STRUCTURE','a_est_structure'); //Champs indiquant si c'est une structure qui est identifiée
define ('BAZ_CHAMPS_EMAIL','a_mail'); //Champs prenom sur la table annuaire
define ('BAZ_CHAMPS_NOM_WIKI','a_nom_wikini'); //Champs nom wikini sur la table annuaire

/** Réglage des droits pour déposer des annonces */
// Mettre à true pour limiter le dépot aux rédacteurs
define ('BAZ_RESTREINDRE_DEPOT', 0) ;

/** Réglage de l'affichage de la liste deroulante pour la saisie des dates */
// Mettre à true pour afficher une liste deroulante vide pour la saisie des dates
define ('BAZ_DATE_VIDE', 0);

/** Réglage de l'URL de l'annuaire */
// Mettre l'URL correspondant à l'annuaire
define ('BAZ_URL_ANNUAIRE', 'http://www.gentiana.org/page:annuaire');

// Mettre à true pour faire apparaitre un champs texte déroulant dans le formulaire
// de recherche des fiches, pour choisir les émetteurs
define ('BAZ_RECHERCHE_PAR_EMETTEUR', 1) ;

$GLOBALS['_BAZAR_']['url'] = $GLOBALS['_GEN_commun']['url'];

//BAZ_CHEMIN_APPLI : chemin vers l'application bazar METTRE UN SLASH (/) A LA FIN!!!!
define('BAZ_CHEMIN_APPLI', PAP_CHEMIN_RACINE.'client/bazar/');

/**Choix de l'affichage (true) ou pas (false) de l'email du rédacteur dans la fiche.*/
define('BAZ_FICHE_REDACTEUR_MAIL', false);// true ou false

//==================================== LES LANGUES ==================================
// Constantes liées à l'utilisation des langues
//==================================================================================
$GLOBALS['_BAZAR_']['langue'] = 'fr-FR';
define ('BAZ_LANGUE_PAR_DEFAUT', 'fr') ; //Indique un code langue par défaut
define ('BAZ_VAR_URL_LANGUE', 'lang') ; //Nom de la variable GET qui sera passée dans l'URL (Laisser vide pour les sites monolingues)
//code pour l'inclusion des langues NE PAS MODIFIER
if (BAZ_VAR_URL_LANGUE != '' && isset (${BAZ_VAR_URL_LANGUE})) {
    include_once BAZ_CHEMIN_APPLI.'langues/baz_langue_'.${BAZ_VAR_URL_LANGUE}.'.inc.php';
} else {
    include_once BAZ_CHEMIN_APPLI.'langues/baz_langue_'.BAZ_LANGUE_PAR_DEFAUT.'.inc.php';
}

// Option concernant la division des resultats en pages
define ('BAZ_NOMBRE_RES_PAR_PAGE', 30);
define ('BAZ_MODE_DIVISION', 'Jumping'); 	// 'Jumping' ou 'Sliding' voir http://pear.php.net/manual/fr/package.html.pager.compare.php
define ('BAZ_DELTA', 12);		// Le nombre de page à afficher avant le 'next';

/** Réglage de l'affichage du formulaire de recherche avancee */
// Mettre à true pour afficher automatiquement le formulaire de recherche avancee, à false pour avoir un lien afficher la recherche avancee
define ('BAZ_MOTEUR_RECHERCHE_AVANCEE', 1);

/** Réglage de l'utilisation ou non des templates */
// Mettre à true pour afficher les pages incluses dans la base bazar_template, à false sinon
define ('BAZ_UTILISE_TEMPLATE', 0);

// Mettre ici le type d'annonce qui va s'afficher dans les calendriers. 
// Il est possible d'indiquer plusieurs identifiant de nature de fiche  (bn_id_nature) en séparant les nombre par des 
// virgules : '1,2,3'
define ('BAZ_NUM_ANNONCE_CALENDRIER', 3);

define ('BAZ_CHEMIN_SQUELETTE', BAZ_CHEMIN_APPLI.'squelettes'.GEN_SEP);
define ('BAZ_SQUELETTE_DEFAUT', 'baz_cal.tpl.html');

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: baz_config.inc.php,v $
* Revision 1.30  2007-07-04 10:04:40  alexandre_tb
* ajout d une variable $_GET['vue'] en complement de la variable action.
* Elle correspond aux 6 vues du bazar (consulter, mes fiches, s'abonner, saisir, administrer, gestion des droits)
*
* Revision 1.29  2007-06-25 09:57:37  alexandre_tb
* ajout de constante sur le chemin par defaut des squelettes
*
* Revision 1.28  2007/04/20 09:57:21  florian
* correction bugs suite au merge
*
* Revision 1.27  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.21.2.1  2007/02/15 13:43:54  jp_milcent
* Ajout de commentaire pour la constante utilisée par le Calendrier.
*
* Revision 1.21  2006/10/05 08:53:50  florian
* amelioration moteur de recherche, correction de bugs
*
* Revision 1.20  2006/07/04 13:59:01  alexandre_tb
* Ajout de la constante BAZ_NUM_ANNONCE_CALENDRIER dans le fichier de conf. Elle indique le type d'annonce que le calendrier doit afficher
*
* Revision 1.19  2006/06/21 15:40:15  alexandre_tb
* rétablissement du menu mes fiches
*
* Revision 1.18  2006/06/02 09:29:30  florian
* ajout constante nom wikini
*
* Revision 1.17  2006/05/19 13:53:57  florian
* stabilisation du moteur de recherche, corrections bugs, lien recherche avancee
*
* Revision 1.16  2006/05/17 09:48:48  alexandre_tb
* Ajout des constantes pour le découpage en page
*
* Revision 1.15  2006/04/28 12:46:14  florian
* integration des liens vers annuaire
*
* Revision 1.14  2006/03/24 09:23:30  alexandre_tb
* ajout de la variable globale $GLOBALS['_BAZAR_']['filtre']
*
* Revision 1.13  2006/03/14 17:10:21  florian
* ajout des fonctions de syndication, changement du moteur de recherche
*
* Revision 1.12  2006/02/07 13:57:41  alexandre_tb
* ajout de la constante pour masquer la liste des émetteurs
*
* Revision 1.11  2006/01/18 10:03:36  florian
* recodage de l'insertion et de la maj des donnÃ©es relatives aux listes et checkbox dans des formulaires
*
* Revision 1.10  2006/01/03 10:19:31  florian
* Mise Ã  jour pour accepter des parametres dans papyrus: faire apparaitre ou non le menu, afficher qu'un type de fiches, dÃ©finir l'action par dÃ©faut...
*
* Revision 1.9  2005/12/16 15:47:54  alexandre_tb
* ajout de l'option restreindre dépôt
*
* Revision 1.8  2005/10/24 09:42:21  florian
* mise a jour appropriation
*
* Revision 1.7  2005/10/21 16:15:04  florian
* mise a jour appropriation
*
* Revision 1.6  2005/09/30 12:22:54  florian
* Ajouts commentaires pour fiche, modifications graphiques, maj SQL
*
* Revision 1.4  2005/07/21 19:03:12  florian
* nouveautÃ©s bazar: templates fiches, correction de bugs, ...
*
* Revision 1.2  2005/02/22 15:34:17  florian
* integration dans Papyrus
*
* Revision 1.1.1.1  2005/02/17 18:05:11  florian
* Import initial de Bazar
*
* Revision 1.1.1.1  2005/02/17 11:09:50  florian
* Import initial
*
* Revision 1.1.1.1  2005/02/16 18:06:35  florian
* import de la nouvelle version
*
* Revision 1.5  2004/07/08 12:15:32  florian
* ajout constantes pour flux RSS
*
* Revision 1.4  2004/07/06 16:21:54  florian
* débuggage modification + MAJ flux RSS
*
* Revision 1.3  2004/07/02 14:50:47  florian
* ajout configuration de l'etat de l'annonce (visible,masquée,...)
*
* Revision 1.2  2004/07/01 10:13:30  florian
* modif Florian
*
* Revision 1.1  2004/06/23 09:58:32  alex
* version initiale
*
* Revision 1.1  2004/06/18 09:00:41  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
