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
// CVS : $Id: bottin.langue_fr.inc.php,v 1.20 2007-06-01 13:40:17 alexandre_tb Exp $
/**
* Fichier de traduction en francais de l'application ins_annuaire
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.20 $ $Date: 2007-06-01 13:40:17 $
// +------------------------------------------------------------------------------------------------------+
*/

if (file_exists (INS_CHEMIN_APPLI.'langues/bottin_langue_'.INS_LANGUE_DEFAUT.'.local.php')) {
	include_once INS_CHEMIN_APPLI.'langues/bottin_langue_'.INS_LANGUE_DEFAUT.'.local.php' ;
}
define ('INS_TITRE_INSCRIPTION', 'Inscription au r&eacute;seau');
define ('INS_INSCRIPTION_PERSONNE','S\'inscrire en tant que personne');
define ('INS_INSCRIPTION_STRUCTURE', 'S\'inscrire en tant que structure');
define ('INS_AJOUT_MEMBRE', 'Ajout d\'un nouveau membre') ;
define ('INS_NOM', 'Nom') ;
define ('INS_NOM_REQUIS', 'Veuillez indiquer votre nom.') ;
define ('INS_PRENOM', 'Pr&eacute;nom') ; // Pas d'entite, car sert dans le corps d un mail
define ('INS_PRENOM_REQUIS', 'Veuillez indiquer votre pr&eacute;nom.') ;
define ('INS_PAYS', 'Pays') ;
define ('INS_LANGUES_PARLES', 'Langues parl&eacute;s') ;
define ('INS_EMAIL', 'Adresse mail') ;
define ('INS_MOT_DE_PASSE', 'Mot de passe') ;
define ('INS_REPETE_MOT_DE_PASSE', 'R&eacute;p&eacute;ter le mot de passe') ;
define ('INS_ADRESSE_1', 'Adresse') ;
define ('INS_ADRESSE_2', 'Adresse (suite)') ;
define ('INS_REGION', 'R&eacute;gion / province') ;
define ('INS_CODE_POSTAL', 'Code postal') ;
define ('INS_CODE_POSTAL_REQUIS', 'Veuillez indiquer votre code postal.') ;
define ('INS_VILLE', 'Ville') ;
define ('INS_VILLE_REQUIS', 'Veuillez indiquer votre ville.') ;
define ('INS_SITE_INTERNET', 'Site internet') ;
define ('INS_LETTRE', 'Je souhaite recevoir la lettre d\'actualit&eacute;') ;
define ('INS_MOT_DE_PASSE_CHANGE', 'Changement de mot de passe') ;
define ('INS_NOUVEAU_MOT_DE_PASSE_ENVOYE', 'Votre mot de passe a &eacute;t&eacute; chang&eacute;, consultez votre messagerie.') ;
define ('INS_MAIL_INCONNU_DANS_ANNUAIRE', 'L\'adresse mail saisie n\'est pas pr&eacute;sente dans notre annuaire, v&eacute;rifiez la saisie de cette adresse') ;
define ('INS_VOUS_RECEVEZ_LETTRE','Vous &ecirc;tes abonn&eacute;(e) &agrave; la cyberlettre');
define ('INS_VOUS_RECEVEZ_PAS_LETTRE','Vous n\'&ecirc;tes pas abonn&eacute;(e) &agrave; la cyberlettre');
define ('INS_VOUS_APPARAISSEZ','Vous apparaissez sur la cartographie et dans l\'annuaire du site');
define ('INS_VOUS_APPARAISSEZ_PAS','Vous n\'apparaissez par sur la cartographie, ni dans l\'annuaire du site');
define ('INS_ADHERENT', 'Vous &ecirc;tes adh&eacute;rents de personnes morales (associations, institutions, entreprise... )') ;
define ('INS_ORGANISME', 'Organisme') ;
define ('INS_FONCTION', 'Fonction') ;
define ('INS_TELEPHONE', 'T&eacute;l&eacute;phone');
define ('INS_TELEPHONE_STRUCTURE', 'T&eacute;l&eacute;phone de la structure');
define ('INS_FAX','Fax');
define ('INS_FAX_STRUCTURE','Fax de la structure');
define ('INS_COORD_CONTACT', 'Coordonn&eacute;es du contact');
define ('INS_NOM_CONTACT', 'Nom');
define ('INS_PRENOM_CONTACT', 'Pr�nom');
define ('INS_POSTE_CONTACT', 'Poste');
define ('INS_TEL_CONTACT', 'T�l�phone');
define ('INS_LOGO_OU_IMAGE', 'Ins&eacute;rer une image ou un logo (.jpg, .png  ou .gif, 150Ko max.)');
define ('INS_ANNULER', 'Annuler') ;
define ('INS_RETABLIR', 'R&eacute;tablir') ;
define ('INS_VALIDER', 'Valider') ;
define ('INS_MOTS_DE_PASSE_DIFFERENTS', 'Les mots de passe sont diff&eacute;rents !') ;
define ('INS_EMAIL_REQUIS', 'Vous devez saisir une adresse &eacute;lectronique.') ;
define ('INS_MOT_DE_PASSE_REQUIS', 'Vous devez saisir un mot de passe.') ;
define ('INS_MAIL_INCORRECT', 'L\'email doit avoir une forme correcte, utilisateur@domaine.ext') ;
define ('INS_MAIL_DOUBLE', 'Cet email est d&eacute;j&agrave utilis&eacute; par quelqu\'un d\'autre') ;
define ('INS_NOTE_REQUIS', 'Indique les champs requis') ;
define ('INS_ACCUEIL_INSCRIPTION', 'Inscription au r&eacute;seau') ;
define ('INS_MODIFIER_INSCRIPTION', 'Modifier votre inscription') ;
define ('INS_SUPPRIMER_INSCRIPTION', 'Supprimer votre inscription') ;
define ('INS_MESSAGE_BIENVENU', 'Vous &ecirc;tes inscrit') ;
define ('INS_FICHE_PERSONNELLE', 'Fiche personnelle') ;
define ('INS_FICHE_STRUCTURE','Fiche de la structure');
define ('INS_DECONNEXION', 'D&eacute;connexion') ;
define ('INS_INSCRIPTION', 'Inscription') ;
define ('INS_TEXTE_PERDU', 'Mot de passe perdu? Indiquez seulement votre adresse email et cliquez sur \'Valider\'') ;
define ('INS_SIGLE_DE_LA_STRUCTURE', 'Sigle de la structure');
define ('INS_SIGLE_STRUCTURE', 'Sigle de la structure <br />(s\'il n\'existe pas, mettre <br />le nom de la structure)');
define ('INS_VISIBLE', 'Je souhaite apparaitre sur la cartographie et sur l\'annuaire du site');
define ('INS_SIGLE_REQUIS', 'Sigle de la structure requis!');
define ('INS_NOM_STRUCTURE', 'Nom de la structure');
define ('INS_MAIL_STRUCTURE', 'Adresse &eacute;lectronique de la structure');
define ('INS_SITE_STRUCTURE', 'Site Internet de la structure');
define ('INS_NUM_AGREMENT', 'Num&eacute;ro d\'agr&eacute;ment FPC');
define ('INS_NOM_WIKI', 'Nom wiki') ;
define ('INS_NOM_WIKI_REQUIS', 'Nom wiki requis') ;
define ('INS_DEJA_INSCRIT', 'D&eacute;j&agrave;&agrave; inscrit, identifiez-vous pour acc&eacute;der &agrave;� votre fiche personnelle :') ;
define ('INS_PAS_INSCRIT', 'Pas encore inscrit, enregistrez-vous!');
define ('INS_ERREUR_LOGIN', 'Utilisateur inconnu ou mot de passe erronn&eacute;') ;
define ('INS_SI_PASSE_PERDU', 'Recevez un nouveau mot de passe par courriel') ; ;
define ('INS_ENVOIE_PASSE', 'Envoi du mot de passe par courriel') ;
define ('INS_LAIUS_INSCRIPTION', 'Pas encore inscrit, inscrivez-vous !') ;
define ('INS_LAIUS_INSCRIPTION_2', '<strong>L\'inscription est libre et gratuite</strong>, elle vous permet de :<br /><ul>
<li> consulter l\'annuaire des personnes inscrites au R&eacute;seau et pouvoir ainsi &eacute;changer des informations</li>
<li> acc&eacute;der &agrave;� certaines informations diffus&eacute;es sur le site</li>
<li> vous inscrire &agrave;� des projets</li>
<li> r&eacute;diger des annonces d\'actualit&eacute;, d\'&eacute;v&eacute;nements, de s&eacute;jours et rencontres</li>
<li> r&eacute;diger des fiches ressources</li>
<li> recevoir un bulletin &eacute;lectronique d\'informations.</li></ul>') ;
define ('INS_ERREUR_SAISIE', 'Erreur de saisie') ;
define ('INS_VEUILLEZ_CORRIGER', 'Veuillez corriger.') ;
define ('INS_CARTOGRAPHIE','Cartographie');
define ('INS_CONFIG_MENU','Configuration de la cartographie du menu');
define ('INS_TITRE_CARTO','Titre &agrave; afficher dans le site pour cette cartographie');
define ('INS_FAUT_CONFIGURER_CARTO','Vous ne pouvez pas acc&eacute;der &agrave; cette cartographie car elle n\'a pas encore &eacute;t&eacute; configur&eacute;e.');

//============= L'envoie du mot de passe perdu par mail =============================
define ('INS_NOUVEAU_MOT_DE_PASSE', 'Votre nouveau mot de passe sur Educ-Envir.org et Ecole-et-Nature.org') ;
define ('INS_NOUVEAU_MOT_DE_PASSE_2', 'Votre nouveau mot de passe : ') ;
define ('INS_NOUVEAU_MOT_DE_PASSE_LAIUS', "\n\n".'Ce mot de passe vous permet de modifier les informations '.
                                        'vous concernant dans les sites du r�seau Ecole et Nature:'."\n".
                                        'http://www.educ-envir.org/'."\n".'http://www.ecole-et-nature.org/'."\n\n".
                                        'Identifiez-vous sur l\'un de ces sites, puis vous pourrez changer votre mot de passe en cliquant sur "Modifier votre inscription".') ;
define ('INS_MOT_DE_PASSE_ENVOYE_1', 'Votre nouveau mot de passe a &eacute;t&eacute; '.
                                        'envoy&eacute; &agrave; l\'adresse') ;
define ('INS_MOT_DE_PASSE_ENVOYE_2', 'Relevez votre messagerie, notez votre nouveau mot de passe et identifiez vous &agrave; '.
                                    'nouveau en allant &agrave; l\'inscription. N\'h&eacute;sitez pas &agrave; changer ce mot de passe '.
                                    'pour en mettre un plus simple, plus facile &agrave; retenir.' );
                                    
//============= L'envoie d'un mail de confirmation ===================================
// Ne pas utiliser d'entites HTML
define ('INS_ENTETE_INSCRIPTION','Inscription sur le site');
define ('INS_MAIL_INSCRIPTION_1', 'Votre inscription a bien &eacute;t&eacute; prise en compte.\n'.
                                'Voici les informations que nous avons enregistr&eacute; :\n') ;
define ('INS_MAIL_INSCRIPTION_2', '\nVous pouvez modifier votre inscription sur \nhttp://www.ecole-et-nature.org ou \nhttp://www.educ-envir.org\n'.
                                    'rubrique S\'inscrire (le signe + sur le bandeau du haut).\n\n'.
                                    'L\'�quipe du r�seau Ecole et Nature.') ;
define ('INS_MESSAGE_EXPIRATION','Le temps imparti &agrave; votre inscription s\'est &eacute;coul&eacute;...<br />'.
				 'Merci de bien vouloir vous r&eacute;inscrire, en r&eacute;pondant rapidement au mail de confirmation.<br /><br />'.
				 'En vous remerciant de votre compr&eacute;hension, &agrave; tout de suite!');
define ('INS_MESSAGE_VALIDER_INSCRIPTION','Validation de votre inscription sur le r�seau :'.'\n'.
					  'Merci de vous &ecirc;tre inscrit(e), soyez bienvenu(e)!'.'\n'.
					  'Veuillez cliquer sur le lien ci-dessous pour finaliser votre inscription:'.'\n');
define ('INS_MESSAGE_DEBUT_MAIL_INSCRIPTION', 'Bonjour,'."\n\n".
                                        'Nous avons re�u une demande d\'inscription pour cette adresse mail.'."\n".
                                        'Pour confirmer, cliquer sur le lien ci-dessous.'."\n\n" ) ;
define ('INS_MESSAGE_FIN_MAIL_INSCRIPTION', "\n\n".'L\'&eacute;quipe de Vivreurope  ') ;
// Envoir d'un mail a la coordination
define ('INS_MAIL_COORD_SUJET', 'Un nouvel inscrit au r&eacute;seau ') ;
define ('INS_MAIL_COORD_CORPS', 'Une nouvelle inscription a &eacute;t&eacute; effectu&eacute;e sur le site.') ;
define ('INS_CHAMPS_REQUIS', 'Champs requis') ;
define ('INS_MODERATION_SUJET', 'Une personne souhaite s\'inscrire au site');
define ('INS_NOUVELLE_INSCRIPTION_A_MODERE', 'Bonjour' ."\n\n".
		'Un utilisateur souhaite s\'inscrire, mod&eacute;rez son inscription');


define ('INS_MESSAGE_INSCRIPTION', 'Votre inscription a &eacute;t&eacute; prise en compte, relevez votre messagerie et cliquer sur le lien propos&eacute; pour terminer votre inscription.') ;
define ('INS_MESSAGE_EN_ATTENTE', 'Votre inscription a bien &eacute;t&eacute; prise en compte. Une demande a &eacute;t&eacute; envoy&eacute;' .
		' &agrave; un mod&eacute;rateur.<br />' .
		'Vous recevrez un email de confirmation lorsque le mod&eacute;rateur aura rendu effective votre inscription.');
define ('INS_EN_ATTENTE_DE_MODERATION', 'En attente de mod&eacute;ration');
// carto google
define ('INS_GOOGLE_MSG', '<br />Si le point correspond &agrave; votre adresse,<br />'.
			' vous pouvez valider le formulaire en cliquant sur &laquo; valider &raquo; ci dessous.<br />'.
			'Vous pouvez ajuster le marqueur pour le faire correspondre &agrave; votre adresse.');
			
			
			
// Configuration de l inscription
define ('INS_SUJET_MAIL_INSCRIPTION_PRISE_EN_COMPTE', 'Indiquer ici, le sujet du mail que l\'inscrit recevra apr&egrave;s que'.
			' son inscription ai &eacute;t&eacute; mod&eacute;r&eacute;e par un administrateur');
define ('INS_CORPS_MAIL_INSCRIPTION_PRISE_EN_COMPTE', 'Le contenu du mail apr&egrave;s inscription mod&eacute;r&eacute;');
define ('INS_NOM_INSCRIPTION', 'Nom inscription');
define ('INS_INSCRIPTION_MODERE', 'L\'inscription est-elle mod&eacute;r&eacute;e ?');
// CARTO
define ('INS_DATE_INS', 'Date d\'inscription') ;
define ('INS_CHECK_UNCHECK', 'Cocher les cases pour s&eacute;lectionner votre destinataire ou cocher / d&eacute;cocher tout') ;
define ('INS_ENVOYER_MAIL', 'Envoyer un email') ;
define ('INS_SUJET', 'Sujet') ;
define ('INS_MESSAGE', 'Message') ;
define ('INS_ENVOYER', 'Envoyer') ;
define ('INS_LABEL_PROJET', 'en tant que membre du r�seau');
define ('INS_COULEUR', 'La couleur est proportionnelle au nombre de fiches.') ;
define ('INS_MONDE', 'Monde') ;
define ('INS_ECHELLE', 'Echelle : ') ;
define ('INS_CLIQUER_ACCEDER', 'Cliquer sur la carte pour zoomer ou acc&eacute;der aux informations&nbsp;&nbsp;') ;
define ('INS_VISUALISER_ZONE', 'Mettre en rouge la zone...');
define ('INS_MESSAGE_ENVOYE', '<br /><br />Votre message a &eacute;t&eacute; envoy&eacute;') ;
define ('INS_MESSAGE_ENVOYE_A', 'Ce message a �t� envoy� �') ;  // pas d'entit�s HTML, c'est pour un mail
define ('INS_PIED_MESSAGE', '') ;
define ('INS_MAIL_ENVOYE', 'Le mail a &eacute;t&eacute; envoy&eacute; avec succ&egrave;s');
define ('INS_AUCUN_INSCRIT', 'aucun inscrit') ;
define ('INS_INSCRIT', 'inscrit') ;
define ('INS_TEXTE_FIN_MAIL', "\n".'---------------------------------------------------------------------------'."\n".
                                'Ce message vous est envoy� par l\'interm�diaire des sites Internet'."\n".
                                'du r�seau '."\n".
                                'auquel vous �tes inscrit. D\'autres inscrits peuvent avoir re�u ce message.'."\n".
                                'Ne r�pondez que si vous �tes concern�, ou si vous avez des informations'."\n".
                                'utiles � transmettre au demandeur.'."\n".
                                '----------------------------------------------------------------------------') ;
define ('INS_NO_DESTINATAIRE', '<br /><br />Veuillez cocher au moins un destinataire pour votre mail<br />');
define ('INS_VOUS_DEVEZ_ETRE_INSCRIT', 'Vous devez �tre inscrit pour pouvoir acc�der aux informations.<br />Identifiez-vous ou inscrivez-vous sur la page <a href="/Inscription">inscription</a> du site.');
define ('INS_SURVEILLANCE_ENVOI_MAIL', 'Surveillance envois de mails: ');
define ('INS_ENREGISTRER_ET_QUITTER', 'Enregistrer et quitter');
define ('INS_TABLE', 'Nom de la table dans la base SQL contenant des informations � cartographier');
define ('INS_TABLE_SUPPLEMENTAIRE', 'Nom de la table additionnelle contenant des informations � cartographier');
define ('INS_NOM_CHAMPS_PAYS', 'Nom du champs repr�sentant le pays');
define ('INS_NOM_CHAMPS_CP', 'Nom du champs repr�sentant le code postal');
define ('INS_REQUETE_SQL_SUPPLEMENTAIRE', 'Compl�ment de requ�te SQL (conditions suppl�mentaires pour le WHERE)');
define ('INS_PAS_NECESSAIRE', 'Pas n�c�ssaire');
define ('INS_ANNUAIRE_MEMBRES','Annuaire des inscrits au site');
define ('INS_RECHERCHE_ANNUAIRE_DES_INSCRITS','Rechercher dans l\'annuaire des inscrits');
define ('INS_DIX_DERNIERES_INSCRIPTIONS','Les dix derni�res inscriptions');
define ('INS_RECHERCHER','Rechercher');
define ('INS_PERSONNES_OU_STRUCTURES','des personnes ou des structures');
define ('INS_PERSONNES','uniquement des personnes');
define ('INS_STRUCTURES','uniquement des structures');
define ('INS_JE_RECHERCHE','Je recherche');
define ('INS_DEPARTEMENT_POUR_LA_FRANCE','D&eacute;partements pour le pays France');
define ('INS_TOUS_DEPARTEMENTS','tous les d&eacute;partements');
define ('INS_TOUS_PAYS','tous les pays');
define ('INS_NOM_ANNUAIRE','Nom (voire pr&eacute;nom) de la personne ou de la structure recherch&eacute;e');
define ('INS_ENTREES','entr&eacute;es trouv&eacute;es');
define ('INS_RESULTATS_RECHERCHE','Les r&eacute;sultats de la recherche');
define ('INS_PAS_DE_RESULTATS','Pas de r&eacute;sultats pour cette recherche, veuillez &eacute;largir vos crit&egrave;res de recherche.');
define ('INS_PAS_IDENTIFIE','Vous pouvez consulter la liste des inscrits, mais pas leur envoyer de message mail. Pour pouvoir les contacter par mail, il faudrait <a href="/Inscription">vous identifier ou vous inscrire au site</a>.');
define ('INS_CLIQUER_ELEMENT_LISTE','Cliquer sur un des &eacute;l&eacute;ments de la liste pour avoir ses informations d&eacute;taill&eacute;es.');
define ('INS_PRESENTATION', 'Pr&eacute;sentation');
define ('INS_ABONNEMENTS', 'Mes abonnements');
define ('INS_GESTION_DES_ABONNEMENTS', 'Gestion de mes abonnements');
define ('INS_ACTUALITES', 'Actualit&eacute;s');
define ('INS_ACTUALITES_DEPOSEES', 'Actualit&eacute;s d&eacute;pos&eacute;es');
define ('INS_RESSOURCES', 'Ressources');
define ('INS_RESSOURCES_ASSOCIEES','Ressources associ&eacute;es');
define ('INS_COMPETENCES', 'Comp&eacute;tences');
define ('INS_COMPETENCES_ASSOCIEES','Comp&eacute;tences associ&eacute;es');
define ('INS_RETOUR_A_LA_CARTE','Retour &agrave; la carte : ');

//annuaire backoffice
define ('INS_CONFIG_ANNUAIRE_BACKOFFICE','Configuration de la gestion de l\'annuaire');
define ('INS_TYPE_ANNUAIRE','Type d\'annuaire &agrave; configurer');
define ('INS_ANNUAIRE_BOTTIN','Annuaire du bottin');
define ('INS_ANNUAIRE_ADMIN_PAPYRUS','Annuaire des administrateurs Papyrus');
define ('AM_L_TITRE', 'Chercher un adh&eacute;rent') ;
define ("AM_L_RECHERCHER", "Rechercher") ;
define ("AM_L_PAYS", "Pays") ;
define ("AM_L_NOM", "Nom") ;
define ("AM_L_PRENOM", "Pr&eacute;nom") ;
define ("AM_L_VILLE", "Ville") ;
define ("AM_L_DEPARTEMENT", "D&eacute;partement") ;
define ("AM_L_MAIL", "Mail") ;
define ("AM_L_COTISANTS", "Cotisants") ;
define ("AM_L_GRP_RES", "Grouper les r&eacute;sultats") ;
define ("AM_L_TOUS", "Tous") ;
define ("AM_L_MAIL_SELECTION", "Envoyer un mail &agrave; la s&eacute;lection") ;
define ('INS_ACTION', 'Action');
define ('INS_SUPPRIMER', 'Supprimer');
define ('INS_PAS_D_INSCRIT_EN_ATTENTE', 'Pas d\'incrit en attente');
//define ('ANN_PAS_D_INSCRITS', 'Pas d\'inscrits commen�ant par cette lettre dans l\'annuaire.');
//define ("ANN_LANGUES_PARLES", "Langues parl&eacute;s :") ;
//define ("ANN_EMAIL", "Courriel :") ;
//define ("ANN_MOT_DE_PASSE", "Mot de passe :") ;
//define ("ANN_REPETE_MOT_DE_PASSE", "R&eacute;p&eacute;ter le mot de passe :") ;
//define ("ANN_RETABLIR", "R�tablir") ;
//define ("ANN_VALIDER", "Valider") ;
//define ("ANN_MESSAGE_BIENVENU", "Vous &ecirc;tes inscrit au R�seau") ;
//define ("ANN_CLIQUEZ_LETTRE", 'Cliquez sur une lettre pour voir les membres du r�seau.') ;
//define ("ANN_LISTE_INSCRIT_LETTRE", "Liste des inscrits &agrave; la lettre") ;
//define ("ANN_TITRE", 'Annuaire du r�seau') ;
//define ("ANN_CHECK_UNCHECK", "Cocher les cases pour s&eacute;lectionner votre destinataire ou cocher / d&eacute;cocher tout") ;
//define ("ANN_ENVOYER_MAIL", "Envoyer un message aux personnes coch�es") ;
//define ("ANN_SUJET", "Sujet") ;
//define ("ANN_MESSAGE", "Message") ;
//define ("ANN_ENVOYER", "Envoyer") ;
//define ("ANN_CLIC_CONFIRMATION", "Cliquez sur OK pour confirmer") ;
//define ("ANN_PAS_D_INSCRIT", "Pas d'inscrit") ;
//define ('ANN_DATE','Date d\'inscription');
//// ========================= Labels pour les mails ============================
//
//define ("ANN_VERIF_MAIL_COCHE", "Veuillez cocher au moins un destinataire pour votre mail" );
//define ("ANN_VERIF_TITRE", "Votre message doit comporter un titre <i>et</i> un corps") ;
//define ("ANN_PIED_MESSAGE", "\n---------------------------------------------------------------------------".
//                            "\nCe message vous est envoy� par l'interm�diaire du site Internet".
//                            "\n(http://www.domaine.org) du r�seau , ".
//                            "\nauquel vous �tes inscrit. ".
//                            "\nNe r�pondez pas � ce message." ) ;
//                            
//define ('ANN_LOGUEZ_VOUS', 'Vous devez �tre inscrit au r�seau pour acc�der � l\'annuaire');
//

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: bottin.langue_fr.inc.php,v $
* Revision 1.20  2007-06-01 13:40:17  alexandre_tb
* nouveaux labels
*
* Revision 1.19  2007/04/11 08:30:12  neiluj
* remise en état du CVS...
*
* Revision 1.15  2006/12/01 13:23:16  florian
* integration annuaire backoffice
*
* Revision 1.14  2006/10/05 13:53:54  florian
* amélioration des fichiers sql
*
* Revision 1.13  2006/09/13 12:31:18  florian
* ménage: fichier de config Papyrus, fichiers temporaires
*
* Revision 1.12  2006/07/17 10:01:08  alexandre_tb
* correction du chemin vers le fichier de traduction local
*
* Revision 1.11  2006/07/04 09:36:16  alexandre_tb
* modification d'un label
*
* Revision 1.10  2006/04/11 08:39:19  alexandre_tb
* modification d'un label
*
* Revision 1.9  2006/04/10 14:01:36  florian
* uniformisation de l'appli bottin: plus qu'un fichier de fonctions
*
* Revision 1.8  2006/04/04 12:23:05  florian
* modifs affichage fiches, généricité de la carto, modification totale de l'appli annuaire
*
* Revision 1.7  2006/02/28 16:26:40  alexandre_tb
* changement d'une entit�
*
* Revision 1.6  2006/02/28 14:07:23  alexandre_tb
* changement de la constante de langue
*
* Revision 1.5  2005/12/19 11:13:29  alexandre_tb
* Ajout de l'appel vers bottin_langue_fr.local.php
*
* Revision 1.4  2005/12/02 13:50:52  florian
* ajout gestion erreur javascript
*
* Revision 1.3  2005/11/24 16:17:52  florian
* changement template inscription + modifs carto
*
* Revision 1.2  2005/11/18 16:04:15  florian
* corrections de bugs, optimisations, tests pour rendre inscription stable.
*
* Revision 1.1  2005/11/17 18:48:02  florian
* corrections bugs + amélioration de l'application d'inscription
*
* Revision 1.3  2005/10/14 12:02:50  alexandre_tb
* Modification des labels pour les rendre plus g�n�rique
*
* Revision 1.2  2005/09/29 13:56:48  alexandre_tb
* En cours de production. Reste � g�rer les news letters et d'autres choses.
*
* Revision 1.1  2005/09/28 13:19:08  alexandre_tb
* version initiale
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>