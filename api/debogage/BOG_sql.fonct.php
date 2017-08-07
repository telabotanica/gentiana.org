<?php
//vim: set expandtab tabstop=4 shiftwidth=4:
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
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
// CVS : $Id: BOG_sql.fonct.php,v 1.2 2005-02-28 11:14:45 jpm Exp $
/**
*Paquetage : BOG - bibliothèque de fonctions de débogage.
*
* Ce paquetage contient des fonctions de débogage pour différent besoin:
* - erreur de requête
*
*@package Debogage
//Auteur original :
*@author            Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author            Alexandre GRANIER <alex@tela-botanica.org>
*@author            Laurent COUDOUNEAU <lc@gsite.org>
*@copyright         Tela-Botanica 2000-2004
*@version           $Revision: 1.2 $ $Date: 2005-02-28 11:14:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +-------------------------------------------------------------------------+
// |                          Liste des fonctions                            |
// +-------------------------------------------------------------------------+

/**Fonction BOG_afficherErreurSql() - Permet d'afficher un message d'erreur sql complet.
*
* Cette fonction permet d'afficher un ensemble de données suite à une erreur de reqête sql
* permettant de trouver plus rapidement la source de l'erreur.
*
* @param string le nom du fichier d'où provient la requête erronée (utiliser __FILE__ lors de l'apple de cette fonction).
* @param integer le numéro de la ligne de la requête (utiliser __LINE__ lors de l'apple de cette fonction).
* @param string le message d'erreur fourni par le programmeur.
* @param string la requête sql erronée.
* @param string un éventuel commentaire complémentaire
*
* @return string l'ensemble des messages d'erreur et des informations collectées.
*/
function BOG_afficherErreurSql ($nom_fichier_courant, $numero_ligne_courante, $message_erreur, $requete = '', $autre = '') 
{
    $retour_erreur = "\n";
    $retour_erreur .= '<div id="zone_erreur">'."\n";
    $retour_erreur .= '<h1 > ERREUR SQL </h1><br />'."\n";
    $retour_erreur .= '<p>'."\n";
    $retour_erreur .= '<span class="champ_intitule" > Fichier : </span> ';
    $retour_erreur .= '<span class="champ_valeur" > '.$nom_fichier_courant.'</span><br />'."\n";
    
    $retour_erreur .= '<span class="champ_intitule" > Ligne n° : </span> ';
    $retour_erreur .= '<span class="champ_valeur" > '.$numero_ligne_courante.'</span><br />'."\n";
    
    $retour_erreur .= '<span class="champ_intitule" > Message erreur : </span> ';
    $retour_erreur .= '<span class="champ_valeur" > '.$message_erreur.'</span><br />'."\n";
    
    if ($requete != '') {
        $retour_erreur .= '<span class="champ_intitule" > Requete : </span> ';
        $retour_erreur .= '<span class="champ_valeur" > '.$requete.' </span><br />'."\n";
    }
    
    if ($autre != '') {
        $retour_erreur .= '<span class="champ_intitule" > Autres infos : </span> ';
        $retour_erreur .= '<span class="champ_valeur" > '.$autre.' </span><br />'."\n";
    }
    $retour_erreur .= '</p>'."\n";
    $retour_erreur .= '</div>'."\n";
    return $retour_erreur;
}

/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: BOG_sql.fonct.php,v $
* Revision 1.2  2005-02-28 11:14:45  jpm
* Modification des auteurs.
*
* Revision 1.1  2004/06/15 10:13:07  jpm
* Intégration dans Papyrus.
*
* Revision 1.4  2004/04/21 07:49:31  jpm
* Modification des commentaires.
*
* Revision 1.3  2004/03/22 16:23:29  jpm
* Correction point-virgule en trop.
*
* Revision 1.2  2004/03/22 12:17:06  jpm
* Utilisation de class et id CSS à la place des attributs styles.
*
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>