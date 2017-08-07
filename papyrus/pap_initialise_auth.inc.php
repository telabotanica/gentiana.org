<?php
//vim: set expandtab tabstop=4 shiftwidth=4:
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2003 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// |                                                                                                      |
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
// |                                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: pap_initialise_auth.inc.php,v 1.26 2007-07-24 13:28:54 jp_milcent Exp $
/**
* Initialisation de l'authentification.
*
* Suite à la recherche des informations depuis la base de données nous initialisons
* l'authentification des utilisateurs si le site l'utilise.
* La page contient le code initialisant l'objet PEAR créé par Net_URL contenant l'url
* courante demandée par l'utilisateur.
* Nous initialisons aussi l'identification de l'utilisateur et le démarage de la session.
*
*@package Papyrus
//Auteur original :
*@author            Alexandre GRANIER <alex@tela-botanica.org>
//Autres auteurs :
*@author            Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright         Tela-Botanica 2000-2004
*@version           $Revision: 1.26 $ $Date: 2007-07-24 13:28:54 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/** <br> Inclusion de l'authentification de PEAR.*/
include_once PAP_CHEMIN_API_PEAR.'Auth.php';

/** Inclusion de la bibliothèque de fonctions d'identification.
* Contient entre autre la fonction founissant le formulaire d'identification pour Auth de Pear.
* Cette inclusion n'a lieu que si le site utilise l'identification.
*/
include_once GEN_CHEMIN_PAP.'bibliotheque/fonctions/pap_identification.fonct.php' ;
include_once GEN_CHEMIN_PAP.'bibliotheque/fonctions/pap_site.fonct.php' ;

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Gestion de l'identification des utilisateurs et des sessions


// +------------------------------------------------------------------------------------------------------+
// Récupération des informations d'identification pour le site courant

// Récupération des informations sur le site
$requete_auth = 'SELECT gen_site_auth.*, gs_id_site '.
                'FROM gen_site_auth, gen_site '.
                'WHERE gs_ce_auth <> 0 '.
                'AND gs_ce_auth = gsa_id_auth';

$resultat_auth = $db->query($requete_auth);
(DB::isError($resultat_auth))
    ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_auth->getMessage(), $requete_auth))
    : '';

while ($ligne_auth = $resultat_auth->fetchRow(DB_FETCHMODE_OBJECT)) {
    // Ajout des valeurs communes aux différents type d'auth
    $GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth]['gsa_nom'] = $ligne_auth->gsa_nom;
    $GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth]['gsa_abreviation'] = $ligne_auth->gsa_abreviation;
    $GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth]['gsa_ce_type_auth'] = $ligne_auth->gsa_ce_type_auth;
    
    
    if ($ligne_auth->gsa_id_auth == $GLOBALS['_GEN_commun']['info_site']->gs_ce_auth) {
        $GLOBALS['_GEN_commun']['info_auth'] = $ligne_auth;
    }
    
    if ($ligne_auth->gsa_ce_auth_bdd != 0) {
        //Identification via une base de donnée :
        $requete_auth_bdd = 'SELECT * '.
                            'FROM gen_site_auth_bdd '.
                            'WHERE gsab_id_auth_bdd = '.$ligne_auth->gsa_ce_auth_bdd;
        
        $resultat_auth_bdd = $db->query($requete_auth_bdd);
        (DB::isError($resultat_auth_bdd))
            ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_auth_bdd->getMessage(), $requete_auth_bdd))
            : '';
        $tab_auth_bdd = $resultat_auth_bdd->fetchRow(DB_FETCHMODE_OBJECT) ;
        if ($ligne_auth->gsa_id_auth == $GLOBALS['_GEN_commun']['info_site']->gs_ce_auth) {
            $GLOBALS['_GEN_commun']['info_auth_bdd'] = $tab_auth_bdd ;
            // Gestion des arguments de l'authentification
            if (isset($GLOBALS['_GEN_commun']['info_auth_bdd']->gsab_parametres)) {
                $arguments = explode(' ', $GLOBALS['_GEN_commun']['info_auth_bdd']->gsab_parametres);
                for ($i = 0; $i < count($arguments); $i++) {
                    $attr = explode('=', $arguments[$i]);
                    if ($attr[0] != '') {
                        $GLOBALS['_GEN_commun']['info_auth_bdd']->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
                    }
                }
            }
        }
        
       	$GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth] = array_merge((array)$GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth], (array) $tab_auth_bdd);
        $resultat_auth_bdd->free();
    } else if ($ligne_auth->gsa_ce_auth_ldap != 0) {
        //Identification via LDAP :
        $requete_auth_ldap =    'SELECT * '.
                                'FROM gen_site_auth_ldap '.
                                'WHERE gsal_id_auth_ldap = '.$ligne_auth->gsa_ce_auth_ldap;
        
        $resultat_auth_ldap = $db->query($requete_auth_ldap);
        (DB::isError($resultat_auth_ldap))
            ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_auth_ldap->getMessage(), $requete_auth_ldap))
            : '';
        $tab_auth_ldap = $resultat_auth_ldap->fetchRow(DB_FETCHMODE_OBJECT);
        if ($ligne_auth->gsa_id_auth == $_GEN_commun['info_site']->gs_ce_auth) {
            $GLOBALS['_GEN_commun']['info_auth_ldap'] = $tab_auth_ldap;
        }
        $GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth] = array_merge((array) $GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth], (array) $tab_auth_ldap);
        $resultat_auth_ldap->free();
    } else {
        die('ERREUR Papyrus : impossible de trouver les information authentification. <br />'.
            'Identifiant auth : '.$ligne_auth->gs_ce_auth.'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__ );
    }
    
    // On teste le type d'authentification
    $tab_type_site = GEN_retournerTableauTypeSiteExterne($db);
    $types_site = '';
    foreach ($tab_type_site as $val) {
        $types_site .= $val['id'].', ';
    }
    $types_site = substr($types_site, 0, -2);
    $requete =  'SELECT gsr_id_valeur '.
                'FROM gen_site_relation '.
                'WHERE gsr_id_site_01 = '.$ligne_auth->gs_id_site.' '.
                'AND gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur IN ('.$types_site.')';
    $type_site_externe = $db->getOne($requete);
    (DB::isError($type_site_externe))
            ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $type_site_externe->getMessage(), $requete))
            : '';
    // Type du site de l'authentification
    if ($type_site_externe != '') {
        $GLOBALS['_PAPYRUS_']['auth'][$ligne_auth->gsa_id_auth]['type_site_externe'] = $type_site_externe;
    }
}
$resultat_auth->free();

// +------------------------------------------------------------------------------------------------------+
// Définition du nom de la session
session_name(PAP_AUTH_SESSION_PREFIXE.$GLOBALS['_GEN_commun']['info_auth']->gsa_abreviation);

// +------------------------------------------------------------------------------------------------------+
// Nour regardons à quel type d'identification nous avons à faire:
$auth_courante = $GLOBALS['_PAPYRUS_']['auth'][$GLOBALS['_GEN_commun']['info_site']->gs_ce_auth] ;
if ($auth_courante['gsa_ce_type_auth'] == 1) {
    // Authentification via une base de données
    $GLOBALS['_PAPYRUS_']['auth']['param_bdd'] = array ('dsn' => $auth_courante['gsab_dsn'],
                        'table' => $auth_courante['gsab_nom_table'],
                        'usernamecol' => $auth_courante['gsab_nom_champ_login'],
                        'passwordcol' => $auth_courante['gsab_nom_champ_mdp'],
                        'cryptType' => $auth_courante['gsab_cryptage_mdp'],
                        'db_fields' => '*');
    // L'authentification courrante
    $GLOBALS['_GEN_commun']['pear_auth'] = new Auth('DB', $GLOBALS['_PAPYRUS_']['auth']['param_bdd'], 'GEN_afficherInfoIdentification', 1);
    
} else if ($auth_courante['gsa_ce_type_auth'] == 2) {
    // Authentification via LDAP
    $GLOBALS['_PAPYRUS_']['auth']['param_ldap'] = array (   'host' => $auth_courante['gsal_serveur'],
                            'port' => $auth_courante['gsal_port'],
                            'basedn' => $auth_courante['gsal_base_dn'],
                            'userattr' => $auth_courante['gsal_uid']);
    $GLOBALS['_GEN_commun']['pear_auth'] = new Auth('LDAP', $GLOBALS['_PAPYRUS_']['auth']['param_ldap'], 'GEN_afficherInfoIdentification', 1);
} else {
    die('ERREUR Papyrus : type identification introuvable. <br />'.
        'Type identification : '.$auth_courante['gsa_ce_type_auth'].'<br />'.
        'Ligne n° : '. __LINE__ . '<br />'.
        'Fichier : '. __FILE__ . '<br />');
}

// +------------------------------------------------------------------------------------------------------+
// Nous allouons le niveau de sécurité
$GLOBALS['_GEN_commun']['pear_auth']->setAdvancedSecurity(PAP_AUTH_SECURITE_AVANCEE);

// +------------------------------------------------------------------------------------------------------+
// Démarage de la session
$GLOBALS['_GEN_commun']['pear_auth']->start();

/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: pap_initialise_auth.inc.php,v $
* Revision 1.26  2007-07-24 13:28:54  jp_milcent
* Appel du bon fichier Auth.php.
*
* Revision 1.25  2007-04-13 09:41:09  neiluj
* rÃ©parration cvs
*
* Revision 1.24  2006/12/14 15:25:22  jp_milcent
* Correction de la gestion des noms de session pour fonctionner avec Auth 1.4.3.
*
* Revision 1.23  2006/12/14 15:01:05  jp_milcent
* Utilisation d'un système permettant de mémoriser les idenitifications.
* Passage à Auth 1.4.3 et DB 1.7.6.
*
* Revision 1.22  2006/11/20 17:29:42  jp_milcent
* Suppression du code de gestion de l'identification Spip et Wikini car non fonctionnel et finalement géré dans les appli tierces.
*
* Revision 1.21  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.20  2006/03/15 09:30:50  florian
* suppression des echos, qui entrainaient des problemes d'affichages
*
* Revision 1.19  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.18  2005/07/07 09:15:36  alexandre_tb
* mise en place de la co-authentification Wikini - papyrus.
*  - ajout d'une requete pour récupérer le mot de passe
*
* Revision 1.17  2005/04/27 15:06:21  alex
* ajout de l'authentification wiki.
*
* Revision 1.16  2005/03/25 13:08:20  jpm
* Déplacement de la gestion des arguments de l'authentification.
*
* Revision 1.15  2005/03/24 15:04:26  alex
* ajout d'un appel à session_set_cookie_params pour allonger la durée de la session
*
* Revision 1.14  2005/03/15 14:20:01  jpm
* Gestion des arguments de l'identification courante.
*
* Revision 1.13  2005/02/22 18:27:24  jpm
* Changement de nom de variables.
*
* Revision 1.12  2004/12/15 15:24:45  alex
* suppression d'un notice
*
* Revision 1.11  2004/12/13 18:06:52  alex
* authentification spip presque parfaite
*
* Revision 1.10  2004/12/07 19:13:51  alex
* authentification spip
*
* Revision 1.7  2004/12/07 10:26:27  jpm
* Correction for en foreach.
*
* Revision 1.6  2004/12/06 12:42:02  alex
* en cours
*
* Revision 1.5  2004/12/06 12:12:28  jpm
* Début de gestion des auth multiples.
*
* Revision 1.4  2004/10/25 16:28:47  jpm
* Ajout de nouvelles balises Papyrus, ajout vérification mise à jour de Papyrus, meilleure gestion des sessions...
*
* Revision 1.3  2004/10/15 18:29:19  jpm
* Modif pour gérer l'appli installateur de Papyrus.
*
* Revision 1.2  2004/06/30 07:23:36  jpm
* Ajout d'un commentaire.
*
* Revision 1.1  2004/06/16 08:12:01  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.6  2004/05/01 11:40:21  jpm
* Suppression de code intégré dans le fichier de l'applette Identification.
*
* Revision 1.5  2004/04/28 12:04:31  jpm
* Changement du modèle de la base de données.
*
* Revision 1.4  2004/04/22 08:29:11  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.3  2004/04/09 16:20:33  jpm
* Gestion de l'authentification uniquement.
* Gestion des tables i18n.
*
* Revision 1.2  2004/04/02 16:29:58  jpm
* Ajout de la gestion de la déconnexion et reconnexion.
*
* Revision 1.1  2004/04/02 08:54:58  jpm
* Création du fichier qui contient l'initialisation des objets Pear, hormis la base de données.
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>
