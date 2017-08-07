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
// CVS : $Id: cartographie.admin.php,v 1.6 2007/04/11 08:30:12 neiluj Exp $
/**
* 
*@package bazar
//Auteur original :
*@author        Florian Schmitt <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.6 $ $Date: 2007/04/11 08:30:12 $
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                            ENT?E du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+
class Cartographie_Admin {
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
        /** Inclusion du fichier de configuration de cette application.*/
        require_once PAP_CHEMIN_RACINE.'client/bottin/configuration/bottin.config.inc.php';
        require_once INS_CHEMIN_APPLI.'configuration/cartographie.config.inc.php';
        require_once PAP_CHEMIN_API_PEAR.'HTML/QuickForm.php' ;
                
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation des attributs
        $this->objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
        $this->objet_pear_db = $GLOBALS['ins_db'];
        $this->objet_pear_url = $GLOBALS['_GEN_commun']['url'];
        $this->sortie_xhtml = '<h1>'.INS_CONFIG_MENU.' '.$_GET['adme_menu_id'].'</h1><br />'."\n";
        
        //-------------------------------------------------------------------------------------------------------------------
        // Gestion des boutons de l'interface
        if (isset($_POST['afficheur_annuler'])) {
            return false;
        } else if (isset($_POST['afficheur_enregistrer_quitter'])) {
            // Sauvegarde paramêtres carto
            //on vérifie l'existence de la configuration, pour savoir si l'on fait un INSERT ou un UPDATE
            $requete = 'SELECT cc_menu_id FROM carto_config WHERE cc_menu_id='.$_GET['adme_menu_id'];
            $resultat = $this->objet_pear_db->query($requete) ;
            if (DB::isError($resultat)) {
            	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
            }
            if ($resultat->numRows()>0) {
             	$requete = 'UPDATE carto_config SET cc_titre_carto="'.$_POST['titre_carto'].'", cc_table1="'.$_POST['nom_table1'].'", cc_table2="'.$_POST['nom_table2'].
                           '", cc_pays="'.$_POST['nom_champs_pays'].'", cc_cp="'.$_POST['nom_champs_cp'].
                           '", cc_sql="'.$_POST['requete_sql'].'" WHERE cc_menu_id='.$_GET['adme_menu_id'];
            } else {
             	$requete = 'INSERT INTO carto_config (cc_titre_carto, cc_menu_id, cc_table1, cc_table2, cc_pays, cc_cp, cc_sql)'.
             	           ' VALUES ( "'.$_POST['titre_carto'].'", '.$_GET['adme_menu_id'].', "'.$_POST['nom_table1'].'", "'.$_POST['nom_table2'].
						   '", "'.$_POST['nom_champs_pays'].'", "'.$_POST['nom_champs_cp'].'", "'.$_POST['requete_sql'].'")';
            }
            $resultat = $this->objet_pear_db->query($requete) ;
            if (DB::isError($resultat)) {
            	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
            }
            return false;
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion des valeurs par defauts, en fonctions des donnees sauvees dans carto_config
        $requete = 'SELECT * FROM carto_config WHERE cc_menu_id='.$_GET['adme_menu_id'];
        $resultat = $this->objet_pear_db->query($requete) ;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        $valeurs_par_defaut = array();
        if ($resultat->numRows()>0) {
        	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        		//valeurs par defaut enregistrees dans la table
        		$valeurs_par_defaut['titre_carto']=$ligne['cc_titre_carto'];
        		$valeurs_par_defaut['nom_table1']=$ligne['cc_table1'];
        		$valeurs_par_defaut['nom_table2']=$ligne['cc_table2'];
        		$valeurs_par_defaut['nom_champs_pays']=$ligne['cc_pays'];
        		$valeurs_par_defaut['nom_champs_cp']=$ligne['cc_cp'];
        		$valeurs_par_defaut['requete_sql']=$ligne['cc_sql'];
        	}
        } else {
        	//valeurs par defaut pour afficher une carto des structures
        	$valeurs_par_defaut['titre_carto']='';
        	$valeurs_par_defaut['nom_table1']=INS_ANNUAIRE;
        	$valeurs_par_defaut['nom_table2']=0;
        	$valeurs_par_defaut['nom_champs_pays']=INS_CHAMPS_PAYS;
        	$valeurs_par_defaut['nom_champs_cp']=INS_CHAMPS_CODE_POSTAL;
        	$valeurs_par_defaut['requete_sql']='a_structure=1';        	
        }
        
        //--------------------------------------------------------------------------------------------------------------
        // Gestion du formulaire
        $this->objet_pear_url->addQueryString('adme_site_id', $_GET['adme_site_id']);
        $this->objet_pear_url->addQueryString('adme_menu_id', $_GET['adme_menu_id']);
        $this->objet_pear_url->addQueryString('adme_action', 'administrer');
        $form = new HTML_QuickForm('form_param_carto', 'post', str_replace('&amp;', '&', $this->objet_pear_url->getUrl()));
        $squelette =& $form->defaultRenderer();
        $squelette->setFormTemplate("\n".'<form{attributes}>'."\n".'<table>'."\n".'{content}'."\n".'</table>'."\n".'</form>'."\n");
        $squelette->setElementTemplate( '<tr>'."\n".
                                        '<td style="padding:5px;text-align:right;">{label}'.
                                        '<!-- BEGIN required --><span class="symbole_obligatoire">*</span><!-- END required -->'."\n".
                                        '<!-- BEGIN error --><span class="erreur">{error}</span><!-- END error -->'."\n".
										' : </td>'."\n".
                                        '<td style="padding:5px;text-align:left;">{element}</td>'."\n".
                                        '</tr>'."\n" );
        $form->addElement('text', 'titre_carto', INS_TITRE_CARTO);
        $requete = 'SHOW TABLES FROM '.$this->objet_pear_db->dsn['database'];
        $resultat = $this->objet_pear_db->query($requete) ;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
        $option_tables = array();
        while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
        	$option_tables[$ligne['Tables_in_'.$this->objet_pear_db->dsn['database']]] =  $ligne['Tables_in_'.$this->objet_pear_db->dsn['database']];
        }
        $javascript= array('onchange' => 'javascript:this.form.submit();');
        $form->addElement('select', 'nom_table1', INS_TABLE, $option_tables, $javascript);
        
        if (isset($_POST['nom_table1'])) {
        	$table=$_POST['nom_table1'];
        } else {
        	$table=$valeurs_par_defaut['nom_table1'];        	
        }
        $requete = 'SHOW COLUMNS FROM '.$table;
        $resultat = $this->objet_pear_db->query($requete) ;
        if (DB::isError($resultat)) {
        	die ("Echec de la requete<br />".$resultat->getMessage()."<br />".$resultat->getDebugInfo()) ;
        }
       	$option_champs = array();
		while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
			$option_champs[$ligne['Field']] =  $ligne['Field'];
		}
       	$form->addElement('select', 'nom_champs_pays', INS_NOM_CHAMPS_PAYS, $option_champs);
       	$form->addElement('select', 'nom_champs_cp', INS_NOM_CHAMPS_CP, $option_champs);
       	$option_tables[0] = INS_PAS_NECESSAIRE;
       	$form->addElement('select', 'nom_table2', INS_TABLE_SUPPLEMENTAIRE, $option_tables);
       	$form->addElement('text', 'requete_sql', INS_REQUETE_SQL_SUPPLEMENTAIRE);         
        $liste_bouton_debut = '<ul class="liste_bouton">'."\n";
        $form->addElement('html', $liste_bouton_debut);
        $form->addElement('submit', 'afficheur_enregistrer_quitter', INS_ENREGISTRER_ET_QUITTER);
        $form->addElement('submit', 'afficheur_annuler', INS_ANNULER);
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
?>