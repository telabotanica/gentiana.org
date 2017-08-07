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
// CVS : $Id: pap_initialisation.fonct.php,v 1.4 2004-10-21 18:15:20 jpm Exp $
/**
* Bibliothèque de fonction pour l'initialisation de Papyrus.
*
* Cette bibliothèque contient des fonctions utilisé lors de l'initialisation de Papyrus.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Alexandre GRANIER <alexadandre@tela-botanica.org
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $ $Date: 2004-10-21 18:15:20 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE des FONCTIONS                                       |
// +------------------------------------------------------------------------------------------------------+

/** Fonction GEN_donnerIdPremiereApplicationLiee() - Renvoie l'id de la première application liée à un menu.
*
* Cette fonction recherche l'application liée à un menu et l'identifiant de ce menu, mais comme il peut
* ne pas y en avoir, elle cherche alors l'application du menu fils qui
* lui-même peut ne pas en avoir, etc...
*
* @param integer l'identifiant d'un menu.
* @return mixed tableau associatif indexé avec gm_id_menu et gm_ce_application et leur valeur ou false en cas d'erreur.
*/
function GEN_donnerIdPremiereApplicationLiee($id_menu)
{
    global $db;
    $aso_application_info = array();
    
    $requete =  'SELECT gm_id_menu, gm_ce_application '.
                'FROM gen_menu '.
                'WHERE gm_id_menu = '.$id_menu;
    
    $resultat = $db->query($requete) ;
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $aso_application_info =& $resultat->fetchRow(DB_FETCHMODE_ASSOC);
    
    if ($aso_application_info['gm_ce_application'] == 0) {
        // Le menu demandé n'a pas d'application liée, nous cherchons celle du premièr menu fils.
        $requete_fils = 'SELECT gm_id_menu '.
                        'FROM gen_menu, gen_menu_relation '.
                        'WHERE gmr_id_menu_02 = '.$id_menu.' '.
                        'AND gmr_id_valeur = 1 '.
                        'AND gmr_id_menu_01 = gm_id_menu '.
                        'ORDER BY gmr_ordre ASC ';
                        
        $resultat_fils = $db->query($requete_fils) ;
        (DB::isError($resultat_fils))
            ? die (BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_fils->getMessage(), $requete_fils))
            : '' ;
        
        if ($resultat_fils->numRows() >= 1) {
            // Nous avons un menu fils, nous rappelons récursivement la fontion avec son identifiant
            // pour récuperer l'application liée.
            $ligne_fils = $resultat_fils->fetchRow(DB_FETCHMODE_OBJECT);
            $aso_application_info = GEN_donnerIdPremiereApplicationLiee($ligne_fils->gm_id_menu);
        }
        else {
            // Gestion des erreurs sur la recherche de l'application liée.
            return false;
        }
    }
    return $aso_application_info ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_initialisation.fonct.php,v $
* Revision 1.4  2004-10-21 18:15:20  jpm
* Ajout de gestion d'erreur aux fonctions.
*
* Revision 1.3  2004/06/30 07:26:52  jpm
* Modification nom de la fonction.
*
* Revision 1.2  2004/06/18 15:51:27  alex
* Modification fonction de recherche d'application liée, elle renvoie maintenant un tableau.
*
* Revision 1.1  2004/06/15 15:10:44  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.6  2004/04/28 12:04:40  jpm
* Changement du modèle de la base de données.
*
* Revision 1.5  2004/04/09 16:23:41  jpm
* Prise en compte des tables i18n.
*
* Revision 1.4  2004/04/02 16:34:03  jpm
* Modifications de commentaires des fonctions.
*
* Revision 1.3  2004/04/01 11:24:51  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.2  2004/03/31 16:53:05  jpm
* Modification du code vis à vis du modèle revision 1.9 de Génésia.
*
* Revision 1.1  2004/03/29 14:53:25  jpm
* Création du fichier et ajout de la fonction donnerIdPremiereApplicationLiee().
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
