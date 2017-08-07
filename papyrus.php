<?php
//vim: set expandtab tabstop=4 shiftwidth=4:

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
// CVS : $Id: papyrus.php,v 1.18 2007-07-25 15:32:21 jp_milcent Exp $

/**
* Papyrus : Programme principal appelant diff�rent fichier � inclure dans un ordre pr�cis.
*
* La page contient l'appel aux fonctions de l'application de v�rification de l'installation puis
* l'appel du fichier r�alisant l'initialisation. Enfin, l'appel du fichier r�alisant le rendu et 
* retournant la page au navigateur client.
*
*@package Papyrus
//Auteur original :
*@author            Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author            Alexandre GRANIER <alex@tela-botanica.org>
*@author            Laurent COUDOUNEAU <laurent.coudouneau@ema.fr>
*@copyright         Tela-Botanica 2000-2004
*@version           $Revision: 1.18 $ $Date: 2007-07-25 15:32:21 $
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// Cr�ation des variables globale de Papyrus
$GLOBALS['_GEN_commun'] = array();
$GLOBALS['_PAPYRUS_']   = array();
$GLOBALS['_DEBOGAGE_']  = '';
$GLOBALS['_CHRONO_']    = array();

// Premi�re mesure du chronom�trage
$GLOBALS['_CHRONO_']['depart'] = microtime();


// V�rification de la configuration de Papyrus
/** Inclusion du programme de v�rification de Papyrus.
* Il v�rifie diff�rent param�tres n�cessaire au bon fonctionnement de Papyrus,
* dont la pr�sence des fichiers de configuration.
* C'est en fonction des param�tres d�termin�s par ce programme que l'application
* Installateur est appel�e si besoin est.*/
require_once 'papyrus/pap_verification.inc.php';
$GLOBALS['_CHRONO_']['V�rification'] = microtime();

// Utilisation par defaut de l'api PEAR fourni par Papyrus
ini_set('include_path', PAP_CHEMIN_API_PEAR.PATH_SEPARATOR.ini_get('include_path'));

/** Inclusion API d�bogage : Gestionnaire d'erreur
* Ajout de la biblioth�que de fonctions permettant d'encpasuler les erreurs PHP.*/
include_once GEN_CHEMIN_API.'debogage/BOG_Gestionnaire_Erreur.class.php';

/** Inclusion API d�bogage : chronom�trage
* Ajout de la biblioth�que de fonctions permettant d'analyser le temps d'execution de Papyrus.*/
include_once GEN_CHEMIN_API.'debogage/BOG_chrono.fonct.php';

/** Inclusion API d�bogage : Gestionnaire d'erreurs sql
* Ajout de la biblioth�que de fonctions de d�bogage d'erreurs SQL.*/
require_once GEN_CHEMIN_API.'debogage/BOG_sql.fonct.php';
// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Cr�ation du gestionnaire d'erreur de Papyrus
$GLOBALS['_PAPYRUS_']['erreur'] =  new BOG_Gestionnaire_Erreur(GEN_DEBOGAGE_CONTEXTE, GEN_CSS_ERREUR);

// +------------------------------------------------------------------------------------------------------+
// Appel de l'application Installateur de Papyrus si n�cessaire
if ($GLOBALS['_GEN_commun']['erreur_instal_afaire'] == true) {
    include_once GEN_CHEMIN_APPLICATION.'installateur/installateur.php';
    $GLOBALS['_GEN_commun']['sortie'] = afficherContenuCorps();
    include_once GEN_CHEMIN_PAP.'pap_envoi.inc.php';
    // Fin du programme Papyrus.
    exit(0);
}

// +------------------------------------------------------------------------------------------------------+
// Gestion de la connexion � la base de donn�es
require_once GEN_CHEMIN_PAP.'pap_connecte_bdd.inc.php';
$GLOBALS['_CHRONO_']['Connexion BdD'] = microtime();

// +------------------------------------------------------------------------------------------------------+
// Initialisation des informations provenant de la base de donn�es de Papyrus
/** <br> Inclusion du programme d'initialisation de Papyrus.
* Nous r�cup�rons alors les infos sur le site, la langue, le menu, l'application li�e et les informations sur la page
* depuis la base de donn�es de Papyrus. Ces informations correspondent au param�tres pass�s dans l'url demand�e par 
* l'utilisateur.Nous cr�ons aussi la repr�sentation sous forme d'objet de l'URL 
* courante demand�e par l'utilisateur.
*/
require_once GEN_CHEMIN_PAP.'pap_initialise_info.inc.php';
$GLOBALS['_CHRONO_']['Initialisation des info'] = microtime();

// +------------------------------------------------------------------------------------------------------+
// Inclusion des fichiers de traduction de Papyrus
if (file_exists(GEN_CHEMIN_LANGUE.'pap_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite � la transaction avec le navigateur.*/
    require_once GEN_CHEMIN_LANGUE.'pap_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par d�faut.*/
    require_once GEN_CHEMIN_LANGUE.'pap_langue_'.GEN_I18N_ID_DEFAUT.'.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// R�glage suppl�mentaire du gestionnaire d'erreurs
$GLOBALS['_PAPYRUS_']['erreur']->ecrireLangue($GLOBALS['_GEN_commun']['i18n']);
$GLOBALS['_PAPYRUS_']['erreur']->ecrireTxtTete(PAP_LANG_DEBOG_TETE);
$GLOBALS['_PAPYRUS_']['erreur']->ecrireTxtPied(PAP_LANG_DEBOG_PIED);
$GLOBALS['_PAPYRUS_']['erreur']->ecrireTraduction(array(PAP_LANG_DEBOG_NIVEAU, PAP_LANG_DEBOG_FICHIER, PAP_LANG_DEBOG_LIGNE, PAP_LANG_DEBOG_CONTEXTE));

// +------------------------------------------------------------------------------------------------------+
// Initialisation de l'authentification si n�cessaire
/** <br> Inclusion du programme d'initialisation de Auth et des Sessions utilis�es par Papyrus.
* Suite � la r�cup�ration des infos sur le site, la langue, le menu, l'application li�e et les infos sur la page,
* nous demandons l'identification et nous d�clenchons une session si le site le demande.
*/
if ($GLOBALS['_GEN_commun']['info_site']->gs_ce_auth > 0) {
    include_once GEN_CHEMIN_PAP.'pap_initialise_auth.inc.php';
    $GLOBALS['_CHRONO_']['Initialisation auth'] = microtime();
}

// +------------------------------------------------------------------------------------------------------+
// Mise en cache de la page si n�cessaire
/** <br> Inclusion du programme de gestion du cache de Papyrus.
* Nous supprimons, si l'application le demande, les pages en cache p�rim�es et nous recherchons
*  la page demand�e dans le cache.Si la page est trouv� nous la renvoyons et le programme
* s'arr�te ici. Sinon, nous continuons.
*/
if (isset($GLOBALS['_GEN_commun']['info_application']->cache) && $GLOBALS['_GEN_commun']['info_application']->cache) {
    include_once GEN_CHEMIN_PAP.'pap_cache.inc.php';
}

// +------------------------------------------------------------------------------------------------------+
// R�alisation du rendu de la page
/** <br> Inclusion du programme de rendu de G�n�sia.
* Il appelle l'application demand�e et cr�� la page gr�ce au fichier squelette et aux balises incluses dedans.
*/
require_once GEN_CHEMIN_PAP.'pap_rendu.inc.php';

$GLOBALS['_CHRONO_']['Rendu'] = microtime();

// +------------------------------------------------------------------------------------------------------+
// Gestion du stockage en cache de la page demand�e et de son envoi au navigateur client si n�cessaire.
/** <br> Inclusion du programme d'envoi de la page demand�e.
* Il stocke la page en cache et la renvoi apr�s compression s'il existe des donn�es � renvoyer.
*/
if (! empty($GLOBALS['_GEN_commun']['sortie'])) {
    if (GEN_DEBOGAGE) {
        // En cas de chronom�trage, nous ins�rons le tableau des r�sultats.
        $GLOBALS['_GEN_commun']['sortie'] = str_replace('<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'CHRONOMETRAGE -->', BOG_afficherChrono(12), $GLOBALS['_GEN_commun']['sortie']);
        // Gestion des erreurs et du d�bogage
        $GLOBALS['_DEBOGAGE_'] .= $GLOBALS['_PAPYRUS_']['erreur']->retournerErreurs();
        $GLOBALS['_GEN_commun']['sortie'] = str_replace('<!-- '.$GLOBALS['_GEN_commun']['balise_prefixe'].'DEBOGAGE -->', $GLOBALS['_DEBOGAGE_'], $GLOBALS['_GEN_commun']['sortie']);
    }
    include_once GEN_CHEMIN_PAP.'pap_envoi.inc.php';
}

// Fin du programme Papyrus.
exit(0);


/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: papyrus.php,v $
* Revision 1.18  2007-07-25 15:32:21  jp_milcent
* Fusion livraison Narmer.
* Gestion de l'include path pour l'api Pear de Papyrus.
*
* Revision 1.17  2005-10-17 13:41:35  ddelon
* Projet Wikini
*
* Revision 1.16  2005/08/31 17:34:52  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.15  2005/08/18 10:20:05  ddelon
* Integrateur Wikini et Acces PEAR
*
* Revision 1.14  2005/07/11 15:41:50  ddelon
* test message information
*
* Revision 1.13  2005/07/11 15:26:25  ddelon
* test message information
*
* Revision 1.12  2005/07/05 10:06:58  ddelon
* Copyright
*
* Revision 1.11  2005/03/02 11:04:31  jpm
* Modification de l'utilisation d'une variable globale.
*
* Revision 1.10  2005/02/28 13:50:01  jpm
* Modification de l'utilisation d'une variable globale.
*
* Revision 1.9  2004/11/29 17:14:26  jpm
* Correction d'un bogue concernant la variable priv�e _DEBOGAGE_.
*
* Revision 1.8  2004/11/29 15:54:31  jpm
* Changement de nom de variable et l�g�res corrections.
*
* Revision 1.7  2004/11/24 18:33:05  jpm
* Ajout de la variable globale _PAPYRUS_.
*
* Revision 1.6  2004/10/22 17:24:53  jpm
* Am�lioration de l'inclusion des fichiers et des tests.
*
* Revision 1.5  2004/09/28 14:57:53  jpm
* Cr�ation d'une balise propre au d�bogage.
*
* Revision 1.4  2004/09/10 16:39:04  jpm
* Ajout des infos de d�bogage � la sortie.
*
* Revision 1.3  2004/07/06 17:27:23  jpm
* Suppression d'inclusion du fichier de fonctions inutilis�es dans Papyrus.
*
* Revision 1.2  2004/06/16 15:10:24  jpm
* Ajout de constantes de chemins.
*
* Revision 1.1  2004/06/15 10:15:12  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.16  2004/04/28 12:04:31  jpm
* Changement du mod�le de la base de donn�es.
*
* Revision 1.15  2004/04/22 08:31:49  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.14  2004/04/21 16:24:29  jpm
* Ajout d'un fichier sp�cifique pour la connexion � la base de donn�es et incluant les classes DataObject de Pear.
*
* Revision 1.12  2004/04/21 08:02:14  jpm
* Ajout de mesure du temps d'�xecution de G�n�sia.
*
* Revision 1.11  2004/04/09 16:33:34  jpm
* Changement des noms de fichier gen_initialisation...
*
* Revision 1.10  2004/04/09 16:19:40  jpm
* Ajout des fichiers ind�pendants d'envoi et de cache.
*
* Revision 1.9  2004/04/08 14:13:47  jpm
* Ajout de l'inclusion du fichier de v�rification.
*
* Revision 1.8  2004/04/02 16:28:12  jpm
* Ajout de l'inclusion du fichier gen_initialisation_pear.inc.php.
*
* Revision 1.7  2004/04/01 11:27:13  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.6  2004/03/31 16:49:30  jpm
* Modifications mineures.
*
* Revision 1.5  2004/03/27 11:01:06  jpm
* Ajout de l'appel des fonctions d'installation.
*
* Revision 1.4  2004/03/25 11:51:06  jpm
* Changement nom dossier noyau en g�n�sia dans les chemins.
*
* Revision 1.3  2004/03/23 17:06:14  jpm
* Ajout de commentaire dans l'ent�te.
*
* Revision 1.2  2004/03/23 16:30:42  jpm
* Ajout de commentaires.
* Changement des noms des fichiers appel�s.
*
* Revision 1.1  2004/03/23 10:22:34  jpm
* Page principale de l'application G�n�sia.
*
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>
