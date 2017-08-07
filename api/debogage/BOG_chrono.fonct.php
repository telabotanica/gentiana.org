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
// CVS : $Id: BOG_chrono.fonct.php,v 1.3 2005-02-28 11:14:45 jpm Exp $
/**
* Bibliothèque de fonctions permettant de mesure le temps d'execution d'un script.
*
* Contient des fonctions permettant d'évaluer un script.
*
*@package Debogage
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2005-02-28 11:14:45 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+
/**Fonction BOG_afficherChrono() - Permet d'afficher les temps d'éxécution de différentes parties d'un script.
*
* Cette fonction permet d'afficher un ensemble de mesure de temps prises à différents endroits d'un script.
* Ces mesures sont affichées au sein d'un tableau XHTML dont on peut controler l'indentation des balises.
* Pour un site en production, il suffit d'ajouter un style #chrono {display:none;} dans la css. De cette façon,
* le tableau ne s'affichera pas. Le webmaster lui pourra rajouter sa propre feuille de style affichant le tableau.
* Le développeur initial de cette fonction est Loic d'Anterroches. Elle a été modifiée par Jean-Pascal Milcent.
* Elle utilise une variable gobale : $_CHRONO_
*
* @author   Loic d'Anterroches
* @author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
* @param    int     l'indentation de base pour le code html du tableau.
* @param    int     le pas d'indentation pour le code html du tableau.
* @return   string  la chaine XHTML de mesure des temps.
*/
function BOG_afficherChrono($indentation_origine = 8, $indentation = 4)
{
    $sortie = str_repeat(' ', $indentation_origine).
        '<table id="chrono" lang="fr" summary="Résultat du chronométrage du programme affichant la page actuelle.">'."\n";
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '<caption>Chronométrage</caption>'."\n";
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '<thead>'."\n";
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 2))).
                '<tr><th>Action</th><th>Temps écoulé (en s.)</th><th>Cumul du temps écoulé (en s.)</th></tr>'."\n";
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '</thead>'."\n";
    
    $tbody = str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '<tbody>'."\n";
    $total_tps_ecoule = 0;
    // Récupération de la première mesure
    list($usec, $sec) = explode(' ', $GLOBALS['_CHRONO_']['depart']);
    // Ce temps correspond à tps_fin
    $tps_fin = ((float)$usec + (float)$sec);
    
    foreach ($GLOBALS['_CHRONO_'] as $cle => $valeur) {
        list($usec, $sec) = explode(' ',$valeur);
        $tps_debut = ((float)$usec + (float)$sec);
        
        $tps_ecoule = abs($tps_fin - $tps_debut);
        $total_tps_ecoule += $tps_ecoule;
        
        $tbody .=   str_repeat(' ', ($indentation_origine + ($indentation * 2))).
                    '<tr>'.
                        '<th>'.$cle.'</th>'.
                        '<td>'.number_format($tps_ecoule,3).'</td>'.
                        '<td>'.number_format($total_tps_ecoule,3).'</td>'.
                    '</tr>'."\n";
        $tps_fin = $tps_debut;
    }
    $tbody .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '</tbody>'."\n";
    
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '<tfoot>'."\n";
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 2))).
                '<tr>'.
                    '<th>'.'Total du temps écoulé (en s.)'.'</th>'.
                    '<td colspan="2">'.number_format($total_tps_ecoule,3).'</td>'.
                '</tr>'."\n";
    $sortie .= str_repeat(' ', ($indentation_origine + ($indentation * 1))).
            '</tfoot>'."\n";
    $sortie .= $tbody;
    $sortie .= str_repeat(' ', $indentation_origine).
        '</table>'."\n";
    
    return $sortie;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: BOG_chrono.fonct.php,v $
* Revision 1.3  2005-02-28 11:14:45  jpm
* Modification des auteurs.
*
* Revision 1.2  2004/11/29 15:54:16  jpm
* Changement de nom de variable et légère correction.
*
* Revision 1.1  2004/06/15 10:13:07  jpm
* Intégration dans Papyrus.
*
* Revision 1.2  2004/04/22 09:01:55  jpm
* Ajout de l'attribut lang au tableau.
*
* Revision 1.1  2004/04/21 07:49:13  jpm
* Ajout d'une bibliothèque de fonction pour le chronométrage des scripts.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>