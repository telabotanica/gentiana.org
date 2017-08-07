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
// CVS : $Id: adau_auth.fonct.php,v 1.2 2005-04-14 13:54:51 jpm Exp $
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
*@version       $Revision: 1.2 $
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
function adau_supprimer_authentification($id_auth, &$db)
{
    // Recherche l'identifiant de gen_site_auth_bdd à partir de gen_site_auth
    $requete = 'SELECT gsa_ce_auth_bdd FROM gen_site_auth WHERE gsa_id_auth = '.$GLOBALS['id_auth'];
    $resultat = $db->query ($requete) ;
    $ligne = $resultat->fetchRow (DB_FETCHMODE_OBJECT) ;
    $id_auth_bdd = $ligne->gsa_ce_auth_bdd ;
    
    $requete = 'DELETE FROM gen_site_auth WHERE gsa_id_auth = '.$id_auth;
    $resultat = $db->query($requete);
    
    $requete = 'DELETE FROM gen_site_auth_bdd WHERE gsab_id_auth_bdd = '.$id_auth_bdd;
    $resultat = $db->query($requete);
}

/**
 *
 *
 * @return
 */
function adau_valeurs_par_defaut($id_auth, &$db)
{
    // Requete sur gen_site_auth
    $requete = 'SELECT * FROM gen_site_auth WHERE gsa_id_auth = '.$id_auth;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
        return ;
    }
    $tableau_retour = array();
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $tableau_retour['nom_auth'] = $ligne->gsa_nom;
    $tableau_retour['abreviation'] = $ligne->gsa_abreviation;
    $tableau_retour['id_auth_bdd'] = $ligne->gsa_ce_auth_bdd;
    $tableau_retour['id_auth'] = $ligne->gsa_id_auth;
    unset($requete, $resultat);
    
    // Requete sur gen_site_auth_bdd
    $requete = 'SELECT * FROM gen_site_auth_bdd WHERE gsab_id_auth_bdd = '.$ligne->gsa_ce_auth_bdd;
    unset($ligne);
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
        return ;
    }
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $tableau_retour['dsn'] = $ligne->gsab_dsn;
    $tableau_retour['nom_table'] = $ligne->gsab_nom_table;
    $tableau_retour['champs_login'] = $ligne->gsab_nom_champ_login;
    $tableau_retour['champs_passe'] = $ligne->gsab_nom_champ_mdp;
    $tableau_retour['cryptage'] = $ligne->gsab_cryptage_mdp;
    $tableau_retour['parametres'] = $ligne->gsab_parametres;
    
    return $tableau_retour;
}

/**
 *
 *
 * @return
 */
function insertion ($valeur, &$db)
{
    $id_auth_bdd = SQL_obtenirNouveauId($db, 'gen_site_auth_bdd', 'gsab_id_auth_bdd');
    $requete = 'INSERT INTO gen_site_auth SET gsa_id_auth = '
                .SQL_obtenirNouveauId($db, 'gen_site_auth', 'gsa_id_auth').', '
                .requete_site_auth($valeur)
                .', gsa_ce_auth_bdd = '.$id_auth_bdd;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
        return ;
    }
    $requete = 'INSERT INTO gen_site_auth_bdd SET gsab_id_auth_bdd = '.$id_auth_bdd.', '.requete_site_auth_bdd($valeur);
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
        return ;
    }
}

/**
 *
 *
 * @return
 */
function mise_a_jour($valeur, &$db)
{
    $requete =  'UPDATE gen_site_auth SET '.requete_site_auth($valeur).' '.
                'WHERE gsa_id_auth = '.$GLOBALS['id_auth'];
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
        return ;
    }
    unset($requete);
    // Recherche l'identifiant de gen_site_auth_bdd à partir de gen_site_auth
    $requete = 'SELECT gsa_ce_auth_bdd FROM gen_site_auth WHERE gsa_id_auth = '.$GLOBALS['id_auth'];
    $resultat = $db->query($requete);
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $id_auth_bdd = $ligne->gsa_ce_auth_bdd;
    
    $requete =  'UPDATE gen_site_auth_bdd SET '
                .requete_site_auth_bdd($valeur)
                .' WHERE gsab_id_auth_bdd = '.$id_auth_bdd;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        trigger_error('Échec de la requete : '.$requete.'<br />'.$resultat->getMessage(), E_USER_WARNING);
        return ;
    }
}

/**
 *
 *
 * @return  string  un morceau de code SQL
 */
function requete_site_auth(&$valeur)
{
    return   'gsa_nom="'.$valeur['nom_auth'].'", '
            .'gsa_ce_type_auth=1, '
            .'gsa_abreviation="'.$valeur['abreviation'].'"' ;
}

/**
 *
 *
 * @return
 */
function requete_site_auth_bdd (&$valeur)
{
    return 'gsab_dsn="'.$valeur['dsn'].'", '
            .'gsab_nom_table="'.$valeur['nom_table'].'", '
            .'gsab_nom_champ_login="'.$valeur['champs_login'].'", '
            .'gsab_nom_champ_mdp="'.$valeur['champs_passe'].'", '
            .'gsab_parametres="'.$valeur['parametres'].'", '
            .'gsab_cryptage_mdp="'.$valeur['cryptage'].'"';
}
// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adau_auth.fonct.php,v $
* Revision 1.2  2005-04-14 13:54:51  jpm
* Amélioration de l'interface et mise en conformité.
*
* Revision 1.1  2005/03/09 10:49:52  jpm
* Changement d'un nom de fichier.
*
* Revision 1.2  2004/12/06 12:43:21  alex
* ajout du champs paramètre dans ls authentification
*
* Revision 1.1  2004/12/06 11:31:54  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>