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
// CVS : $Id: inscription.fonct.wiki.php,v 1.7 2007-06-25 15:37:57 alexandre_tb Exp $
/**
* Fonctions wikini
*
* Ce fichier propose 3 fonctions pour intervenir sur la table interwikini_users.
*
*@package inscription
*@subpackage fonctions_wikini
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2007-06-25 15:37:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

function inscription_interwikini_users($id, $valeur) {
    // On vérifie l'existance du nom wiki dans interwikini_users
    $requete_verif = 'select name from interwikini_users where name="'.$valeur['nom_wiki'].'"';
    $resultat_verif = $GLOBALS['ins_db']->query ($requete_verif) ;
    if (DB::isError($resultat_verif)) {
        echo ("Echec de la requete dans interwikini_users<br />".$resultat_verif->getMessage()) ;
    }
    if ($resultat_verif->numRows() != 0) {
    	return ;	
    }
    $requete = "insert into interwikini_users set name=\"".$valeur['nom_wiki'].
                "\", password=\"".md5($valeur['mot_de_passe'])."\", email=\"".$valeur['a_mail']."\"".
                ', signuptime=now()' ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError($resultat)) {
        echo ("Echec de la requete dans interwikini_users<br />".$resultat->getMessage()) ;
    }
}

function mod_inscription_interwikini_users($nomwiki, $valeur) {
    
    $requete = "update interwikini_users set password=\"".md5($valeur['mot_de_passe'])."\", email=\"".$valeur['email']."\"".
                " where name=\"$nomwiki\"" ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError($resultat)) {
        die ("Echec de la requete dans interwikini_users<br />".$resultat->getMessage()) ;
    }
}

function desinscription_interwikini_users($nomwiki) {
    $requete = "delete from interwikini_users where name=\"$nomwiki\"" ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError($resultat)) {
        die ("Echec de la requete dans interwikini_users<br />".$resultat->getMessage()) ;
    }
}

function verif_doublonNomWiki($nom_wiki) {
    global $db ;
    $requete = "select name from interwikini_users where name = \"$nom_wiki\"" ;
    $resultat = $db->query ($requete) ;
    if (DB::isError ($resultat)) {
    	die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
    }
    if ($resultat->numRows() == 0) return true ;
    return false ;
}

function wiki_cookie() {
	if ($userid != "") {
		// 1. name
		// On recherche le nom
		$nomwikini = $AUTH->getAuthData('ga_login') ;
		setcookie ("name", $nomwikini, time () + 3600 * 24 * 30, "/" ) ; // 1 mois
		//2. password
		// on recherche le mot de passe crypté
		$requete = "select ga_mot_de_passe from gen_annuaire where ga_id_administrateur=$userid" ;
		$resultat = $db->query ($requete) ;
		if (DB::isError($resultat)) {
			die ("Erreur") ;
		}
		$ligne = $resultat->fetchRow (DB_FETCHMODE_OBJECT) ;
		$mot_de_passe = $ligne->ga_mot_de_passe ;
		setcookie ("password", $mot_de_passe, time () + 3600 * 24 * 30, "/") ;
		// 3. remember
		setcookie ("remember", 1, time () + 3600 * 24 * 30, "/") ;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: inscription.fonct.wiki.php,v $
* Revision 1.7  2007-06-25 15:37:57  alexandre_tb
* correction de bug
*
* Revision 1.6  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.4  2006/07/04 09:39:03  alexandre_tb
* correction d'un bug mineur
*
* Revision 1.3  2006/04/11 08:42:07  alexandre_tb
* Vérification de l'existance d'un nom wiki avant son insertion
*
* Revision 1.2  2005/09/29 13:56:48  alexandre_tb
* En cours de production. Reste à gérer les news letters et d'autres choses.
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.2  2005/03/21 16:57:30  florian
* correction de bug, mise à jour interface
*
* Revision 1.1  2004/12/15 13:32:25  alex
* version initiale
*
* Revision 1.1  2004/07/06 15:42:17  alex
* en cours
*
* Revision 1.1  2004/06/18 09:20:48  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/




?>
