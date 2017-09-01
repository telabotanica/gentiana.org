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
// CVS : $Id: afficheur.admin.php,v 1.24 2007-06-26 15:38:39 jp_milcent Exp $
/**
* Gestion de la rédaction du contenu pour Papyrus.
*
* Contient les fonctions nécessaires à la gestion du contenu de Papyrus.
*
*@package Afficheur
*@subpackage Administration
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.24 $ $Date: 2007-06-26 15:38:39 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Nous indiquons à Papyrus de ne pas chercher de balises d'applettes dans le contenu généré par l'appli
$GLOBALS['_PAPYRUS_']['applette']['analyse'] = false;

// +------------------------------------------------------------------------------------------------------+
// |                                                 CLASSE                                               |
// +------------------------------------------------------------------------------------------------------+
class Afficheur_Admin {
    var $objet_pear_auth;
    var $objet_pear_db;
    var $objet_pear_url;
    var $sortie_xhtml;
    
    /** Fonction redigerContenu() - Affiche le formulaire de rédaction
    *
    *
    *   @return  string  Le HTML
    */
    function afficherContenuCorps()
    {
        /** Inclusion du fichier de configuration de cette application.*/
        require_once GEN_CHEMIN_PAP.'applications'.GEN_SEP.'afficheur'.GEN_SEP.'configuration'.GEN_SEP.'affi_configuration.inc.php';
        
        //-------------------------------------------------------------------------------------------------------------------
        // Stockage des styles de l'application
        GEN_stockerStyleExterne('afficheur', AFFI_CHEMIN_STYLE.'afficheur.css');
        
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation des attributs
        $this->objet_pear_auth = $GLOBALS['_GEN_commun']['pear_auth'];
        $this->objet_pear_db = $GLOBALS['_GEN_commun']['pear_db'];
        $this->objet_pear_url = $GLOBALS['_GEN_commun']['url'];
        $this->sortie_xhtml = '';
        
        //-------------------------------------------------------------------------------------------------------------------
        // Gestion de l'interface
        if (isset($_POST['afficheur_annuler'])) {
            return false;
        } else if (isset($_POST['afficheur_enregistrer_quitter'])) {
            // Mise à jour du contenu
            $this->_ajouterContenu($this->objet_pear_db, $this->objet_pear_url, $this->objet_pear_auth, $_GET['adme_menu_id'], $_POST);
            return false;
        } else if (isset($_POST['afficheur_enregistrer_rester'])) {
            // Mise à jour du contenu
            $this->_ajouterContenu($this->objet_pear_db, $this->objet_pear_url, $this->objet_pear_auth, $_GET['adme_menu_id'], $_POST);
            $this->sortie_xhtml .= $this->_redigerContenu($this->objet_pear_db, $this->objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action']);
        } else if (isset($_POST['afficheur_historique'])) {
            // Réediter une version archivée
            $this->sortie_xhtml .= $this->_reediterContenu($this->objet_pear_db, $this->objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action']);
        } else {
			if (isset($_GET['adme_version'])) {
				// Nous avons demandés la réedition d'une version archivées
				$this->sortie_xhtml .= $this->_redigerContenu($this->objet_pear_db, $this->objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action'], $_GET['adme_version']);
			} else {
				// Nous affichons le dernier contenu
				$this->sortie_xhtml .= $this->_redigerContenu($this->objet_pear_db, $this->objet_pear_url, $_GET['adme_site_id'], $_GET['adme_menu_id'], $_GET['adme_action']);
			}
        }
        
        return $this->sortie_xhtml;
    }
    
    function _redigerContenu($db, $url, $adme_site_id, $adme_menu_id, $adme_action, $adme_contenu_id = '')
    {
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation de variable
    	$contenu = '';
    	$donnees = array();
        $url->addQueryString('adme_site_id', $adme_site_id);
        $url->addQueryString('adme_menu_id', $adme_menu_id);
        $url->addQueryString('adme_action', $adme_action);
		
		if ($adme_contenu_id != '') {
			// Nous réeditons une version archivée
			$ligne_dernier_contenu = GEN_rechercheContenuIdentifiant($db, $adme_contenu_id, DB_FETCHMODE_ASSOC);
			$donnees['reedition_info'] = $ligne_dernier_contenu['gmc_date_modification'];
		} else {
   			// Nous affichons la dernière version du contenu
   			$ligne_dernier_contenu = GEN_rechercheContenu($db, $adme_menu_id, DB_FETCHMODE_ASSOC);
		}

        //-------------------------------------------------------------------------------------------------------------------
        // Récupération des données
        $donnees['form_url'] = $url->getUrl();
		
		// Gestion de FckEditor
		$donnees['fck_editor'] = '';
        if ($GLOBALS['_AFFI_']['fckeditor']['utilisation']) {
            /** Inclusion du fichier de FCKeditor*/
            require_once AFFI_CHEMIN_FCKEDITOR.'fckeditor.php';
            $fckeditor = new FCKeditor('gmc_contenu');
            if ($ligne_dernier_contenu['gmc_contenu']) {
	            $fckeditor->Value = $ligne_dernier_contenu['gmc_contenu'];
            } else {
            	if ($contenu) {
            		$fckeditor->Value = $contenu;
            	} else {
            		$fckeditor->Value = '';
            	}
            } 
            $fckeditor->Height = $GLOBALS['_AFFI_']['fckeditor']['hauteur'];
            $fckeditor->ToolbarSet = $GLOBALS['_AFFI_']['fckeditor']['barre'];
            $fckeditor->Config['CustomConfigurationsPath']=$GLOBALS['_AFFI_']['fckeditor']['CustomConfigurationsPath'];
            $fckeditor->Config['AutoDetectLanguage'] = false;
            $fckeditor->Config['DefaultLanguage'] = $GLOBALS['_AFFI_']['fckeditor']['langue'];
            $fckeditor->BasePath = AFFI_CHEMIN_FCKEDITOR;
            if ($fckeditor->IsCompatible()) {
                $donnees['fck_editor'] = $fckeditor->CreateHtml();
            }
        }

        // Identifiant du menu
        $donnees['gmc_ce_menu'] = $adme_menu_id;
        
        // Type de contenu
        // Par défaut c'est du XHTML (donc 1)
		$donnees['gmc_ce_type_contenu'] = 1;
        if (isset($ligne_dernier_contenu['gmc_ce_type_contenu'])) {
        	$donnees['gmc_ce_type_contenu'] = $ligne_dernier_contenu['gmc_ce_type_contenu'];
        }
        
		$squelette = AFFI_CHEMIN_SQUELETTE.'formulaire.tpl.html';
        
        return $this->_genererContenu($squelette, $donnees);
	}
    
    function _reediterContenu($db, $url, $adme_site_id, $adme_menu_id, $adme_action)
    {
        //-------------------------------------------------------------------------------------------------------------------
        // Initialisation de variable
    	$contenu = '';
    	$donnees = array();
        $url->addQueryString('adme_site_id', $adme_site_id);
        $url->addQueryString('adme_menu_id', $adme_menu_id);
        $url->addQueryString('adme_action', $adme_action);
        
		$donnees['archives'] = GEN_lireContenuMenuHistorique($db, $adme_menu_id);
		
		foreach ($donnees['archives'] as $cle => $archive) {
			$url->addQueryString('adme_version', $archive->gmc_id_contenu);
			$donnees['archives'][$cle]->url = $url->getURL();
			$url->removeQueryString('adme_version');
		}
		// print_r($donnees['archives']);

		$squelette = AFFI_CHEMIN_SQUELETTE.'historique.tpl.html';
		
		return $this->_genererContenu($squelette, $donnees);
    }
    
    /** Méthode ajouterContenu() - Enregistre les infos du formulaire de saisie d'un menu
    *
    *
    *   @return  void  les données sont enregistrées dans la base de données.
    */
    function _ajouterContenu($db, $url, $auth, $adme_menu_id, $tab_valeur)
    {
    	//-------------------------------------------------------------------------------------------------------------------
        // Récupération des informations du contenu concerné.
        $ligne_menu = GEN_lireInfoMenu($db, $adme_menu_id, DB_FETCHMODE_ASSOC);
	        
        if ($ligne_menu == false) {
            die('ERREUR Papyrus Administrateur de Menus: impossible de lire les infos du menu.<br />'.
                'Idenitifiant du menu n° : '. $adme_menu_id .'<br />'.
                'Ligne n° : '. __LINE__ .'<br />'.
                'Fichier n° : '. __FILE__ .'<br />');
        }
        
        if ((isset($tab_valeur['gmc_ce_menu']) && $tab_valeur['gmc_ce_menu']!='') && (isset($tab_valeur['gmc_ce_type_contenu_table']) && $tab_valeur['gmc_ce_type_contenu_table']!='')) {
         
	        //-------------------------------------------------------------------------------------------------------------------
	        // Mise à jour de l'ancien contenu du menu
	        $requete =  'UPDATE gen_menu_contenu SET '.
	                    'gmc_bool_dernier = 0 '.
	                    'WHERE gmc_ce_menu = '.$tab_valeur['gmc_ce_menu'] . ' '.
		                'AND gmc_ce_type_contenu = '. $tab_valeur['gmc_ce_type_contenu_table']. ' ';
	
			                    
	        $result = $db->query($requete);
	        (DB::isError($result)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $result->getMessage(), $requete)) : '';
	        
        }
        
        //-------------------------------------------------------------------------------------------------------------------
        // Obtention d'un nouvel identifiant de contenu
        $nouveau_id_contenu = SQL_obtenirNouveauId($db, 'gen_menu_contenu', 'gmc_id_contenu');
        
        // remplacement des guillemets doubles pour les appels aux applettes de Papyrus
        $tab_valeur['gmc_contenu'] = str_replace('&quot;', '\"', $tab_valeur['gmc_contenu']);
        
        //-------------------------------------------------------------------------------------------------------------------
        // Ajout du nouveau contenu pour ce menu
        $requete =  'INSERT INTO gen_menu_contenu SET '.
                    'gmc_id_contenu = '.$nouveau_id_contenu.', '.
                    'gmc_ce_admin = '.$auth->getAuthData('ga_id_administrateur').', '.
                    'gmc_ce_menu = '.$adme_menu_id.', '.
                    'gmc_ce_type_contenu = '.$tab_valeur['gmc_ce_type_contenu'].', '.
                    'gmc_contenu = "'.mysql_real_escape_string($tab_valeur['gmc_contenu']).'", '.
                    'gmc_ce_type_modification = '.$tab_valeur['gmc_ce_type_modification'].', '.
                    'gmc_resume_modification = "'.$tab_valeur['gmc_resume_modification'].'", '.
                    'gmc_date_modification = "'.date('Y-m-d H:i:s').'", '.
                    'gmc_bool_dernier = 1';
        $result = $db->query($requete);
        (DB::isError($result)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $result->getMessage(), $requete)) : '';
    }
    
    function _genererContenu($squelette, $donnees)
    {
    	//+------------------------------------------------------------------------------------------------------------+
		// Extrait les variables et les ajoutes à l'espace de noms local
		// Gestion des squelettes
		extract($donnees);
		// Démarre le buffer
		ob_start();
		// Inclusion du fichier
		include($squelette);
		// Récupérer le  contenu du buffer
		$contenu = ob_get_contents();
		// Arrête et détruit le buffer
		ob_end_clean();
		
		return $contenu;
    }
}// Fin de la classe

// +------------------------------------------------------------------------------------------------------+
// |                                            PIED du PROGRAMME                                         |
// +------------------------------------------------------------------------------------------------------+


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: not supported by cvs2svn $
* Revision 1.23  2007-06-26 13:30:48  jp_milcent
* Suppression de l'utilisation de Quickform.
* Utilisation de squellette PHP.
*
* Revision 1.22  2007-01-03 11:28:34  ddelon
* correction bug multilinguisme (portage bug livraison)
*
* Revision 1.21  2006/12/01 16:59:45  florian
* Ajout d'une variable parametrant la recherche de balise d'applette dans le contenu généré par l'appli.
*
* Revision 1.20  2006/12/01 11:23:23  ddelon
* Suppression mode wiki afficheur
*
* Revision 1.19  2006/10/16 15:49:07  ddelon
* Refactorisation code mulitlinguisme et gestion menu invisibles
*
* Revision 1.18  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.17  2006/03/27 13:42:32  ddelon
* the last but not the least
*
* Revision 1.16  2006/03/27 11:21:49  ddelon
* Still some pb
*
* Revision 1.15  2006/03/27 10:14:43  ddelon
* Still some pb
*
* Revision 1.11  2006/03/13 22:27:23  ddelon
* bug afficheur multilinguisme
*
* Revision 1.10  2006/03/13 22:12:20  ddelon
* bug afficheur multilinguisme
*
* Revision 1.9  2006/03/13 21:00:20  ddelon
* Suppression messages d'erreur multilinguisme
*
* Revision 1.8  2006/03/02 10:49:49  ddelon
* Fusion branche multilinguisme dans branche principale
*
* Revision 1.7.2.1  2006/02/28 14:02:11  ddelon
* Finition multilinguisme
*
* Revision 1.7  2005/07/18 08:53:14  ddelon
* Configuration Fcsk et menage
*
* Revision 1.6  2005/07/15 17:10:08  ddelon
* Configuration Fcsk et menage
*
* Revision 1.5  2005/06/03 18:39:30  jpm
* Ajout de la barre d'outil Papyrus FCKeditor.
*
* Revision 1.4  2005/05/31 13:43:57  jpm
* Ajout d'un bouton pour remplacer les entités html.
*
* Revision 1.3  2005/04/25 13:56:31  jpm
* Ajout de styles.
*
* Revision 1.2  2005/02/28 10:34:15  jpm
* Changement de nom Genesia en Papyrus.
*
* Revision 1.1  2004/11/09 17:53:49  jpm
* Interface d'administration de l'application afficheur.
*
* Revision 1.4  2004/11/08 17:40:33  jpm
* Mise en conformité avec la convention de codage.
* Légères corrections.
*
* Revision 1.3  2004/09/23 17:45:13  jpm
* Amélioration de la gestion des liens annuler et du selecteur de sites.
*
* Revision 1.2  2004/07/06 17:07:37  jpm
* Modification de la documentation pour une mailleur analyse par PhpDocumentor.
*
* Revision 1.1  2004/06/16 15:04:32  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.5  2004/05/07 16:32:27  jpm
* Modification des commentaires.
*
* Revision 1.4  2004/05/07 07:23:53  jpm
* Amélioration du code, des commentaires et correction de bogues.
*
* Revision 1.3  2004/05/04 16:27:55  jpm
* Amélioration gestion du déplacement des menus.
*
* Revision 1.2  2004/05/03 14:51:59  jpm
* Normalisation du nom d'une fonction et ajout de la gestion d'une erreur.
*
* Revision 1.1  2004/04/30 16:21:30  jpm
* Ajout de la rédaction de contenu.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
