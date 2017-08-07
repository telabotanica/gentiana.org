<?php
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
/**
* Fichier de traduction en fran�ais de l'application inscription
*
* Fichier de traduction en fran�ais de l'application inscription
*
*@package vecam
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Id$
// +------------------------------------------------------------------------------------------------------+
*/  

define ('ANN_NOM', 'Nom') ;
define ('ANN_PRENOM', 'Pr&eacute;nom') ;
define ('ANN_CP', 'Code Postal') ;
define ('ANN_PAYS', 'Pays') ;
define ('ANN_LANGUES_PARLES', 'Langues parl&eacute;s :') ;
define ('ANN_EMAIL', 'E-mail :') ;
define ('ANN_MOT_DE_PASSE', 'Mot de passe :') ;
define ('ANN_REPETE_MOT_DE_PASSE', 'R&eacute;p&eacute;ter le mot de passe :') ;
define ('ANN_RETABLIR', 'R�tablir') ;
define ('ANN_VALIDER', 'Valider') ;
define ('ANN_MOTS_DE_PASSE_DIFFERENTS', 'Les mots de passe sont diff&eacute;rents !') ;
define ('ANN_EMAIL_REQUIS', 'Vous devez saisir un email.') ;
define ('ANN_MOT_DE_PASSE_REQUIS', 'Vous devez saisir un mot de passe.') ;
define ('ANN_MAIL_INCORRECT', 'L\'email doit avoir une forme correcte, utilisateur@domaine.ext') ;
define ('ANN_NOTE_REQUIS', 'Indique les champs requis') ;
define ('ANN_MODIFIER_INSCRIPTION', 'Modifier votre inscription') ;
define ('ANN_SUPPRIMER_INSCRIPTION', 'Supprimer votre inscription') ;
define ('ANN_MESSAGE_BIENVENU', 'Vous &ecirc;tes inscrit &agrave; I-Jumelage') ;
define ('ANN_CLIQUEZ_LETTRE', 'Cliquez sur une lettre pour voir les inscrits.') ;
define ('ANN_LISTE_INSCRIT_LETTRE', 'Liste des inscrits &agrave; la lettre') ;
define ('ANN_TITRE', 'Annuaire du site de Gentiana') ;
define ('ANN_IDENTIFICATION_PRESENTATION_XHTML', 
'<h2>S\'identifier et s\'inscrire</h2>
<p>Afin de pouvoir consulter l\'annuaire, il est indispensable de s\'inscrire.<br />
L\'inscription est libre et gratuite !<br />
Elle vous permet de :</p>
<ul>
	<li>saisir des fiches pour nous informer ;</li>
	<li>saisir vos observations botaniques�;</li>
	<li>consulter l\'annuaire des personnes inscrites et pouvoir ainsi �changer des informations ;</li>
	<li>acc�der �  certaines informations diffus�es sur le site ;</li>
	<li>recevoir une lettre �lectronique d\'informations.</li>
</ul>
<p>Par la suite, il vous sera possible de modifier voire annuler votre inscription.<br />
Seuls vos pr�nom, nom, ville, commune et pays appara�trons dans l\'annuaire, les autres informations restent confidentielles (e-mail, adresse). </p>
<p>Les informations recueillies sont n�cessaires pour votre <strong>inscription au site de GENTIANA</strong>. Elles font l\'objet d\'un traitement informatique et servent � GENTIANA 
� vous contacter afin de valider les donn�es botaniques ou les informations que vous donnez.</p>
<p>En application des articles 39 et suivants de la loi du 6 janvier 1978 modifi�e, vous b�n�ficiez d\'un droit d\'acc�s 
et de rectification aux informations qui vous concernent.</p>
<p><strong>L\'inscription � l\'annuaire du site de GENTIANA implique que vous soyez d\'accord pour que votre nom, pr�nom,  ville, 
code postal  et pays apparaissent en clair dans le site Internet de GENTIANA</strong>.</p>

<p>Si vous avez perdu votre mot de passe, veuillez cliquez sur le lien suivant : <a href="http://www.gentiana.org/page:inscrire?action=mdp_oubli">perte de mot de passe</a></p>
<p>D�j�  inscrit, identifiez-vous pour acc�der �  votre fiche personnelle :</p>');
define ('ANN_TEXTE_PERDU', 'Si vous avez perdu votre mot de passe, indiquer '.
                            'votre adresse email dans le champs login ci-dessus et cliquez sur "Valider"') ;
define ('ANN_CHECK_UNCHECK', 'Cocher les cases pour s&eacute;lectionner votre destinataire ou cocher / d&eacute;cocher tout') ;
define ('ANN_ENVOYER_MAIL', 'Envoyer un email') ;
define ('ANN_MESSAGE_A_TOUS', 'Si vous souhaitez diffuser votre message � l\'ensemble des membres du r�seau, vous pouvez r�diger un article dans %s.');
define ('ANN_ACTUALITE', 'les actualit�s de Gentiana');
define ('ANN_SURVEILLANCE', '<strong>Avertissement :</strong> la messagerie ci-dessous est destin�e � vous permettre d\'�changer ' .
		'des messages entre inscrit au site de Gentiana, sans d�voiler les adresses email des inscrits. Afin de respecter la ' .
		'tranquillit� de chacun, il est strictement interdit d\'utiliser cette messagerie interne pour faire des relances p�riodiques ' .
		'd\'informations ou des annonces publicitaires et commerciales. Une surveillance du contenu des mails �chang�s est effectu�e ' .
		'par l\'Association Gentiana. Merci de votre compr�hension.') ;
define ('ANN_SUJET', 'Sujet') ;
define ('ANN_MESSAGE', 'Message') ;
define ('ANN_ENVOYER', 'Envoyer') ;
define ('ANN_CLIC_CONFIRMATION', 'Cliquez sur OK pour confirmer') ;
define ('ANN_PAS_D_INSCRIT', 'Pas d\'inscrit') ;
define ('ANN_MAIL_ENVOYER', 'Votre mail a �t� envoy�') ;
define ('ANN_DATE_INS', 'Date d\'inscription') ;
define ('ANN_VILLE', 'Ville') ;
define ('ANN_PIED_INFO', 'Si vous constatez des probl�mes en utilisant cette application, veuillez contacter : ') ;
define ('ANN_PIED_MAIL', 'accueil@gentiana.org') ;

// ========================= Labels pour les mails ============================

define ('ANN_VERIF_MAIL_COCHE', 'Veuillez cocher au moins un destinataire pour votre mail' );
define ('ANN_VERIF_TITRE', 'Votre message doit comporter un titre <i>et</i> un corps') ;
define ('ANN_MESSAGE_APPLI', 'Application ANNUAIRE');
define ('ANN_MESSAGE_ENVOYE_A', 'Ce message a �t� envoy� � ');
define ('ANN_PIED_MESSAGE', '---------------------------------------------------------------------------'."\n".
                            'Ce message vous est envoy� par l\'interm�diaire du site Internet'."\n".
                            '(http://www.gentiana.org) de Gentiana, '."\n".
                            'auquel vous �tes inscrit.'."\n".
                            'D\'autres inscrits peuvent avoir re�u ce message.'."\n".
                            'Ne r�pondez que si vous �tes concern�, ou si vous avez des'."\n".
                            'informations utiles � transmettre au demandeur.' ) ;


// ============================ Label de lannuaire Back ===========================
define ('AM_L_TITRE', 'Chercher un adh�rent') ;
define ('AM_L_RECHERCHER', 'Rechercher') ;
define ('AM_L_PAYS', 'Pays') ;
define ('AM_L_NOM', 'Nom') ;
define ('AM_L_PRENOM', 'Pr�nom') ;
define ('AM_L_VILLE', 'Ville') ;
define ('AM_L_DEPARTEMENT', 'D�partement') ;
define ('AM_L_MAIL', 'Mail') ;
define ('AM_L_COTISANTS', 'Cotisants') ;
define ('AM_L_GRP_RES', 'Grouper les r�sultats') ;
define ('AM_L_TOUS', 'Tous') ;
define ('AM_L_MAIL_SELECTION', 'Envoyer un mail � la s�lection') ;
?>