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
// CVS : $Id: ins_annuaire.langue.fr.inc.php,v 1.3 2007/04/06 08:35:46 neiluj Exp $
/**
* Fichier de traduction en français de l'application ins_annuaire
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2007/04/06 08:35:46 $
// +------------------------------------------------------------------------------------------------------+
*/
define ('INS_TITRE_INSCRIPTION', 'Inscription au réseau');
define ('INS_INSCRIPTION_PERSONNE','S\'inscrire en tant que personne');
define ('INS_INSCRIPTION_STRUCTURE', 'S\'inscrire en tant que structure');
define ("INS_AJOUT_MEMBRE", "Ajout d'un nouveau membre") ;
define ("INS_NOM", "Nom") ;
define ("INS_NOM_REQUIS", "Veuillez indiquer votre nom.") ;
define ("INS_PRENOM", "Pr&eacute;nom") ;
define ("INS_PRENOM_REQUIS", "Veuillez indiquer votre prénom.") ;
define ("INS_PAYS", "Pays") ;
define ("INS_LANGUES_PARLES", "Langues parl&eacute;s") ;
define ("INS_EMAIL", "Adresse mail") ;
define ("INS_MOT_DE_PASSE", "Mot de passe") ;
define ("INS_REPETE_MOT_DE_PASSE", "R&eacute;p&eacute;ter le mot de passe") ;
define ("INS_ADRESSE_1", "Adresse") ;
define ("INS_ADRESSE_2", "Adresse (suite)") ;
define ("INS_REGION", "R&eacute;gion / province") ;
define ("INS_CODE_POSTAL", "Code postal") ;
define ("INS_CODE_POSTAL_REQUIS", "Veuillez indiquer votre code postal.") ;
define ("INS_VILLE", "Ville") ;
define ("INS_VILLE_REQUIS", "Veuillez indiquer votre ville.") ;
define ("INS_SITE_INTERNET", "Site web personnel") ;
define ("INS_LETTRE", "Je souhaite recevoir la lettre<br /> d'actualité sur l'éducation en<br /> l'environnement") ;
define ("INS_ADHERENT", "Vous &ecirc;tes adh&eacute;rents de personnes morales (associations, institutions, entreprise... )") ;
define ("INS_ORGANISME", "Organisme") ;
define ("INS_FONCTION", "Fonction") ;
define ('INS_TELEPHONE', 'Téléphone');
define ('INS_FAX','Fax');
define ("INS_ANNULER", "Annuler") ;
define ("INS_RETABLIR", "Rétablir") ;
define ("INS_VALIDER", "Valider") ;
define ("INS_MOTS_DE_PASSE_DIFFERENTS", "Les mots de passe sont diff&eacute;rents !") ;
define ("INS_EMAIL_REQUIS", "Vous devez saisir une adresse électronique.") ;
define ("INS_MOT_DE_PASSE_REQUIS", "Vous devez saisir un mot de passe.") ;
define ("INS_MAIL_INCORRECT", "L'email doit avoir une forme correcte, utilisateur@domaine.ext") ;
define ("INS_MAIL_DOUBLE", "Cet email est d&eacute;j&agrave utilis&eacute; par quelqu'un d'autre") ;
define ("INS_NOTE_REQUIS", "Indique les champs requis") ;
define ("INS_ACCUEIL_INSCRIPTION", "Inscription au réseau") ;
define ("INS_MODIFIER_INSCRIPTION", "Modifier votre inscription") ;
define ("INS_SUPPRIMER_INSCRIPTION", "Supprimer votre inscription") ;
define ("INS_MESSAGE_BIENVENU", "Vous &ecirc;tes inscrit aux sites Educ-Envir.org et Ecole-et-Nature.org") ;
define ("INS_FICHE_PERSONNELLE", "Fiche personnelle") ;
define ("INS_DECONNEXION", 'D&eacute;connexion') ;
define ("INS_INSCRIPTION", 'Inscription') ;
define ("INS_TEXTE_PERDU", "Mot de passe perdu? Indiquez seulement votre adresse email et cliquez sur \"Valider\"") ;
define ('INS_SIGLE_STRUCTURE', 'Sigle de la structure <br />(s\'il n\'existe pas, mettre <br />le nom de la structure)');
define ('INS_VISIBLE', 'Je souhaite apparaitre sur la <br/>cartographie et sur l\'annuaire <br />du site');
define ('INS_SIGLE_REQUIS', 'Sigle de la structure requis!');
define ('INS_NOM_STRUCTURE', 'Nom de la structure');
define ('INS_MAIL_STRUCTURE', 'Adresse électronique');
define ('INS_SITE_STRUCTURE', 'Site Internet de la structure');
define ('INS_NUM_AGREMENT', 'Numéro d\'agrément FPC');
define ("INS_NOM_WIKI", "Nom wiki") ;
define ("INS_MAUVAIS_NOM_WIKI", "Le nom wiki n'est pas valide (ex : NomPrenom)") ;
define ("INS_DEJA_INSCRIT", "D&eacute;j&agrave;  inscrit, identifiez-vous pour acc&eacute;der &agrave;  votre fiche personnelle :") ;
define ('INS_PAS_INSCRIT', 'Pas encore inscrit, enregistrez-vous!');
define ("INS_ERREUR_LOGIN", "Utilisateur inconnu ou mot de passe erronn&eacute;") ;
define ("INS_SI_PASSE_PERDU", "Si vous avez perdu votre mot de passe, indiquez votre adresse email dans le champs ci-dessus.<br>\n".
                                "Un nouveau mot de passe vous sera envoyé.") ; ;
define ("INS_ENVOIE_PASSE", "Envoi du mot de passe par mail") ;
define ("INS_LAIUS_INSCRIPTION", "L'inscription au r&eacute;seau Ecole et Nature est libre et gratuite !") ;
define ("INS_LAIUS_INSCRIPTION_2", "<h3>L'inscription est libre et gratuite, elle vous permet de :</h3><ul>
<li> consulter l'annuaire des personnes inscrites au R&eacute;seau et pouvoir ainsi &eacute;changer des informations</li>
<li> acc&eacute;der &agrave;  certaines informations diffus&eacute;es sur le site</li>
<li> vous inscrire &agrave;  des projets d'éducation à l'environnement</li>
<li> rédiger des annonces d'actualité, d'évenements, de séjours et rencontres, de covoiturage ou de parutions</li>
<li> recevoir un bulletin &eacute;lectronique d'informations.</li></ul>") ;

//============= L'envoie du mot de passe perdu par mail =============================
define ("INS_NOUVEAU_MOT_DE_PASSE", "Votre nouveau mot de passe sur Educ-Envir.org et Ecole-et-Nature.org") ;
define ("INS_NOUVEAU_MOT_DE_PASSE_2", "Votre nouveau mot de passe : ") ;
define ("INS_NOUVEAU_MOT_DE_PASSE_LAIUS", "\n\nCe mot de passe vous permet de modifier les informations\n".
                                        "vous concernant dans les sites du réseau Ecole et Nature: Educ-Envir.org et Ecole-et-Nature.org.\n".
                                        "http://www.educ-envir.org/\n\n".
					"http://www.ecole-et-nature.org/\n\n") ;
define ("INS_MOT_DE_PASSE_ENVOYE_1", "Votre nouveau mot de passe a &eacute;t&eacute; ".
                                        "envoy&eacute; &agrave; l'adresse") ;
define ("INS_MOT_DE_PASSE_ENVOYE_2", "Relevez votre messagerie, notez votre nouveau mot de passe et identifiez vous à ".
                                    "nouveau en allant à l'inscription. N'h&eacute;sitez pas à changer ce mot de passe ".
                                    "pour en mettre un plus simple, plus facile &agrave; retenir." );
                                    
//============= L'envoie d'un mail de confirmation ===================================
// Ne pas utiliser d'entités HTML
define ('INS_ENTETE_INSCRIPTION','Inscription sur les sites Educ-Envir.org et Ecole-et-Nature.org');
define ("INS_MAIL_INSCRIPTION_1", "Votre inscription a bien été prise en compte.\n".
                                "Voici les informations que nous avons enregistré :\n") ;
define ("INS_MAIL_INSCRIPTION_2", "\nVous pouvez modifier votre inscription sur \nhttp://www.ecole-et-nature.org ou \nhttp://www.educ-envir.org\n".
                                    "rubrique S'inscrire (le signe + sur le bandeau du haut).\n\n".
                                    "L'équipe du réseau Ecole et Nature.") ;
define ('INS_MESSAGE_EXPIRATION','Désolé, le temps imparti à votre inscription c\'est écoulé...<br />'.
				 'Merci de bien vouloir vous réinscrire, en répondant rapidement au mail de confirmation.<br /><br />'.
				 'En vous remerciant de votre compréhension, a tout de suite!');
define ('INS_MESSAGE_VALIDER_INSCRIPTION','Validation de votre inscription sur le réseau Ecole et Nature:'."\n".
					  'Merci de vous être inscrit(e), soyez bienvenu(e)!'."\n".
					  'Veuillez cliquer sur le lien ci-dessous pour finaliser votre inscription:'."\n");

// Envoir d'un mail à la coordination
define ("INS_MAIL_COORD_SUJET", "Un nouvel inscrit au réseau ") ;
define ("INS_MAIL_COORD_CORPS", "Une nouvelle inscription a été effectuée sur le site.") ;
define ("INS_CHAMPS_REQUIS", "Champs requis") ;

define ("INS_MESSAGE_INSCRIPTION", "Votre inscription a été prise en compte, relevez votre messagerie et cliquer sur le lien proposé pour terminer votre inscription.") ;

// CARTO
define ("INS_DATE_INS", "Date d'inscription") ;
define ("INS_CHECK_UNCHECK", "Cocher les cases pour s&eacute;lectionner votre destinataire ou cocher / d&eacute;cocher tout") ;
define ("INS_ENVOYER_MAIL", "Envoyer un email") ;
define ("INS_SUJET", "Sujet") ;
define ("INS_MESSAGE", "Message") ;
define ("INS_ENVOYER", "Envoyer") ;
define ("INS_LABEL_PROJET", "en tant que membre du réseau Ecole et Nature");
define ("INS_COULEUR", "La couleur est proportionnelle au nombre d'inscrits.") ;
define ("INS_AVERTISSEMENT_TITRE", "Avertissement et d&eacute;ni de responsabilit&eacute;") ;
define ("INS_AVERTISSEMENT", "La représentation et l'utilisation des fronti&egrave;res, des noms g&eacute;ographiques et autres ".
                            " donn&eacute;es employ&eacute;s sur les cartes et utilis&eacute;s dans les listes,".
                            " les tableaux, les documents et les bases de donn&eacute;es de ce site ne sont pas garanties sans ".
                            "erreurs, de m&ecirc;me qu'elles n'engagent pas la responsabilit&eacute; des auteurs de ce site ni ".
                            "n'impliquent de reconnaissance officielle de leur part.") ;
define ("INS_MONDE", "Monde") ;
define ("INS_CLIQUER_ACCEDER", "Cliquer sur la carte pour zoomer ou acc&eacute;der aux informations&nbsp;&nbsp;") ;
define ('INS_VISUALISER_ZONE', 'Mettre en rouge la zone...');
define ("INS_MESSAGE_ENVOYE", "<br /><br />Votre message a &eacute;t&eacute; envoy&eacute;") ;
define ("INS_MESSAGE_ENVOYE_A", "Ce message a été envoyé à") ;  // pas d'entités HTML, c'est pour un mail
define ("INS_AUCUN_INSCRIT", "aucun inscrit") ;
define ("INS_INSCRIT", "inscrit") ;
define ('INS_TEXTE_FIN_MAIL', "\n".'---------------------------------------------------------------------------'."\n".
                                'Ce message vous est envoyé par l\'intermédiaire des sites Internet'."\n".
                                'du réseau Ecole et Nature: Educ-Envir.org et Ecole-et-nature.org'."\n".
                                'auquel vous êtes inscrit. D\'autres inscrits peuvent avoir reçu ce message.'."\n".
                                'Ne répondez que si vous êtes concerné, ou si vous avez des informations'."\n".
                                'utiles à transmettre au demandeur.'."\n".
                                "----------------------------------------------------------------------------") ;
define ('INS_NO_DESTINATAIRE', '<br /><br />Veuillez cocher au moins un destinataire pour votre mail<br />');
define ('INS_VOUS_DEVEZ_ETRE_INSCRIT', 'Vous devez être inscrit pour pouvoir envoyer des messages électronique aux personnes ou structure de l\'annuaire.<br />Identifiez-vous ou inscrivez-vous sur la page <a href="http://test.educ-envir.org/papyrus.php?site=1&menu=29">Inscription</a> du site.');
define ('INS_SURVEILLANCE_ENVOI_MAIL', 'Surveillance envois de mails: ');
define ('INS_ENREGISTRER_ET_QUITTER', 'Enregistrer et quitter');
define ('INS_TABLE', 'Nom de la table dans la base SQL contenant des informations à cartographier');
define ('INS_TABLE_SUPPLEMENTAIRE', 'Nom de la table additionnelle contenant des informations à cartographier');
define ('INS_NOM_CHAMPS_PAYS', 'Nom du champs représentant le pays');
define ('INS_NOM_CHAMPS_CP', 'Nom du champs représentant le code postal');
define ('INS_REQUETE_SQL_SUPPLEMENTAIRE', 'Complément de requète SQL (conditions supplémentaires pour le WHERE)');
define ('INS_PAS_NECESSAIRE', 'Pas nécéssaire');



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ins_annuaire.langue.fr.inc.php,v $
* Revision 1.3  2007/04/06 08:35:46  neiluj
* update suite correction bugs modifications inscription / avatar
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.2  2005/03/10 09:40:39  tam
* modifs labels
*
* Revision 1.1  2005/03/04 10:39:54  tam
* installation
*
* Revision 1.1  2004/07/06 15:42:17  alex
* en cours
*
* Revision 1.4  2004/07/06 15:31:43  alex
* en cours
*
* Revision 1.3  2004/06/25 14:25:40  alex
* ajout de labels
*
* Revision 1.2  2004/06/24 07:43:55  alex
* traduction
*
* Revision 1.1  2004/06/18 09:21:15  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>