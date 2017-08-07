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
// CVS : $Id: mail_tous.php,v 1.2 2006/01/02 09:51:03 alexandre_tb Exp $
/**
* Permet d'envoie un mail à une sélection dans l'annuaire
* 
*
*@package annuaire
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.2 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

function putFrame() {
    
    // configuration
    global $objet, $corps, $annuaire_LABEL_STATUT, $SERVER_ADMIN ;
    global $action ;
    
    $url = $GLOBALS['ins_url']->getURL() ;

    // Entete
    
    $corps_debut = "RESEAU TELA BOTANICA - Le ".date("j/m/Y").
                    "\n\nBonjour,\n"."\n\nCordialement,\n-------------------\n".
                    "Tela Botanica le réseau des botanistes francophones\n".
                    "accueil@tela-botanica.org\nhttp://www.tela-botanica.org\n";  

    $res = "<h1>Envoi d'un mail &agrave; tous les membres</h1>\n" ;

    if ($_GET['action'] == ANN_MAIL_TOUS_ENVOIE) $res .= envoie_mail_selection() ;

    // formulaire
    $res .= "<div><form action=\"$url&action=".ANN_MAIL_TOUS_ENVOIE."\" method=\"post\"><table>\n" ;
    $res .= "<tr><td>" ;
    $res .= "Objet&nbsp;:&nbsp;</td><td><input size=\"91\" name=\"objet\" type=\"text\"></td></tr>\n" ;
    $res .= '<tr><td>Corps&nbsp;:&nbsp;</td><td><textarea name="corps" cols="90" rows="30">'.
    			$corps_debut.'</textarea></td></tr>'."\n" ;
    $res .= "<tr><td></td><td><input type=\"submit\" value=\"envoyer\"" ;
    $res .= " onclick=\"javascript:return confirm('Etes-vous sur de vouloir envoyer ce message !!');\"" ;
    $res .= "></td></tr>\n" ;
    $res .= "</table></form></div>\n" ;

return $res ;
}

include_once ("Mail.php");

// envoie le mail à tous


function envoie_mail_selection() 
{

    $headers['From']    = INS_MAIL_ADMIN_APRES_INSCRIPTION ;
    $headers['Subject'] = stripslashes($_REQUEST['objet']) ;

    $corps = stripslashes($_REQUEST['corps']) ;
    
    $requete = $_SESSION['requete_mail_tous'] ;
    unset ($_SESSION['requete_mail_tous']) ;

    $resultat = $GLOBALS['ins_db']->query($requete) ; 
    
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        if (!mail($ligne[INS_CHAMPS_MAIL], $headers['Subject'], $corps, "From: ".$headers['From'])) {
        	return "<div>Une erreur s'est produite:<br>".$mail_object->getMessage()."</div>\n" ;
        }
    }
    
    return "<div>Le mail est parti !</div>\n";
}
/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: mail_tous.php,v $
* Revision 1.2  2006/01/02 09:51:03  alexandre_tb
* généralisation du code et intégration au bottin
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
