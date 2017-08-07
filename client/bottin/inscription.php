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
// CVS : $Id: inscription.php,v 1.28 2007-06-26 09:32:32 neiluj Exp $
/**
* Inscription
*
* Un module d'inscription, en general ce code est specifique a
* un site web
*
*@package inscription
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision: 1.28 $ $Date: 2007-06-26 09:32:32 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
include_once 'configuration/bottin.config.inc.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.fonct.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.fonct.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.class.php';
// Inclusion d'une classe personnalise si elle existe
if (file_exists (INS_CHEMIN_APPLI.'bibliotheque/inscription.class.local.php')) {
	include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.class.local.php' ;	
} else {
	include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.class.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

if (!isset($_REQUEST['action'])) {
	$_REQUEST['action']='';
}


if ( isset($_GET['voir_fiche']) or isset($_GET['voir_abonnement']) or isset($_GET['voir_actus']) or isset($_GET['voir_ressources']) or isset($_GET['voir_competences']) 
or (isset($_REQUEST['action'])&&($_REQUEST['action']=='modifier_v'||$_REQUEST['action']=='modifier_v'))
or ($GLOBALS['AUTH']->getAuth() && ($_REQUEST['action']!='modifier')) ) {
	//---------------le menu de l'appli-----------
	function afficherContenuNavigation () {
		$res =inscription_onglets();
		return $res ;
	}
}

function afficherContenuCorps() {
    $res = '<h1>'.INS_TITRE_INSCRIPTION.'</h1>'."\n" ;
		
    // Recuperation de la configuration
    if (isset($_REQUEST['id_inscription'])) {
     	$GLOBALS ['ins_config'] = inscription::getConfig($_REQUEST['id_inscription']);
    } else {
    	$GLOBALS ['ins_config'] = inscription::getConfig();
    }
    // Template du formulaire
    $GLOBALS['ins_config']['ic_inscription_template'] = inscription::getTemplate(INS_TEMPLATE_FORMULAIRE, 
    									$GLOBALS['ins_config']['ic_id_inscription']);
     // 
//cas de la deconnexion----------------------------------------------------------------------------------
    if ($_REQUEST['action'] == 'deconnexion') {
        $GLOBALS['AUTH']->logout() ;
        $_POST['username'] = '' ;
        $_POST['password'] = '' ;
        return $res.inscription_AUTH_formulaire_login() ;
    }
    
//cas de la desinscription-------------------------------------------------------------------------------
    if ($_REQUEST['action'] == 'supprimer') {
    	$id_utilisateur = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID) ;
    	// Suppression dans SPIP
        if (INS_UTILISE_SPIP) {
            desinscription_spip($GLOBALS['AUTH']->getAuthData(INS_CHAMPS_ID)) ;
        }
		// Suppression dans Wikini
        if (INS_UTILISE_WIKINI) {
			$nom_wiki = $GLOBALS['AUTH']->getAuthData(INS_CHAMPS_NOM_WIKINI) ;
			desinscription_interwikini_users($nom_wiki) ;
        }
        
        // Lettre d actualite
        desinscription_lettre($GLOBALS['ins_config']['ic_mail_desinscription_news']);
        $msg = '';
        // Appel des actions desinscriptions des applications clientes
        $d = dir(GEN_CHEMIN_CLIENT);
		while (false !== ($repertoire = $d->read())) {
			if ($repertoire != '.' || $repertoire != '..') {
				if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.desinscription.inc.php'))
				include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.desinscription.inc.php' ;   
			}
			if ($msg != '') $res .= $msg;
		}
		$d->close();
		
    	$resultat = $GLOBALS['AUTH']->removeUser($GLOBALS['AUTH']->getUsername()) ;	
        if (PEAR::isError($resultat)) {
        	return ($resultat->getMessage().'<br />'.$resultat->getDebugInfo()) ;
        }
        
        
		// Deconnection        
        $GLOBALS['AUTH']->logout() ;
        // Destruction du cookie de session de Papyrus : est ce utile?
		setcookie(session_name(), session_id(), time()-3600, '/');
		// Destruction du cookie de permanence de l'identitification de Papyrus
		setcookie(session_name().'-memo', '', time()-3600, '/');
		
        return $res.inscription_AUTH_formulaire_login() ;
    }
    
//cas de l'envoi de mot de passe par mail----------------------------------------------------------------
    if ($_REQUEST['action'] == 'sendpasswd') {
        return inscription_envoie_passe()."\n".inscription_formulaire_envoi_passe() ;
    }

//cas de la saisie ou la modification de l'inscription individuelle ou structure
    if (($_REQUEST['action'] == 'modifier')or($_REQUEST['action'] == 'modifier_v')or($_REQUEST['action'] == 'inscription')or($_REQUEST['action'] == 'inscription_v')) {
        $formulaire = new HTML_formulaireInscription('formulaire_inscription', 'post', preg_replace('/&amp;/', '&', $GLOBALS['ins_url']->getURL()), '_self', '', 0) ;
        $formulaire->addElement('hidden', 'id_inscription', $_REQUEST['id_inscription']) ;
        if ($_REQUEST['action'] == 'modifier') {
            $formulaire->setDefaults(inscription_formulaire_defaults()) ;
        }
        $formulaire->construitFormulaire(preg_replace('/&amp;/', '&', $GLOBALS['ins_url']->getURL()));
        if (isset($_REQUEST['id_inscription'])) {
        	if ($_REQUEST['id_inscription']==1) {
        		$formulaire->formulaireStructure() ;
        	}
        }
        

        //pour la modification d'une inscription, on charge les valeurs par defauts
        if ($_REQUEST['action'] == 'modifier') {
            $formulaire->addElement('hidden', 'action', 'modifier_v') ;
            $formulaire->setDefaults(inscription_formulaire_defaults()) ;
        }
	
        if ($_REQUEST['action'] == 'inscription') {
            if ($GLOBALS['AUTH']->getAuth()) {
            	
            } else {
            	$formulaire->addElement('hidden', 'action', 'inscription_v') ;
            	$formulaire->setDefaults(array('pays' => 'fr', 'visible' => 1,'lettre'=>1, 'a_lettre' =>1));
            }
        }
	
        if ($_REQUEST['action'] == 'inscription_v') {
            $formulaire->registerRule('doublonmail', 'callback', 'inscription_verif_doublonMail');
	        $formulaire->addRule('email', INS_MAIL_DOUBLE, 'doublonmail');
            if ($formulaire->validate()) {
			    if ($GLOBALS['ins_config']['ic_mail_valide_inscription']) {
				    $formulaire->process('inscription_demande', false) ;
				    return $res.INS_MESSAGE_INSCRIPTION;
			    } else {
				    if ($GLOBALS['ins_config']['ic_inscription_modere']) {
				    	inscription::demandeInscriptionModere($formulaire->getSubmitValues());
				    	return inscription::getTemplate(INS_TEMPLATE_MESSAGE_INSCRIPTION_MODEREE, $GLOBALS['ins_config']['ic_id_inscription']);	
				    }				    
				    $formulaire->process('inscription_validee', false) ;				    
				    $id_utilisateur = $GLOBALS['ins_db']->getOne('SELECT MAX('.INS_CHAMPS_ID.') FROM '.INS_ANNUAIRE) ;				    
				    // Appel des actions des inscriptions des applications clientes
			        $d = dir(GEN_CHEMIN_CLIENT);
					while (false !== ($repertoire = $d->read())) {
						if ($repertoire != '.' && $repertoire != '..') {
							if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php'))
							include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php' ;
						}   
					}
					$d->close();
				    return $res.info();
			    }
            } else {
            	// Si le formulaire n'est pas bon on remet l'action inscription_v
            	$formulaire->addElement('hidden', 'action', 'inscription_v') ;	
            }
        }
        if ($_REQUEST['action'] == 'modifier_v') {
            if ($formulaire->validate()) {
                $formulaire->process('inscription_mise_a_jour', false) ;
            } else {
            	return $formulaire->toHTML();
            }
            return $res.info();
        }
	
        return $res.$formulaire->toHTML() ;
    }
    
//cas de la validation par mail d'une inscription--------------------------------------------------------
	// On a besoin de la globale ins_config,
	// or on ignore quel est l identifiant de l inscription
	// on recupere les donnees serializees a partir de $_GET['id']
	
	if (isset($_GET['id'])) {
		$requete = 'SELECT id_donnees FROM inscription_demande WHERE id_identifiant_session="'.$_GET['id'].'"' ;
	    $resultat = $GLOBALS['ins_db']->query($requete) ;
	    if (DB::isError ($resultat)) {
		    return ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	    }
	    
	    if($resultat->numRows() == 0)
	    	return INS_MESSAGE_EXPIRATION;
	    	
	    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
	    $donnees = unserialize (stripslashes($ligne->id_donnees)) ;
	    
	    // dans les donnees serialisees, on recupere l identifiant de l inscription
	    // pour charger la globale ins_config
	    $GLOBALS['ins_config'] = inscription::getConfig($donnees['id_inscription']);
		// Template du formulaire
		
  		$GLOBALS['ins_config']['ic_inscription_template'] = inscription::getTemplate(INS_TEMPLATE_FORMULAIRE, 
    									$GLOBALS['ins_config']['ic_id_inscription']);
	   
	    // si l inscription est modere on place la demande en attente
	    // et on envoie un mail au moderateur
	    
	    if ($GLOBALS['ins_config']['ic_inscription_modere']) {
	    			
			$requete_attente = 'insert into inscription_attente select * from inscription_demande where id_identifiant_session="'.
	    					$_GET['id'].'"';
			$resultat = $GLOBALS['ins_db']->query($requete_attente);
			if (DB::isError ($resultat)) {
		    	return ("Echec de la requete : $requete<br />".$resultat->getMessage());
	    	}
	    	$mails_moderateur = split ('/\n/', $GLOBALS['ins_config']['ic_mail_moderateur']);
	    	foreach ($mails_moderateur as $mail) {
	    		mail ($mail, INS_MODERATION_SUJET, INS_NOUVELLE_INSCRIPTION_A_MODERE) ;
	    	}
	    	
	    } else {
	    
		    $id_utilisateur = inscription_insertion($donnees) ;
		    $GLOBALS['AUTH']->username = $donnees['a_mail'] ;
		    $GLOBALS['AUTH']->password = $donnees['mot_de_passe'] ;
		    
		    // On loggue l'utilisateur
		    $GLOBALS['AUTH']->login() ;
		    
		    // inscription a la lettre d'information
		    if (isset ($donnees['lettre'])) {
			    inscription_lettre($GLOBALS['ins_config']['ic_mail_inscription_news']) ;
		    }
		    // Appel des actions des inscriptions des applications clientes
	        $d = dir(GEN_CHEMIN_CLIENT);
			while (false !== ($repertoire = $d->read())) {
				if (file_exists(GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php'))
				include_once GEN_CHEMIN_CLIENT.$repertoire.GEN_SEP.$repertoire.'.inscription.inc.php' ;   
			}
			$d->close();
		    envoie_mail() ;
	    }
	    // On supprime la demande d'inscription
	    $requete = 'delete from inscription_demande where id_identifiant_session="'.$_GET['id'].'"' ;
	    $resultat = $GLOBALS['ins_db']->query($requete) ;
	    if (DB::isError($resultat)) {
		    return ("Echec de la requete : $requete<br />".$resultat->getMessage()) ;
	    }
	}
    
    
    if ((!$GLOBALS['AUTH']->getAuth())&&($_REQUEST['action']!='inscription')&&($_REQUEST['action']!='inscription_v')) {    
        if (isset($_POST['username']) && $_POST['username'] != '') {
            $res .= '<p class="erreur">'.INS_ERREUR_LOGIN.'</p><br />'."\n".inscription_formulaire_envoi_passe();
        } else {
            $res .= inscription_AUTH_formulaire_login() ;
        }
    }
    
//cas d'une authentification reussie---------------------------------------------------------------------
    if ($GLOBALS['AUTH']->getAuth() && ($_REQUEST['action']!='modifier')) {
            // Il faut charger ins_config
            if(empty($GLOBALS['ins_config']))
            	$GLOBALS['ins_config'] = inscription::getConfig($GLOBALS['AUTH']->getAuthData('a_ce_id_inscription'));
             
            return info() ;
    }
    
    return $res ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: inscription.php,v $
* Revision 1.28  2007-06-26 09:32:32  neiluj
* debug inscription (warnings) et adaptation php5
*
* Revision 1.27  2007-06-25 09:59:03  alexandre_tb
* ajout de carte_google, mise en place des templates avec api/formulaire, configuration de multiples inscriptions, ajout de modele pour les mails
*
* Revision 1.26  2007-06-01 15:11:00  alexandre_tb
* correction de la verification de l email qui ne fonctionnait plus
*
* Revision 1.25  2007-06-01 13:37:56  alexandre_tb
* mise en place de la table inscription_configuration et de la moderation
*
* Revision 1.24  2007-05-25 14:31:10  alexandre_tb
* en cours
*
* Revision 1.23  2007/04/11 08:30:12  neiluj
* remise en état du CVS...
*
* Revision 1.20.2.1  2007/01/26 10:32:59  alexandre_tb
* suppression d un notice
*
* Revision 1.20  2006/12/01 13:23:17  florian
* integration annuaire backoffice
*
* Revision 1.19  2006/10/05 13:53:54  florian
* amélioration des fichiers sql
*
* Revision 1.18  2006/07/20 09:48:07  alexandre_tb
* r�glages
*
* Revision 1.17  2006/07/06 10:33:30  alexandre_tb
* correction bug du � derni�re mise � jour
*
* Revision 1.16  2006/07/04 09:38:31  alexandre_tb
* Ajout de la r�gle doublon email uniquement lors de cr�ation d'une entr�e
*
* Revision 1.15  2006/06/01 10:00:35  alexandre_tb
* correction bug d�sinscription des appli cliente
*
* Revision 1.14  2006/04/10 09:48:16  alexandre_tb
* Correction de bug pour les inscriptions aux autres applications
*
* Revision 1.13  2006/04/04 12:23:05  florian
* modifs affichage fiches, généricité de la carto, modification totale de l'appli annuaire
*
* Revision 1.12  2006/03/15 11:05:45  alexandre_tb
* ajout de l'action cach� inscription_v lors du r�affichage du formulaire apr�s erreur de saisie.
*
* Revision 1.11  2006/03/02 14:10:35  alexandre_tb
* correction du bug desinscription wikini
*
* Revision 1.10  2006/03/02 13:03:45  alexandre_tb
* bug de d�sinscription interwikini_users
*
* Revision 1.9  2006/02/28 14:08:27  alexandre_tb
* appel des inscriptions des autres appli, sous le format:
* client/appli/appli.inscription.php
*
* Revision 1.8  2006/02/14 10:21:08  alexandre_tb
* ajout d'un appel � un fichier de classe personnalis�
*
* Revision 1.7  2005/12/19 13:16:14  alexandre_tb
* correction d'un bug
*
* Revision 1.6  2005/11/18 16:04:15  florian
* corrections de bugs, optimisations, tests pour rendre inscription stable.
*
* Revision 1.5  2005/11/17 18:48:02  florian
* corrections bugs + amélioration de l'application d'inscription
*
* Revision 1.4  2005/10/25 14:02:21  alexandre_tb
* le formulaire affiche la france par d�faut
*
* Revision 1.3  2005/09/29 16:07:51  alexandre_tb
* En cours de production.
*
* Revision 1.2  2005/09/27 13:59:24  alexandre_tb
* correction de bogue, g�n�ralisation du code etc.
*
* Revision 1.1  2005/09/22 14:02:49  ddelon
* nettoyage annuaire et php5
*
* Revision 1.4  2005/09/22 13:30:49  florian
* modifs pour compatibilité XHTML Strict + corrections de bugs (mais ya encore du boulot!!)
*
* Revision 1.4  2005/03/21 16:57:30  florian
* correction de bug, mise � jour interface
*
* Revision 1.3  2005/03/08 17:44:02  alex
* suppression en utilisant removeUser de Auth plut�t qu'en requete directe
*
* Revision 1.2  2005/03/02 12:44:41  alex
* Correction du bug message d'erreur alors qu'on tente de s'inscrire simplement
*
* Revision 1.1  2004/12/15 13:32:15  alex
* version initiale
*
* Revision 1.2  2004/09/01 16:36:37  alex
* changement du chemin pour les include
*
* Revision 1.1  2004/07/06 15:42:28  alex
* en cours
*
* Revision 1.5  2004/07/06 15:28:56  alex
* en cours
*
* Revision 1.4  2004/06/25 14:26:03  alex
* modification de la suppression
*
* Revision 1.3  2004/06/23 12:41:44  alex
* am�lioration de la gestion de la perte de mot de passe
*
* Revision 1.2  2004/06/18 09:18:23  alex
* version initiale
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
