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
// CVS : $Id: SQL_manipulation.fonct.php,v 1.2 2004-10-21 15:17:19 alex Exp $
/**
* Bibliothèque de fonctions liées au SQL
*
* Contient des fonctions permettant d'automatiser certaine requête SQL.
*
*@package SQL
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.2 $ $Date: 2004-10-21 15:17:19 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/** Fonction SQL_obtenirNouveauId()- Retourne le prochain identifiant numérique libre d'une table.
*
*   On passe en paramètre le nom de la table, le nom du champ cotnenant la clé et l'objet PEAR DB
*
*   @param  mixed       handler de connexion
*   @param  string      Nom de la table
*   @param  string      Nom du champ identifiant.
*   @return mixed       la nouvelle valeur de clé pouvant être utilisé ou false en cas d'erreur sql.
*/

function SQL_obtenirNouveauId(&$db, $table, $colonne_identifiant)
{
    $requete = 'SELECT MAX('.$colonne_identifiant.') AS maxi FROM '.$table;
    $resultat = $db->query($requete);
    if (DB::isError($resultat) || $resultat->numRows() > 1) {
        return false;
    }
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    return $ligne->maxi + 1;
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: SQL_manipulation.fonct.php,v $
* Revision 1.2  2004-10-21 15:17:19  alex
* passage de l'identifiant de connexion par référence.
*
* Revision 1.1  2004/06/15 10:13:26  jpm
* Intégration dans Papyrus.
*
* Revision 1.1  2004/04/28 11:38:54  jpm
* Ajout d'un fichier de fonctions de manipulation sql.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>