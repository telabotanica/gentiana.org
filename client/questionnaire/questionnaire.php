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
// CVS : $Id: questionnaire.php,v 1.1 2007-04-19 14:51:10 florian Exp $
/**
* Contact
*
* Un module d'envoi de mails a une personne de l'annuaire, choisie par une liste déroulante
*
*@package inscription
//Auteur original :
*@author        Florian SCHMITT <florian@ecole-et-nature.org>
*
*@copyright     Réseau Ecole et Nature 2005
*@version       $Revision: 1.1 $ $Date: 2007-04-19 14:51:10 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

require_once PAP_CHEMIN_RACINE.'api/formulaire/formulaire.class.inc.php' ;
//appel du fichier de constantes des langues
include_once PAP_CHEMIN_RACINE.'client/questionnaire/langues/questionnaire.langue.'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php' ; 


// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

function afficherContenuCorps() {
	// Gestion des valeurs par defauts, en fonctions des donnees sauvees dans le menu
    $requete = 'SELECT gm_application_arguments FROM gen_menu WHERE gm_id_menu='.$_GET['menu'] ;
    $resultat = $GLOBALS['_GEN_commun']['pear_db']->query($requete) ;
    if (DB::isError($resultat)) {
    	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    }
    if ($resultat->numRows()>0) {        	        	
    	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {        		
    		$arguments = explode('||', $ligne->gm_application_arguments) ;        	
			for ($i = 0; $i < count($arguments); $i++) {
				$attr = explode('=', $arguments[$i], 2) ;
				if ($attr[0] != '') {
					$info_application->$attr[0] = (isset($attr[1]) ? $attr[1] : '') ;
				}
		   	}
		}    	
    }
    // On recupere le template du questionnaire 
    $requete = 'SELECT bti_nom, bti_template FROM pap_formulaires WHERE bti_id='.$info_application->num_questionnaire.' AND bti_i18n LIKE "'.$GLOBALS['_GEN_commun']['i18n'].'%"' ;     
    $resultat = $GLOBALS['_GEN_commun']['pear_db']->query($requete) ;
    if (DB::isError($resultat)) {
    	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    }              
    if ($resultat->numRows()>0) { 
    	$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ; 
    	$nom_questionnaire=$ligne->bti_nom ;
    	$template=$ligne->bti_template ;		           	
    }
	$url = preg_replace ('/&amp;/', '&', $GLOBALS['_GEN_commun']['url']->getURL()) ;
	$form = new PAP_donnees ;
	$res='<h1>'.$nom_questionnaire.'</h1>'."\n" ;
	// cas du formulaire deja rempli : on envoie le mail
	if (isset($_POST['envoi']) && !isset($_SESSION['formulaire_deja_envoye']) ) {
		$_SESSION['formulaire_deja_envoye'] = 1 ;		
		$headers  = 'From: '.QUESTIONNAIRE.' <'.$info_application->mail_questionnaire.'>'."\n" ;
		$headers .= 'X-Mailler: Florian'."\n" ;				
		$corps='' ;
		$tableau = $form->afficher_donnees($info_application->num_questionnaire) ;
		//var_dump($_POST);		
		for ($i=0; $i<count($tableau); $i++) {
			if (isset($_POST[$tableau[$i]['nom_bdd']]) && ( $tableau[$i]['type']=='formulaire_texte' || $tableau[$i]['type']=='formulaire_textelong' ) ) {
				$val=$tableau[$i]['nom_bdd'] ;
				if ($_POST[$val] != '' and $_POST[$val] != FORM_CHOISIR and $_POST[$val] != FORM_NON_PRECISE) {
					$corps .= $tableau[$i]['label'].' : '.$_POST[$val]."\n"."\n" ;
				}				
			}
			elseif ( $tableau[$i]['type']=='formulaire_liste' ) {				
				$requete = 'SELECT plv_label FROM pap_liste_valeurs WHERE plv_valeur='.$_POST['liste'.$tableau[$i]['nom_bdd'].$tableau[$i]['id_source']].' AND plv_ce_liste='.$tableau[$i]['nom_bdd'].' AND plv_ce_i18n LIKE "'.$GLOBALS['_GEN_commun']['i18n'].'%"' ;     
    			$resultat = $GLOBALS['_GEN_commun']['pear_db']->query($requete) ;
    			if (DB::isError($resultat)) {
    				die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
    			}              
    			if ($resultat->numRows()>0) { 
    				$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ; 
    				$val=$ligne->plv_label ;		           	
    			}
    			else $val='';    			
				if ($val != '' and $val != FORM_CHOISIR and $val != FORM_NON_PRECISE) {
					$corps .= $tableau[$i]['label'].' : '.$val."\n"."\n" ;
				}
			}
			elseif ( $tableau[$i]['type']=='formulaire_listedatedeb' || $tableau[$i]['type']=='formulaire_listedatefin' ) {
				$val=$tableau[$i]['nom_bdd'] ;
				if (!in_array($val, array ('bf_date_debut_validite_fiche', 'bf_date_fin_validite_fiche'))) {
					if ($_POST[$val] != '') {
						$corps .= $tableau[$i]['label'].' : '.strftime('%d.%m.%Y',strtotime($_POST[$val]))."\n"."\n" ;
					}
				}		
			}			
		}
		mail($info_application->mail_questionnaire, QUESTIONNAIRE_REPONSE_AU.' : '.$nom_questionnaire, html_entity_decode($corps), $headers) ; // Envoi du mail
		$res .= $info_application->texte_questionnaire_envoye;
		return $res;
	// Cas ou l'on affiche le questionnaire
	} else {
		unset ($_SESSION['formulaire_deja_envoye']) ;
		$res .= $form->afficher_formulaire('formulaire_questionnaire', $url , $template ) ;		
	}
	return $res ;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: questionnaire.php,v $
* Revision 1.1  2007-04-19 14:51:10  florian
* application questionnaire
*
* Revision 1.3  2006/04/28 11:35:37  florian
* ajout constantes chemin
*
* Revision 1.2  2006/01/19 10:24:37  florian
* champs obligatoires pour le formulaire de saisie
*
* Revision 1.1  2005/09/22 13:28:50  florian
* Application de contact, pour envoyer des mails. Reste a faire: configuration pour choisir les destinataires dans l'annuaire.
*
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
