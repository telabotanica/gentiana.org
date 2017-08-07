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
// CVS : $Id: inscription.fonct.php,v 1.30 2007-06-25 09:59:03 alexandre_tb Exp $
/**
* Fonctions du module inscription
*
* Fonctions du module inscription
*
*@package inscription
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Florian Schmitt <florian@ecole-et-nature.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.30 $ $Date: 2007-06-25 09:59:03 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

include_once 'inscription.fonct.wiki.php' ;
include_once 'inscription.class.php' ;
if (INS_UTILISE_SPIP) include_once 'inscription.fonct.spip.php' ;

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+


/**
 *
 * @param   array   les valeurs renvoyés par le formulaire
 * @return
 */

function demande_inscription($valeurs) {
    // On stocke les informations dans un variable de session
    // On coupe l'identifiant de session pour ne prendre que les 8 premiers caractères
    // afin d'éviter d'obtenir une url trop longue
    $chaine = substr (session_id(), 0, 8) ;
    $requete_verif = 'select * from inscription_demande where id_identifiant_session="'.$chaine.'"' ;
    $resultat_verif = $GLOBALS['ins_db']->query ($requete_verif) ;
    if ($resultat_verif->numRows() != 0) {
        $requete_suppression = 'delete from inscription_demande where id_identifiant_session="'.$chaine.'"' ;
        $GLOBALS['ins_db']->query ($requete_suppression) ;
    }
    $requete = 'insert into inscription_demande set id_identifiant_session="'.$chaine.'", id_donnees="'.
                addslashes(serialize($valeurs)).'", id_date=NOW()' ;
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError ($resultat)) {
        echo ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
    }
    // On envoie un email de confirmation pour l'utilisateur
    $GLOBALS['ins_url']->addQueryString ('id', $chaine) ;
    
    
    if (INS_UTILISE_REECRITURE_URL) {
        $url = 'http://'.$GLOBALS['ins_url']->host.'/'.INS_URL_PREFIXE.$chaine ;
    } else {
        $url = str_replace ('&amp;', '&', $GLOBALS['ins_url']->getURL()) ;
    }
    
    require_once PAP_CHEMIN_API_PEAR.'HTML/Template/IT.php';
    $tpl = new HTML_Template_IT() ;
    // Le gabarit du mail est dans un template
    // template 2
    $requete = 'select it_template from inscription_template where it_id_template=2'.
    			' and it_i18n like "%'.INS_LANGUE_DEFAUT.'"' ;
    
    if (!$tpl -> setTemplate($GLOBALS['ins_db']->getOne ($requete))) {
    	echo 'erreur' ;	
    }
	$tpl->setVariable('URL_INSCRIPTION', $url) ;

    mail ($GLOBALS['email'], 'Inscription', $tpl->get(), 'From: '.INS_MAIL_ADMIN_APRES_INSCRIPTION) ;
}



/**
*   Renvoie l'accueil de l'inscription
*
*   @return string	HTML
*/
function AUTH_formulaire_login() {   
    require_once PAP_CHEMIN_API_PEAR.'/HTML/Template/IT.php';
    $tpl = new HTML_Template_IT() ;
    // Le formulaire pour se logguer est dans un template
    // template 1
    $requete = 'SELECT it_template FROM inscription_template WHERE it_id_template=1'.
    			' AND it_i18n LIKE "%'.INS_LANGUE_DEFAUT.'"' ;
    
    if (!$tpl -> setTemplate($GLOBALS['ins_db']->getOne ($requete))) {
    	echo 'erreur' ;	
    }
	$tpl->setVariable('URL_INSCRIPTION', $GLOBALS['ins_url']->getURL());
    return $tpl->get() ;
    
}


/** formulaire_envoi_passe() - Renvoie le code HTML d'un formulaire d'envoi de mot de passe par mail 
*
* @return   string  HTML
*/
function formulaire_envoi_passe() {
    $res = '<h2>'.INS_SI_PASSE_PERDU.'</h2>'."\n" ;
    $res .= '<form action="'.$GLOBALS['ins_url']->getURL().'&amp;action=sendpasswd" method="post">'."\n" ;
    $res .= '<p class="label100">'.INS_EMAIL.' : </p>'."\n" ;
    $res .= '<input type="text" value="';
    if (isset($_POST['username'])) $res .= $_POST['username'];
    $res .= '" name="mail" size="32" />'."\n" ;
    $res .= '<input type="submit" value="'.INS_ENVOIE_PASSE.'" />' ;
    $res .= '</form><br />'."\n" ;
    $res .= AUTH_formulaire_login() ;
    return $res;
}


function insertion($valeur) {
    // ===========  Insertion dans l'annuaire ===================
	// Génération du nom wikini à partir du nom et du prénom
    if (INS_UTILISE_WIKINI && INS_NOM_WIKINI_GENERE) {
        $valeur['nom_wiki'] = genere_nom_wiki ($valeur['nom'], isset ($valeur['prenom']) ?  $valeur['prenom'] : '') ;
    } else {
    	if (!INS_NOM_WIKINI_GENERE)	{
    		$valeur['nom_wiki'] = $valeur['nomwiki'];	
    	}
    }
    $id_utilisateur = nextId(INS_ANNUAIRE, INS_CHAMPS_ID, $GLOBALS['ins_db']) ;
    $requete = 'INSERT INTO '.INS_ANNUAIRE.' SET '.
                INS_CHAMPS_ID.'="'.$id_utilisateur.'",'.
                requete_annuaire($valeur) ;

    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        die ($resultat->getMessage().$resultat->getDebugInfo()) ;
    }

    // ================ Insertion dans SPIP =========================================
    if (INS_UTILISE_SPIP) {
        inscription_spip($id_utilisateur, $valeur) ;
    }
	if (INS_UTILISE_WIKINI) inscription_interwikini_users('', $valeur) ;
	return $id_utilisateur ;
}


/**
*   Réalise une mise à jour dans la base de donnée
*
*   @param  array   un tableau de valeur avec en clé les noms des champs du formulaire
*   @return void
*/
function mise_a_jour($valeur, $id = '') {
    // ====================Mise à jour dans l'annuaire gen_annuaire ====================
	if ($id == '') {
		$id = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
	}
    $requete = 'update '.INS_ANNUAIRE.' set '.
                requete_annuaire ($valeur).
                'where '.INS_CHAMPS_ID.'="'.$id.'"';
    $resultat = $GLOBALS['ins_db']->query ($requete) ;
    if (DB::isError($resultat)) {
        die ($resultat->getMessage().$resultat->getDebugInfo()) ;
    }
    unset ($resultat) ;

    // ========================= Mise à jour dans SPIP ================================
    if (INS_UTILISE_SPIP) {
        mod_inscription_spip($GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID), $valeur) ;
    }
}

/** requete_annuaire () - Renvoie une chaine contenant les champs de l'annuaire avec leur valeur suite à le fonction process de QuickForm
*
* @return   string  une requete du type champs="valeur",...
*/

function requete_annuaire($valeur) {
    $req = INS_CHAMPS_NOM.'="'.addslashes($valeur['nom']).'", ';
    if (isset($valeur['est_structure']) && $valeur['est_structure'] == 0) 
    			$req .= INS_CHAMPS_PRENOM.'="'.addslashes($valeur['prenom']).'", ';
    // Initialisation de variable pour éviter des notices
    foreach (array ('adresse_1', 'adresse_2', 'ville', 'telephone', 'fax', 'site') as $val) {
    	if (!isset ($valeur[$val])) $valeur[$val] = '' ;   	
    }

    $req .= INS_CHAMPS_MAIL.'="'.addslashes($valeur['email']).'", ' ;
    $req .= INS_CHAMPS_PASSE.'="'.md5($valeur['mot_de_passe']).'", '.
            INS_CHAMPS_PAYS.'="'.addslashes($valeur['pays']).'", '.
            INS_CHAMPS_ADRESSE_1.'="'.addslashes($valeur['adresse_1']).'", '.
            INS_CHAMPS_ADRESSE_2.'="'.addslashes($valeur['adresse_2']).'", '.
            INS_CHAMPS_DATE_INSCRIPTION.'=NOW(), '.
            INS_CHAMPS_CODE_POSTAL.'="'.addslashes($valeur['cp']).'", '.
			INS_CHAMPS_VILLE.'="'.addslashes($valeur['ville']).'", '.
			INS_CHAMPS_EST_STRUCTURE.'="'.addslashes($valeur['est_structure']).'", '.
			INS_CHAMPS_TELEPHONE.'="'.addslashes($valeur['telephone']).'", '.
			INS_CHAMPS_FAX.'="'.addslashes($valeur['fax']).'", '.
			INS_CHAMPS_SITE_INTERNET.'="'.addslashes($valeur['site']).'" ';
			
	if (isset($valeur['visible'])) $req .= ', '.INS_CHAMPS_VISIBLE.'="'.$valeur['visible'].'"';
	else $req .= ', '.INS_CHAMPS_VISIBLE.'=0';
	
	if (INS_CHAMPS_LETTRE != '') {
		if (isset($valeur['lettre'])) {
			$req .= ', '.INS_CHAMPS_LETTRE.'="'.$valeur['lettre'].'" ';
			inscription_lettre('inscrire');
		}
		else {
			$req .= ', '.INS_CHAMPS_LETTRE.'=0 ';
			inscription_lettre('desinscrire');
		} 
	}
	
	if (isset($valeur['sigle_structure'])) {
        $req .= ', '.INS_CHAMPS_SIGLE_STRUCTURE.'="'.addslashes($valeur['sigle_structure']).'"' ;
    }
    if (isset($valeur['num_agrement'])) {
        $req .= ', '.INS_CHAMPS_NUM_AGREMENT.'="'.addslashes($valeur['num_agrement']).'"' ;
    }
    // traitement du numéro de département pour la france
    if ($valeur['pays'] == 'FR') {
        if (preg_match("/^97|98[0-9]*/", $valeur['cp'])) {
            $n_dpt = substr($valeur['cp'], 0, 3) ;
        } else {
            $n_dpt = substr($valeur['cp'], 0, 2) ;
        }
        $req .= ",".INS_CHAMPS_DEPARTEMENT."='$n_dpt'";
    }
    if (INS_UTILISE_WIKINI && isset ($valeur['nom_wiki'])) $req .= ','.INS_CHAMPS_NOM_WIKINI.'="'.$valeur['nom_wiki'].'"';
    if ($GLOBALS['ins_config']['ic_google_key']) {
    	$req .= ', a_longitude="'.$valeur['longitude'].'", a_latitude="'.$valeur['latitude'].'"';
    }
    return $req ;
}



/** formulaire_defaults() - Renvoie un tableau avec les valeurs par défaut du formulaire d'inscription
*
* @return   array   Valeurs par défaut du formulaire d'inscription
*/
function formulaire_defaults($id = '') {
	if ($id == '') {
			$id = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID);
	}
    $requete = 'select '.INS_ANNUAIRE.'.* '.
                'from '.INS_ANNUAIRE.' '.
                'where '.INS_ANNUAIRE.'.'.INS_CHAMPS_ID.'= "'.$id.'"' ;
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
    if (INS_UTILISE_WIKINI) {$valeurs_par_defaut['nomwiki'] = $ligne[INS_CHAMPS_NOM_WIKINI] ;}
    $valeurs_par_defaut['cp'] = $ligne[INS_CHAMPS_CODE_POSTAL] ;
    $valeurs_par_defaut['ville'] = $ligne[INS_CHAMPS_VILLE] ;
    $valeurs_par_defaut['adresse_1'] = $ligne[INS_CHAMPS_ADRESSE_1] ;
    $valeurs_par_defaut['adresse_2'] = $ligne[INS_CHAMPS_ADRESSE_2] ;
    $valeurs_par_defaut['telephone'] = $ligne[INS_CHAMPS_TELEPHONE] ;
    $valeurs_par_defaut['fax'] = $ligne[INS_CHAMPS_FAX] ;
    if (INS_CHAMPS_STRUCTURE != '' && isset($ligne[INS_CHAMPS_STRUCTURE])) {
    	$valeurs_par_defaut['structure'] = $ligne[INS_CHAMPS_STRUCTURE] ;
    	//$valeurs_par_defaut['type_structure'] = $ligne['a_type_structure'];	
    }
    $valeurs_par_defaut['site'] = $ligne[INS_CHAMPS_SITE_INTERNET] ;
    $valeurs_par_defaut['lettre'] = $ligne[INS_CHAMPS_LETTRE] ;
    $valeurs_par_defaut['visible'] = $ligne[INS_CHAMPS_VISIBLE] ;
    $valeurs_par_defaut['sigle_structure'] = $ligne[INS_CHAMPS_SIGLE_STRUCTURE] ;
    if (INS_CHAMPS_NUM_AGREMENT != '') $valeurs_par_defaut['num_agrement'] = $ligne[INS_CHAMPS_NUM_AGREMENT] ;
    return $valeurs_par_defaut ;
}


/**	ligne_inscription() - Renvoie une ligne avec label et valeur
 *
 * @param string label Le label
 * @param string valeur
 * @return	string HTML
 */
function ligne_inscription($label, $valeur) {
    if ($valeur == '') {
        return;
    }
    if (($label == '')or($label == '&nbsp;')) {
    	return '<li>'."\n".$valeur."\n".'</li>'."\n" ;
    } else {
    	return '<li>'."\n".'<strong>'.$label.' : </strong>'."\n".$valeur."\n".'</li>'."\n" ;    	
    }
}


/** Renvoie vrai si l'email passé en paramètre n'est pas déjà dans l'annuaire
*   ou si, en cas de modification d'inscription, l'inscrit ne modifie pas son email
*
*   @return boolean 
*/
function verif_doublonMail($mail, $id = '') {
	if ($id == '') {
		if (isset ($GLOBALS['AUTH'])) {
			$id = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID) ;
		}
	}
    if (isset ($id) && $id != '') {
        $requete_mail = "select ".INS_CHAMPS_MAIL." from ".INS_ANNUAIRE." where ".
        				INS_CHAMPS_ID."=".$id ;
        $resultat_mail = $GLOBALS['ins_db']->query ($requete_mail) ;
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


function envoie_passe() {
	$res='';
	$requete = 'SELECT '.INS_CHAMPS_MAIL.' FROM '.INS_ANNUAIRE.' WHERE '.INS_CHAMPS_MAIL.'="'.$_POST['mail'].'"' ;
    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    }
    if ($resultat->numRows() == 0) {
    	$res .= '<p class="erreur">'.INS_MAIL_INCONNU_DANS_ANNUAIRE.'</p>'."\n" ;
    } else {
    	include_once PAP_CHEMIN_RACINE.'api/pear/Mail.php' ;
    	$mail = & Mail::factory('smtp') ;
    	$headers ['Return-Path'] = "<".INS_MAIL_ADMIN_APRES_INSCRIPTION.">" ;
    	$headers ['From'] = "<".INS_MAIL_ADMIN_APRES_INSCRIPTION.">" ;
    	$headers ['Subject'] = INS_MOT_DE_PASSE_CHANGE ;
    	$headers ['Reply-To'] = "<".INS_MAIL_ADMIN_APRES_INSCRIPTION.">" ;
    	$headers ['To'] = "<".$_POST['mail'].">" ;
    	$nouveau_passe = create_new_random(6) ;
    	// modification du mot de passe dans la base
    	$requete = 'UPDATE '.INS_ANNUAIRE.' SET '.INS_CHAMPS_PASSE.'=MD5("'.$nouveau_passe.'") WHERE '.INS_CHAMPS_MAIL.'="'.$_POST['mail'].'"' ;
    	$resultat = $GLOBALS['ins_db']->query($requete) ;
    	if (DB::isError($resultat)) {
    		die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    	}
    	$body = INS_NOUVEAU_MOT_DE_PASSE_2.$nouveau_passe ;
    	$body .= INS_NOUVEAU_MOT_DE_PASSE_LAIUS ;
    	$mail->send($_POST['mail'], $headers, $body) ;
    	if (PEAR::isError($mail)) {
    		$res .= '<p class="erreur">'.INS_PROBLEME_ENVOI_MAIL.'</p>'."\n" ;
    		return $res ;
    	}
    	$res .= '<p class="info">'.INS_NOUVEAU_MOT_DE_PASSE_ENVOYE.'</p>'."\n" ;
    }
    return $res ;
}

/**
 *
 * @global  ins_db  Un pointeur vers un objet PEAR::DB connecté
 * @return
 */

function envoie_mail() //A COMPLETER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
{
    //include_once PAP_CHEMIN_RACINE.'api/pear/Mail/mime.php' ;
    include_once PAP_CHEMIN_RACINE.'api/pear/Mail.php' ;
    $crlf="\n";
    
    $headers ['From'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;
    $headers ['Subject'] = html_entity_decode(INS_MAIL_COORD_SUJET) ;
    $headers ['Reply-To'] = $GLOBALS['ins_config']['ic_from_mail_confirmation'] ;
    
    //$mime = new Mail_mime($crlf);
    
    $requete = "select *, ".INS_CHAMPS_LABEL_PAYS." from ".INS_ANNUAIRE.",".INS_TABLE_PAYS.
            " where ".INS_CHAMPS_MAIL."=\"".$GLOBALS['AUTH']->getUsername()."\"".
            " and ".INS_CHAMPS_ID_PAYS."=".INS_CHAMPS_PAYS;

    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError ($resultat)) {
        die ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
    }
    $ligne  = $resultat->fetchRow(DB_FETCHMODE_ASSOC) ;
    $body_entete = INS_MAIL_COORD_CORPS."\n" ;
    $body = "mail : ".$ligne[INS_CHAMPS_MAIL]."\n" ;
    $body .= "------------------------------------------\n";
    $body .= INS_NOM.": ".html_entity_decode($ligne[INS_CHAMPS_NOM])." \n" ;
    $body .= INS_PRENOM.' : '.html_entity_decode($ligne[INS_CHAMPS_PRENOM])." \n" ;
    $body .= INS_PAYS." : ".html_entity_decode($ligne[INS_CHAMPS_LABEL_PAYS])." \n" ;
    $body .= "-------------------------------------------\n" ;
    
    //$mime->setTXTBody($body);
    //$mime->setHTMLBody(info()) ;
    
    //$body = $mime->get();
    //$headers = $mime->headers($headers);
    $body = html_entity_decode($body);
    $mail = & Mail::factory('mail') ;
    $mail -> send ($ligne[INS_CHAMPS_MAIL], $headers, $body) ;
    
    //mail ($ligne[INS_CHAMPS_MAIL], $headers ['Subject'], $body, 'From: '.$GLOBALS['ins_config']['ic_from_mail_confirmation']);
    // Envoi du mail aux administrateur du site
    $body = $body_entete.$body;
    $body = html_entity_decode($body);
    $mails_moderateur = split ('/\n/', $GLOBALS['ins_config']['ic_mail_admin_apres_inscription']);
	foreach ($mails_moderateur as $mail_admin) {
		$mail -> send ($mail_admin, $headers, $body) ;
	}
    return true ;
}


/**
 *  Génère un nom wiki valide à partir des données saisies par l'utilisateur
 *  fait une requete dans la base
 *
 * @return  string un nom wiki valide
 */

function genere_nom_wiki($prenom, $nom) {
    // 1. suppression des espaces
    $nom = trim ($nom) ;
    $prenom = trim ($prenom) ;
    
    // 2. suppression des caractères non ascii et ajout de la première lettre en majuscule
    $nom = trim_non_ascii ($nom) ;
    $prenom = trim_non_ascii ($prenom) ;
    
    // Vérification
    $nom_wiki = $prenom.$nom ;
    if (!preg_match('/^[A-Z][a-z]+[A-Z,0-9][A-Z,a-z,0-9]*$/', $nom_wiki)) {
        $nom_wiki = chr(rand(65, 90)).$nom_wiki.chr(rand(65, 90)) ;
    }
    return $nom_wiki ;
}

/**
 *	Cette fonction supprime les caractères autres que asccii et les chiffres
 *
 * @return	string la chaine épurée
 */

function trim_non_ascii ($nom) {
    $premiere_lettre = true ;
    for ($i = 0; $i < strlen ($nom); $i++) {
        if (!preg_match ('/[a-zA-Z0-9]/', $nom[$i])) {
            $nom[$i] = '_' ;
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
    $nom = preg_replace ('/_/', '', $nom) ;
    return $nom ;
}

// For users prior to PHP 4.3.0 you may do this:
function unhtmlentities($string)
{
    $trans_tbl = get_html_translation_table (HTML_ENTITIES);
    $trans_tbl = array_flip ($trans_tbl);
    return strtr ($string, $trans_tbl);
}

//==============================================================================
/** function nextId () Renvoie le prochain identifiant numérique libre d'une table
*
*   On passe en paramètre le nom de la table et l'identifiant de la base selon PEAR DB
*
*   @param  mixed   handler de connexion
*   @param  string  Nom de la table
*   return  interger    l'identifiant
*/

function nextId($table, $colonne_identifiant)
{
    $requete = 'select MAX('.$colonne_identifiant.') as maxi from '.$table ;
    $resultat = $GLOBALS['ins_db']->query($requete) ;
    if (DB::isError($resultat)) {
        die (__FILE__ . __LINE__ . $resultat->getMessage() . $requete);
        return $GLOBALS['ins_db']->raiseError($resultat) ;
    }
    
    if ($resultat->numRows() > 1) {
        return $GLOBALS['ins_db']->raiseError("<br />La table $table a un identifiant non unique<br/>") ;
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
    return $ligne->maxi + 1 ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: inscription.fonct.php,v $
* Revision 1.30  2007-06-25 09:59:03  alexandre_tb
* ajout de carte_google, mise en place des templates avec api/formulaire, configuration de multiples inscriptions, ajout de modele pour les mails
*
* Revision 1.29  2007-05-25 14:32:17  alexandre_tb
* en cours
*
* Revision 1.28  2007/04/20 08:39:37  alexandre_tb
* correction de commentaire
*
* Revision 1.27  2007/04/11 08:30:12  neiluj
* remise en Ã©tat du CVS...
*
* Revision 1.23  2006/12/01 13:23:15  florian
* integration annuaire backoffice
*
* Revision 1.22  2006/10/05 13:53:53  florian
* amÃ©lioration des fichiers sql
*
* Revision 1.21  2006/09/20 13:10:01  alexandre_tb
* Ajout d'un test sur la lettre d'actualité
*
* Revision 1.20  2006/07/06 10:33:58  alexandre_tb
* Suppression d'un warning
*
* Revision 1.19  2006/07/04 09:39:27  alexandre_tb
* correction d'un bug mineur
*
* Revision 1.18  2006/06/01 14:42:20  alexandre_tb
* suppression d'un commentaire inutile
*
* Revision 1.17  2006/04/28 12:44:05  florian
* integration bazar
*
* Revision 1.16  2006/04/11 08:41:41  alexandre_tb
* Ajout du champs nom wiki dans le formulaire si la constante INS_GENERE_NOM_WIKI n'est pas activé
*
* Revision 1.15  2006/04/10 14:01:36  florian
* uniformisation de l'appli bottin: plus qu'un fichier de fonctions
*
* Revision 1.14  2006/04/04 12:23:05  florian
* modifs affichage fiches, gÃ©nÃ©ricitÃ© de la carto, modification totale de l'appli annuaire
*
* Revision 1.13  2006/03/21 10:25:33  alexandre_tb
* ajout d'un template pour le mail de confirmation
*
* Revision 1.12  2006/03/15 11:02:35  alexandre_tb
* ajout de l'insertion du prénom qui avait disparu
*
* Revision 1.11  2006/03/02 16:57:31  alexandre_tb
* correction appel au générateur de nom wiki
*
* Revision 1.10  2006/02/28 14:02:20  alexandre_tb
* suppression des insertion dans les tables du bazar
*
* Revision 1.9  2006/02/14 10:19:10  alexandre_tb
* Mise en place des templates
* CREATE TABLE `inscription_template` (
*   `it_id_template` smallint(5) unsigned NOT NULL default '0',
*   `it_i18n` varchar(5) NOT NULL default '',
*   `it_template` text NOT NULL,
*   PRIMARY KEY  (`it_id_template`)
* ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
*
* Revision 1.8  2006/01/02 09:51:38  alexandre_tb
* généralisation du code et intégration au bottin
*
* Revision 1.7  2005/12/19 13:19:07  alexandre_tb
* Correction de l'affichage des pays
*
* Revision 1.6  2005/11/24 16:17:52  florian
* changement template inscription + modifs carto
*
* Revision 1.5  2005/11/18 16:04:15  florian
* corrections de bugs, optimisations, tests pour rendre inscription stable.
*
* Revision 1.4  2005/11/17 18:48:02  florian
* corrections bugs + amÃ©lioration de l'application d'inscription
*
* Revision 1.3  2005/10/03 09:45:21  alexandre_tb
* suppression d'un echo
*
* Revision 1.2  2005/09/29 13:56:48  alexandre_tb
* En cours de production. Reste à gérer les news letters et d'autres choses.
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilitÃ© XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.3  2005/03/21 16:57:30  florian
* correction de bug, mise à jour interface
*
* Revision 1.2  2004/12/17 17:41:51  alex
* ajout du numéro de tel, du fax et de la structure
*
* Revision 1.1  2004/12/15 13:32:25  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/

?>
