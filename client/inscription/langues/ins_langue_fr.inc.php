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
// CVS : $Id: ins_langue_fr.inc.php,v 1.3 2005/03/21 16:50:45 alex Exp $
/**
* Fichier de traduction en français de l'application inscription
*
* Fichier de traduction en français de l'application inscription
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2005/03/21 16:50:45 $
// +------------------------------------------------------------------------------------------------------+
*/

define ("INS_AJOUT_MEMBRE", "Remplissez le formulaire ci-dessous pour vous inscrire") ;
define ('INS_MODIF_MEMBRE', 'Modification de vos informations');
define ("INS_NOM", "Nom") ;
define ("INS_NOM_REQUIS", "Indiquez votre nom.") ;
define ("INS_PRENOM", "Pr&eacute;nom") ;
define ("INS_PRENOM_REQUIS", "Veuillez indiquer votre prénom.") ;
define ("INS_PAYS", "Pays") ;
define ("INS_LANGUES_PARLES", "Langues parl&eacute;s") ;
define ("INS_EMAIL", "Adresse mail") ;
define ("INS_MOT_DE_PASSE", "Mot de passe :") ;
define ("INS_REPETE_MOT_DE_PASSE", "R&eacute;p&eacute;ter le mot de passe :") ;
define ("INS_ADRESSE_1", "Adresse ") ;
define ("INS_ADRESSE_2", "Adresse (suite)") ;
define ("INS_REGION", "R&eacute;gion / province") ;
define ("INS_CODE_POSTAL", "Code postal") ;
define ("INS_CODE_POSTAL_REQUIS", "Indiquez votre code postal.") ;
define ("INS_VILLE", "Ville") ;
define ("INS_VILLE_REQUIS", "Indiquez votre ville.") ;
define ("INS_SITE_INTERNET", "Site web personnel") ;
define ("INS_LETTRE", "Je souhaite recevoir la lettre d'actualité de Gentiana") ;
define ("INS_ADHERENT", "Vous &ecirc;tes adh&eacute;rents de personnes morales (associations, institutions, entreprise... )") ;
define ("INS_ANNULER", "Annuler") ;
define ("INS_RETABLIR", "Rétablir") ;
define ("INS_VALIDER", "Valider") ;
define ("INS_MOTS_DE_PASSE_DIFFERENTS", "Les mots de passe sont diff&eacute;rents !") ;
define ("INS_EMAIL_REQUIS", "Vous devez saisir un email.") ;
define ("INS_MOT_DE_PASSE_REQUIS", "Vous devez saisir un mot de passe.") ;
define ("INS_MAIL_INCORRECT", "L'email doit avoir une forme correcte, utilisateur@domaine.ext") ;
define ("INS_MAIL_DOUBLE", "Cet email est d&eacute;j&agrave utilis&eacute; par quelqu'un d'autre") ;
define ("INS_NOTE_REQUIS", "Indique les champs requis") ;
define ("INS_ACCUEIL_INSCRIPTION", "Inscription au site de Gentiana") ;
define ("INS_MODIFIER_INSCRIPTION", "Modifier votre inscription") ;
define ("INS_SUPPRIMER_INSCRIPTION", "Supprimer votre inscription") ;
define ("INS_MESSAGE_BIENVENU", "Vous &ecirc;tes inscrit &agrave; Gentiana") ;
define ('INS_MESSAGE_EXPIRATION', 'Votre demande a expiré, veuillez ressaisir le formulaire d\'inscription.') ;
define ("INS_FICHE_PERSONNELLE", "Fiche personnelle") ;
define ("INS_DECONNEXION", 'D&eacute;connexion') ;
define ("INS_INSCRIPTION", 'Inscription') ;
define ("INS_MDP_PERDU_TITRE", "Perte ou oubli de mot de passe");
define ("INS_MDP_PERDU_TITRE_RETENTER", "Vous pouvez aussi essayer à nouveau de vous identifier...");

define ("INS_TEXTE_PERDU", "Si vous avez perdu votre mot de passe, veuillez cliquez sur le lien suivant :") ;
define('INS_MDP_PERDU_OUBLI', 'perte de mot de passe');
define ("INS_DEJA_INSCRIT", "D&eacute;j&agrave;  inscrit, identifiez-vous pour acc&eacute;der &agrave;  votre fiche personnelle :") ;
define ("INS_ERREUR_LOGIN", "Utilisateur inconnu ou mot de passe erronn&eacute;") ;
define ("INS_SI_PASSE_PERDU", "Si vous avez perdu votre mot de passe") ;
define ("INS_INDIQUE_ADRESSE", "Indiquez dans le champs ci-dessous l'adresse email que vous avez utilisé pour vous inscrire au site.<br>\n".
                                "Un nouveau mot de passe vous sera envoyé.") ;
define ("INS_ENVOIE_PASSE", "Envoi du mot de passe par mail") ;
define ("INS_LAIUS_INSCRIPTION", "L'inscription est libre et gratuite !") ;
define ("INS_LAIUS_INSCRIPTION_2", "Elle vous permet de :</p>
<ul>
	<li>saisir vos observations botaniques ;</li>
	<li>consulter l'annuaire des personnes inscrites et pouvoir ainsi échanger des informations ;</li>
	<li>accéder à  certaines informations diffusées sur le site ;</li>
	<li>recevoir une lettre électronique d'informations.</li>
</ul>
<p>Par la suite, il vous sera possible de modifier voire annuler votre inscription.<br />
Seuls vos prénom, nom, ville, commune et pays apparaîtrons dans l'annuaire, les autres informations restent confidentielles (e-mail, adresse). </p>
<p>Les informations recueillies sont nécessaires pour votre <strong>inscription au site de GENTIANA</strong>. Elles font l'objet d'un traitement informatique et servent à GENTIANA 
à vous contacter afin de valider les données botaniques ou les informations que vous donnez.</p>
<p>En application des articles 39 et suivants de la loi du 6 janvier 1978 modifiée, vous bénéficiez d'un droit d'accès 
et de rectification aux informations qui vous concernent.</p>
<p><strong>L'inscription à l'annuaire du site de GENTIANA implique que vous soyez d'accord pour que votre nom, prénom,  ville, 
code postal  et pays apparaissent en clair dans le site Internet de GENTIANA</strong>.");
define ('INS_PIED_INFO', 'Si vous constatez des problèmes en utilisant cette application, veuillez contacter : ') ;
define ('INS_PIED_MAIL', 'gentiana@gentiana.org') ;

//============= L'envoie du mot de passe perdu par mail =============================
define ("INS_NOUVEAU_MOT_DE_PASSE", "Votre nouveau mot de passe Gentiana") ;
define ("INS_NOUVEAU_MOT_DE_PASSE_2", "Votre nouveau mot de passe : ") ;
define ("INS_NOUVEAU_MOT_DE_PASSE_LAIUS", "\n\nCe mot de passe vous permet de modifier les informations\n".
                                        "vous concernant dans le site de Gentiana.\n".
                                        "http://www.gentiana.org/\n\n") ;
define ("INS_MOT_DE_PASSE_ENVOYE_1", "Votre nouveau mot de passe a &eacute;t&eacute; ".
                                        "envoy&eacute; &agrave; l'adresse") ;
define ("INS_MOT_DE_PASSE_ENVOYE_2", "Relevez votre messagerie, notez votre nouveau mot de passe et identifiez vous à ".
                                    "nouveau en allant à l'inscription. N'h&eacute;sitez pas à changer ce mot de passe ".
                                    "pour en mettre un plus simple, tr&egrave;s facile &agrave; retenir." );
                                    
//============= L'envoie d'un mail de confirmation ===================================
// Ne pas utiliser d'entités HTML
define ("INS_MAIL_INSCRIPTION_1", "Votre inscription a bien été prise en compte.\n".
                                "Voici les informations que nous avons enregistré :\n") ;
define ("INS_MAIL_INSCRIPTION_2", "\nVous pouvez modifier votre inscription sur \nhttp://www.gentiana.org\n".
                                    "rubrique Inscription.\n\n".
                                    "L'équipe de Gentiana.") ;

// Envoir d'un mail à la coordination
define ("INS_MAIL_COORD_SUJET", "Un nouvel inscrit à Gentiana") ;
define ("INS_MAIL_COORD_CORPS", "Un nouvel inscrit à Gentiana") ;

define ("INS_MESSAGE_INSCRIPTION", "<h1 class=\"titre1_inscription\">Inscription à Gentiana</h1>\n".
            "<p>Votre inscription a bien été prise en compte.</p>\n".
            "<h2>Pour terminer votre inscription :</h2>\n".
            "<p>Un message de confirmation vous a été envoyé à l'adresse e-mail que vous avez fournie.".
            " Veuillez lire ce mail et en suivre les instructions pour activer complètement votre inscription.</p>") ;
define ('INS_MESSAGE_DEBUT_MAIL_INSCRIPTION', 'Bonjour,'."\n\n".
                                        'Nous avons reçu une demande d\'inscription pour cette adresse mail.'."\n".
                                        'Pour confirmer, cliquer sur le lien ci-dessous.'."\n\n" ) ;
define ('INS_MESSAGE_FIN_MAIL_INSCRIPTION', "\n\n".'L\'équipe de Gentiana') ;
?>