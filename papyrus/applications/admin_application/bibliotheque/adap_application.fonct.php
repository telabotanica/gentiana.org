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
// CVS : $Id: adap_application.fonct.php,v 1.4 2006-12-01 10:39:14 alexandre_tb Exp $
/**
* Contient les fonctions de l'appli admin_auth
*
* 
* 
*
*@package Admin_auth
*@subpackage Fonctions
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/**
 *
 *
 * @return
 */

function adap_supprimer_application($id_appl, &$db) {
    $requete = 'DELETE FROM gen_application WHERE gap_id_application='.$id_appl;
    $resultat = $db->query ($requete) ;
}

/**
 *
 *
 * @return
 */

function adap_valeurs_par_defaut ($id_appl, &$db) {
    // requete sur gen_site_auth
    
    $requete = 'SELECT * FROM gen_application WHERE gap_id_application='.$id_appl ;
    $resultat = $db->query ($requete) ;
    if (DB::isError ($resultat)) {
        trigger_error("Echec de la requete : $requete<br />".$resultat->getMessage(), E_USER_WARNING) ;
        return ;
    }
    $tableau_retour = array () ;
    $ligne = $resultat->fetchRow (DB_FETCHMODE_OBJECT) ;
    $tableau_retour['nom_appl'] = $ligne->gap_nom ;
    $tableau_retour['description'] = $ligne->gap_description ;
    $tableau_retour['chemin'] = $ligne->gap_chemin ;
    unset ($requete, $resultat) ;
    return $tableau_retour ;
}

/**
 *
 *
 * @return
 */

function insertion ($valeur, &$db) {
    $id_appl_bdd = SQL_obtenirNouveauId ($db, 'gen_application', 'gap_id_application') ;
    $requete = "insert into gen_application set gap_id_application="
                .$id_appl_bdd.","
                .requete_site_appl($valeur) ;
    $resultat = $db->query ($requete) ;
    if (DB::isError ($resultat)) {
        trigger_error("Echec de la requete : $requete<br />".$resultat->getMessage(),E_USER_WARNING) ;
    }
}

/**
 *
 *
 * @return
 */

function mise_a_jour ($valeur, &$db) {
    $requete = "update gen_application set ".requete_site_appl($valeur)
                .' WHERE gap_id_application='.$GLOBALS['id_appl'] ;
    $resultat = $db->query ($requete) ;
    if (DB::isError ($resultat)) {
        trigger_error("Echec de la requete : $requete<br />".$resultat->getMessage(),E_USER_WARNING) ;
    }
}

/**
 *
 *
 * @return  string  un morceau de code SQL
 */

function requete_site_appl (&$valeur) {
	if (!isset($valeur['applette'])) {$valeur['applette']=0;}
	return   'gap_nom="'.$valeur['nom_appl'].'", '
	        .'gap_description="'.$valeur['description'].'", '
		.'gap_chemin="'.$valeur['chemin'].'"';
}


// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adap_application.fonct.php,v $
* Revision 1.4  2006-12-01 10:39:14  alexandre_tb
* Suppression des références aux applettes
*
* Revision 1.3  2006/09/07 13:28:39  jp_milcent
* Mise en majuscule des termes SQL et trie des application par ordre alphabétique.
*
* Revision 1.2  2005/09/23 15:02:38  florian
* correction de bugs
*
* Revision 1.1  2005/03/09 10:44:04  jpm
* Mise au norme du nom du fichier.
*
* Revision 1.2  2005/03/09 10:40:33  alex
* version initiale
*
* Revision 1.1  2004/12/13 18:07:28  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>