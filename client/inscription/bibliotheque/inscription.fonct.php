<?php
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1																					  |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)							   	          |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or										  |
// | modify it under the terms of the GNU Lesser General Public										      |
// | License as published by the Free Software Foundation; either										  |
// | version 2.1 of the License, or (at your option) any later version.								      |
// |																									  |
// | This library is distributed in the hope that it will be useful,									  |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of									      |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU									  |
// | Lesser General Public License for more details.													  |
// |																									  |
// | You should have received a copy of the GNU Lesser General Public									  |
// | License along with this library; if not, write to the Free Software								  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA							  |
// +------------------------------------------------------------------------------------------------------+
/**
* Fonctions du module inscription
*
* Fonctions du module inscription
*
*@package inscription
//Auteur original :
*@author		Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author	   Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@copyright	 Tela-Botanica 2000-2004
*@version	 $Id: inscription.fonct.php,v 1.2 2005/03/21 16:50:27 alex Exp $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |											ENTETE du PROGRAMME									   |
// +------------------------------------------------------------------------------------------------------+



// +------------------------------------------------------------------------------------------------------+
// |										   LISTE de FONCTIONS										 |
// +------------------------------------------------------------------------------------------------------+

/**
 *
 * @param   array   les valeurs renvoyés par le formulaire
 * @return
 */
function demande_inscription ($valeurs) {
	// On stocke les informations dans un variable de session
	// On coupe l'identifiant de session pour ne prendre que les 8 premiers caractères
	// afin d'éviter d'obtenir une url trop longue
	$chaine = substr (session_id(), 0, 8) ;
	$requete_verif = 'SELECT * FROM inscription_demande WHERE id_identifiant_session="'.$chaine.'"' ;
	$resultat_verif = $GLOBALS['ins_db']->query($requete_verif) ;
	if ($resultat_verif->numRows() != 0) {
		$requete_suppression = 'DELETE FROM inscription_demande WHERE id_identifiant_session="'.$chaine.'"' ;
		$GLOBALS['ins_db']->query($requete_suppression) ;
	}
	$requete = 'INSERT INTO inscription_demande SET id_identifiant_session="'.$chaine.'", id_donnees="'.
				addslashes(serialize($valeurs)).'", id_date=NOW()' ;
	$resultat = $GLOBALS['ins_db']->query($requete) ;
	if (DB::isError ($resultat)) {
		echo ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	}
	// On envoie un email de confirmation pour l'utilisateur
	$GLOBALS['ins_url']->addQueryString('id', $chaine) ;
	
	$corps = INS_MESSAGE_DEBUT_MAIL_INSCRIPTION ;
	if (INS_UTILISE_REECRITURE_URL) {
		$corps .= 'http://'.$GLOBALS['ins_url']->host.'/'.INS_URL_PREFIXE.$chaine ;
	} else {
		$corps .= str_replace ('&amp;', '&', $GLOBALS['ins_url']->getURL()) ;
	}
	$corps .= INS_MESSAGE_FIN_MAIL_INSCRIPTION ;
	mail ($GLOBALS['email'], 'Inscription', $corps, 'From: '.INS_MAIL_ADMIN_APRES_INSCRIPTION) ;
}

function AUTH_formulaire_login ($msg = '') {
	$res = '';
	//--------------------------------------------------------------------------
	// Les urls
	$url_deja_inscrit = preg_replace ('/&amp;/', '&', $GLOBALS['ins_url']->getURL()) ;
	$GLOBALS['ins_url']->addQueryString('action', 'inscription');
	$url_inscription = preg_replace ('/&amp;/', '&', $GLOBALS['ins_url']->getURL()) ;

	//--------------------------------------------------------------------------
	// Le formulaire	
	$form = new HTML_QuickForm ('inscription', 'post', $url_inscription);
	$form->addElement ('submit', 'Inscription', INS_INSCRIPTION) ;
	$res = '<h1 class="titre1_inscription">'.INS_ACCUEIL_INSCRIPTION.'</h1>';
	$res .= $msg ;
	$res .= '<h2 class="titre2_inscription">'.INS_LAIUS_INSCRIPTION.'</h2>'."\n" ;
	$res .= '<p>'.INS_LAIUS_INSCRIPTION_2.'</p>'."\n" ;
	$res .= $form->toHTML() ;
	$res .= '<h2 class="titre2_inscription">'.INS_DEJA_INSCRIT.'</h2>' ;
	$form = new HTML_QuickForm ('inscription', 'post', $url_deja_inscrit) ;
	$form->addElement ('text', 'username', INS_EMAIL) ;
	$form->addElement ('password', 'password', INS_MOT_DE_PASSE) ;
	$form->addElement('submit', 'valider', INS_VALIDER);
	$res .= $form->toHTML() ;
	$res .= '<p>'.INS_TEXTE_PERDU.'</p>'."\n" ;
	return $res;
}

/** message_erreur () - Renvoie le code HTML d'un message d'erreur
*
* Cette page est appelée avec le paramêtre action=mdp_oubli passé dans l'url.
* Elle peut aussi être appelé en cas d'erreur de loggin.
* @return   string  HTML
*/
function message_erreur ($erreur = true) {
	$res = '';

	// Les urls
	$url_deja_inscrit = preg_replace ('/&amp;/', '&', $GLOBALS['ins_url']->getURL()) ;
	$GLOBALS['ins_url']->addQueryString('action', 'sendpasswd');
	$url_envoi_mdp = preg_replace ('/&amp;/', '&', $GLOBALS['ins_url']->getURL()) ;
	$GLOBALS['ins_url']->removeQueryString('action');

	// La page 	
	$res .= '<h1 class="titre1_inscription">'.INS_MDP_PERDU_TITRE.'</h1>' ;
	if ($erreur) {
		$res .= '<p class="attention">'.INS_ERREUR_LOGIN.'</p>'."\n" ;
	}
	$res .= '<div class="information">'."\n";
	$res .= '<p>'.INS_SI_PASSE_PERDU.'</p>'."\n";
	$res .= '<p>'.INS_INDIQUE_ADRESSE.'</p>'."\n";
	$res .= '<p>'."\n";
	$res .= '<form action="'.$url_envoi_mdp.'" method="post">'."\n";
	$res .= '<label for="nom_d_utilisateur">'.INS_EMAIL.' : </label>';
	$valeur = (isset($_POST['username'])) ? $_POST['username'] : '';
	$res .= '<input type="text" id="nom_d_utilisateur" name="nom_d_utilisateur" value="'.$valeur.'" size="32" /></li></ul>'."\n";
	$res .= '<input type="submit" value="'.INS_ENVOIE_PASSE.'" />'."\n";
	$res .= '</form>'."\n";
	$res .= '</p>';
	$res .= '</div>';
	$res .= '<hr/>';
	
	// On remet le formulaire d'inscription mais un peu réduit
	$res .= '<h2 class="titre2_inscription">'.INS_MDP_PERDU_TITRE_RETENTER.'</h2>' ;
	$form = new HTML_QuickForm ('inscription', 'post', $url_deja_inscrit) ;
	$form->addElement('text', 'username', INS_EMAIL) ;
	$form->addElement('password', 'password', INS_MOT_DE_PASSE) ;
	$form->addElement('submit', 'valider', INS_VALIDER);

	// Retour du html
	$res .= $form->toHTML() ;
	return $res;
}

function insertion($valeur) {	
	// ===========  Insertion dans l'annuaire ===================

	$autres_valeurs = info_annuaire($valeur);
	$autres_valeurs[INS_CHAMPS_DATE] = date('Y-m-d');
	$autres_valeurs[INS_CHAMPS_MAIL] = $valeur['email'];
	switch (INS_MDP_CRYPTYPE) {
		case 'md5' :
			$autres_valeurs[INS_CHAMPS_PASSE] = md5($valeur['mot_de_passe']);
			break;
		default :
		trigger_error('Type d\'encodage du mot de passe inconnu!', E_USER_ERROR);
	}
	
	// Utilisation de AUTH pour ajouter la personne
	//$resultat = $GLOBALS['AUTH']->addUser($valeur['email'], $valeur['mot_de_passe'], $autres_valeurs) ;
	$champs = '';
	$vals = '';
	foreach($autres_valeurs as $champ => $val) {
		if ($val != '') {
			$champs .= $champ.', ';
			$vals .= '"'.str_replace('"', '\"', $val).'", ';
		}
	}
	$champs = trim($champs, ', ');
	$vals = trim($vals, ', ');
	$requete = 	'INSERT INTO '.INS_ANNUAIRE.' '.
				' ('.$champs.') '.
				'VALUES ('.$vals.') ';
	$resultat = $GLOBALS['ins_db']->query($requete) ;
	if (DB::isError($resultat)) {
		die ($resultat->getMessage().$resultat->getDebugInfo()) ;
	}

	// Récupération de l'identifiant de l'inscription
	$requete = 	'SELECT '.INS_CHAMPS_ID.' '.
				'FROM '.INS_ANNUAIRE.' '.
				'WHERE '.INS_CHAMPS_MAIL.' = "'.$valeur['email'].'"' ;
	$resultat = $GLOBALS['ins_db']->query ($requete) ;
	if (DB::isError ($resultat)) {
		die ('Echec de la requete : '.$requete.'<br />'.$resultat->getMessage()) ;
	}
	$ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
	$id = $ligne[INS_CHAMPS_ID] ;

	// Insertion dans les statistiques
	if (INS_UTILISE_STAT) {
		$requete = 'INSERT INTO '.INS_TABLE_STATISTIQUE.' SET '.INS_STATS_CHAMPS_DATE.' = NOW(), '.INS_STATS_CHAMPS_ACTION.' = "add" ';
		$resultat = $GLOBALS['ins_db']->query($requete) ;
		if (DB::isError ($resultat)) {
			die ('Echec de la requete : '.$requete.'<br />'.$resultat->getMessage()) ;
		}
	}
}

/**
 *  Effectue une mise à jour dans la base de donnée
 *
 * @global  AUTH	un objet PEAR:Auth
 * @global  ins_db  un objet PEAR::DB
 * @return
 */
function mise_a_jour($valeur) {
	// ====================Mise à jour dans l'annuaire ====================
	$requete = 	'UPDATE '.INS_ANNUAIRE.' '.
				'SET '.requete_annuaire($valeur).' '.
				'WHERE '.INS_CHAMPS_ID.' = "'.$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID).'"';
	$resultat = $GLOBALS['ins_db']->query($requete) ;
	if (DB::isError($resultat)) {
		die ($resultat->getMessage().$resultat->getDebugInfo()) ;
	}
	
	if (isset($valeur['lettre'])) {
		// On appelle cette fonction pour mettre à jour
		$GLOBALS['AUTH']->setAuthData(INS_CHAMPS_LETTRE, $valeur['lettre'], true);	
	}
	// la valeur de session (récupéré par getAuthData()
	unset($resultat);	
}

/** requete_annuaire () - Renvoie une chaine contenant les champs de l'annuaire avec leur valeur suite à le fonction process de QuickForm
*
* @return   string  une requete du type champs="valeur",...
*/
function requete_annuaire(&$valeur) {
	if (!isset($valeur['lettre'])) {
		$valeur['lettre'] = 0;
	}
	if (preg_match ('/([0-9][0-9])[0-9][0-9][0-9]/', $valeur['cp'], $match)) {
		$valeur['dpt'] = $match[1];
		if (preg_match ('/(97[0-9])[0-9][0-9]/', $valeur['cp'], $match2)) {
			$valeur['dpt'] = $match2[1];
		}
	}
	foreach($valeur as $champ => $val) {
		$valeur[$champ] = str_replace('"', '\"', $val);
	}
	$req =	INS_CHAMPS_NOM.' = "'.$valeur['nom'].'",'.
			INS_CHAMPS_PRENOM.' = "'.$valeur['prenom'].'",'.
			INS_CHAMPS_MAIL.' = "'.$valeur['email'].'",'.
			INS_CHAMPS_PASSE.' = "'.md5 ($valeur['mot_de_passe']).'",'.
			INS_CHAMPS_PAYS.' = "'.$valeur['pays'].'", '.
			INS_CHAMPS_CODE_POSTAL.' = "'.$valeur['cp'].'", '.
			INS_CHAMPS_VILLE.' = "'.$valeur['ville'].'", '.
			INS_CHAMPS_ADRESSE_1.' = "'.$valeur['adresse_1'].'", '.
			INS_CHAMPS_ADRESSE_2.' = "'.$valeur['adresse_2'].'", '.
			INS_CHAMPS_REGION.' = "'.$valeur['region'].'", '.
			INS_CHAMPS_STRUCTURE.' = "'.$valeur['organisme'].'", '.
			INS_CHAMPS_SITE_WEB.' = "'.$valeur['site'].'", '.
			INS_CHAMPS_LETTRE.' = "'.$valeur['lettre'].'" ';
	if (isset($valeur['dpt'])) {
		$req .= ','.INS_CHAMPS_DPT.' = "'.$valeur['dpt'].'"' ;
	}
	return $req ;
}

/**
 *  renvoie un tableau avec en clé les champs de la base et en valeur les valeurs saisies dans le formulaire
 *
 * @return  array   renvoie un tableau avec en clé les champs de la base et en valeur les valeurs saisies dans le formulaire
 */
function info_annuaire ($valeur) {
	
	// Petit code pour recupere le num de dpt a partir du cp
	if (preg_match ('/([0-9][0-9])[0-9][0-9][0-9]/', $valeur['cp'], $match)) {
		$valeur['dpt'] = $match[1];
		if (preg_match ('/(97[0-9])[0-9][0-9]/', $valeur['cp'], $match2)) {
			$valeur['dpt'] = $match2[1];
		}
	}
	$tableau = array (
				INS_CHAMPS_ID => nextId(INS_ANNUAIRE, INS_CHAMPS_ID, $GLOBALS['ins_db']),
				INS_CHAMPS_NOM => addslashes($valeur['nom']),
				INS_CHAMPS_PRENOM => addslashes($valeur['prenom']),
				INS_CHAMPS_PAYS => $valeur['pays'],
				INS_CHAMPS_CODE_POSTAL => $valeur['cp'],
				INS_CHAMPS_VILLE => addslashes($valeur['ville']),
				INS_CHAMPS_ADRESSE_1 => addslashes($valeur['adresse_1']),
				INS_CHAMPS_ADRESSE_2 => addslashes($valeur['adresse_2']),
				INS_CHAMPS_REGION => addslashes($valeur['region']),
				INS_CHAMPS_SITE_WEB => $valeur['site']);
	if (INS_UTILISE_LISTE){
		$tableau[INS_CHAMPS_LETTRE] = $valeur['lettre'];
	}
	return $tableau ;
}

/** formulaire_defaults () - Renvoie un tableau avec les valeurs par défaut du formulaire d'inscription
*
* @return   array   Valeurs par défaut du formulaire d'inscription
*/
function formulaire_defaults () {
	$requete =	'SELECT '.INS_ANNUAIRE.'.* '.
				'FROM '.INS_ANNUAIRE.' '.
				'WHERE '.INS_ANNUAIRE.'.'.INS_CHAMPS_ID.'= "'.$GLOBALS['AUTH']->getAuthData (INS_CHAMPS_ID).'"' ;
	$resultat = $GLOBALS['ins_db']->query ($requete) ;
	if (DB::isError($resultat)) {
		die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
	}
	$ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
	$valeurs_par_defaut = array() ;
	$valeurs_par_defaut['email'] = $ligne[INS_CHAMPS_MAIL];
	$valeurs_par_defaut['nom'] = $ligne[INS_CHAMPS_NOM];
	$valeurs_par_defaut['prenom'] = $ligne[INS_CHAMPS_PRENOM] ;
	$valeurs_par_defaut['pays'] = $ligne[INS_CHAMPS_PAYS] ;
	$valeurs_par_defaut['nomwiki'] = $ligne[INS_CHAMPS_LOGIN] ;
	$valeurs_par_defaut['cp'] = $ligne[INS_CHAMPS_CODE_POSTAL] ;
	$valeurs_par_defaut['ville'] = $ligne[INS_CHAMPS_VILLE] ;
	$valeurs_par_defaut['adresse_1'] = $ligne[INS_CHAMPS_ADRESSE_1] ;
	$valeurs_par_defaut['adresse_2'] = $ligne[INS_CHAMPS_ADRESSE_2] ;
	$valeurs_par_defaut['region'] = $ligne[INS_CHAMPS_REGION] ;
	$valeurs_par_defaut['site'] = $ligne[INS_CHAMPS_SITE_WEB] ;
	if (INS_UTILISE_LISTE){
		$valeurs_par_defaut['lettre'] = $ligne[INS_CHAMPS_LETTRE] ;
	}
	return $valeurs_par_defaut ;
}

function info() {
	$requete = 	'SELECT * '.
				'FROM '.INS_ANNUAIRE.', '.INS_TABLE_PAYS.' '.
				'WHERE '.INS_ANNUAIRE.'.'.INS_CHAMPS_ID.'="'.$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID).'" '.
				'AND '.INS_CHAMPS_PAYS.'='.INS_CHAMPS_ID_PAYS.' ';
				
	$resultat = $GLOBALS['ins_db']->query($requete); 
	if (DB::isError ($resultat)) {
		die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo());
	}

	$ligne = $resultat->fetchRow (DB_FETCHMODE_ASSOC) ;
	$res = '<h1 class="inscription_titre1">'.INS_MESSAGE_BIENVENU.'</h1>'."\n";
	$res .= '<h2 class="inscription_titre2">'.INS_FICHE_PERSONNELLE.'</h2>'."\n";
	$res .= '<dl>';
	$res .= ligne_inscription (INS_EMAIL, $ligne[INS_CHAMPS_MAIL]) ;
	$res .= ligne_inscription (INS_NOM, $ligne[INS_CHAMPS_NOM]) ;
	$res .= ligne_inscription (INS_PRENOM, $ligne[INS_CHAMPS_PRENOM]) ;
	$res .= ligne_inscription (INS_ADRESSE_1, $ligne[INS_CHAMPS_ADRESSE_1]) ;
	$res .= ligne_inscription (INS_ADRESSE_2, $ligne[INS_CHAMPS_ADRESSE_2]) ;
	$res .= ligne_inscription (INS_REGION, $ligne[INS_CHAMPS_REGION]) ;
	$res .= ligne_inscription (INS_CODE_POSTAL, $ligne[INS_CHAMPS_CODE_POSTAL]) ;
	$res .= ligne_inscription (INS_VILLE, $ligne[INS_CHAMPS_VILLE]) ;
	$res .= ligne_inscription (INS_PAYS, $ligne[INS_CHAMPS_LABEL_PAYS]) ;
	$res .= ligne_inscription (INS_SITE_INTERNET, $ligne[INS_CHAMPS_SITE_WEB]) ;
	$res .= '</dl>';
	return $res;
}

/**
 *
 *
 * @return
 */

function ligne_inscription ($label, $valeur) {
	if ($valeur == '') {
		$valeur = '&nbsp;' ;
	}
	return '<dt>'.$label.' : </dt><dd>'.$valeur.'</dd>' ;
}

function bouton($url) {
	$boutons = new HTML_QuickForm('inscription', 'post', $url) ; ;
	//confirmation() ;
	$buttons[] = &HTML_QuickForm::createElement('submit', 'modifier', INS_MODIFIER_INSCRIPTION);
	$buttons[] = &HTML_QuickForm::createElement('submit', 'supprimer', INS_SUPPRIMER_INSCRIPTION, 
											array ('onclick' => "javascript:return confirm('".INS_SUPPRIMER_INSCRIPTION." ?');"));
	$boutons->addGroup($buttons, null, null, '&nbsp;');
	$boutons->addElement('hidden', 'id_utilisateur', $GLOBALS['AUTH']->getAuthData (INS_CHAMPS_ID));
	return $boutons->toHTML();
}

/**
 *  Renvoie un lien pour se déconnex=cter
 *
 * @return  string  
 */
function deconnexion ($url) {
	// Un champs logout
	return '<div><a href="'.$url.'&amp;logout=1">'.INS_DECONNEXION.'</a></div>';
}

function verif_doublonMail($mail) {
	if (isset ($GLOBALS['AUTH']) && $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID) != '') {
		$requete_mail = "select ".INS_CHAMPS_MAIL." from ".INS_ANNUAIRE." where ".INS_CHAMPS_ID."=".$GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID) ;
		$resultat_mail = $GLOBALS['ins_db']->query($requete_mail) ;
		if (DB::isError ($resultat_mail)) {
			die ("Echec de la requete : $requete_mail<br />".$resultat_mail->getMessage()) ;
		}
		$ligne_mail = $resultat_mail->fetchRow(DB_FETCHMODE_ASSOC) ;
		if ($mail == $ligne_mail[INS_CHAMPS_MAIL]) {
			return true ;
		}
	}
	$requete = "select ".INS_CHAMPS_MAIL." from ".INS_ANNUAIRE." where ".INS_CHAMPS_MAIL."= \"$mail\"" ;
	$resultat = $GLOBALS['ins_db']->query ($requete) ;
	if (DB::isError ($resultat)) {
		die ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
	}
	if ($resultat->numRows() == 0) return true ;
	return false ;
}

function envoie_passe()
{
	$headers['From']	= INS_MAIL_ADMIN_APRES_INSCRIPTION ;
	$headers['Subject'] = INS_NOUVEAU_MOT_DE_PASSE;

	$nouveau_passe = create_new_random(6) ;

	$body = INS_NOUVEAU_MOT_DE_PASSE_2.$nouveau_passe ;
	$body .= INS_NOUVEAU_MOT_DE_PASSE_LAIUS ;

	// modification du mot de passe dans la base
	$requete = "update ".INS_ANNUAIRE." set ".INS_CHAMPS_PASSE."=MD5(\"$nouveau_passe\") where ".INS_CHAMPS_MAIL."=\"".$_POST['nom_d_utilisateur']."\"" ;

	$resultat = $GLOBALS['ins_db']->query($requete) ;
	if (DB::isError($resultat)) {
		die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
	}
	// On teste si l'email est présent dans la base
	if ($GLOBALS['ins_db']->affectedRows() == 0) {
		return '<div class="erreur">Il n\'y a pas d\'inscrit avec cet email</div>'."\n" ;
	}

	// création du mail
	if (!mail ($_POST['nom_d_utilisateur'], $headers['Subject'], $body)) {
		return 'erreur lors de l\'envoie de mail' ;
	}

	return "<div class=\"titre1_inscription\">".INS_MOT_DE_PASSE_ENVOYE_1." ".$_POST['nom_d_utilisateur']."</div>\n".
			"<div><br>".INS_MOT_DE_PASSE_ENVOYE_2."</div>\n";

}

/**
 *
 * @global  ins_db  Un pointeur vers un objet PEAR::DB connecté
 * @return
 */
function envoie_mail()
{
	include_once 'Mail/mime.php' ;
	$crlf="\n";
	
	$headers ['From'] = INS_MAIL_ADMIN_APRES_INSCRIPTION ;
	$headers ['Subject'] = INS_MAIL_COORD_SUJET ;
	$headers ['Reply-To'] = INS_MAIL_ADMIN_APRES_INSCRIPTION ;
	
	$mime = new Mail_mime($crlf);
	
	$requete = 	'SELECT *, '.INS_CHAMPS_LABEL_PAYS.' '.
				'FROM '.INS_ANNUAIRE.','.INS_TABLE_PAYS.' '.
				'WHERE '.INS_CHAMPS_MAIL.' = "'.$GLOBALS['AUTH']->getUsername().'"'.
				'AND '.INS_CHAMPS_ID_PAYS.'='.INS_CHAMPS_PAYS.' ';

	$resultat = $GLOBALS['ins_db']->query($requete);
	if (DB::isError ($resultat)) {
		die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	}
	$ligne  = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
	$body = INS_MAIL_COORD_CORPS."\n" ;
	
	$body .= "------------------------------------------\n";
	$body .= INS_EMAIL.": ".unhtmlentities($ligne[INS_CHAMPS_MAIL])." \n" ;
	$body .= INS_NOM.": ".unhtmlentities($ligne[INS_CHAMPS_NOM])." \n" ;
	$body .= unhtmlentities(INS_PRENOM).' : '.unhtmlentities($ligne[INS_CHAMPS_PRENOM])." \n" ;
	$body .= INS_PAYS." : ".unhtmlentities($ligne[INS_CHAMPS_LABEL_PAYS])." \n" ;
	$body .= INS_ADRESSE_1." : ".unhtmlentities($ligne[INS_CHAMPS_ADRESSE_1])." \n" ;
	$body .= INS_ADRESSE_2." : ".unhtmlentities($ligne[INS_CHAMPS_ADRESSE_2])." \n" ;
	$body .= unhtmlentities(INS_REGION)." : ".unhtmlentities($ligne[INS_CHAMPS_REGION])." \n" ;
	$body .= INS_CODE_POSTAL." : ".unhtmlentities($ligne[INS_CHAMPS_CODE_POSTAL])." \n" ;
	$body .= INS_VILLE." : ".unhtmlentities($ligne[INS_CHAMPS_VILLE])." \n" ;
	$body .= INS_SITE_INTERNET." : ".unhtmlentities($ligne[INS_CHAMPS_SITE_WEB])." \n" ;
	$body .= "-------------------------------------------\n" ;

	$mime->setTXTBody($body);

	$body = $mime->get();
	$headers = $mime->headers($headers);
	
	$mail =& Mail::factory('mail') ;
	$mail->send($ligne[INS_CHAMPS_MAIL], $headers, $body) ;
	
	// Envoi du mail aux administrateur du site
	if ($ligne[INS_CHAMPS_MAIL] != '') {
		foreach ($GLOBALS['mail_admin'] as $administrateur) {
			$mail->send($administrateur, $headers, $body) ;
		}
	}
	return true ;
}

/**
 *
 *
 * @return
 */

function message_inscription () {
	return '<p>'.INS_MESSAGE_INSCRIPTION.'</p>' ;
}

/**
 *  Inscrit un adhérent à la lettre d'actualité par l'envoie d'un email subscribe / unsubscribe
 *  à la liste
 *
 * @global  AUTH	Un objet PEAR::Auth
 * @return  boolean true en cas de succès
 */
function inscription_lettre ($action) {
	$mail = & Mail::factory ('smtp') ;
	$email = $GLOBALS['AUTH']->getUsername() ;
	$headers ['Return-Path'] = $email ;
	$headers ['From'] = "<".$email.">" ;
	$headers ['Subject'] = $action ;
	$headers ['Reply-To'] = $email ;
	
	$mail -> send ($action, $headers, "") ;
	if (PEAR::isError ($mail)) {
		echo '<p class="erreur">Le mail n\'est pas partie...</p>' ;
		return false ;
	}
	return true ;
}

/**
 *  Génère un nom wiki valide à partir des données saisies par l'utilisateur
 *  fait une requete dans la base
 *
 * @return  string un nom wiki valide
 */
function genere_nom_wiki  ($nom, $prenom) {
	// 1. suppression des espaces
	$nom = trim ($nom) ;
	$prenom = trim ($prenom) ;
	
	// 2. suppression des caractères non ascii et ajout de la première lettre en majuscule
	$nom = trim_non_ascii ($nom) ;
	$prenom = trim_non_ascii ($prenom) ;
	
	// Vérification
	$nom_wiki = $nom.$prenom ;
	if (!preg_match('/^[A-Z][a-z]+[A-Z,0-9][A-Z,a-z,0-9]*$/', $nom_wiki)) {
		$nom_wiki = chr(rand(65, 90)).$nom_wiki.chr(rand(65, 90)) ;
	}
	return $nom_wiki ;
}

/**
 *
 *
 * @return
 */
function trim_non_ascii ($nom) {
	$premiere_lettre = true ;
	for ($i = 0; $i < strlen ($nom); $i++) {
		if (!preg_match ('/[a-zA-Z0-9]/', $nom[$i])) {
//			str_replace ($nom[$i], '_', $nom, 1) ;
		}
	// remplacement de la première lettre en majuscule
		if (preg_match ('/[a-zA-Z]/', $nom[$i]) && $premiere_lettre) {
			$nom[$i] = strtoupper ($nom[$i]) ;
			$premiere_lettre = false ;
		} else {
			if (preg_match ('/[a-zA-Z]/', $nom[$i])) {
				$nom[$i] = strtolower ($nom[$i]) ;
			}
		}
	}
	$nom = trim ($nom, '_') ;
	return $nom ;
}

// For users prior to PHP 4.3.0 you may do this:
function unhtmlentities ($string)
{
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	return strtr ($string, $trans_tbl);
}

/* ***********************************
create_new_random($n,$type) permet de générer un nombre de caractères aléatoires.

ENTREE :
- $n : créer un 'mot' de $n caractères
- $type : permet de définir la liste des caractères disponibles

SORTIE : chaine de $n caractères pris dans une liste $type
	*********************************** */
 
function create_new_random($n,$type="")
{
	$str = "";

	switch ($type){
		//liste des caractères possibles en virant ceux qui se ressemblent (ijl1oO0)
		// case "":
		//	{
		//	}
		// break;
		
		default:{
			$chaine = "abcdefghkmnpqrstuvwxyzABCDEFGHKLMNPQRSTUVWXYZ23456789";
		}
			break;
	}
 
	srand((double)microtime()*1000000);
	for($i = 0; $i < $n; $i++){
		$str .= $chaine[rand()%strlen($chaine)];
	}
 
	return "$str";
}

//==============================================================================
/** function nextId () Renvoie le prochain identifiant numérique libre d'une table
*
*   On passe en paramètre le nom de la table et l'identifiant de la base selon PEAR DB
*
*   @param  mixed   handler de connexion
*   @param  string  Nom de la table
*   return  interger	l'identifiant
*/

function nextId ($table, $colonne_identifiant, $db)
{
	$requete = "select MAX($colonne_identifiant) as maxi from $table" ;
	$resultat = $db->query($requete) ;
	if (DB::isError($resultat)) {
		die (__FILE__ . __LINE__ . $resultat->getMessage() . $requete);
		return $db->raiseError($resultat) ;
	}
	
	if ($resultat->numRows() > 1) {
		return $db->raiseError("<br/>La table $table a un identifiant non unique<br/>") ;
	}
	$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
	return $ligne->maxi + 1 ;
}
?>
