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
// CVS : $Id: pap_application.fonct.php,v 1.3 2006-04-28 12:41:49 florian Exp $
/**
* Biblibothèque de fonction sur les applications.
*
* Liste des fonctions sur les applications.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2006-04-28 12:41:49 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/** Fonction GEN_verifierPresenceInterfaceAdmin() - Vérifie la présence d'une interface d'administration.
*
* Vérifie que l'application attribuée à un menu possède une interface d'administration.
*
* @param  object objet Pear de connection à la base de données.
* @param  integer l'identifiant de l'application.
* @return boolean true si l'appli peut être administrer, sinon false.
*/
function GEN_verifierPresenceInterfaceAdmin($db, $id_appli) {
    // Gestion des erreurs
    if ($id_appli == 0) {
        return false;
    }
    // Requête sur les applications
    $requete =  'SELECT * '.
                'FROM gen_application '.
                'WHERE gap_id_application = '.$id_appli;
    $resultat = $db->query($requete);
    
    $ligne_appli = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $chemin_appli = $ligne_appli->gap_chemin;
    $chemin_appli = preg_replace('/.php$/', '.admin.php', $chemin_appli);
    
    if (file_exists($chemin_appli)) {
        return true;
    } else {
        return false;
    }
}

/** Fonction GEN_retournerCheminInterfaceAdmin() - Retourne le chemin de l'interface d'administration d'une appli.
*
* Retourne le chemin de l'interface d'administration d'une appli si elle en possède sinon false
*
* @param  object objet Pear de connection à la base de données.
* @param  integer l'identifiant de l'application.
* @return mixed le chemin si l'appli peut être administrer, sinon false.
*/
function GEN_retournerCheminInterfaceAdmin($db, $id_appli) {
    // Requête sur les applications
    $requete =  'SELECT gap_chemin '.
                'FROM gen_application '.
                'WHERE gap_id_application = '.$id_appli.' ';
    $resultat = $db->query($requete);
    $ligne_appli = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $chemin_appli = $ligne_appli->gap_chemin;
    $chemin_interface_admin = preg_replace('/.php$/', '.admin.php', $chemin_appli);
    if (file_exists($chemin_interface_admin)) {
        return $chemin_interface_admin;
    } else {
        return false;
    }
}

/** Fonction GEN_retournerNomInterfaceAdmin() - Retourne le nom de la classe d'une interface d'administration d'une appli.
*
* Retourne le nom de la classe d'une interface d'administration d'une appli si elle en possède sinon false
*
* @param  object objet Pear de connection à la base de données.
* @param  integer l'identifiant de l'application.
* @return mixed le nom de l'interface d'admin de l'appli, sinon false.
*/
function GEN_retournerNomInterfaceAdmin($db, $id_appli) {
    // Requête sur les applications
    $requete =  'SELECT gap_chemin '.
                'FROM gen_application '.
                'WHERE gap_id_application = '.$id_appli.' ';
    $resultat = $db->query($requete);
    $ligne_appli = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $chemin_appli = $ligne_appli->gap_chemin;
    $morceaux='';
    preg_match('/([\w_]+).php$/', $chemin_appli, $morceaux);
    $nom_interface_admin = ucfirst($morceaux[1]).'_Admin';
    return $nom_interface_admin;
}

/** Fonction GEN_retournerNomAppli() - Retourne le nom de la classe d'une appli.
*
* Retourne le nom de la classe d'une appli.
*
* @param  object objet Pear de connection à la base de données.
* @param  integer l'identifiant de l'application.
* @return mixed le nom de la classe de l'appli, sinon false.
*/
function GEN_retournerNomAppli($db, $id_appli) {
    // Requête sur les applications
    $requete =  'SELECT gap_chemin '.
                'FROM gen_application '.
                'WHERE gap_id_application = '.$id_appli.' ';
    $resultat = $db->query($requete);
    $ligne_appli = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $chemin_appli = $ligne_appli->gap_chemin;
    $morceaux='';
    preg_match('/([\w_]+).php$/', $chemin_appli, $morceaux);
    preg_replace('/_(\w)/', '_'.ucfirst(${1}),$morceaux[1]);
    $nom_classe_appli = $morceaux[1];
    return $nom_classe_appli;
}

/** Fonction GEN_retournerInfoAppliMenu() - Retourne les infos de l'application d'un menu.
*
* Retourne un objet contenant les infos de l'application liée à un menu
*
* @param  object objet Pear de connection à la base de données.
* @param  integer l'identifiant du menu.
* @return mixed l'objet représentant les infos de l'appli, sinon false.
*/
function GEN_retournerInfoAppliMenu($db, $id_menu) {
    // Gestion des erreurs
    if ($id_menu == 0) {
        return false;
    }
    // Requête sur les applications
    $requete =  'SELECT gen_application.* '.
                'FROM gen_application, gen_menu '.
                'WHERE gm_id_menu = '.$id_menu.' '.
                'AND gm_ce_application = gap_id_application';
    $resultat = $db->query($requete);
    $ligne_appli = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    return $ligne_appli;
}

/** Fonction GEN_retournerIdAppliMenu() - Retourne l'identifiant de l'application d'un menu.
*
* Retourne l'identifiant de l'application liée à un menu
*
* @param  object objet Pear de connection à la base de données.
* @param  integer l'identifiant du menu.
* @return integer identifiant de l'appli du menu, sinon false.
*/
function GEN_retournerIdAppliMenu($db, $id_menu) {
    // Requête sur les applications
    $requete =  'SELECT gen_application.* '.
                'FROM gen_application, gen_menu '.
                'WHERE gm_id_menu = '.$id_menu.' '.
                'AND gm_ce_application = gap_id_application';
    $resultat = $db->query($requete);
    $ligne_appli = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    return $ligne_appli->gap_id_application;
}
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_application.fonct.php,v $
* Revision 1.3  2006-04-28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.2  2005/02/28 11:12:03  jpm
* Modification des auteurs.
*
* Revision 1.1  2004/11/09 17:54:50  jpm
* Ajout de fonction permettant de manipuler les informations liées aux applications.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>