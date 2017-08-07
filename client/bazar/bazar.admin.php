<?php
//vim: set expandtab tabstop=4 shiftwidth=4:

// Copyright (C) 1999-2004 Tela Botanica (accueil@tela-botanica.org)
//
// Ce logiciel est un programme informatique servant � g�rer du contenu et des
// applications web.
                                                                                                      
// Ce logiciel est r�gi par la licence CeCILL soumise au droit fran�ais et
// respectant les principes de diffusion des logiciels libres. Vous pouvez
// utiliser, modifier et/ou redistribuer ce programme sous les conditions
// de la licence CeCILL telle que diffus�e par le CEA, le CNRS et l'INRIA 
// sur le site "http://www.cecill.info".

// En contrepartie de l'accessibilit� au code source et des droits de copie,
// de modification et de redistribution accord�s par cette licence, il n'est
// offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
// seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
// titulaire des droits patrimoniaux et les conc�dants successifs.

// A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
// associ�s au chargement,  � l'utilisation,  � la modification et/ou au
// d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
// donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
// manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
// avertis poss�dant  des  connaissances  informatiques approfondies.  Les
// utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
// logiciel � leurs besoins dans des conditions permettant d'assurer la
// s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
// � l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

// Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
// pris connaissance de la licence CeCILL, et que vous en avez accept� les
// termes.
// ----
// CVS : $Id: bazar.admin.php,v 1.2 2007-04-20 09:57:21 florian Exp $

/**
* Papyrus : Programme d'administration du bazar
*
* La page contient l'appel aux fonctions de l'application de v�rification de l'installation puis
* l'appel du fichier r�alisant l'initialisation. Enfin, l'appel du fichier r�alisant le rendu et 
* retournant la page au navigateur client.
*
*@package Bazar
//Auteur original :
*@author            Florian SCHMITT <florian.schmitt@laposte.net>
*@copyright         Tela-Botanica 2000-2007
*@version           $Revision: 1.2 $
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENT�TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

include_once 'configuration/baz_config.inc.php'; //fichier de configuration de Bazar
//appel du fichier de constantes des langues
include_once 'langues/baz_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php'; 


// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+

class Bazar_Admin {
    var $objet_pear_auth;
    var $objet_pear_db;
    var $objet_pear_url;
    var $sortie_xhtml;
    
    /** Fonction redigerContenu() - Affiche le formulaire de r?action
    *
    *
    *   @return  string  Le HTML
    */
    function afficherContenuCorps()
    {                
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation des attributs
        $this->objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
        $this->objet_pear_db = $GLOBALS['_GEN_commun']['pear_db'];
        $this->objet_pear_url = $GLOBALS['_GEN_commun']['url'];
        $this->sortie_xhtml = '<h1>'.BAZ_CONFIG.'</h1>'."\n";        
        
        //-------------------------------------------------------------------------------------------------------------------
        // Gestion des boutons de l'interface
        if (isset($_POST['afficheur_annuler'])) {
            return false;
        } else if (isset($_POST['afficheur_enregistrer_quitter'])) {
            $requete = 'UPDATE gen_menu SET gm_application_arguments="num_questionnaire='.$_POST['num_questionnaire'].
					   '||mail_questionnaire='.$_POST['mail_questionnaire'].'||texte_questionnaire_envoye='.$_POST['texte_questionnaire_envoye'].'" WHERE gm_id_menu='.$_GET['adme_menu_id'];            
            $resultat = $this->objet_pear_db->query($requete) ;
            if (DB::isError($resultat)) {
            	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
            }
            return false;
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion des valeurs par defauts, en fonctions des donnees sauvees dans le menu
        $requete = 'SELECT gm_application_arguments FROM gen_menu WHERE gm_id_menu='.$_GET['adme_menu_id'];
        $resultat = $this->objet_pear_db->query($requete) ;
        //echo $requete;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        $valeurs_par_defaut = array();
        if ($resultat->numRows()>0) {        	        	
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {        		
        		$arguments = explode('||', $ligne->gm_application_arguments);        	
 				for ($i = 0; $i < count($arguments); $i++) {
 					$attr = explode('=', $arguments[$i], 2);
 					if ($attr[0] != '') {
 						$info_application->$attr[0] = (isset($attr[1]) ? $attr[1] : '');
 					}
 			   	}
 			}
        	//valeurs par defaut enregistrees dans la table        	
        	if (isset($info_application)) {
        		$valeurs_par_defaut['num_questionnaire']=$info_application->num_questionnaire; 
        		$valeurs_par_defaut['mail_questionnaire']=$info_application->mail_questionnaire;   
        		$valeurs_par_defaut['texte_questionnaire_envoye']=$info_application->texte_questionnaire_envoye;
        	}      
        } else {
        	//valeurs par defaut pour afficher une carto des structures
        	$valeurs_par_defaut['num_questionnaire']='';
        	$valeurs_par_defaut['mail_questionnaire']='';
        	$valeurs_par_defaut['texte_questionnaire_envoye']='';
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion du questionnaire
        $this->objet_pear_url->addQueryString('adme_site_id', $_GET['adme_site_id']);
        $this->objet_pear_url->addQueryString('adme_menu_id', $_GET['adme_menu_id']);
        $this->objet_pear_url->addQueryString('adme_action', 'administrer');
        $form = new HTML_QuickForm('form_param_bazar', 'post', str_replace('&amp;', '&', $this->objet_pear_url->getUrl()));
        $squelette =& $form->defaultRenderer();
        $squelette->setFormTemplate("\n".'<form {attributes}>'."\n".'{content}'."\n".'</form>'."\n");
        $squelette->setElementTemplate( '<p>'."\n".
                                        '<label style="width:100px;padding:5px;text-align:right;">{label}'.
                                        '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                        '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
										' : </label>'."\n".'{element}'."\n".
										'</p>'."\n" );
        $form->addElement('text', 'mail_questionnaire', QUESTIONNAIRE_MAIL);                
        $liste_bouton_debut = '<ul class="liste_bouton">'."\n";
        $form->addElement('html', $liste_bouton_debut);
        $form->addElement('submit', 'afficheur_enregistrer_quitter', BAZ_ENREGISTRER_ET_QUITTER);
        $form->addElement('submit', 'afficheur_annuler', BAZ_ANNULER);
        $liste_bouton_fin = '</ul>'."\n";
        $form->addElement('html', $liste_bouton_fin);
        $form->setDefaults($valeurs_par_defaut);
        $this->sortie_xhtml .= $form->toHTML()."\n";	
        return $this->sortie_xhtml;
    }

}// Fin de la classe

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+
/* +--Fin du code ---------------------------------------------------------------------------------------+
* $Log: bazar.admin.php,v $
* Revision 1.2  2007-04-20 09:57:21  florian
* correction bugs suite au merge
*
* Revision 1.1  2007/02/02 14:02:08  alexandre_tb
* version initiale vide pour le moment
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>