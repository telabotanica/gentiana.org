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
// CVS : $Id$
/**
* Fichier de configuration de l'application d'inscription/annuaire
*
* A éditer de façon spécifique à chaque déploiement
*
*@package ins_annuaire
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/
//================================= CONSTANTES DB ==================================
/** Nom de la table Annuaire */
define ('INS_ANNUAIRE', 'annuaire');
/** Nom de la table des départements */ 
define ('INS_TABLE_DPT', 'gen_departement');
/** Nom de la table des pays */
define ('INS_TABLE_PAYS', 'gen_i18n_pays');
/** Champs identifiant */
define ('INS_CHAMPS_ID', 'a_id');                   
/** Champs adresse mail */
define ('INS_CHAMPS_MAIL', 'a_mail');
/** Champs nom */
define ('INS_CHAMPS_NOM', 'a_nom');
/** Champs prénom */
define ('INS_CHAMPS_PRENOM', 'a_prenom');
/** Champs description */
define ('INS_CHAMPS_DESCRIPTION','a_description');
/** Champs mot de passe */
define ('INS_CHAMPS_PASSE', 'a_mot_de_passe');
/** Champs identifiant pays */
define ('INS_CHAMPS_PAYS', 'a_ce_pays');
/** Champs code postal */
define ('INS_CHAMPS_CODE_POSTAL', 'a_code_postal');
/** Champs département */
define ('INS_CHAMPS_DEPARTEMENT', 'a_numero_dpt');
/** Champs adresse 1 */
define ('INS_CHAMPS_ADRESSE_1', 'a_adresse1');
/** Champs adresse 2 */
define ('INS_CHAMPS_ADRESSE_2', 'a_adresse2');
/** Champs ville */
define ('INS_CHAMPS_VILLE', 'a_ville');
/** Champs date de l'inscription */
define ('INS_CHAMPS_DATE_INSCRIPTION', 'a_date_inscription');
/** Champs pour désigner si c'est l'inscription d'une structure */
define ('INS_CHAMPS_EST_STRUCTURE', 'a_est_structure');
/** Champs sigle de la structure */
define ('INS_CHAMPS_SIGLE_STRUCTURE', 'a_sigle_structure');
/** Champs numéro de téléphone */
define ('INS_CHAMPS_TELEPHONE', 'a_telephone');
/** Champs numéro de fax */
define ('INS_CHAMPS_FAX', 'a_fax');
/** Champs d'appartenance à une structure */
define ('INS_CHAMPS_STRUCTURE', 'a_ce_structure');
/** Champs identifiant du pays de la table des pays*/
define ('INS_CHAMPS_ID_PAYS', 'gip_id_pays');
/** Champs nom du pays de la table des pays*/
define ('INS_CHAMPS_LABEL_PAYS', 'gip_nom_pays_traduit');
/** Champs qui contient la localisation */
define ('INS_CHAMPS_I18N_PAYS', ' gip_id_i18n') ;
/** Champs identifiant du département de la table des departement*/
define ('INS_CHAMPS_ID_DEPARTEMENT','gd_id_departement');
/** Champs nom du département de la table des departement*/
define ('INS_CHAMPS_NOM_DEPARTEMENT','gd_nom');
/** Champs pour l'abonnement à une liste, laisser vide si vous ne souhaitez pas d'inscription' */
define ('INS_CHAMPS_LETTRE', 'a_lettre');
/** Champs de la date d'inscription */
define ('INS_CHAMPS_DATE', 'a_date_inscription');
/** Champs du site Internet*/
define ('INS_CHAMPS_SITE_INTERNET', 'a_site_internet');
/** Champs pour la vue sur carto*/
define ('INS_CHAMPS_VISIBLE', 'a_voir_sur_carto');
/** Champs pour la vue sur carto*/
define ('INS_CHAMPS_NUM_AGREMENT', 'a_num_agrement_fpc');
/** Champs pour le logo*/
define ('INS_CHAMPS_LOGO', 'a_logo');
?>