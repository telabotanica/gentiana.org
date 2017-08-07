<?php

//vim: set expandtab tabstop=4 shiftwidth=4: 
// +-----------------------------------------------------------------------------------------------+
// | PHP version 4.0                                                                               |
// +-----------------------------------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group                                      |
// +-----------------------------------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,                                | 
// | that is bundled with this package in the file LICENSE, and is                                 |
// | available at through the world-wide-web at                                                    |
// | http://www.php.net/license/2_02.txt.                                                          |
// | If you did not receive a copy of the PHP license and are unable to                            |
// | obtain it through the world-wide-web, please send a note to                                   |
// | license@php.net so we can mail you a copy immediately.                                        |
// +-----------------------------------------------------------------------------------------------+
/**
*
*Fichier des fonctions du bottin
*
*@package bottin
//Auteur original :
*@author                Alexandre GRANIER <alexandre@tela-botanica.org.org>
//Autres auteurs :
*@copyright         Outils-reseaux 2006-2040
*@version           05 avril 2006
// +-----------------------------------------------------------------------------------------------+
//
// $Id: bottin.class.php,v 1.5 2007-06-25 15:02:50 alexandre_tb Exp $
// FICHIER : $RCSfile: bottin.class.php,v $
// AUTEUR    : $Author: alexandre_tb $
// VERSION : $Revision: 1.5 $
// DATE        : $Date: 2007-06-25 15:02:50 $
*/


// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

require_once PAP_CHEMIN_API_PEAR.'PEAR.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CONSTANTE DES TEMPLATES                                   |
// +------------------------------------------------------------------------------------------------------+

// Page d'accueil
define ('INS_TEMPLATE_PAGE_ACCUEIL', 1);

//Template du formulaire
define ('INS_TEMPLATE_FORMULAIRE', 3);

// Template mail confirmation inscription
define ('INS_TEMPLATE_MAIL_CONFIRMATION_SUJET', 4);
define ('INS_TEMPLATE_MAIL_CONFIRMATION_CORPS', 2);

// Template d envoie de mot de passe perdu
define ('INS_TEMPLATE_MAIL_PASSE_SUJET', 5);
define ('INS_TEMPLATE_MAIL_PASSE_CORPS', 6);

// Template du mail apres moderation accepte
define ('INS_TEMPLATE_MAIL_APRES_MODERATION_SUJET', 7);
define ('INS_TEMPLATE_MAIL_APRES_MODERATION_CORPS', 8);

// Modele du titre du formulaire (ce qui precede le formulaire)
define ('INS_TEMPLATE_TITRE_FORMULAIRE', 9);

// Message apres demande d inscription moderee
define ('INS_TEMPLATE_MESSAGE_INSCRIPTION_MODEREE', 10);

// Modele de la page de la cartogrphie google
define ('INS_TEMPLATE_CARTO_GOOGLE_ACCUEIL', 11);


class inscription extends PEAR {
	
	/**
     * Constructeur
     *
     *	
     * @return void
     * @access public
     */
	function inscription() {
			
	}
	
	/**
	 * Renvoie le code HTML d une liste avec les lettres
	 * 
	 * @global  Un pointeur vers une connexion de base de donnee $GLOBALS['ins_url']
	 * @return array ['ic_param'] les parametres tels que dans la table inscription_config
	 * @access public
	 */
	function getConfig($id_inscription = '') {
		// Recuperation de la configuration
	    $requete = 'select * from inscription_configuration';
	    if ($id_inscription != '') $requete .= ' where ic_id_inscription="'.$id_inscription.'"';
	    $resultat = $GLOBALS['ins_db']->query($requete);
	    if (DB::isError($resultat)) return "Echec de la requete : $requete<br />".$resultat->getMessage() ;
		    if ($resultat->numRows() != 0) {
		    $ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
		    return $ligne;
	    } else {
	    	return PEAR::raiseError('La table inscription_configuration est vide...');
	    }
	}
	
	/**
	 * Renvoi un tableau avec les informations de inscription_attente
	 * 
	 * @global  Un pointeur vers une connexion de base de donnee $GLOBALS['ins_db']
	 * @return array Un tableau ['id'], ['nom'], ['prenom'] ... ou la chaine vide si il n'y a personne en attente
	 * @access public
	 */
	function getInscritEnAttenteModeration() {
		$requete = 'select * from inscription_attente';
		$resultat = $GLOBALS['ins_db']->query($requete);
		
		$tableau_inscrit = array();
		if (DB::isError($resultat)) return "Echec de la requete : $requete<br />".$resultat->getMessage() ;
		    if ($resultat->numRows() != 0) {
			    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
				    $donnees = unserialize (stripslashes($ligne->ia_donnees)) ;
				    array_push ($tableau_inscrit, array_merge (array('id' => $ligne->ia_id_inscription, 'date' => $ligne->ia_date), $donnees));
			    }
			    return $tableau_inscrit;
		    } else {
	    		return '';
	    	}
	}
	
	/** Renvoi le tableau HTML des inscrits en attente
	 * 
	 * @global	$GLOBALS['ins_url'] un objet Net_URL avec l url courante
	 * @param array Un tableau de tableau d inscrit avec ['id'],['nom'],['prenom'],['email'],['ville'],['date']
	 * @return string Un tableau HTML
	 */
	 
	 function getTableauEnAttente($tableau) {
	 	$html = '';
	 	
	 	if (empty ($tableau)) {
	 		return INS_PAS_D_INSCRIT_EN_ATTENTE;
	 	}
	 	$table = new HTML_Table();
	 	$table->addRow(array (INS_NOM, INS_EMAIL, INS_VILLE, INS_DATE_INS, INS_ACTION), '', 'TH');
	 	
	 	$action = '<a href="'.$GLOBALS['ins_url']->getURL().'">'.'</a>';
	 	foreach ($tableau as $demandeur) {
	 		// L identifiant du demandeur dans l url
	 		$GLOBALS['ins_url']->addQueryString (INS_VARIABLE_ID_DEMANDEUR, $demandeur['id']) ;
	 		$GLOBALS['ins_url']->addQueryString(ANN_VARIABLE_ACTION, ANN_ACTION_VALIDER_INSCRIPTION);
	 		$valide = '<a href="'.$GLOBALS['ins_url']->getURL().'">'.INS_VALIDER.'</a> / ';
	 		$GLOBALS['ins_url']->addQueryString(ANN_VARIABLE_ACTION, ANN_ACTION_SUPPRIMER_DEMANDE_INSCRIPTION);
	 		$valide .= '<a href="'.$GLOBALS['ins_url']->getURL().
					'" onclick="javascript:return confirm(\''.INS_SUPPRIMER.' ?\')">'.INS_SUPPRIMER.'</a>';
	 		$table->addRow(array($demandeur['a_nom'].' '.(isset($demandeur['a_prenom']) ? $demandeur['a_prenom']: ''), $demandeur['a_mail'], 
	 							$demandeur['a_ville'], $demandeur['date'], $valide));
	 	}
	 	return $table->toHTML();
	 }
	
	/**
	 * Renvoie un tableau avec les moderateurs de l inscription
	 * ceux du champs ic_mail_moderateur
	 * 
	 * @return array Un tableau de mail de moderateur
	 */
	function getModerateurs() {
		
	}
	/**
	 * Insere une demande d inscription dans la table inscription_attente et 
	 * envoi un mail aux moderateurs
	 * 
	 * @param	string	Un identifiant de session, soit genere aleatoirement soit venu de la tablea inscription_demande
	 * @global array la globale $GLOBALS['ins_config']
	 * @global mixed un pointeur vers une base de donnees $GLOBALS['ins_db']
	 * @return string Un message a renvoye a l utilisateur indiquant que sa demande a ete prise en compte
	 */
	function demandeInscriptionModere($valeurs) {
	// On stocke les informations dans un variable de session
	    // On coupe l'identifiant de session pour ne prendre que les 8 premiers caract�res
	    // afin d'eviter d'obtenir une url trop longue
	    $chaine = substr (session_id(), 0, 8) ;
	    $requete_verif = 'select * from inscription_attente where ia_id_inscription="'.$chaine.'"' ;
	    $resultat_verif = $GLOBALS['ins_db']->query ($requete_verif) ;
	    if ($resultat_verif->numRows() != 0) {
	        $requete_suppression = 'delete from inscription_attente where ia_id_inscription="'.$chaine.'"' ;
	        $GLOBALS['ins_db']->query ($requete_suppression) ;
	    }
	    $requete = 'insert into inscription_attente set ia_id_inscription="'.$chaine.'", ia_donnees="'.
	                addslashes(serialize($valeurs)).'", ia_date=NOW()' ;
	    $resultat = $GLOBALS['ins_db']->query ($requete) ;
	    if (DB::isError ($resultat)) {
	        echo ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	    }
	    // On envoie un email aux moderateurs
	    
	    require_once PAP_CHEMIN_RACINE.'api/pear/HTML/Template/IT.php';
	    $tpl = new HTML_Template_IT() ;
	    // Le gabarit du mail est dans un template
	    // template 3
	    $url = $GLOBALS['ins_url']->getURL();
	    $requete = 'select it_template from inscription_template where it_id_template=3'.
	    			' and it_i18n like "%'.INS_LANGUE_DEFAUT.'"' ;
	    
	    if (!$tpl -> setTemplate($GLOBALS['ins_db']->getOne ($requete))) {
	    	echo 'erreur' ;	
	    }
		$tpl->setVariable('URL_INSCRIPTION', $url) ;
		$mails_moderateur = split ('/\n/', $GLOBALS['ins_config']['ic_mail_moderateur']);
		foreach ($mails_moderateur as $mail) {
			mail ($mail, INS_MODERATION_SUJET, 
				html_entity_decode(INS_NOUVELLE_INSCRIPTION_A_MODERE), 
					'From: '.$GLOBALS['ins_config']['ic_from_mail_confirmation']) ;
		}
	    return true ;
	}
	/**
	 * 	Valide une demande d inscription
	 * 	Transfere les donnees de la table inscription_attente vers annuaire
	 * 
	 * 	Envoie un email d avertissement a l inscrit
	 * 
	 * @global array la globale ins_config
	 */
	function validerInscription() {
		$requete = 'SELECT ia_donnees FROM inscription_attente WHERE ia_id_inscription="'.$_GET[INS_VARIABLE_ID_DEMANDEUR].'"' ;
	    $resultat = $GLOBALS['ins_db']->query($requete) ;
	    if (DB::isError ($resultat)) {
		    return ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	    }
	    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
	    $donnees = unserialize (stripslashes($ligne->ia_donnees)) ;
	    
	    // dans les donnees serialisees, on recupere l identifiant de l inscription
	    // pour charger la globale ins_config
	    $GLOBALS['ins_config'] = inscription::getConfig($donnees['id_inscription']);
	    // Template du formulaire
   		$GLOBALS['ins_config']['ic_inscription_template'] = inscription::getTemplate(INS_TEMPLATE_FORMULAIRE, 
    									$GLOBALS['ins_config']['ic_id_inscription']);

	    
	    $id_utilisateur = inscription_insertion($donnees) ;
	    
	    // Envoie du mail
	    $destinataire = $donnees['a_mail'];
	    $sujet = inscription::getTemplate(INS_TEMPLATE_MAIL_APRES_MODERATION_SUJET, $GLOBALS['ins_config']['ic_id_inscription']);
	    $corps = inscription::getTemplate(INS_TEMPLATE_MAIL_APRES_MODERATION_CORPS, $GLOBALS['ins_config']['ic_id_inscription']);
	    // Appel des actions desinscriptions des applications clientes
        $d = dir(GEN_CHEMIN_CLIENT);
		while (false !== ($repertoire = $d->read())) {
			if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php'))
			include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php' ;
		}
		$d->close();
		if (INS_CHAMPS_LETTRE != '' && isset ($donnees['a_lettre'])) {
			inscription_lettre($GLOBALS['ins_config']['ic_mail_inscription_news']) ;
		}
	    if (!mail ($destinataire, $sujet, $corps, 'From: '.$GLOBALS['ins_config']['ic_from_mail_confirmation'])) return 'erreur dans l\'envoi du mail';
	    
	    inscription::supprimerDemandeInscription();
	}
	/**
	 * 	Supprime une demande d inscription dans la table inscription_attente
	 * 
	 * @global	string	l indentifiant de la demande
	 * @global mixed la globale ins_db
	 */
	function supprimerDemandeInscription() {
		// Suppression de la ligne dans inscription_attente
	    $req_sup = 'delete from inscription_attente where ia_id_inscription="'.$_GET[INS_VARIABLE_ID_DEMANDEUR].'"';
	    $res_sup = $GLOBALS['ins_db']->query ($req_sup);
	    if (DB::isError ($res_sup)) {
		    return ("Echec de la requete : $req_sup<br />".$res_sup->getMessage()) ;
	    }
	}
	
	/**
	 * 	Supprimer un inscrit de l annuaire et appelle les fichiers
	 * 	client appli.desinscription.inc.php
	 * 
	 * @static
	 * @global int l identifiant de l inscrit
	 * @global mixed la globale ins_db
	 */

	function supprimerInscription() {

	    $queryLogin = 'select '.INS_CHAMPS_MAIL.' from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.'='.$_GET[INS_VARIABLE_ID_INSCRIT] ;
	    $resultLogin = $GLOBALS['ins_db']->query($queryLogin) ;
	    $rowLogin = $resultLogin->fetchRow(DB_FETCHMODE_ASSOC) ;
	    $mail = $rowLogin[INS_CHAMPS_MAIL];
	
	    // suppression
	    $query = 'delete from '.INS_ANNUAIRE.' where '.INS_CHAMPS_ID.'='.$_GET[INS_VARIABLE_ID_INSCRIT] ;
	    $resultat = $GLOBALS['ins_db']->query($query);
	    if (DB::isError ($resultat)) {
		    return ("Echec de la requete : $req_sup<br />".$res_sup->getMessage()) ;
	    }
	     // Appel des actions desinscriptions des applications clientes
	    $d = dir(GEN_CHEMIN_CLIENT);
		$id_utilisateur = $_GET[INS_VARIABLE_ID_INSCRIT];
		while (false !== ($repertoire = $d->read())) {
			if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.desinscription.inc.php'))
			include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.desinscription.inc.php' ;   
		}
		$d->close();
	}
	
	function getTemplate($id_template, $id_inscription, $langue = INS_LANGUE_DEFAUT) {

	    $requete = 'select it_template from inscription_template where it_id_template="'.$id_template.'"'.
	    			' and it_i18n like "'.$langue.'%" and it_ce_inscription="'.$id_inscription.'"' ;
	    $resultat = $GLOBALS['ins_db']->query($requete);
	    if (DB::isError ($resultat)) {
		    $this->raiseError();
		}
		$ligne = $resultat->fetchRow (DB_FETCHMODE_OBJECT);
		return $ligne->it_template;
	}
}


class lettresAlphabet extends PEAR {
	
	var $url;
	
	var $variable_lettre ;
	
	/**
     * Constructeur
     *
     * @param Net_URL un objet Net_URL
     * @param string $variable_lettre le nom de la variable $_GET qui sera place dans l URL
     * @return void
     * @access public
     */
	function lettresAlphabet($url, $variable_lettre = 'lettre') {
		$this->url = $url ;
		$this->variable_lettre = $variable_lettre ;	
	}
	
	/**
	 * Renvoie le code HTML d une liste avec les lettres
	 * 
	 * @return string HTML
	 * @access public
	 */
	function toHMTL() {
		
		$res = '<ul class="liste_lettre">'."\n" ;
		for ($i = 65 ; $i <91 ; $i++) {
			$this->url->addQueryString($this->variable_lettre, chr($i)) ;
			$res .= "\t".'<li class="liste_lettre"><a class="lien_alphabet" '.
					'href="'.
					$this->url->getURL().'">';
			$res .= chr($i) ;
			$res .= '</a></li>'."\n";
		}
		$res .= '</ul>';
		return $res ;
	}	
}

//-- Fin du code source    ------------------------------------------------------------
/*
* $Log: bottin.class.php,v $
* Revision 1.5  2007-06-25 15:02:50  alexandre_tb
* correction bug
*
* Revision 1.4  2007-06-25 09:59:03  alexandre_tb
* ajout de carte_google, mise en place des templates avec api/formulaire, configuration de multiples inscriptions, ajout de modele pour les mails
*
* Revision 1.3  2007-06-01 13:47:47  alexandre_tb
* nouvelles methodes
*
* Revision 1.2  2007-05-25 14:31:24  alexandre_tb
* en cours
*
* Revision 1.1  2006/12/13 13:26:52  alexandre_tb
* version initiale
*
*/
?>