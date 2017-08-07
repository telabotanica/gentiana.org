<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Papyrus.                                                                        |
// |                                                                                                      |
// | Foobar is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | Foobar is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: more_recherche_papyrus_menu.class.php,v 1.13.2.1 2008-08-08 15:59:09 jp_milcent Exp $
/**
* Classe permettant d'effectuer des recherches sur les informations des menus de Papyrus.
*
* Permet de rechercher et classer les menus en fonction d'une chaine.
* Utilisation des bibliothèques inclue par Papyrus :
* - Papyrus pap_meta.fonct.php
* - Papyrus pap_menu.fonct.php
* - Papyrus pap_url.class.php
*
*@package Applette
*@subpackage Moteur_Recherche
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.13.2.1 $ $Date: 2008-08-08 15:59:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
///** Inclusion du fichier contenant les fonctions de manipulations des menus de Papyrus.*/
//require_once GEN_CHEMIN_BIBLIO.'pap_menu.fonct.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

class More_Recherche_Papyrus_Menu extends More_Recherche{
    
    // Constructeur
    function Recherche_Menu_Meta($motif) {
        $this->setMotif($motif);
    }
    
    // Accesseurs
    function getMotif() {
        return $this->motif;
    }
    function setMotif($motif) {
        $this->motif = $motif;
    }
    
    // Méthodes
    function rechercherMotif($motif) {
        $db = $GLOBALS['_MOTEUR_RECHERCHE_']['bd']['papyrus'];
        $tab_menus = GEN_retournerMenus($db);
        foreach ($tab_menus as $cle => $menu_id) {
            // Initialisation du tableau de résultat vide
            $aso_resultat = array(  'poids' => 0, 'url' => '', 'titre' => '',
                                    'hreflang' => '', 'accesskey' => '', 'title' => '',
                                    'date_creation' => '', 'description' => '');
            
            // Récupération des infos du menu courant : transtypage pour éviter les erreur avec array_merge
            $aso_menu_info = (array) GEN_lireInfoMenu($db, $menu_id, DB_FETCHMODE_ASSOC);
            // Nous vérifions que le menu à une date de validité valide
            if ($aso_menu_info['gm_date_fin_validite'] == '0000-00-00 00:00:00' || strtotime($aso_menu_info['gm_date_fin_validite']) > time() ) {
	            // Récupération du contenu du menu courant : transtypage pour éviter les erreur avec array_merge
	            $aso_menu_contenu = (array) GEN_lireContenuMenu($db, $menu_id, DB_FETCHMODE_ASSOC);
				
				// Fusion des deux tableaux de champs à analyser
				$aso_menu = array_merge($aso_menu_info, $aso_menu_contenu);
				
	            // Analyse du poids de cette page vis à vis des méta informations et du contenu
	            $tab_champs_a_visiter = array(  'gm_nom', 'gm_titre', 'gm_titre_alternatif', 'gm_mots_cles', 
	                                            'gm_description_libre', 'gm_description_resume', 'gm_description_table_matieres', 
	                                            'gm_source', 'gm_auteur', 'gm_contributeur', 'gm_editeur', 'gm_categorie', 
	                                            'gm_public', 'gmc_contenu');
				foreach ($tab_champs_a_visiter as $val) {
	                // Vérification que le champ existe et contient quelque chose 
	                if (isset($aso_menu[$val]) && $aso_menu[$val] != '') {
						$aso_resultat['poids'] += $this->retournerOccurenceMotif($motif, $aso_menu[$val]);
	                }
	            }
	            
	            // Si le menu contient les mots recherchés nous poursuivons 
				if ($aso_resultat['poids'] > 0) {
	                // Création de l'url
		            // TODO : utiliser comme pour spip un fichier de config spécifique pour virer PAP_URL d'ici
		            $une_url = new Pap_URL(PAP_URL);
		            $une_url->setId($menu_id);
		            $aso_resultat['url_simple'] = $une_url->getURL();
		            $une_url->addQueryString('var_recherche', $this->traiterMotif($motif, 'url'), true);
		            $aso_resultat['url'] = $une_url->getURL();
		            $une_url->removeQueryString('var_recherche');
		            
		            // Récupération du titre de la page
		            if (trim($aso_menu_info['gm_nom']) != '') {
		                $aso_resultat['titre'] = htmlentities($aso_menu_info['gm_nom']);
		            } else if (trim($aso_menu_info['gm_titre']) != '') {
		                $aso_resultat['titre'] = htmlentities($aso_menu_info['gm_titre']);
		            } else if (trim($aso_menu_info['gm_titre_alternatif']) != '') {
		                $aso_resultat['titre'] = htmlentities($aso_menu_info['gm_titre_alternatif']);
		            }
		            $aso_resultat['hreflang'] = htmlentities($aso_menu_info['gm_ce_i18n']);
		            $raccourci_txt = '';
		            $aso_resultat['accesskey'] = htmlentities($aso_menu_info['gm_raccourci_clavier']);
		            if ($aso_resultat['accesskey'] != '') {
		                $raccourci_txt =    MORE_LG_RESULTAT_CADRE_OUVRIR.
		                                    MORE_LG_RESULTAT_RACCOURCI.$aso_resultat['accesskey'].' '.
		                                    MORE_LG_RESULTAT_CADRE_FERMER.MORE_LG_RESULTAT_POINT.' ';
		            }
		            $aso_resultat['title'] = htmlentities($raccourci_txt.$aso_menu_info['gm_description_resume']);
		            
		            $aso_resultat['description'] = htmlentities($aso_menu_info['gm_description_libre']);
		            if (($jour = date('d', strtotime($aso_menu_info['gm_date_creation'] )) ) != 0 ) {
		                $aso_resultat['date_creation'] .= '<span class="page_modification_jour"> '.$jour.'</span>'."\n";
		            }
		            if (($mois = $this->traduireMois(date('m', strtotime($aso_menu_info['gm_date_creation'] ))) ) != '' ) {
		                $aso_resultat['date_creation'] .= '<span class="page_modification_mois"> '.$mois.'</span>'."\n";
		            }
		            if (($annee = date('Y', strtotime($aso_menu_info['gm_date_creation'] )) ) != 0 ) {
		                $aso_resultat['date_creation'] .= '<span class="page_modification_annee"> '.$annee.'</span>'."\n";
		            }
		                
	                $this->setResultat($aso_resultat);
				}
            }
        }
        return $this->getResultats();
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: more_recherche_papyrus_menu.class.php,v $
* Revision 1.13.2.1  2008-08-08 15:59:09  jp_milcent
* Les menus dont la date de fin de validitÃ© est dÃ©passÃ©e ne sont plus affichÃ©s.
*
* Revision 1.13  2007-10-29 18:29:30  jp_milcent
* Ajout d'un prÃ©fixe devant les classes de l'applette pour Ã©viter les conflits avec d'autres classes provenant des applis clientes.
*
* Revision 1.12  2007-01-02 18:49:22  jp_milcent
* Amélioration de la gestion du motif.
* Ajout de la gestion des expressions complête via l'utilisation de guillemets.
*
* Revision 1.11  2006/11/21 18:52:20  jp_milcent
* Ajout de la possibilité de surligner des mots.
*
* Revision 1.10  2006/11/20 09:36:59  jp_milcent
* Correction bogue zéro résultat et ajout d'url simple pour indiquer la page de l'article.
*
* Revision 1.9  2006/10/17 09:21:40  jp_milcent
* Mise en commun des spécifications de la recherche.
*
* Revision 1.8  2006/10/16 14:11:30  jp_milcent
* Amélioration du moteur de recherche.
* Utilisation de l'opérateur "et" entre les mots recherchés.
*
* Revision 1.7  2006/10/10 13:28:13  jp_milcent
* Suppression d'une variable et utilisation de la constante PAP_URL
*
* Revision 1.6  2006/05/19 10:04:55  jp_milcent
* Ajout d'un moteur de recherche analysant les articles des sites sous Spip.
*
* Revision 1.5  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.4  2005/05/25 13:49:22  jpm
* Corection erreur pour la recherche dans le contenu.
*
* Revision 1.3  2005/05/19 12:46:12  jpm
* Correction bogue accesskey.
* Ajout d'un id à la liste.
* Arrondissement des score.
*
* Revision 1.2  2005/04/14 17:39:34  jpm
* Amélioration du moteur de rechercher :
*  - pourcentage
*  - ajout d'info
*
* Revision 1.1  2004/12/07 10:24:06  jpm
* Moteur de recherche version de départ.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>