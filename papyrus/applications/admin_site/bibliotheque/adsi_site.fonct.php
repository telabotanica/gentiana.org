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
// CVS : $Id: adsi_site.fonct.php,v 1.42 2007-10-23 13:31:22 ddelon Exp $
/**
* Bibliotheque de fonctions d'admininistration des projets
*
* Contient un ensemble de fonctions permettant a l'application Administrateur de Papyrus, de modifier des informations
* sur les projets (=sites geres par Papyrus).
*
*@package Admin_site
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.42 $ $Date: 2007-10-23 13:31:22 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
if (GEN_FTP_UTILISE) {
    /** Inclusion bibliotheque de PEAR gerant le FTP.*/
    require_once ADSI_CHEMIN_BIBLIOTHEQUE_PEAR.'Net/FTP.php';
}

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction ADMIN_afficherListeSites()- Genere le xhtml permettant de choisir un site parmis une liste.
*
* Cette fonction fournie une liste des sites principaux geres par papyrus.
*
* @param  string   l'objet Pear DB.
* @param  string   l'url de la page � laquelle renvoyer le formulaire.
* @param  string   un message important � destination de l'utilisateur.
* return  string   le code XHTML a retourner.
*/
function ADMIN_afficherFormListeSites(&$db, $url, $message = '')
{
	
	$id_langue = $GLOBALS['_GEN_commun']['i18n']; //identifiant de la langue choisie
	
	// Langue en cours : langue choisie ou langue par defaut (principale)
	
	if (isset($id_langue) && ($id_langue!='')) {
		$langue_test=$id_langue;
	} else {
		$langue_test=GEN_I18N_ID_DEFAUT;
	}

    // Liste des sites principaux :
    // Recherche de tous les sites langue en cours
    
    $requete =  'SELECT * '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_site_01 = gs_id_site '.
                'AND gsr_id_valeur IN (102, 103) '.
                'AND gs_ce_i18n = "'.$langue_test.'" '.
                'ORDER BY gsr_ordre';
                    
    
    $resultat = $db->query($requete);
    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '' ;
    
    $liste_site=array();
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
    	
    		if ($langue_test == GEN_I18N_ID_DEFAUT) {
    			
    		  $requete_est_traduction =   'SELECT gsr_id_site_01 '.
	                       'FROM  gen_site_relation '.
	                       'WHERE '.$ligne->gs_id_site.' = gsr_id_site_02 ' .
	                  	   'AND  gsr_id_site_01 <> gsr_id_site_02 ' .
	                       'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	                                
	                                
	            $resultat_est_traduction = $db->query($requete_est_traduction);
	            (DB::isError($resultat_est_traduction))
	                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
	                : '';
	                
	   			if ( $resultat_est_traduction->numRows() == 0 ) {
    	 			$liste_site[]=$ligne;
	            }
    		}
    		else {
    			   $liste_site[]=$ligne;
    		}
    }
    $resultat->free();
    
    // Si la langue en cours n'est pas la langue par defaut, recherche des sites ayant comme langue
    // la langue par defaut, non traduits dans la langue en cours et n'etant pas des traductions
  	
  	
	if ($langue_test != GEN_I18N_ID_DEFAUT) {

    
	    $requete =  'SELECT * '.
	                'FROM gen_site, gen_site_relation '.
	                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
	                'AND gs_id_site = gsr_id_site_01 '.
	                'AND gsr_id_valeur IN (102, 103) '.
	                'AND gs_ce_i18n = "'.GEN_I18N_ID_DEFAUT.'" '.
	                'ORDER BY gs_code_num ASC';// 102 = site "principal" et 103 = site "externe"
	                
	    $resultat = $db->query($requete);
	    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	    
	    
	            
	    
	    // Recherche de tous les sites de la langue principale  qui ne sont pas traduits dans la langue en cours
	    
	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
	    	
	    		$requete_est_traduction =   'SELECT gsr_id_site_01 '.
	                                'FROM  gen_site_relation '.
	                                'WHERE '.$ligne->gs_id_site.' = gsr_id_site_02 ' .
	                                'AND  gsr_id_site_01 <> gsr_id_site_02 ' .
	                                'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	                                
	                                
	            $resultat_est_traduction = $db->query($requete_est_traduction);
	            (DB::isError($resultat_est_traduction))
	                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_est_traduction->getMessage(), $requete_est_traduction))
	                : '';
	                
	            if ( $resultat_est_traduction->numRows() == 0 ) {
	            	
		    	
					if (isset($id_langue) && ($id_langue!='')) {
						$langue_test=$id_langue;
					} else {
						$langue_test=GEN_I18N_ID_DEFAUT;
					}
				    	
		    		$requete_traduction =   'SELECT gsr_id_site_01 '.
		                                    'FROM  gen_site_relation, gen_site '.
		                                    'WHERE '.$ligne->gs_id_site.' = gsr_id_site_01 ' .
		                                    'AND gsr_id_site_02 = gs_id_site '.
		                                    'AND gs_ce_i18n = "'.$langue_test.'" '.
		                                    'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
		                                    
		            $resultat_traduction = $db->query($requete_traduction);
		            (DB::isError($resultat_traduction))
		                ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
		                : '';
		                
		            if ( $resultat_traduction->numRows() == 0 ) {
		            	$liste_site []=$ligne;
		            }
		            
		            $resultat_traduction->free();
		            
	            }
	               $resultat_est_traduction->free();
		    
	    }
	    $resultat->free();
	}
    
    
  
    //----------------------------------------------------------------------------
    // Cr�ation du formulaire
    $form = new HTML_QuickForm('form_sites', 'post', str_replace('&amp;', '&', $url));
    $tab_index = 1000;
    $squelette =& $form->defaultRenderer();
    $squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'{content}'."\n".'</form>'."\n");
    $squelette->setElementTemplate( '<li>'."\n".'{label}'."\n".'{element}'."\n".
                                    '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                    '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
                                    '</li>'."\n");
    $squelette->setRequiredNoteTemplate("\n".'<p>'."\n".'<span class="symbole_obligatoire">*</span> {requiredNote}'."\n".'</p>'."\n");
    
    $partie_site_debut =    '<fieldset>'."\n".
                            '<legend>Listes des sites</legend>'."\n".
                            '<ul>'."\n";
    $form->addElement('html', $partie_site_debut);
    
    $aso_options = array();
    foreach ($liste_site as $ligne ) {
        $aso_options[$ligne->gs_id_site] = htmlentities($ligne->gs_nom.' ('.$ligne->gs_code_alpha.')');
        
        // Affichage des traductions
        $requete_traduction =   'SELECT * '.
	                            'FROM  gen_site_relation, gen_site '.
	                            'WHERE '.$ligne->gs_id_site.' = gsr_id_site_01 ' .
	                            'AND gsr_id_site_02 <> gsr_id_site_01 '.
	                            'AND gsr_id_site_02 = gs_id_site '.
	                            'AND gsr_id_valeur = 1 ';// 1 = "avoir traduction"
	    $resultat_traduction = $db->query($requete_traduction);
        (DB::isError($resultat_traduction))
            ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_traduction->getMessage(), $requete_traduction))
            : '';
        
        while ($ligne_traduction = $resultat_traduction->fetchRow(DB_FETCHMODE_OBJECT)) {    
        	$aso_options[$ligne_traduction->gs_id_site] = '&nbsp;&nbsp;&nbsp;'.$ligne_traduction->gs_ce_i18n.":&nbsp;".htmlentities($ligne_traduction->gs_nom.' ('.$ligne_traduction->gs_code_alpha.')');
        }
        $resultat_traduction->free();
    
    }
    
    $id = 'form_sites_id_site';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.'Listes des sites : '.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    $partie_site_fin =  '</ul>'."\n".
                        '</fieldset>'."\n";
    $form->addElement('html', $partie_site_fin);
    
    $liste_bouton_debut = '<ul class="liste_bouton">'."\n";
    $form->addElement('html', $liste_bouton_debut);
    
    $id = 'form_sites_ajouter';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = 'Ajouter';
    $form->addElement('submit', $id, $label, $aso_attributs);
    
    $id = 'form_sites_modifier';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = 'Modifier';
    $form->addElement('submit', $id, $label, $aso_attributs);

    $id = 'form_sites_traduire';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = 'Traduire';
    $form->addElement('submit', $id, $label, $aso_attributs);
    
    $id = 'form_sites_supprimer';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'onclick' => 'javascript:return confirm(\''.'�tes vous s�r de vouloir supprimer ce site ?'.'\');');
    $label = 'Supprimer';
    $form->addElement('submit', $id, $label, $aso_attributs);
    
    $liste_bouton_fin = '</ul>'."\n";
    $form->addElement('html', $liste_bouton_fin);
    
    $sortie = $form->toHTML()."\n";
    
    // Titre de la page:
    $titre = 'Configuration des sites';
    
    // Construction de la page.
    return ADMIN_contruirePage($titre, $sortie, $message);
}

/** Fonction ADMIN_validerFormListesSites() - Valide les donn�es issues du formulaire de liste de sites.
*
* Cette fonction valide les donn�es du formulaire de liste de site.
*
* @param  string   l'objet pear de connexion � la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @return string   retourne les messages d'erreurs sinon rien.
*/
function ADMIN_validerFormListesSites(&$db, $aso_valeurs)
{
    $message = '';
    
    // Validation des donnees du formulaire
    if (empty($aso_valeurs['form_sites_id_site'])) {
        $message .= '<p class="pap_erreur">Vous devez d\'abord s&eacute;lectionner un site.</p>';
    }
    
    return $message;
}

/** Fonction ADMIN_afficherFormSite()- G�n�re un formulaire pour gen_site.
*
* Cette fonction retourne un formulaire pour modification ou pour ajout.
*
* @param  string   l'objet pear de connexion a la base de donnees.
* @param  string   l'url a laquelle renvoyer le formulaire.
* @param  string   le tableau contenant les valeurs du formulaire.
* @param  string   un message a destination de l'utilisateur.
* return  string   le code XHTML a retourner.
*/
function ADMIN_afficherFormSite(&$db, $url, $aso_valeurs = array(), $message = '')
{
    // Initialisation des valeurs
    $sortie = '';
    $aso_valeurs['modification'] = false;
    $aso_valeurs['traduction'] = false;
    $aso_valeurs['defaut'] = false;
    $aso_valeurs['type_site_externe'] = 0;
    // Nous cherchons a savoir si nous somme en modification
    if ((isset($aso_valeurs['form_sites_modifier']))  || (isset($aso_valeurs['form_sites_traduire'])))  {
    	if ((isset($aso_valeurs['form_sites_modifier']))) { 
        	$as_val['modification'] = true;
        	$as_val['traduction'] = false;
    	}
        else { 
        	$as_val['traduction'] = true;
        	$as_val['modification'] = false;
        }
        
        if ($as_val['traduction']) {
	        // Traduction d'un site principal uniquement :
	        
	        $requete =  'SELECT * '.
	                    'FROM gen_site_relation '.
	                    'WHERE gsr_id_site_02 = '.$aso_valeurs['form_sites_id_site'].' '.
	                    'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
	        
	        $resultat = $db->query($requete);
	        
	        if (DB::isError($resultat)) {
	            die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	        }
	
	        if ( $resultat->numRows() == 0 ) {
	        	$site_id = $aso_valeurs['form_sites_id_site'];
	        }
	        else {
	        	$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
		        $site_id = $ligne->gsr_id_site_01;
	        }
	        $resultat->free();
       		 }
        else {
          	$site_id = $aso_valeurs['form_sites_id_site'];
      	 }
	        
	        // Requete pour recuperer les informations sur le site a modifier
	        $requete =  'SELECT * '.
	                    'FROM gen_site '.
	                    'WHERE gs_id_site = '.$site_id;
	        $resultat = $db->query($requete);
	        if (DB::isError($resultat)) {
	            die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	        }
	        $aso_valeurs = $resultat->fetchRow(DB_FETCHMODE_ASSOC);
	        $site_ligne = $aso_valeurs;
	        $resultat->free();
        
        // Requete pour recuperer les informations issues des relations du site a modifier
        $requete =  'SELECT * '.
                    'FROM gen_site_relation '.
                    'WHERE gsr_id_site_01 = '.$site_id.' '.
                    'AND gsr_id_site_01 = gsr_id_site_02';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
        }
        
        $tab_type = GEN_retournerTableauTypeSiteExterne($db);
        while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ) {
            if ($ligne->gsr_id_valeur == 101) {// 101 = site par defaut
                $aso_valeurs['defaut'] = true;
            }
            foreach ($tab_type as $cle => $val) {
                if ($ligne->gsr_id_valeur == $val['id']) {// 20x = type de site externe a Papyrus
                    $aso_valeurs['type_site_externe'] = $val['id'];
                }
            }
        }
        $resultat->free();
        
        if (($as_val['modification'])) { 
        	$aso_valeurs['modification'] = true;
        	$aso_valeurs['traduction'] = false;
        }
        else { 
        	$aso_valeurs['traduction'] = true;
        	$aso_valeurs['modification'] = false;
        };
      
        
        
    } else if (isset($aso_valeurs['gs_id_site'])) {
        $aso_valeurs['modification'] = true;
    }
    // Debogage :
    //$GLOBALS['_DEBOGAGE_'] .= '<pre>'.print_r($aso_valeurs, true).'</pre>';
    //-------------------------------------------------------------------------------------------------------------------
    // Information precedent le formulaire (en modification)
    if ((isset($aso_valeurs['modification'])||isset($aso_valeurs['traduction']))&&isset($aso_valeurs['gs_id_site'])) {
        $sortie .= '<p>'.'Identifiant de ce site : '.'<span id="adsi_site_id">'.$aso_valeurs['gs_id_site'].'</span></p>'."\n";
    }
    //-------------------------------------------------------------------------------------------------------------------
    // Cr�ation du formulaire
    $form = new HTML_QuickForm('site', 'post', str_replace('&amp;', '&', $url));
    $tab_index = 1000;
    $squelette =& $form->defaultRenderer();
    $squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
	$squelette->setElementTemplate( '<p class="formulaire_element"><span class="form_label">'."\n".
		'{label}'."\n".
		'<!-- BEGIN required --><span style="color:red; width:5px; margin:0; padding:0;">*</span><!-- END required -->'."\n".		
		'</span>'."\n".'{element}'."\n".
		'<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
		'</p>'."\n");
	$squelette->setGroupElementTemplate('<p style="display:inline">{element}</p>', 'form_boutons');
	$squelette->setRequiredNoteTemplate("\n".'<p class="symbole_obligatoire">*&nbsp;:&nbsp;{requiredNote}</p>'."\n");
	//Note pour les erreurs javascript
	$form->setJsWarnings('Erreur de saisie', 'Veuillez verifier vos informations saisies');
    // Note de fin de formulaire
    $form->setRequiredNote('Indique les champs obligatoires');
    
//    $squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'{content}'."\n".'</form>'."\n");
//    $squelette->setElementTemplate(  '<li>'."\n".
//                                    '{label}'."\n".
//                                    '{element}'."\n".
//                                    '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
//                                    '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
//                                    '</li>'."\n");
//    $squelette->setGroupElementTemplate('{label}'."\n".
//                                        '{element}'."\n".
//                                        '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
//                                        '&nbsp;'."\n"
//                                        , 'double');
//    $squelette->setRequiredNoteTemplate("\n".'<p><span class="symbole_obligatoire">*</span> {requiredNote}</p>'."\n");
//    
    $partie_site_debut = '<fieldset>'."\n".'<legend>Configuration du site</legend>'."\n";
    $form->addElement('html', $partie_site_debut);
    
    if ($aso_valeurs['modification'] || $aso_valeurs['traduction']) {
        $form->addElement('hidden', 'gs_id_site');
        $form->addElement('hidden', 'modification');
        $form->addElement('hidden', 'traduction');
    }
    
    $id = 'gs_nom';
    $aso_attributs = array('id'=>$id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 100, 'value' => 'nom du site');
    $label = '<label for="'.$id.'">'.'Nom du site : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule($id, 'Un nom est requis pour le site !', 'required', '', 'client');
    
    $id = 'gs_code_alpha';
    $aso_attributs = array('id'=>$id, 'tabindex' => $tab_index++, 'size' => 20, 'maxlength' => 20, 'value' => 'site_01');
    $label = '<label for="'.$id.'">'.'Code alphanum&eacute;rique : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule('gs_code_alpha', 'Un code alphanum&eacute;rique est requis pour le site !', 'required', '', 'client');
    
    $id = 'gs_code_num';
    $aso_attributs = array('id'=>$id, 'tabindex' => $tab_index++, 'size' => 20, 'maxlength' => 20, 'value' => 1);
    $label = '<label for="'.$id.'">'.'Code num&eacute;rique : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule('gs_code_num', 'Un code num&eacute;rique est requis pour le site !', 'required', '', 'client');
    
    $id = 'gs_raccourci_clavier';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'size' => 1, 'maxlength' => 1, 'value' => 'Z');
    $label = '<label for="'.$id.'">'.'Raccourci clavier : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    // Requete pour connaitre les identifications dispo
    $requete =  'SELECT * '.
                'FROM gen_site_auth '.
                'WHERE gsa_id_auth != 0';
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    $aso_options = array();
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ) {
        // Test pour conna�tre le type d'authentification.
        $type = '';
        if ($ligne->gsa_ce_type_auth == '1' ) {
            $type = 'Base de donn&eacute;es';
        } else if ($ligne->gsa_ce_type_auth == '2' ) {
            $type = 'LDAP';
        }
        $aso_options[$ligne->gsa_id_auth] = $ligne->gsa_nom.' ('.$type.')';
    }
    $resultat->free();
    
    
    $id = 'gs_ce_auth';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.'Identification : '.'</label>';
    if (isset($aso_valeurs['gs_ce_auth'])) {
	    $s = &$form->createElement('select', $id , $label, "", $aso_attributs);
    	$s->loadArray($aso_options,$aso_valeurs['gs_ce_auth']);
    	$form->addElement($s);
    }
    else {
	    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    } 
    
    // En modification nous affichons la liste des squelettes disponibles dans
    // le dossier du site.
    if ($aso_valeurs['modification'] || $aso_valeurs['traduction']) {
        $aso_options = array();
        if (!GEN_FTP_UTILISE) {
            $chemin_squelettes =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                    $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_SQUELETTE.GEN_SEP;
            $dossier = opendir($chemin_squelettes);
            while(($fichier = readdir($dossier)) !== false) {
                if ($fichier != '.' && $fichier != '..') {
                    $chemin_type = $chemin_squelettes.GEN_SEP.$fichier;
                    if (filetype($chemin_type) != 'dir') {
                        $aso_options[$fichier] = $fichier;
                    }
                }
            }
        } else {
            // ouverture des squelettes present dans le dossier du site 
            // creation de l'objet pear ftp
            $objet_pear_ftp = new Net_FTP(PAP_FTP_SERVEUR, PAP_FTP_PORT);
            // creation de la connexion
            $ftp_conn = $objet_pear_ftp->connect(PAP_FTP_SERVEUR, PAP_FTP_PORT);
            // identification
            $ftp_login_result = $objet_pear_ftp->login(PAP_FTP_UTILISATEUR, PAP_FTP_MOT_DE_PASSE);
            // Gestion des erreurs ftp
            if ((PEAR::isError($ftp_conn) || PEAR::isError($ftp_login_result))) {
                return ('ERREUR Papyrus admin : impossible de se connecter par ftp.<br />'.
                    'Serveur : '. GEN_FTP_SERVEUR .'<br />'.
                    'Utilisateur : '. GEN_FTP_UTILISATEUR .'<br />'.
                    'Ligne n&deg; : '. __LINE__ .'<br />'.
                    'Fichier n&deg; : '. __FILE__ .'<br />');
                    //'Message erreur de connection : '.$ftp_conn->getMessage().'<br />'.
                    //'Message erreur de login : '.$ftp_login_result->getMessage());
            }
            $chemin_squelettes =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                    $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_SQUELETTE.GEN_SEP;
            $tab_squelettes = $objet_pear_ftp->ls($chemin_squelettes);
            $aso_options = array();
            if (PEAR::isError($tab_squelettes)) {
                return ('ERREUR Papyrus admin : impossible d\'acc&eacute; aux fichiers par ftp.<br />'.
                    'Chemin : '. $chemin_squelettes .'<br />'.
                    'Ligne n&deg; : '. __LINE__ .'<br />'.
                    'Fichier n&deg; : '. __FILE__ .'<br />'.
                    'Message : '. $tab_squelettes->getMessage());
            }
            for ($i = 0; $i < count($tab_squelettes) ; $i++) {
                if ($tab_squelettes[$i]['is_dir'] == false) {
                    $aso_options[$tab_squelettes[$i]['name']] = $tab_squelettes[$i]['name'];
                }
            }
            $objet_pear_ftp->disconnect();
        }
        
        // Verification de la presence de squelettes
        if (count($aso_options) == 0) {
            $aso_options['Aucun squelette'] = 'Aucun squelette';
        }
        
        $id = 'gs_fichier_squelette';
        $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
        $label = '<label for="'.$id.'">'.'Squelette : '.'</label>';
        $s = &$form->createElement('select', $id , $label, "", $aso_attributs);
    	$s->loadArray($aso_options,$aso_valeurs['gs_fichier_squelette']);
    	$form->addElement($s);
    
    }
    
    // Requete pour connaitre les internationalisation dispo
    
    if (!$aso_valeurs['modification'] && !$aso_valeurs['traduction']) {
    	$requete =  'SELECT * '.
        	        'FROM gen_i18n ';
    }
    	else  {
    		
    		
    		if ($aso_valeurs['traduction']) {
    			
    		// Recherche liste des sites deja traduits 
    		
	    		 $requete =  'SELECT distinct gs_ce_i18n  '.
                'FROM gen_site_relation, gen_site '.
                'WHERE gsr_id_site_01 = ' .$site_ligne['gs_id_site'] .' '.
                'AND gs_id_site = gsr_id_site_02  '.
                'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
                
                
			    $resultat = $db->query($requete) ;
			    if (DB::isError($resultat)) {
			        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
			    }
			    $not_in_langue='';
			    if ( $resultat->numRows() == 0 ) {
					$not_in_langue="gi_id_i18n not in('".$site_ligne['gs_ce_i18n']."')";
			    }
			    else {
			    	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
    	 					$not_in_langue="'".$ligne->gs_ce_i18n."'".",".$not_in_langue;
    	 					$end="'".$ligne->gs_ce_i18n."'";
    					}
    					if ($not_in_langue) {
			    			$not_in_langue="'".$site_ligne['gs_ce_i18n']."'".",".$not_in_langue;
			    			$not_in_langue=' gi_id_i18n not in('.$not_in_langue.$end.')';
			    		}
			    		else {
			    			$not_in_langue="gi_id_i18n not in('".$site_ligne['gs_ce_i18n']."')";
			    		}
			    }
				$resultat->free();		    
    		
	    		$requete =  "SELECT * FROM gen_i18n where ".$not_in_langue;
    		}
    		else 
    		{
    			$requete =  "SELECT * FROM gen_i18n where  gi_id_i18n =('".$site_ligne['gs_ce_i18n']."')";
    		}
    }
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    $aso_options = array();
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ) {
        $aso_options[$ligne->gi_id_i18n] = $ligne->gi_id_i18n;
    }
    $resultat->free();
    $id = 'gs_ce_i18n';
    $aso_attributs = array('id' => $id, 'tabindex' => $tab_index++);
    $label = '<label for="'.$id.'">'.'Langue : '.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    $id = 'defaut';
    $aso_attributs = array('id' => $id, 'tabindex' => $tab_index++);
    if (isset($aso_valeurs[$id]) && $aso_valeurs[$id] === true) {
        $aso_attributs['checked'] = 'checked';
    }
    $label = '<label for="'.$id.'">'.'En faire le site par d&eacute;faut : '.'</label>';
    $form->addElement('checkbox', $id, $label, null, $aso_attributs);
    
    // Groupe site externe
    $tab_type = GEN_retournerTableauTypeSiteExterne($db);
    $aso_options = array('0' => 'Aucun');
    foreach ($tab_type as $cle => $val) {
        $aso_options[$val['id']] = $val['intitule'];
    }
    
    $id = 'type_site_externe';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++);
    $label = '<label>'.'Type de site externe : '.'</label>';
    $form->addElement('select', $id, $label, $aso_options, $aso_attributs);
    
    $id = 'gs_url';
    $aso_attributs = array('id' => $id, 'tabindex' => $tab_index++,'size' => 35, 'maxlength' => 255, 'value' => 'http://');
    $label = '<label>'.'URL du site externe : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    
    $partie_site_fin = "\n".'</fieldset>'."\n";
    $form->addElement('html', $partie_site_fin);
    
    $partie_entete_debut = '<fieldset>'."\n".'<legend>Ent&egrave;te par d&eacute;faut des pages du site</legend>'."\n";
    $form->addElement('html', $partie_entete_debut);
    
    $id = 'gs_titre';
    $aso_attributs = array('id'=>$id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255, 'value' => ADSI_TITRE_SITE);
    $label = '<label for="'.$id.'">'.ADSI_TITRE_SITE.' : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule('gs_titre', 'Un titre est requis pour le site !', 'required', '', 'client');
    
    $id = 'gs_mots_cles';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 3, 'cols' => 45);
    $label = '<label for="'.$id.'">'.'Mots-cl&eacute;s : '.'</label>';
    $zone_mots_cles = $form->createElement('textarea', $id, $label, $aso_attributs);
    $zone_mots_cles->setValue('mots-cl&eacute;s du site');
    $form->addElement($zone_mots_cles);
    $form->addRule($id, 'Des mots cl&eacute;s sont requis pour le site !', 'required', '', 'client');
    
    $id = 'gs_description';
    $aso_attributs = array('id'=> $id, 'tabindex' => $tab_index++, 'rows' => 3, 'cols' => 45);
    $label = '<label for="'.$id.'">'.'Description du contenu : '.'</label>';
    $zone = $form->createElement('textarea', $id, $label, $aso_attributs);
    $zone->setValue('description du site');
    $form->addElement($zone);
    $form->addRule($id, 'Une description est requise pour le site !', 'required', '', 'client');
    
    $id = 'gs_auteur';
    $aso_attributs = array('id'=>$id, 'tabindex' => $tab_index++, 'size' => 35, 'maxlength' => 255, 'value' => 'auteur du site');
    $label = '<label for="'.$id.'">'.'Auteur du site : '.'</label>';
    $form->addElement('text', $id, $label, $aso_attributs);
    $form->addRule('gs_auteur', 'Un auteur est requis pour le site !', 'required', '', 'client');  
    
    $partie_entete_fin = "\n".'</fieldset>'."\n";
    $form->addElement('html', $partie_entete_fin);
    
    if ($aso_valeurs['modification'] ||  $aso_valeurs['traduction']) {
        // Requete pour connaitre les informations sur l'administrateur ayant fait la derni�re modif
        $requete_admin =    'SELECT * '.
                            'FROM gen_annuaire '.
                            'WHERE ga_id_administrateur = '.$aso_valeurs['gs_ce_admin'];
        $resultat_admin = $db->query($requete_admin);
        if (DB::isError($resultat_admin)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_admin->getMessage(), $requete_admin));
        }
        $ligne_admin = $resultat_admin->fetchRow(DB_FETCHMODE_OBJECT);
        if (isset($ligne_admin)) {
        	$info_admin =   '<p class="info">Site cr&eacute;&eacute; le '.$aso_valeurs['gs_date_creation'].'. Derni&egrave;re modification par '.
                        $ligne_admin->ga_prenom.' '.$ligne_admin->ga_nom.'.'.'</p>';
        	$form->addElement('html', $info_admin);
        	$form->addElement('hidden', 'gs_ce_admin');
        	$form->addElement('hidden', 'gs_date_creation');
        }
        
        // Titre de la page:
        if ($aso_valeurs['modification']) {
        	$titre = 'Modifier un site';
        	$bouton_validation = '<input type="submit" id="site_modifier" name="site_modifier" value="Enregistrer" />';
        }
        else {
        	$titre = 'Traduire un site';
        	$bouton_validation = '<input type="submit" id="site_traduire" name="site_traduire" value="Enregistrer" />';
        }
        
    } else {
        // Titre de la page:
        $titre = 'Ajouter un site';
        // Bouton validant le formulaire
        $bouton_validation = '<input type="submit" id="site_enregistrer" name="site_enregistrer" value="Enregistrer" />';
    }
    $bouton_annuler =   '<input type="submit" id="form_annuler" name="form_annuler" value="Annuler" />';
    $bouton_effacer =   '<input type="reset" id="effacer" name="effacer" value="Effacer" />';
    $boutons =  '<p>'."\n".
                $bouton_validation."\n".
                $bouton_annuler."\n".
                $bouton_effacer."\n".
                '</p>'."\n";
    $form->addElement('html', $boutons);
    
    // Instanciation des valeurs par defaut du formulaire
    $form->setDefaults($aso_valeurs);
    
    // Javascript pour la validation cote client
    $regles_javascript = $form->getValidationScript();
    
    // Note de fin de formulaire
    $form->setRequiredNote('Indique les champs obligatoires');
    $sortie .= $form->toHTML()."\n";
    
    // Construction de la page.
    return ADMIN_contruirePage($titre, $sortie, $message);
}

/** Fonction ADMIN_validerFormAjouterSite() - Valide les donnees issues du formulaire pour gen_site.
*
* Cette fonction valide les donnees a ajouter dans la table gen_site.
*
* @param  string   l'objet pear de connexion a la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @return string   retourne les messages d'erreurs sinon rien.
*/
function ADMIN_validerFormSite(&$db, $aso_valeurs)
{
    $message = '';
    
    // Validation des donnees du formulaire
    if (empty($aso_valeurs['gs_nom'])) {
        $message .= '<p class="pap_erreur">Le champ "Nom" ne doit pas &ecirc;tre vide.</p>';
    }
    if (empty($aso_valeurs['gs_code_alpha'])) {
        $message .= '<p class="pap_erreur">Le champ "Code alphanum&eacute;rique" ne doit pas &ecirc;tre vide.</p>';
    }
    if ($aso_valeurs['gs_code_num'] == '') {
        // Note: ne pas utilisez empty() car si on veut saisir 0, cela est conscid�r� comme vide!
        $message .= '<p class="pap_erreur">Le champ "Code num&eacute;rique" ne doit pas &ecirc;tre vide.</p>';
    }
    if (preg_match('/^[0-9]+$/',$aso_valeurs['gs_code_num']) == 0) {
        $message .= '<p class="pap_erreur">Le champ "Code num&eacute;rique" doit contenir un nombre.</p>';
    }
    
    // Requete pour verifier l'absence du code numerique et alphanumerique de la table gen_site
    // en mode creation uniquement !
   
   
    if (!isset($aso_valeurs['site_modifier'])) $aso_valeurs['site_modifier']=0;
    if (!isset($aso_valeurs['site_traduire'])) $aso_valeurs['site_traduire']=0;
    
    if (@!$aso_valeurs['site_modifier'] && @!$aso_valeurs['site_traduire'] ) {
    
	    $requete =  'SELECT gs_code_alpha, gs_code_num '.
	                'FROM gen_site, gen_site_relation '.
	                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
	                'AND gsr_id_site_01 = gs_id_site '.
	                'AND gsr_id_valeur IN (102, 103) ';// 102 = site "principal" et 103 = site "externe"
	    $requete .= (isset($aso_valeurs['gs_id_site'])) ? 'AND gs_id_site != '.$aso_valeurs['gs_id_site'] : '';
	    
	    
	    $resultat = $db->query($requete);
	    if (DB::isError($resultat)) {
	        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
	    }
	    
	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ) {
	        if ($ligne->gs_code_num == $aso_valeurs['gs_code_num']) {
	            $message .= '<p class="pap_erreur">La valeur "'.$aso_valeurs['gs_code_num'].'" pour le champ "Code num&eacute;rique" existe d&eacute;j&agrave;.</p>';
	        }
	        if ($ligne->gs_code_alpha == $aso_valeurs['gs_code_alpha']) {
	            $message .= '<p class="pap_erreur">La valeur "'.$aso_valeurs['gs_code_alpha'].'" pour le champ "Code alphanum&eacute;rique" existe d&eacute;j&agrave;.</p>';
	        }
	    }
	    
	    $resultat->free();
	    
    }
    
    else {
    // Refuser si plus de traduction disponible !	
    }
    
    if (empty($aso_valeurs['gs_titre'])) {
        $message .= '<p class="pap_erreur">Le champ "Titre" ne doit pas &ecirc;tre vide.</p>';
    }
    if (empty($aso_valeurs['gs_mots_cles'])) {
        $message .= '<p class="pap_erreur">Le champ "Mots cl&eacute;s" ne doit pas &ecirc;tre vide.</p>';
    }
    if (empty($aso_valeurs['gs_description'])) {
        $message .= '<p class="pap_erreur">Le champ "Description" ne doit pas &ecirc;tre vide.</p>';
    }
    if (empty($aso_valeurs['gs_auteur'])) {
        $message .= '<p class="pap_erreur">Le champ "Auteur" ne doit pas &ecirc;tre vide.</p>';
    }
    if (isset($aso_valeurs['externe']) && $aso_valeurs['externe'] == 1 && (empty($aso_valeurs['gs_url']) || $aso_valeurs['gs_url'] == 'http://')) {
        $message .= '<p class="pap_erreur">'.'Vous avez d&eacute;sign&eacute; ce site comme &eacute;tant externe. Il est n&eacute;cessaire de saisir son URL!'.'</p>';
    }
    if (isset($aso_valeurs['externe']) && $aso_valeurs['externe'] == 0 && (!empty($aso_valeurs['gs_url']) && $aso_valeurs['gs_url'] != 'http://')) {
        $message .= '<p class="pap_erreur">'.'Vous avez saisie une l\'url : '.$aso_valeurs['gs_url'].'<br />'.
                    'Vous conscid&eacute;rez donc ce site comme &eacute;tant externe. Il est n&eacute;cessaire de cocher la case "oui"!'.'</p>';
    }
    return $message;
}

/** Fonction ADMIN_enregistrerSite() - Ajoute un site � Papyrus.
*
* Cette fonction ajoute le site � Papyrus, c'est � dire :
* - 1. Cr�ation des r�pertoire du projet en fonction du nom et des sous-r�pertoires.
* - 2. Insertion d'une ligne dans la table "gen_site".
* - 3. Insertion d'une ligne dans la table "gen_site_auth" et ses tables li�es si n�cessaire.
*
* @param  string   l'objet pear de connexion � la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @param  int      identifiant de l'administrateur r�alisant cette cr�ation.
* @return string retourne un message en cas de succ�s ou d'�chec.
*/
function ADMIN_enregistrerSite(&$db, $aso_valeurs, $id_admin)
{
    // Nous verifions si nous avons a faire a un site externe.
    $id_type_site = '102';// par defaut on conscid�re que c'est un site "principal"
    if (isset($aso_valeurs['type_site_externe']) && $aso_valeurs['type_site_externe'] > 0 && !empty($aso_valeurs['gs_url']) && $aso_valeurs['gs_url'] != 'http://') {
        $id_type_site = '103';// c'est un site "externe"
    }
    
    // Ajout des repertoires des sites "principaux" soit par manipulation de fichier soit par FTP en fonction de la constante definie
    // par l'utilisateur dans le fichier de config avancee.
    $tab_rep_langue = array(GEN_DOSSIER_GENERIQUE, $aso_valeurs['gs_ce_i18n']);
    $tab_rep_site = array(  GEN_DOSSIER_IMAGE,
                            GEN_DOSSIER_STYLE,
                            GEN_DOSSIER_SCRIPT,
                            GEN_DOSSIER_SQUELETTE,
                            GEN_DOSSIER_DOC);
    if (!GEN_FTP_UTILISE && $id_type_site != '103') {
        foreach ($tab_rep_langue as $nom_rep_langue) {
            foreach ($tab_rep_site as $nom_rep_site) {
                $chemin_repertoire =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                        $nom_rep_langue.GEN_SEP.$nom_rep_site;
                $vieux_umask = umask(0);
                $resultat = creerDossier($chemin_repertoire, 0777, GEN_SEP);
                umask($vieux_umask);
                if ($resultat == false) {
                    $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le r&eacute;pertoire.<br />'.
                                'R&eacute;pertoire : '. $chemin_repertoire .'<br />'.
                                'Ligne n&deg; : '. __LINE__ .'<br />'.
                                'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                    return $message;
                }
            }
        }
        $chemin_squelette_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                    GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        $chemin_squelette_site =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                    $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        if (!copy($chemin_squelette_defaut, $chemin_squelette_site)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le fichier de squellete par d&eacute;faut.<br />'.
                        'Fichier : '. $chemin_squelette_site .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
        $chemin_style_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        $chemin_style_site =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        if (!copy($chemin_style_defaut, $chemin_style_site)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le fichier de style par d&eacute;faut.<br />'.
                        'Fichier : '. $chemin_style_site .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
    } else if (GEN_FTP_UTILISE && $id_type_site != '103') {  // 103 est le type "site externe"
        // Creation d'une connection ftp avec Net_FTP de PEAR
        // voir http://pear.php.net/manual/fr/package.networking.net-ftp.php
        
        // creation de l'objet pear ftp
        $objet_pear_ftp = new Net_FTP(PAP_FTP_SERVEUR, PAP_FTP_PORT);
        // creation de la connexion
        $ftp_conn = $objet_pear_ftp->connect(PAP_FTP_SERVEUR, PAP_FTP_PORT);
        // identification
        $ftp_login_result = $objet_pear_ftp->login(PAP_FTP_UTILISATEUR, PAP_FTP_MOT_DE_PASSE);
        // Gestion des erreurs ftp
        if ((PEAR::isError($ftp_conn) || PEAR::isError($ftp_login_result))) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de se connecter par ftp.<br />'.
                        'Serveur : '. PAP_FTP_SERVEUR .'<br />'.
                        'Utilisateur : '. PAP_FTP_UTILISATEUR .'<br />'.
                        'Erreur connexion : '.$ftp_conn->getMessage().'<br />'.
                        'Erreur login : '.$ftp_login_result->getMessage().'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /><p>';
            return $message;
        }
        $resultat = $objet_pear_ftp->mkdir(PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha']) ;
        
       if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr�er le r�pertoire par ftp.<br />'.
                        'R&eacute;pertoire : '. PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'] .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Informations de debogage : '.$resultat->getDebugInfo().'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
        //$objet_pear_ftp->cd(PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha']) ;
        foreach ($tab_rep_langue as $nom_rep_langue) {
            $objet_pear_ftp->mkdir(PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.$nom_rep_langue) ;
            foreach ($tab_rep_site as $nom_rep_site) {
                $chemin_repertoire =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.$nom_rep_langue.GEN_SEP.$nom_rep_site;
                
                $resultat = $objet_pear_ftp->mkdir($chemin_repertoire) ;
                if (PEAR::isError($resultat)) {
                    $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le r&eacute;pertoire par ftp.<br />'.
                                'R&eacute;pertoire : '. $chemin_repertoire .'<br />'.
                                'Erreur origine : '. $resultat->getMessage() .'<br />'.
                                'Informations de debogage : '.$resultat->getDebugInfo().'<br />'.
                                'Ligne n&deg; : '. __LINE__ .'<br />'.
                                'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                    return $message;
                }
            }
        }
        $chemin_squelette_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                    GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        $chemin_squelette_site =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                    $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        $resultat = $objet_pear_ftp->put($chemin_squelette_defaut, $chemin_squelette_site, true, FTP_BINARY);
        if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier le squelette defaut par ftp.<br />'.
                        'Fichier origine : '. $chemin_squelette_defaut .'<br />'.
                        'Fichier copi&eacute; : '. $chemin_squelette_site .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
        }
        $chemin_style_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        $chemin_style_site =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        $resultat = $objet_pear_ftp->put($chemin_style_defaut, $chemin_style_site, true, FTP_BINARY);
        if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier les styles defaut par ftp.<br />'.
                        'Fichier origine : '. $chemin_style_defaut .'<br />'.
                        'Fichier copi&eacute; : '. $chemin_style_site .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
        }
        
        $chemin_image_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_IMAGE.GEN_SEP;
        $chemin_image_site =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_IMAGE.GEN_SEP;
        $resultat = $objet_pear_ftp->putRecursive($chemin_image_defaut, $chemin_image_site, false, FTP_BINARY);
        if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier le dossier images par ftp.<br />'.
                        'Fichier origine : '. $chemin_image_defaut .'<br />'.
                        'Fichier copi&eacute; : '. $chemin_image_site .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
        }

        
        
        $objet_pear_ftp->disconnect();
    }
    
    $id_site = SQL_obtenirNouveauId($db, 'gen_site','gs_id_site');
    if ($id_site == false) {
        $message = '<p class="erreur"> ERREUR papyrus admin : impossible de r&eacute;cup&eacute;rer un identifiant pour la table gen_site.<br />'.
                    'Ligne n&deg; : '. __LINE__ .'<br />'.
                    'Fichier n&deg; : '. __FILE__ .'<br /></p>';
        return $message;
    }
    
    // Modification de la requete si nous avons a faire a un site externe.
    $requete_complement = ', gs_url = NULL';
    if (isset($aso_valeurs['type_site_externe']) && $aso_valeurs['type_site_externe'] > 0 && !empty($aso_valeurs['gs_url']) && $aso_valeurs['gs_url'] != 'http://') {
        $requete_complement = ', gs_url = "'.$aso_valeurs['gs_url'].'"';
    }
    
    // Requete d'insertion des infos d'un site dans gen_site
    $requete =  'INSERT INTO gen_site '.
                'SET gs_id_site = '.$id_site.', '.
                'gs_ce_i18n = "'.$aso_valeurs['gs_ce_i18n'].'", '.
                'gs_ce_auth = '.$aso_valeurs['gs_ce_auth'].', '.
                'gs_fichier_squelette = "defaut.html", '.
                'gs_code_num = '.$aso_valeurs['gs_code_num'].', '.
                'gs_code_alpha = "'.$aso_valeurs['gs_code_alpha'].'", '.
                'gs_nom = "'.$aso_valeurs['gs_nom'].'", '.
                'gs_raccourci_clavier = "'.$aso_valeurs['gs_raccourci_clavier'].'", '.
                'gs_titre = "'.$aso_valeurs['gs_titre'].'", '.
                'gs_mots_cles = "'.$aso_valeurs['gs_mots_cles'].'", '.
                'gs_description = "'.$aso_valeurs['gs_description'].'", '.
                'gs_auteur = "'.$aso_valeurs['gs_auteur'].'", '.
                'gs_date_creation = "'.date('Y-m-d H:i:s').'", '.
                'gs_ce_admin = '.$id_admin.
                $requete_complement;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    
    // Recherche du nouveau numero d'ordre de ce site "principal" ou "externe"
    $requete =  'SELECT MAX(gsr_ordre) AS max_ordre '.
                'FROM gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur IN (102, 103) ';// 102 = site "principal" et 103 = site "externe"
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $nouvel_ordre = $ligne->max_ordre + 1;
    
    // Requete d'insertion des relations dans gen_site_relation
    $requete =  'INSERT INTO gen_site_relation '.
                'SET gsr_id_site_01 = '.$id_site.', '.
                'gsr_id_site_02 = '.$id_site.', '.
                'gsr_id_valeur = '.$id_type_site.', '.
                'gsr_ordre = '.$nouvel_ordre;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
    }
    
    // Gestion du site par d�faut
    if (isset($aso_valeurs['defaut']) && $aso_valeurs['defaut'] == 1) {
        $requete_supr_defaut =  'DELETE FROM gen_site_relation '.
                                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                                'AND gsr_id_valeur = 101 ';// 101 = site par "defaut"
        $resultat_supr_defaut = $db->query($requete_supr_defaut);
        if (DB::isError($resultat_supr_defaut)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_defaut->getMessage(), $requete_supr_defaut));
        }
        
        // Requete d'insertion de la relations site par defaut
        $requete =  'INSERT INTO gen_site_relation '.
                    'SET gsr_id_site_01 = '.$id_site.', '.
                    'gsr_id_site_02 = '.$id_site.', '.
                    'gsr_id_valeur = 101, '.
                    'gsr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
    }
    
    // Gestion des sites externes
    if ($id_type_site == '103') {
        // Requete d'insertion des relations dans gen_site_relation
        $requete =  'INSERT INTO gen_site_relation '.
                    'SET gsr_id_site_01 = '.$id_site.', '.
                    'gsr_id_site_02 = '.$id_site.', '.
                    'gsr_id_valeur = '.$aso_valeurs['type_site_externe'].', '.
                    'gsr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
    }
    
    $message = '<p class="pap_info">'.'Succ&eacute;s de l\'ajout du site.'.'</p>';
    return $message;
}

/** Fonction ADMIN_traduireSite() - Traduire un site papyrus
*
* Cette fonction traduit un site a Papyrus, c'est a dire :
* - 1. Creation des repertoire du projet en fonction du nom et des sous-repertoires.
* - 2. Insertion d'une ligne dans la table "gen_site".
* - 3. Insertion d'une ligne dans la table "gen_site_auth" et ses tables liees si necessaire.
*
* @param  string   l'objet pear de connexion a la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @param  int      identifiant de l'administrateur realisant cette cr�ation.
* @return string retourne un message en cas de succes ou d'echec.
*/

function ADMIN_traduireSite(&$db, $aso_valeurs, $id_admin)
{
    // Nous verifions si nous avons a faire a un site externe.
    $id_type_site = '102';// par defaut on considere que c'est un site "principal"
    if (isset($aso_valeurs['type_site_externe']) && $aso_valeurs['type_site_externe'] > 0 && !empty($aso_valeurs['gs_url']) && $aso_valeurs['gs_url'] != 'http://') {
        $id_type_site = '103';// c'est un site "externe"
    }
    
    // Ajout des repertoires des sites "principaux" soit par manipulation de fichier soit par FTP en fonction de la constante definie
    // par l'utilisateur dans le fichier de config avancee.
    $tab_rep_langue = array(GEN_DOSSIER_GENERIQUE, $aso_valeurs['gs_ce_i18n']);
    $tab_rep_site = array(  GEN_DOSSIER_IMAGE,
                            GEN_DOSSIER_STYLE,
                            GEN_DOSSIER_SCRIPT,
                            GEN_DOSSIER_SQUELETTE,
                            GEN_DOSSIER_DOC);
    if (!GEN_FTP_UTILISE && $id_type_site != '103') {
        foreach ($tab_rep_langue as $nom_rep_langue) {
            foreach ($tab_rep_site as $nom_rep_site) {
                $chemin_repertoire =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                        $nom_rep_langue.GEN_SEP.$nom_rep_site;
                $vieux_umask = umask(0);
                $resultat = creerDossier($chemin_repertoire, 0777, GEN_SEP);
                umask($vieux_umask);
                if ($resultat == false) {
                    $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le r&eacute;pertoire.<br />'.
                                'R&eacute;pertoire : '. $chemin_repertoire .'<br />'.
                                'Ligne n&deg; : '. __LINE__ .'<br />'.
                                'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                    return $message;
                }
            }
        }
        $chemin_squelette_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                    GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        $chemin_squelette_site =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                    $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        if (!copy($chemin_squelette_defaut, $chemin_squelette_site)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le fichier de squellete par d&eacute;faut.<br />'.
                        'Fichier : '. $chemin_squelette_site .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
        $chemin_style_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        $chemin_style_site =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        if (!copy($chemin_style_defaut, $chemin_style_site)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er le fichier de style par d�faut.<br />'.
                        'Fichier : '. $chemin_style_site .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
        
        $chemin_image_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_IMAGE.GEN_SEP;
        $chemin_image_site =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_IMAGE.GEN_SEP;
                                
		if (!copy($chemin_image_defaut, $chemin_image_site)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr&eacute;er les fichhiers image par defaut.<br />'.
                        'Fichier : '. $chemin_style_site .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
                                                
    } else if (GEN_FTP_UTILISE && $id_type_site != '103') {  // 103 est le type "site externe"
        // Cr�ation d'une connection ftp avec Net_FTP de PEAR
        // voir http://pear.php.net/manual/fr/package.networking.net-ftp.php
        
        // cr�ation de l'objet pear ftp
        $objet_pear_ftp = new Net_FTP(PAP_FTP_SERVEUR, PAP_FTP_PORT);
        // cr�ation de la connexion
        $ftp_conn = $objet_pear_ftp->connect(PAP_FTP_SERVEUR, PAP_FTP_PORT);
        // identification
        $ftp_login_result = $objet_pear_ftp->login(PAP_FTP_UTILISATEUR, PAP_FTP_MOT_DE_PASSE);
        // Gestion des erreurs ftp
        if ((PEAR::isError($ftp_conn) || PEAR::isError($ftp_login_result))) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de se connecter par ftp.<br />'.
                        'Serveur : '. PAP_FTP_SERVEUR .'<br />'.
                        'Utilisateur : '. PAP_FTP_UTILISATEUR .'<br />'.
                        'Erreur connexion : '.$ftp_conn->getMessage().'<br />'.
                        'Erreur login : '.$ftp_login_result->getMessage().'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /><p>';
            return $message;
        }
        $objet_pear_ftp->mkdir(PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha']) ;
        
        //$objet_pear_ftp->cd(PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha']) ;
        foreach ($tab_rep_langue as $nom_rep_langue) {
            $objet_pear_ftp->mkdir(PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.$nom_rep_langue) ;
            foreach ($tab_rep_site as $nom_rep_site) {
                $chemin_repertoire =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.$nom_rep_langue.GEN_SEP.$nom_rep_site;
                
                $resultat = $objet_pear_ftp->mkdir($chemin_repertoire) ;
                if (PEAR::isError($resultat)) {
                    $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de cr�er le r�pertoire par ftp.<br />'.
                                'R&eacute;pertoire : '. $chemin_repertoire .'<br />'.
                                'Erreur origine : '. $resultat->getMessage() .'<br />'.
                                'Ligne n&deg; : '. __LINE__ .'<br />'.
                                'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                    return $message;
                }
            }
        }
        $chemin_squelette_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                    GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        $chemin_squelette_site =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                    $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_SQUELETTE.GEN_SEP.GEN_FICHIER_SQUELETTE;
        $resultat = $objet_pear_ftp->put($chemin_squelette_defaut, $chemin_squelette_site, true, FTP_BINARY);
        if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier le squelette defaut par ftp.<br />'.
                        'Fichier origine : '. $chemin_squelette_defaut .'<br />'.
                        'Fichier copi&eacute; : '. $chemin_squelette_site .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
        }
        $chemin_style_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        $chemin_style_site =    PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_STYLE.GEN_SEP.GEN_FICHIER_STYLE;
        $resultat = $objet_pear_ftp->put($chemin_style_defaut, $chemin_style_site, true, FTP_BINARY);
        if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier les styles defaut par ftp.<br />'.
                        'Fichier origine : '. $chemin_style_defaut .'<br />'.
                        'Fichier copi&eacute; : '. $chemin_style_site .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
        }
        
        $chemin_image_defaut =  PAP_CHEMIN_RACINE.GEN_CHEMIN_COMMUN.GEN_DOSSIER_GENERIQUE.GEN_SEP.
                                GEN_DOSSIER_IMAGE.GEN_SEP;
        $chemin_image_site =    PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP.
                                $aso_valeurs['gs_ce_i18n'].GEN_SEP.GEN_DOSSIER_IMAGE.GEN_SEP;
        $resultat = $objet_pear_ftp->putRecursive($chemin_image_defaut, $chemin_image_site, false, FTP_BINARY);
        if (PEAR::isError($resultat)) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier le dossier images par ftp.<br />'.
                        'Fichier origine : '. $chemin_image_defaut .'<br />'.
                        'Fichier copi&eacute; : '. $chemin_image_site .'<br />'.
                        'Erreur origine : '. $resultat->getMessage() .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
        }

        $objet_pear_ftp->disconnect();
    }
    
    $id_site = SQL_obtenirNouveauId($db, 'gen_site','gs_id_site');
    
    if ($id_site == false) {
        $message = '<p class="erreur"> ERREUR G�n�sia admin : impossible de r�cup�rer un identifiant pour la table gen_site.<br />'.
                    'Ligne n&deg; : '. __LINE__ .'<br />'.
                    'Fichier n&deg; : '. __FILE__ .'<br /></p>';
        return $message;
    }
    
    // Modification de la requete si nous avons � faire � un site externe.
    $requete_complement = ', gs_url = NULL';
    if (isset($aso_valeurs['type_site_externe']) && $aso_valeurs['type_site_externe'] > 0 && !empty($aso_valeurs['gs_url']) && $aso_valeurs['gs_url'] != 'http://') {
        $requete_complement = ', gs_url = "'.$aso_valeurs['gs_url'].'"';
    }
    
    // Requete d'insertion des infos d'un site dans gen_site
    $requete =  'INSERT INTO gen_site '.
                'SET gs_id_site = '.$id_site.', '.
                'gs_ce_i18n = "'.$aso_valeurs['gs_ce_i18n'].'", '.
                'gs_ce_auth = '.$aso_valeurs['gs_ce_auth'].', '.
                'gs_fichier_squelette = "defaut.html", '.
                'gs_code_num = '.$aso_valeurs['gs_code_num'].', '.
                'gs_code_alpha = "'.$aso_valeurs['gs_code_alpha'].'", '.
                'gs_nom = "'.$aso_valeurs['gs_nom'].'", '.
                'gs_raccourci_clavier = "'.$aso_valeurs['gs_raccourci_clavier'].'", '.
                'gs_titre = "'.$aso_valeurs['gs_titre'].'", '.
                'gs_mots_cles = "'.$aso_valeurs['gs_mots_cles'].'", '.
                'gs_description = "'.$aso_valeurs['gs_description'].'", '.
                'gs_auteur = "'.$aso_valeurs['gs_auteur'].'", '.
                'gs_date_creation = "'.date('Y-m-d H:i:s').'", '.
                'gs_ce_admin = '.$id_admin.
                $requete_complement;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    
    // Recherche du nouveau num�ro d'ordre de ce site "principal" ou "externe"
    $requete =  'SELECT MAX(gsr_ordre) AS max_ordre '.
                'FROM gen_site_relation '.
                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur IN (102, 103) ';// 102 = site "principal" et 103 = site "externe"
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    $ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    $nouvel_ordre = $ligne->max_ordre + 1;
    
    // Requete d'insertion des relations dans gen_site_relation
    
    $requete =  'INSERT INTO gen_site_relation '.
                'SET gsr_id_site_01 = '.$id_site.', '.
                'gsr_id_site_02 = '.$id_site.', '.
                'gsr_id_valeur = '.$id_type_site.', '.
                'gsr_ordre = '.$nouvel_ordre;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
    }
    
    // Traduction : Requete d'insertion des relations dans gen_site_relation

    $requete =  'SELECT MAX(gsr_ordre) AS max_ordre '.
                'FROM gen_site_relation '.
                'WHERE gsr_id_site_01 = ' .$aso_valeurs['gs_id_site'] .' '.
                'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    if ( $resultat->numRows() == 0 ) {
	      $nouvel_ordre = 1;
    }
    else {
    	$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
    	$nouvel_ordre = $ligne->max_ordre + 1;
    }

    // 1 : insertion information traduction pere (si inexistant)
    
    $requete =  'SELECT * '.
                'FROM gen_site_relation '.
                'WHERE gsr_id_site_01 = ' .$aso_valeurs['gs_id_site'] .' '.
                'AND gsr_id_site_01 = gsr_id_site_02 '.
                'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
                
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    if ( $resultat->numRows() == 0 ) {
    
		$requete =  'INSERT INTO gen_site_relation '.
		            'SET gsr_id_site_01 = '. $aso_valeurs['gs_id_site'].', '.
		            'gsr_id_site_02 = '.$aso_valeurs['gs_id_site'].', '.
		            'gsr_id_valeur = 1, '. // 1 = "avoir traduction"
		            'gsr_ordre = 1 ';
		$resultat = $db->query($requete);
		if (DB::isError($resultat)) {
		    die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
		}
		$nouvel_ordre = 2;
    }    


    // 2 : insertion information traduction site en cours (si inexistant ?) (et la mise a jour, c'est ailleurs
    // dans les mises � jour
    
    $requete =  'INSERT INTO gen_site_relation '.
                'SET gsr_id_site_01 = '. $aso_valeurs['gs_id_site'].', '.
                'gsr_id_site_02 = '.$id_site.', '.
                'gsr_id_valeur = 1, '. // 1 = "avoir traduction"
                'gsr_ordre = '.$nouvel_ordre;
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
    }
        
  
    // Gestion du site par d�faut
    if (isset($aso_valeurs['defaut']) && $aso_valeurs['defaut'] == 1) {
        $requete_supr_defaut =  'DELETE FROM gen_site_relation '.
                                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                                'AND gsr_id_valeur = 101 ';// 101 = site par "defaut"
        $resultat_supr_defaut = $db->query($requete_supr_defaut);
        if (DB::isError($resultat_supr_defaut)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_defaut->getMessage(), $requete_supr_defaut));
        }
        
        // Requete d'insertion de la relations site par d�faut
        $requete =  'INSERT INTO gen_site_relation '.
                    'SET gsr_id_site_01 = '.$id_site.', '.
                    'gsr_id_site_02 = '.$id_site.', '.
                    'gsr_id_valeur = 101, '.
                    'gsr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
    }
    
    // Gestion des sites externes
    if ($id_type_site == '103') {
        // Requete d'insertion des relations dans gen_site_relation
        $requete =  'INSERT INTO gen_site_relation '.
                    'SET gsr_id_site_01 = '.$id_site.', '.
                    'gsr_id_site_02 = '.$id_site.', '.
                    'gsr_id_valeur = '.$aso_valeurs['type_site_externe'].', '.
                    'gsr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
    }
    
    $message = '<p class="pap_info">'.'Succ&eacute;s de l\'ajout du site.'.'</p>';
    return $message;
}



/** Fonction ADMIN_modifierSite() - Modifie un site de Papyrus.
*
* Cette fonction modifie un site g�r� par Papyrus.
* Il faudrait aussi pouvoir renomer le dossier du site si le code alpha change.
*
* @param  string   l'objet pear de connexion � la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @param  int      identifiant de l'administrateur r�alisant cette modification.
* @return string retourne un message en cas de succ�s ou d'�chec.
*/
function ADMIN_modifierSite(&$db, $aso_valeurs, $id_admin)
{
    // Initialisation de variables
    $message_complement = '';
    
    // R�cup�ration de l'ancien code alphanum�rique
    $requete =  'SELECT gs_code_alpha '.
                'FROM gen_site '.
                'WHERE gs_id_site = '.$aso_valeurs['gs_id_site'];
    $ancien_code_alphnum = $db->getOne($requete);
    if (DB::isError($ancien_code_alphnum)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $ancien_code_alphnum->getMessage(), $requete) );
    }
    
    // Nous v�rifions si nous avons � faire � un site externe.
    $id_type_site = '102';// par d�faut on conscid�re que c'est un site "principal"
    $requete_complement = ', gs_url = NULL ';
    if (isset($aso_valeurs['type_site_externe']) && $aso_valeurs['type_site_externe'] > 0 && !empty($aso_valeurs['gs_url']) && $aso_valeurs['gs_url'] != 'http://') {
        $requete_complement = ', gs_url = "'.$aso_valeurs['gs_url'].'" ';
        $id_type_site = '103';// c'est un site "externe"
    }
    
    // Si le code alphanum�rique � chang� et que nous n'avons pas � faire � un site externe.
    if ($aso_valeurs['gs_code_alpha'] != $ancien_code_alphnum && $id_type_site != 103) {
        if (!GEN_FTP_UTILISE) {
            $chemin_site_ancien = PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$ancien_code_alphnum.GEN_SEP;
            $chemin_site_nouveau = PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP;
            if (!rename($chemin_site_ancien, $chemin_site_nouveau)) {
                $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de changer le nom du dossier du site.<br />'.
                            'Ancien nom : '. $chemin_site_ancien .'<br />'.
                            'Nouveau nom : '. $chemin_site_nouveau .'<br />'.
                            'Ligne n&deg; : '. __LINE__ .'<br />'.
                            'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                return $message;
            }
        } else {
            $chemin_site_ancien = PAP_FTP_RACINE.GEN_CHEMIN_SITES.$ancien_code_alphnum.GEN_SEP;
            $chemin_site_nouveau = PAP_FTP_RACINE.GEN_CHEMIN_SITES.$aso_valeurs['gs_code_alpha'].GEN_SEP;
            // Cr�ation d'une connection ftp avec Net_FTP de PEAR
            // voir http://pear.php.net/manual/fr/package.networking.net-ftp.php
            // cr�ation de l'objet pear ftp
            $objet_pear_ftp = new Net_FTP(PAP_FTP_SERVEUR, PAP_FTP_PORT);
            // cr�ation de la connexion
            $ftp_conn = $objet_pear_ftp->connect(PAP_FTP_SERVEUR, PAP_FTP_PORT);
            // identification
            $ftp_login_result = $objet_pear_ftp->login(PAP_FTP_UTILISATEUR, PAP_FTP_MOT_DE_PASSE);
            // Gestion des erreurs ftp
            if ((PEAR::isError($ftp_conn) || PEAR::isError($ftp_login_result))) {
                $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de se connecter par ftp.<br />'.
                            'Serveur : '. PAP_FTP_SERVEUR .'<br />'.
                            'Utilisateur : '. PAP_FTP_UTILISATEUR .'<br />'.
                            'Erreur connexion : '.$ftp_conn->getMessage().'<br />'.
                            'Erreur login : '.$ftp_login_result->getMessage().'<br />'.
                            'Ligne n&deg; : '. __LINE__ .'<br />'.
                            'Fichier n&deg; : '. __FILE__ .'<br /><p>';
                return $message;
            }
            $resultat = $objet_pear_ftp->putRecursive($chemin_site_ancien, $chemin_site_nouveau, false, FTP_BINARY);
            if (PEAR::isError($resultat)) {
                $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de copier l\'ancien dossier du site.<br />'.
                            'Dossier site ancien : '. $chemin_site_ancien .'<br />'.
                            'Dossier site nouveau : '. $chemin_site_nouveau .'<br />'.
                            'Erreur origine : '. $resultat->getMessage() .'<br />'.
                            'Ligne n&deg; : '. __LINE__ .'<br />'.
                            'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                    return $message;
            }
            // On utilise la racine FTP pour rm
            $chemin_site_ancien = PAP_FTP_RACINE.GEN_CHEMIN_SITES.$ancien_code_alphnum.GEN_SEP;
            // Changement du niveau d'erreur pour �viter les Notices PHP dues � Net_FTP
            error_reporting(E_PARSE);
            $resultat = $objet_pear_ftp->rm($chemin_site_ancien, true);
            if (PEAR::isError($resultat)) {
                $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de supprimer l\'ancien dossier du site.<br />'.
                            'Dossier site ancien : '. $chemin_site_ancien .'<br />'.
                            'Erreur origine : '. $resultat->getMessage() .'<br />'.
                            'Ligne n&deg; : '. __LINE__ .'<br />'.
                            'Fichier n&deg; : '. __FILE__ .'<br /></p>';
                    return $message;
            }
            // Retour au niveau d'erreur d�finit dans le fichier de config de Papyrus
            error_reporting(GEN_DEBOGAGE_NIVEAU);
            $objet_pear_ftp->disconnect();
        }
    }
    
    // Requete de mise � jour des infos d'un site dans gen_site
    $requete =  'UPDATE gen_site '.
                'SET gs_ce_i18n = "'.$aso_valeurs['gs_ce_i18n'].'", '.
                'gs_ce_auth = '.$aso_valeurs['gs_ce_auth'].', '.
                'gs_fichier_squelette = "'.$aso_valeurs['gs_fichier_squelette'].'", '.
                'gs_code_num = '.$aso_valeurs['gs_code_num'].', '.
                'gs_code_alpha = "'.$aso_valeurs['gs_code_alpha'].'", '.
                'gs_nom = "'.$aso_valeurs['gs_nom'].'", '.
                'gs_raccourci_clavier = "'.$aso_valeurs['gs_raccourci_clavier'].'", '.
                'gs_titre = "'.$aso_valeurs['gs_titre'].'", '.
                'gs_mots_cles = "'.$aso_valeurs['gs_mots_cles'].'", '.
                'gs_description = "'.$aso_valeurs['gs_description'].'", '.
                'gs_auteur = "'.$aso_valeurs['gs_auteur'].'", '.
                'gs_date_creation = "'.$aso_valeurs['gs_date_creation'].'", '.
                'gs_ce_admin = '.$id_admin.' '.
                $requete_complement.
                'WHERE gs_id_site = '.$aso_valeurs['gs_id_site'];
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    // Gestion du site externe
    if ($id_type_site == 103) {
        // V�rification pour voir si nous avons � faire � une transformation d'un site "principal" en site "externe"
        $requete =  'SELECT COUNT(gsr_id_site_01) AS nbre_relation '.
                    'FROM gen_site_relation '.
                    'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                    'AND gsr_id_site_01 = '.$aso_valeurs['gs_id_site'].' '.
                    'AND gsr_id_valeur = 102 ';// 102 = site "principal"
        $nbre_relation = $db->getOne($requete);
        if (DB::isError($nbre_relation)) {
            die( BOG_afficherErreurSql(__FILE__, __LINE__, $nbre_relation->getMessage(), $requete) );
        }
        
        // Nous supprimons l'ancienne relation si n�cessaire
        if ($nbre_relation >= 1) {
            $requete_supr_ext = 'DELETE FROM gen_site_relation '.
                                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                                'AND gsr_id_site_01 = '.$aso_valeurs['gs_id_site'].' '.
                                'AND gsr_id_valeur = 102 ';// 102 = site "principal"
            $resultat_supr_ext = $db->query($requete_supr_ext);
            if (DB::isError($resultat_supr_ext)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_ext->getMessage(), $requete_supr_ext));
            }
            $message_complement =   'Le site "principal" a �t� transform� en site "externe". Si n�cessaire, veuillez '.
                                    'supprimer manuellement par FTP, le dossier contenant les fichiers de ce site sur '.
                                    'le serveur!';
        }
        
        // V�rification pour voir si le site est d�j� "externe"
        $requete =  'SELECT COUNT(gsr_id_site_01) AS nbre_relation '.
                    'FROM gen_site_relation '.
                    'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                    'AND gsr_id_site_01 = '.$aso_valeurs['gs_id_site'].' '.
                    'AND gsr_id_valeur = 103 ';// 103 = site "externe"
        $nbre_relation = $db->getOne($requete);
        if (DB::isError($nbre_relation)) {
            die( BOG_afficherErreurSql(__FILE__, __LINE__, $nbre_relation->getMessage(), $requete) );
        }
        if ($nbre_relation == 0) {
            // Requete d'insertion de la relations site "externe"
            $requete =  'INSERT INTO gen_site_relation '.
                        'SET gsr_id_site_01 = '.$aso_valeurs['gs_id_site'].', '.
                        'gsr_id_site_02 = '.$aso_valeurs['gs_id_site'].', '.
                        'gsr_id_valeur = '.$id_type_site.', '.
                        'gsr_ordre = NULL ';
            $resultat = $db->query($requete);
            if (DB::isError($resultat)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
            }
        }
        
        // Ajout du type de site externe
        $requete =  'INSERT INTO gen_site_relation '.
                    'SET gsr_id_site_01 = '.$aso_valeurs['gs_id_site'].', '.
                    'gsr_id_site_02 = '.$aso_valeurs['gs_id_site'].', '.
                    'gsr_id_valeur = '.$aso_valeurs['type_site_externe'].', '.
                    'gsr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
        
    }
    
    // Gestion du site par d�faut
    if (isset($aso_valeurs['defaut']) && $aso_valeurs['defaut'] == 1) {
        $requete_supr_defaut =  'DELETE FROM gen_site_relation '.
                                'WHERE gsr_id_site_01 = gsr_id_site_02 '.
                                'AND gsr_id_valeur = 101 ';// 101 = site par "defaut"
        $resultat_supr_defaut = $db->query($requete_supr_defaut);
        if (DB::isError($resultat_supr_defaut)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_defaut->getMessage(), $requete_supr_defaut));
        }
        
        // Requete d'insertion de la relations site par d�faut
        $requete =  'INSERT INTO gen_site_relation '.
                    'SET gsr_id_site_01 = '.$aso_valeurs['gs_id_site'].', '.
                    'gsr_id_site_02 = '.$aso_valeurs['gs_id_site'].', '.
                    'gsr_id_valeur = 101, '.
                    'gsr_ordre = NULL ';
        $resultat = $db->query($requete);
        if (DB::isError($resultat)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
        }
    }
    
    $message = '<p class="pap_info">'.'Succ�s de la modification du site.'.'</p>';
    $message .= '<p class="pap_info">'.$message_complement.'</p>';
    return $message;
}

/** Fonction ADMIN_supprimerSite() - Ajoute un site � Papyrus.
*
* Cette fonction ajoute le site � Papyrus, c'est � dire :
* - 1. Cr�ation des r�pertoire du projet en fonction du nom et des sous-r�pertoires.
* - 2. Insertion d'une ligne dans la table "gen_site".
* - 3. Insertion d'une ligne dans la table "gen_site_auth" et ses tables li�es si n�cessaire.
*
* @param  string   l'objet pear de connexion � la base de donn�es.
* @param  string   le tableau contenant les valeurs du formulaire.
* @param  int      identifiant de l'administrateur r�alisant cette cr�ation.
* @return string retourne un message en cas de succ�s ou d'�chec.
*/
function ADMIN_supprimerSite(&$db, $aso_valeurs)
{
    // Recherche du coda alpha du site principal afin de pouvoir d�truire ses r�pertoires
    $requete =  'SELECT gs_code_alpha '.
                'FROM gen_site '.
                'WHERE gs_id_site = '.$aso_valeurs['form_sites_id_site'];
    $code_alpha_site_principal = $db->getOne($requete);
    if (DB::isError($code_alpha_site_principal)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $code_alpha_site_principal->getMessage(), $requete));
    }
    
    // Nous v�rifions que le site n'a pas le code alphanum correspondant au site par d�faut d'administration (admin).
    if ($code_alpha_site_principal == GEN_SITE_DEFAUT) {
        $message =  '<p class="pap_erreur">Si vous voulez vraiment supprimer le site d\'administration par d�faut de '.
                    'Papyrus, veuillez commencer par changer la valeur de son code alphanum&eacute;rique. Vous pourrez '.
                    'ensuite le supprimer via cette interface.</p>';
        return $message;
    }
    
    // Recherche des diff�rents sites li�s � celui que l'on veut d�truire
    // Cela comprend le site � d�truire lui m�me car il poss�de la relations
    // sur lui meme "site principale".
    $requete =  'SELECT gs_id_site '.
                'FROM gen_site, gen_site_relation '.
                'WHERE gsr_id_site_01 = '.$aso_valeurs['form_sites_id_site'].' '.
                'AND gsr_id_site_02 = gs_id_site ';
    $resultat = $db->query($requete);
    if (DB::isError($resultat)) {
        die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete));
    }
    
    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
        // Requete de suppression des sites li�s dans gen_site
        $requete_supr_site =    'DELETE FROM gen_site '.
                                'WHERE gs_id_site = '.$ligne->gs_id_site;
        $resultat_supr_site = $db->query($requete_supr_site);
        if (DB::isError($resultat_supr_site)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_site->getMessage(), $requete_supr_site));
        }
        
        // Requete de suppression des relations des sites � d�truire
        $requete_supr_site_relation =   'DELETE FROM gen_site_relation '.
                                        'WHERE gsr_id_site_01 = '.$ligne->gs_id_site;
        $resultat_supr_site_relation = $db->query($requete_supr_site_relation);
        if (DB::isError($resultat_supr_site_relation)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_site_relation->getMessage(), $requete_supr_site_relation));
        }
        
        // Recherche des diff�rents menus li�s au site � d�truire
        $requete_menu = 'SELECT gm_id_menu '.
                        'FROM gen_menu '.
                        'WHERE gm_ce_site = '.$ligne->gs_id_site;
        $resultat_menu = $db->query($requete_menu) ;
        if (DB::isError($resultat_menu)) {
            die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_menu->getMessage(), $requete_menu));
        }
        while ($ligne_menu = $resultat_menu->fetchRow(DB_FETCHMODE_OBJECT)) {
            // Requete de suppression des des menus
            $requete_supr_menu =   'DELETE FROM gen_menu '.
                                            'WHERE gm_id_menu = '.$ligne_menu->gm_id_menu;
            $resultat_supr_menu = $db->query($requete_supr_menu);
            if (DB::isError($resultat_supr_menu)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_menu->getMessage(), $requete_supr_menu));
            }
            // Requete de suppression des relations des menus
            $requete_supr_menu_relation =   'DELETE FROM gen_menu_relation '.
                                            'WHERE gmr_id_menu_01 = '.$ligne_menu->gm_id_menu;
            $resultat_supr_menu_relation = $db->query($requete_supr_menu_relation);
            if (DB::isError($resultat_supr_menu_relation)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_menu_relation->getMessage(), $requete_supr_menu_relation));
            }
            
            // Requete de suppression des contenus des menus
            $requete_supr_menu_contenu =   'DELETE FROM gen_menu_contenu '.
                                            'WHERE gmc_ce_menu = '.$ligne_menu->gm_id_menu;
            $resultat_supr_menu_contenu = $db->query($requete_supr_menu_contenu);
            if (DB::isError($resultat_supr_menu_contenu)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_menu_contenu->getMessage(), $requete_supr_menu_contenu));
            }
            
            // Requete de suppression des ulr alternatives des menus
            $requete_supr_menu_url_alt =   'DELETE FROM gen_menu_url_alternative '.
                                            'WHERE gmua_ce_menu = '.$ligne_menu->gm_id_menu;
            $resultat_supr_menu_url_alt = $db->query($requete_supr_menu_url_alt);
            if (DB::isError($resultat_supr_menu_url_alt)) {
                die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat_supr_menu_url_alt->getMessage(), $requete_supr_menu_url_alt));
            }
        }
        $resultat_menu->free();
    }
    $resultat->free();
    
    // Suppression des r�pertoires du site
    if (!GEN_FTP_UTILISE) {
        $chemin_repertoire = PAP_CHEMIN_RACINE.GEN_CHEMIN_SITES.$code_alpha_site_principal;
        $resultat = supprimerDossier($chemin_repertoire, GEN_SEP);
        if (!$resultat) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de supprimer le r&eacute;pertoire.<br />'.
                        'R&eacute;pertoire : '. $chemin_repertoire .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
            return $message;
        }
    } else {
        // Cr�ation d'une connection ftp avec Net_FTP de PEAR
        // voir http://pear.php.net/manual/fr/package.networking.net-ftp.php
        
        // cr�ation de l'objet pear ftp
        $objet_pear_ftp = new Net_FTP(PAP_FTP_SERVEUR, PAP_FTP_PORT);
        // cr�ation de la connexion
        $ftp_conn = $objet_pear_ftp->connect(PAP_FTP_SERVEUR, PAP_FTP_PORT);
        // identification
        $ftp_login_result = $objet_pear_ftp->login(PAP_FTP_UTILISATEUR, PAP_FTP_MOT_DE_PASSE);
        // Gestion des erreurs ftp
        if ((PEAR::isError($ftp_conn) || PEAR::isError($ftp_login_result))) {
            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de se connecter par ftp.<br />'.
                        'Erreur connexion : '.$ftp_conn->getMessage().'<br />'.
                        'Erreur login : '.$ftp_login_result->getMessage().'<br />'.
                        'Serveur : '. PAP_FTP_SERVEUR .'<br />'.
                        'Utilisateur : '. PAP_FTP_UTILISATEUR .'<br />'.
                        'Ligne n&deg; : '. __LINE__ .'<br />'.
                        'Fichier n&deg; : '. __FILE__ .'<br /><p>';
            return $message;
        }
        // Changement du niveau d'erreur pour �viter les Notices PHP dues �  Net_FTP
        error_reporting(E_PARSE);
        $chemin_repertoire = PAP_FTP_RACINE.GEN_CHEMIN_SITES.$code_alpha_site_principal.'/';
        
        if ($code_alpha_site_principal!='') {
	        $resultat = $objet_pear_ftp->rm($chemin_repertoire, true);
	        if (PEAR::isError($resultat)) {
	            $message =  '<p class="pap_erreur"> ERREUR Papyrus admin : impossible de supprimer le r&eacute;pertoire par ftp.<br />'.
	                        'Erreur ftp : '.$resultat->getMessage().'<br />'.
	                        'R&eacute;pertoire : '. $chemin_repertoire .'<br />'.
	                        'Ligne n&deg; : '. __LINE__ .'<br />'.
	                        'Fichier n&deg; : '. __FILE__ .'<br /></p>';
	            return $message;
	        }
        }
        $objet_pear_ftp->disconnect();
        // Retour au niveau d'erreur d�finit dans le fichier de config de Papyrus
        error_reporting(GEN_DEBOGAGE_NIVEAU);
    }
    $message = '<p class="pap_info">Succ&eacute;s de la suppression du site.</p>';
    return $message;
}


function ADMIN_verifier_traduction_possible(&$db, $aso_valeurs) {
	
		
	// 	Traduction d'un site principal uniquement :
    
    $requete =  'SELECT gsr_id_site_01, gs_ce_i18n '.
                'FROM gen_site_relation, gen_site '.
                'WHERE gsr_id_site_02 = '.$aso_valeurs['form_sites_id_site'].' '.
                'AND gs_id_site = gsr_id_site_01  '.
                'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
    
    $resultat = $db->query($requete);
    
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }

    if ( $resultat->numRows() == 0 ) {
    	$site_id = $aso_valeurs['form_sites_id_site'];
    }
    else {
    	$ligne_site = $resultat->fetchRow(DB_FETCHMODE_OBJECT);
        $site_id = $ligne_site->gsr_id_site_01;
    }
    
		
	 $requete =  'SELECT distinct gs_ce_i18n '.
    'FROM gen_site_relation, gen_site '.
    'WHERE gsr_id_site_01 = ' . $site_id .' '.
    'AND gs_id_site = gsr_id_site_02  '.
    'AND gsr_id_valeur =1  '; // 1 = "avoir traduction"
    
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    $not_in_langue='';
    if ( $resultat->numRows() == 0 ) {
		$not_in_langue="gi_id_i18n not in('".$ligne_site->gs_ce_i18n."')";    
    }
    else {
    	    while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
				$not_in_langue="'".$ligne->gs_ce_i18n."'".",".$not_in_langue;
				$end="'".$ligne->gs_ce_i18n."'";
			}
    		$not_in_langue=' gi_id_i18n not in('.$not_in_langue.$end.')';
    }
	$resultat->free();		    

	$requete =  "SELECT * FROM gen_i18n where ".$not_in_langue;
	
    $resultat = $db->query($requete) ;
    if (DB::isError($resultat)) {
        die( BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete) );
    }
    
    $retour = $resultat->numRows();
    $resultat->free();
    
    $message='';
    if ($retour == 0) {
    	  $message = '<p class="pap_erreur">Plus de traduction possible pour ce site </p>';
    }
    return  $message;
}
    
// +- Fin du code source  --------------------------------------------------------------------------------+
/*
* $Log: adsi_site.fonct.php,v $
* Revision 1.42  2007-10-23 13:31:22  ddelon
* Ajout copie images lors traduction d'un site
*
* Revision 1.41  2007-10-21 16:44:37  ddelon
* Pb Pap chemin
*
* Revision 1.40  2007-10-04 12:57:37  ddelon
* retablisssement chemin ftp dans traduction site
*
* Revision 1.39  2007-06-26 14:18:53  florian
* amélioration des formulaires des différentes applis de l'interface d'administration afin de les simplifier
*
* Revision 1.38  2007-06-25 12:15:06  alexandre_tb
* merge from narmer
*
* Revision 1.37  2007/04/24 13:27:57  alexandre_tb
* encodage
*
* Revision 1.36  2007/04/20 13:48:31  alexandre_tb
* nettoyage accent
*
* Revision 1.35  2007/04/20 10:42:42  neiluj
* suite oubli, fix des derniers bugs FTP
*
* Revision 1.34  2007/04/20 09:21:41  neiluj
* correction bug ftp création/suppression/modification de site
* (changé PAP_FTP_RACINE en PAP_CHEMIN_RACINE)
* voir compatibilité chroot() du serveur FTP)
*
* Revision 1.33  2007/04/19 15:34:35  neiluj
* préparration release (livraison) "Narmer" - v0.25
*
* Revision 1.32  2006/10/16 15:49:06  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.31  2006/09/12 09:54:02  ddelon
* Affichage des identifications disponibles lors de la création d'un site. Un bug faisait que l'affichage de l'identification par défaut ne fonctionnait plus en creation.
*
* Revision 1.30  2006/07/19 13:57:35  ddelon
* Bug suppression de site
*
* Revision 1.29  2006/03/23 20:24:58  ddelon
* *** empty log message ***
*
* Revision 1.28  2006/03/15 23:44:19  ddelon
* Gestion site
*
* Revision 1.27  2006/03/15 23:35:25  ddelon
* Gestion site
*
* Revision 1.26  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.25.2.2  2006/02/28 14:02:10  ddelon
* Finition multilinguisme
*
* Revision 1.25.2.1  2006/01/19 21:26:20  ddelon
* Multilinguisme site + bug ftp
*
* Revision 1.25  2005/10/17 13:48:59  jp_milcent
* Ajout d'un espace apr�s le texte "Derni�re modification par".
*
* Revision 1.24  2005/09/23 14:32:54  florian
* compatibilité XHTML + correction interface
*
* Revision 1.23  2005/09/20 17:01:22  ddelon
* php5 et bugs divers
*
* Revision 1.22  2005/05/27 16:06:16  jpm
* Gestion des infos sur l'admin modifiant les infos.
*
* Revision 1.21  2005/04/08 13:29:04  jpm
* Utiliation de r�f�rences.
* Correction du double &amp; dans les urls du formulaire.
*
* Revision 1.20  2005/03/08 11:17:47  jpm
* Suppression de l'inclusion d'un fichier inutile.
*
* Revision 1.19  2005/02/28 11:07:00  jpm
* Modification des auteurs.
*
* Revision 1.18  2005/02/28 10:59:07  jpm
* Modification des commentaires et copyright.
*
* Revision 1.17  2005/02/17 17:51:11  florian
* Correction bug FTP
*
* Revision 1.16  2005/02/17 16:44:55  florian
* correction du bug sur les sites par d�faut
*
* Revision 1.15  2005/01/04 19:52:50  alex
* correction de bug de copie de r�pertoire r�cursif de PEAR.
*
* Revision 1.14  2004/12/03 19:22:53  jpm
* Gestion des types de sites externes g�r�s par Papyrus.
*
* Revision 1.13  2004/12/03 16:37:34  jpm
* Correction d'un bogue qui emp�cher la mise � jour des url des sites externes.
*
* Revision 1.12  2004/12/01 17:22:58  jpm
* Ajout d'une confirmation javascript pour la suppression d'un site.
*
* Revision 1.11  2004/11/30 16:43:51  jpm
* Correction de bogues.
*
* Revision 1.10  2004/11/29 17:05:28  jpm
* Correction d'un bogue concernat les cases � cocher.
*
* Revision 1.9  2004/11/26 13:13:51  jpm
* Mise en commentaire de variable pass�e dans un message d'erreur car elles semblent provoquer un bogue et ne sont pas obligatoire.
*
* Revision 1.8  2004/11/03 17:59:59  jpm
* Corrections bogues erreurs variable inconnue.
*
* Revision 1.7  2004/10/26 18:41:28  jpm
* Gestion des sites externes � Papyrus.
*
* Revision 1.6  2004/10/22 17:25:31  jpm
* Changement du nom de la class CSS d'erreur.
*
* Revision 1.5  2004/10/19 15:57:55  jpm
* Am�lioration de la gestion des fichiers sur le serveur.
* Ajout d'une contrainte pour �viter la suppression par erreur du site par d�faut.
*
* Revision 1.4  2004/10/18 18:27:41  jpm
* Correction probl�mes FTP et manipulation de fichiers.
*
* Revision 1.3  2004/09/23 16:51:27  jpm
* Ajout d'informations suppl�mentaires sur les messages d'erreur.
*
* Revision 1.2  2004/07/06 17:08:01  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 14:28:46  jpm
* Changement de nom de G�n�sia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.20  2004/05/10 14:32:14  jpm
* Changement du titre.
*
* Revision 1.19  2004/05/10 12:23:39  jpm
* Modification formulaire.
*
* Revision 1.18  2004/05/07 16:33:53  jpm
* Am�lioration des formulaires.
*
* Revision 1.17  2004/05/07 07:22:51  jpm
* Ajout de la gestion des modification et suppression de site.
* Am�lioration de la cr�ation des sites.
*
* Revision 1.16  2004/04/30 16:22:53  jpm
* Poursuite de l'administration des sites.
*
* Revision 1.14  2004/04/02 15:58:39  jpm
* Modification fonction liste des projets.
*
* Revision 1.13  2004/04/01 11:21:41  jpm
* Ajout et modification de commentaires pour PhpDocumentor.
*
* Revision 1.12  2004/03/24 20:01:02  jpm
* Traduction, mise en forme, ajout de commentaire pour les fonctions listProjects() et updateProject().
*
* Revision 1.11  2004/03/24 10:06:01  jpm
* Ajout des commentaires d'ent�te.
* D�but mise en conformit� avec la convention de codage.
* D�but traitement de la fonction listant les projets.
*
*
*/
?>
