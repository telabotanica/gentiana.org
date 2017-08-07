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
// CVS : $Id: pap_identification.fonct.php,v 1.5.4.1 2007-11-19 12:59:29 alexandre_tb Exp $
/**
* Bibliothèque de fonctions d'identification de Papyrus.
*
* Ce paquetage contient des fonctions d'identifiacation pour différents besoin
* de Papyrus.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author            Alexandre GRANIER <alex@tela-botanica.org>
//Autres auteurs :
*@author            Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright         Tela-Botanica 2000-2004
*@version           $Revision: 1.5.4.1 $ $Date: 2007-11-19 12:59:29 $
// +------------------------------------------------------------------------------------------------------+
*/

// +-------------------------------------------------------------------------+
// |                          Liste des fonctions                            |
// +-------------------------------------------------------------------------+

/** Fonction GEN_afficherInfoIdentification() - Retourne un message demandant l'identification.
*
* Cette fonction informe l'utilisateur qu'il doit utiliser le formulaire d'identification
* mis à sa dispositon. Ce formulaire peut être placé n'importe où dans le squelette via la 
* balise <!-- IDENTIFICATION -->. Un note précise de contacter le webmaster si le formulaire
* d'identification est indisponible.
*
* @return string note précisant la nécessité de s'identifier sur le site.
*/
function GEN_afficherInfoIdentification()
{
    $res  = "\n";
    $res .= str_repeat(' ', 12).'<p>';
    $res .= 'Veuillez vous identifier dans la zone d\'identification mise à votre disposition sur ce site.';
    $res .= str_repeat(' ', 12).'</p>'."\n";
    $res .= str_repeat(' ', 12).'<p>';
    $res .= '<strong>Note : </strong>Veuillez contacter le webmaster si cette zone d\'identification est absente.';
    $res .= str_repeat(' ', 12).'</p>'."\n";
    
    return $res;
}

/** Fonction verification_mot_de_passe() - Met à jour les mots de passe vers le cryptage MD5.
*
* Cette fonction permet de mettre à jour en douceur l'annuaire des inscrits à Tela Botanica.
* Les mots de passe anciennement crypté avec la fonction password de Mysql sont progressivement
* passé en cryptage MD5.
*
* @param mixed l'objet de Pear DB permettant la connexion à la base de données.
* @param string le mot de passe non crypté de l'utilisateur.
* @param string le login de l'utilisateur.
* @return void  une requête modifie la base de données.
*/
function verification_mot_de_passe($objet_pear_db, $password, $username)
{
    // Requête pour la taille du champs mot de passe pour l'individu
    $requete =  'SELECT U_PASSWD, LENGTH(U_PASSWD) AS longueur '.
                'FROM annuaire_tela '.
                'WHERE U_MAIL = "'.$username.'"';
    $resultat = $objet_pear_db->query($requete);
    (DB::isError($resultat)) ? die (BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
    
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    if (!is_object ($ligne)) return;
    $longueur = $ligne->longueur;
    $mot_de_passe_crypte = $ligne->U_PASSWD;
    unset($ligne);
    $resultat->free();
    
    if ($longueur == 16) {
        // Le couple login / mot de passe est-il bon ?
        $requete = 'SELECT OLD_PASSWORD("'.$password.'")';
        $resultat = $objet_pear_db->query($requete);
        (DB::isError($resultat)) ? die (BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
        
        $ligne = $resultat->fetchRow(DB_FETCHMODE_ORDERED);
        $resultat->free();
        
        // Est-ce que le mot de passe est bon ?
        if ($ligne[0] == $mot_de_passe_crypte) {
            // On met à jour le champs de U_PASSWD pour le mettre en md5
            $requete =  'UPDATE annuaire_tela '.
                        'SET U_PASSWD = "'.md5($password).'" '.
                        'WHERE U_MAIL = "'.$username.'"';
            $resultat = $objet_pear_db->query($requete);
            (DB::isError($resultat)) ? die (BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
        }
    }
}

/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: pap_identification.fonct.php,v $
* Revision 1.5.4.1  2007-11-19 12:59:29  alexandre_tb
* suppression d un warning dans la fonction verification_mot_de_passe
*
* Revision 1.5  2006/12/14 10:31:04  jp_milcent
* Modification de PASSWORD en OLD_PASSWORD pour Mysql5
*
* Revision 1.4  2005/03/03 14:36:09  jpm
* Correction orthographe.
*
* Revision 1.3  2004/10/25 14:49:59  jpm
* Correction orthographe.
*
* Revision 1.2  2004/09/23 14:32:03  jpm
* Correction bogue sur l'annuaire_tela.
*
* Revision 1.1  2004/06/15 15:10:15  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.8  2004/05/01 11:42:40  jpm
* Suppression de la fonction GEN_afficherFormIdentification() transformée en applette.
*
* Revision 1.7  2004/04/09 16:23:41  jpm
* Prise en compte des tables i18n.
*
* Revision 1.6  2004/04/02 16:33:04  jpm
* Ajout de commentaires aux fonctions.
* Modification des formulaires d'identification.
*
* Revision 1.5  2004/04/01 11:24:51  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.4  2004/03/26 12:51:24  jpm
* Modification mineure sur l'indentation.
*
* Revision 1.3  2004/03/24 17:31:54  jpm
* Ajout de l'indentation du xhtml de la fonction loginFunction().
* Mise en forme.
*
* Revision 1.2  2004/03/22 18:36:49  jpm
* Ajout de la fonction de mise à jour des mots de passe de l'annuaire Tela Botanica. Cette fonction devrait à terme intégré l'application Annuaire Tela Botanica.
*
* Revision 1.1  2004/03/22 11:34:19  jpm
* Bibliothèque de fonctions gérant l'identification dans Génésia.
*
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>
