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
// CVS : $Id: inscription.fonct.spip.php,v 1.4 2007/04/11 08:30:12 neiluj Exp $
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
*@version       $Revision: 1.4 $ $Date: 2007/04/11 08:30:12 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

function inscription_spip($id, &$valeur)
{

    // Requete pour inscrire dans SPIP
    if (isset ($valeur['nomwiki'])) {
        $login = $valeur['nomwiki'] ;
    } else {
        $login = $valeur['email'] ;
    }
    $requete = "insert into spip_auteurs set id_auteur=$id, nom=\"".$valeur['prenom']." ".$valeur['nom'].
                "\",email=\"".$valeur['email']."\",login=\"".$login.
                "\", pass=\"".md5($valeur['mot_de_passe'])."\", statut=\"nouveau\", lang=\"".
                strtolower($valeur['pays'])."\"" ;
    @mysql_query($requete) or die ("$requete<br>Echec <br>".mysql_error()) ;
}

function mod_inscription_spip($id, &$valeur)
{
    if (isset ($valeur['nomwiki'])) {
        $login = $valeur['nomwiki'] ;
    } else {
        $login = $valeur['email'] ;
    }
    //BIEN METTRE alea_actuel, htpass ET alea_futur À ""
     $requete = "update spip_auteurs set nom=\"".$valeur['prenom']." ".$valeur['nom'].
                "\",email=\"".$valeur['email']."\",login=\"".$login.
                "\", pass=\"".md5($valeur['mot_de_passe'])."\", htpass=\"\", alea_actuel=\"\", alea_futur=\"\", lang=\"fr\" where id_auteur=$id" ;
    //echo $requete;
    @mysql_query($requete) or die ("$requete<br>Echec <br>".mysql_error()) ;
}
function desinscription_spip($id_utilisateur)
{
     $requete = 'delete from spip_auteurs where id_auteur='.$id_utilisateur ;
    @mysql_query($requete) or die ("$requete<br>Echec de la requête de mise à la poubelle de l'utilisateur dans spip <br>".mysql_error()) ;
}

function spip_cookie() {
	if ($userid != 0) {
		setcookie("spip_admin", "@$login", time()+3600*24*30, INS_CHEMIN_SPIP) ;
		include ("ecrire/inc_version.php3");
		include_ecrire ("inc_meta.php3");
		include_ecrire ("inc_session.php3");
		$query = "SELECT * FROM spip_auteurs WHERE id_auteur=$userid";
		$result = mysql_query($query);
		$GLOBALS['auteur_session'] = mysql_fetch_array($result) ;
		$GLOBALS['auteur_session']['statut'] = "1comite" ;
		$GLOBALS['auteur_session']['lang'] = "en" ;
		
		if (!$HTTP_COOKIE_VARS["spip_session"]) {
			$id_session = $userid."_".(md5 (uniqid (rand ())));
			setcookie("spip_session", $id_session, time()+3600*24*30, "/vecam/") ;
		} else {
			$id_session = preg_replace("/[0-9]+_/", $userid."_", $HTTP_COOKIE_VARS["spip_session"]) ;
			setcookie("spip_session", $id_session, time()+3600*24*30, "/vecam/") ;
		}
		ajouter_session($GLOBALS['auteur_session'], $id_session) ;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: inscription.fonct.spip.php,v $
* Revision 1.4  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.2  2006/03/15 11:03:34  alexandre_tb
* généralisation du code
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
* Revision 1.2  2004/06/25 14:25:27  alex
* modification de la requete de suppresssion
*
* Revision 1.1  2004/06/18 09:20:48  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/




?>
