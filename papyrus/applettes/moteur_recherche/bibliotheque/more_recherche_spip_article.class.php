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
// CVS : $Id$
/**
* Classe permettant d'effectuer des recherches sur les informations des articles de Spip.
*
* Permet de rechercher et classer les articles en fonction d'une chaine.
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
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
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

class More_Recherche_Spip_Article extends More_Recherche {
    
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
    	for ($i = 0; $i < count($GLOBALS['_MOTEUR_RECHERCHE_']['spip']); $i++ ) {
	        $db = DB::connect($GLOBALS['_MOTEUR_RECHERCHE_']['spip'][$i]['bdd_dsn']);
	        if (DB::isError($db)) {
	    		$msg_erreur_connection = 'Impossible de se connecter à la base de données Spip.';
	    		die(BOG_afficherErreurSql(__FILE__, __LINE__, $db->getMessage(), 'connexion à la base de données',$msg_erreur_connection));
			}
	        $prefixe = $GLOBALS['_MOTEUR_RECHERCHE_']['spip'][$i]['table_prefixe'];
	        $url_base = $GLOBALS['_MOTEUR_RECHERCHE_']['spip'][$i]['url'];
	        $tab_articles = $this->retournerArticles($db, $prefixe);
	        foreach ($tab_articles as $article_id => $Article) {
	            // Initialisation du tableau de résultat vide
	            $aso_resultat = array(  'poids' => 0, 'url' => '', 'titre' => '',
	                                    'hreflang' => '', 'accesskey' => '', 'title' => '',
	                                    'date_creation' => '', 'description' => '');
	            
	            // Analyse du poids de cette page vis à vis des données
	            $tab_champs_a_visiter = array('surtitre', 'titre', 'soustitre', 'descriptif', 'chapo', 'texte', 'ps');
	            foreach ($tab_champs_a_visiter as $val) {
	                // Vérification que le champ existe et contient quelque chose 
	                if (isset($Article->$val) && $Article->$val != '') {
						$aso_resultat['poids'] += $this->retournerOccurenceMotif($motif, $Article->$val);
	                }
	            }
	            
	            if ($aso_resultat['poids'] > 0) {
	                // Création de l'url
		            $aso_resultat['url_simple'] = $url_base.'article'.$article_id.'.html';
		            $aso_resultat['url'] = $aso_resultat['url_simple'].'?var_recherche='.$this->traiterMotif($motif, 'url');
		            
		            // Récupération du titre de la page
		            if (trim($Article->titre) != '') {
		                $aso_resultat['titre'] = htmlentities($Article->titre);
		            } else if (trim($Article->surtitre) != '') {
		                $aso_resultat['titre'] = htmlentities($Article->surtitre);
		            } else if (trim($Article->soustitre) != '') {
		                $aso_resultat['titre'] = htmlentities($Article->soustitre);
		            }
		            $aso_resultat['hreflang'] = htmlentities($Article->lang);
		            
		            $aso_resultat['description'] = $this->couper($Article->texte, MORE_RESULTAT_TAILLE_DESCRIPTION);
		            
		            if (($jour = date('d', strtotime($Article->date)) ) != 0 ) {
		                $aso_resultat['date_creation'] .= '<span class="page_modification_jour"> '.$jour.'</span>'."\n";
		            }
		            if (($mois = $this->traduireMois(date('m', strtotime($Article->date))) ) != '' ) {
		                $aso_resultat['date_creation'] .= '<span class="page_modification_mois"> '.$mois.'</span>'."\n";
		            }
		            if (($annee = date('Y', strtotime($Article->date)) ) != 0 ) {
		                $aso_resultat['date_creation'] .= '<span class="page_modification_annee"> '.$annee.'</span>'."\n";
		            }
	                $this->setResultat($aso_resultat);
	            }
	        }
    	}
        return $this->getResultats();
    }
    
    /** Renvoie un tableau contenant les infos sur les articles
	*
	* @param  mixed		une instance de la classse Pear DB.
	* @param  string	le préfixe pour les tables spip.
	* @return array		tableau contenant les articles.
	*/
	function retournerArticles(&$db, $prefixe = '')
	{
	    //----------------------------------------------------------------------------
	    // Recherche des informations sur le menu
	    $requete =  'SELECT * '.
	                'FROM '.$prefixe.'spip_articles '.
	                'WHERE statut = "publie"';
	
	    $resultat = $db->query($requete);
	    (DB::isError($resultat)) ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete)) : '';
	
	    //----------------------------------------------------------------------------
	    // Récupération des infos
	    $tab_retour = array();
	    while ($info_article = $resultat->fetchRow(DB_FETCHMODE_OBJECT)) {
	        $tab_retour[$info_article->id_article] = $info_article;
	    }
	    $resultat->free();
	
	    return $tab_retour;
	}
	
	// Fichier : inc_texte.php3
	function couper($texte, $taille = 50)
	{
		$texte = substr($texte, 0, 400 + 2*$taille); /* eviter de travailler sur 10ko pour extraire 150 caracteres */
	
		// on utilise les \r pour passer entre les gouttes
		$texte = str_replace("\r\n", "\n", $texte);
		$texte = str_replace("\r", "\n", $texte);
	
		// sauts de ligne et paragraphes
		$texte = ereg_replace("\n\n+", "\r", $texte);
		$texte = ereg_replace("<(p|br)( [^>]*)?".">", "\r", $texte);
	
		// supprimer les traits, lignes etc
		$texte = ereg_replace("(^|\r|\n)(-[-#\*]*|_ )", "\r", $texte);
	
		// supprimer les tags
		$texte = $this->supprimer_tags($texte);
		$texte = trim(str_replace("\n"," ", $texte));
		$texte .= "\n";	// marquer la fin
	
		// travailler en accents charset
		// On supprime dans Papyrus car cela tire trop de fonctions...
		//$texte = $this->filtrer_entites($texte);
	
		// supprimer les liens
		$texte = ereg_replace("\[->([^]]*)\]","\\1", $texte); // liens sans texte
		$texte = ereg_replace("\[([^\[]*)->([^]]*)\]","\\1", $texte);
	
		// supprimer les notes
		$texte = ereg_replace("\[\[([^]]|\][^]])*\]\]", "", $texte);
	
		// supprimer les codes typos
		$texte = ereg_replace("[}{]", "", $texte);
	
		// supprimer les tableaux
		$texte = ereg_replace("(^|\r)\|.*\|\r", "\r", $texte);
	
		// couper au mot precedent
		$long = $this->spip_substr($texte, 0, max($taille-4,1));
		$court = ereg_replace("([^[:space:]][[:space:]]+)[^[:space:]]*\n?$", "\\1", $long);
		$points = MORE_LG_RESULTAT_ETC;
	
		// trop court ? ne pas faire de (...)
		if (strlen($court) < max(0.75 * $taille,2)) {
			$points = '';
			$long = $this->spip_substr($texte, 0, $taille);
			$texte = ereg_replace("([^[:space:]][[:space:]]+)[^[:space:]]*$", "\\1", $long);
			// encore trop court ? couper au caractere
			if (strlen($texte) < 0.75 * $taille)
				$texte = $long;
		} else
			$texte = $court;
	
		if (strpos($texte, "\n"))	// la fin est encore la : c'est qu'on n'a pas de texte de suite
			$points = '';
	
		// remettre les paragraphes
		$texte = ereg_replace("\r+", "\n\n", $texte);
	
		// supprimer l'eventuelle entite finale mal coupee
		$texte = preg_replace('/&#?[a-z0-9]*$/', '', $texte);
	
		return trim($texte).$points;
	}
	
	// Gerer les outils mb_string
	// Fichier : inc_texte.php3	
	function spip_substr($c, $start=0, $end='')
	{
		// methode substr normale
		if ($end) {
			return substr($c, $start, $end);
		} else {
			return substr($c, $start);
		}
	}

	// Suppression basique et brutale de tous les <...>
	// Fichier : inc_filtres.php3
	function supprimer_tags($texte, $rempl = "")
	{
		$texte = preg_replace(",<[^>]*>,U", $rempl, $texte);
		// ne pas oublier un < final non ferme
		$texte = str_replace('<', ' ', $texte);
		return $texte;
	}

}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.7  2007-10-29 18:29:30  jp_milcent
* Ajout d'un prÃ©fixe devant les classes de l'applette pour Ã©viter les conflits avec d'autres classes provenant des applis clientes.
*
* Revision 1.6  2007-01-02 18:49:22  jp_milcent
* Amélioration de la gestion du motif.
* Ajout de la gestion des expressions complête via l'utilisation de guillemets.
*
* Revision 1.5  2006/11/20 09:36:59  jp_milcent
* Correction bogue zéro résultat et ajout d'url simple pour indiquer la page de l'article.
*
* Revision 1.4  2006/11/14 16:08:40  jp_milcent
* Paramétrage de la découpe de la description et du symbole "etc"
*
* Revision 1.3  2006/10/17 09:21:40  jp_milcent
* Mise en commun des spécifications de la recherche.
*
* Revision 1.2  2006/10/16 14:11:30  jp_milcent
* Amélioration du moteur de recherche.
* Utilisation de l'opérateur "et" entre les mots recherchés.
*
* Revision 1.1  2006/05/19 10:04:55  jp_milcent
* Ajout d'un moteur de recherche analysant les articles des sites sous Spip.
*
* 
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>