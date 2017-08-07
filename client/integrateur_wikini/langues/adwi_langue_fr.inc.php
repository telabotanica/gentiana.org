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
// CVS : $Id: adwi_langue_fr.inc.php,v 1.6 2006-06-19 10:06:29 alexandre_tb Exp $
/**
* Gestion des langues de l'application ADWI : administration des Wikini
*
* Contient les constantes pour la langue française de l'application ADWI
*
*@package Admin_Wikini
*@subpackage Langues
//Auteur original :
*@author        David Delon <david.delon@clapas.net>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.6 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            LISTE des CONSTANTES                                      |
// +------------------------------------------------------------------------------------------------------+
define ("ADWI_NOM_WIKINI", "Nom Wikini") ;
define ("ADWI_BDD_HOTE", "Serveur base de donnee") ;
define ("ADWI_BDD_NOM", "Base de donnée") ;
define ("ADWI_BDD_UTILISATEUR", "Utilisateur") ;
define ("ADWI_BDD_MDP", "Mot de Passe") ;
define ("ADWI_TABLE_PREFIX", "Préfixe des tables") ;
define ("ADWI_PAGE", "Page de démarrage") ;
define ("ADWI_CHEMIN", "Chemin d'accès") ;

define ("ADWI_MODIFIER", "Modifier") ;
define ("ADWI_SUPPRIMER", "Supprimer") ;
define ("ADWI_SELECTIONNER", "Selection") ;
define ("ADWI_CHOISIR", "Choisir") ;
define ("ADWI_AJOUTER", "Ajouter un Wikini") ;
define ("ADWI_VISITER", "Voir Contenu ") ;


define("ADWI_TITRE_SELECTION","Sélection Wikini pour le menu");

define("ADWI_LISTE_WIKINI","Liste des Wikini enregistrés");

define("ADWI_PAGE_DEMARRAGE","Page de démarrage");

define ("ADWI_NOM_WIKINI_ALERTE", "Vous devez spécifier un nom") ;
define ("ADWI_NOM_WIKINI_NON_VALIDE", "Le nom wiki n'est pas valide, il ne doit contenir que des lettres sans accents.") ;

define ("ADWI_CHAMPS_REQUIS", "Indique les champs requis") ;

define ("ADWI_ANNULER", "Annuler") ;
define ("ADWI_VALIDER", "Valider") ;
define ("ADWI_RETOUR", "Retour") ;


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: adwi_langue_fr.inc.php,v $
* Revision 1.6  2006-06-19 10:06:29  alexandre_tb
* Ajout d'une règle sur le nom wiki. Que des lettres.
*
* Revision 1.5  2005/09/09 09:37:17  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.4  2005/09/06 08:35:36  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.3  2005/09/02 11:29:25  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.2  2005/08/31 17:34:52  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.1  2005/08/25 08:59:12  ddelon
* Integrateur Wikini et administration des Wikini
*
* Revision 1.2  2005/03/09 10:40:37  alex
* version initiale
*
* Revision 1.1  2004/12/13 18:07:38  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>