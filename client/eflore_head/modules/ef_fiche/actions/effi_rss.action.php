<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | wiki file is part of eFlore-Fiche.                                                                   |
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
// CVS : $Id: effi_rss.action.php,v 1.6 2007-06-19 10:32:57 jp_milcent Exp $

/**
* Fichier d'action du module eFlore-Fiche : Wiki
*
* Appel du suivi rss de tous les taxons
* 
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        David Delon <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision: 1.6 $ $Date: 2007-06-19 10:32:57 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+


class ActionRss {
	
	public function executer()
	{

		// Récuperation contexte wikini
	
		$GLOBALS['_GEN_commun']['info_application']->wikini = EF_WIKI_NOM;
		// Ajout du fichier contenant la fonction d'affichage du wikini
		require_once  EF_WIKI_CHEMIN_BIBLIO.'iw_integrateur.fonct.php';
	
		
		$GLOBALS['_PAPYRUS_']['erreur']->setActive(0);
	
		global $wiki;
		global $wikini_config_defaut;
		$sortie='';
	    $wakkaConfig = $GLOBALS['wikini_config_defaut'];
	    if (!class_exists('Wiki_Papyrus')) return ;
	    $wiki  = new Wiki_Papyrus($wakkaConfig);
	
	
	    $server=$_SERVER['PHP_SELF'];
		$_SERVER['PHP_SELF']="wakka.php";

		if ($pages = $wiki->LoadAll("select tag, time, user, owner, body from ".$wiki->config["table_prefix"]."pages where latest = 'Y' and comment_on = '' order by time desc limit 50" )) {
		    
			$dao_n = new NomDeprecieDao();
			if (!($link = $wiki->GetParameter("link"))) $link=$wiki->config["root_page"];
			
	         	$output = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?> \n";
		        $output .= "<rss version=\"0.91\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";
		 
			$link=EF_URL;
			$link=ereg_replace('\/$','',EF_URL) ;


		    	$output .= "<channel>\n";
			$output .= "<title> Derniers changements sur ".$_SESSION['cpr'] ." </title>\n";
			$output .= "<link>" . $link . "</link>\n";
			$output .= "<description> Derniers changements sur ".$_SESSION['cpr'] ." </description>\n";
		    
		    $items = '';
			foreach ($pages as $i => $page)
			{
				
				if (substr($page["tag"],0,strlen($_SESSION['cpr']))==$_SESSION['cpr']) {
				
					list($day, $time) = explode(" ", $page["time"]);
					$day= preg_replace("/-/", " ", $day);
					list($hh,$mm,$ss) = explode(":", $time);
					
					$nt_rss=substr($page["tag"],strlen($_SESSION['cpr'])+2);		
					
					$dao_sn = new SelectionNomDao;
					$dao_n = new NomDeprecieDao;
					$tab_sn_nt = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID, array( (int)$nt_rss, (int)$_SESSION['nvp'] ) );
					foreach($tab_sn_nt as $une_sn) {
						if ($une_sn->getCe('statut') == EF_SNS_RETENU) {
						$tab_nom_retenu = $dao_n->consulter( EF_CONSULTER_NOM_ID, array((int)$une_sn->getId('nom'), (int)$_SESSION['nvpn']));
						$le_nom_retenu = $tab_nom_retenu[0];
						break;
						}
					}

					
					$dao_sn = new SelectionNomDao;
					$tab_sn = $dao_sn->consulter(EF_CONSULTER_SN_VERSION_TAXON_ID_RETENU, array((int)$nt_rss, (int)$_SESSION['nvp']));
					if (isset($tab_sn[0])) {
						$un_sn = $tab_sn[0];
						if (is_object($un_sn)) {
							$nn = $un_sn->getId('nom');
						}
					}
				
			
			
					$lien = clone $GLOBALS['_EFLORE_']['url_permalien'];
					$lien->setType('nn');
					$lien->setProjetCode($_SESSION['cpr']);
					$lien->setVersionCode($_SESSION['cprv']);
					$lien->setPage('wiki');
					$lien->setTypeId($nn);
					$itemurl=$lien->getUrl();
			
			        
			        
					$items .= "<item>\n";
					$items .= "<link>" . $itemurl . "</link>\n";
					if ($page['user']=='')	$page['user']='Anonyme';
					$items .= "<title>" . htmlspecialchars($le_nom_retenu->formaterNom()) .  " (numéro taxonomique : " . $nt_rss .") --- par " .$page["user"] . " le " . $day ." - ". $hh .":". $mm . "</title>\n";
						
					$items .= "<description> Modification de " . htmlspecialchars($le_nom_retenu->formaterNom()) . " (numéro taxonomique : " . $nt_rss .")  --- par " .$page["user"] . " le " . $day ." - ". $hh .":". $mm . htmlspecialchars($wiki->Format($page['body'])).  "</description>\n";
					$items .= "<dc:format>text/html</dc:format>";
					$items .= "</item>\n";
				}
			}
			$output .= $items . "\n";
		    $output .= "</channel>\n";
		    $output .= "</rss>\n";

		}
		
		
		$_SERVER['PHP_SELF'] = $server;
		$GLOBALS['_PAPYRUS_']['erreur']->setActive(1);

		// Définition du type de document et de son encodage.
		header("Content-Type: text/xml; charset=ISO-8859-1");
		echo $output;
		exit;
		
		
	}
	
}



/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: effi_rss.action.php,v $
* Revision 1.6  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.5  2007-04-10 09:09:21  ddelon
* affichage contenu flux rss
*
* Revision 1.3.2.1  2007/01/26 14:05:10  jp_milcent
* Ajout de l'encodage à l'entête http.
* Remplacement des & par des &amp;.
*
* Revision 1.3  2007/01/17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.2.2.2  2007/01/15 19:31:36  jp_milcent
* Ajout d'entête xml.
*
* Revision 1.2.2.1  2006/11/21 14:47:16  ddelon
* backport modif wiki depuis bracnhe principale
*
* Revision 1.2  2006/11/21 13:18:45  ddelon
* merge modif wiki decaisne dans branche principale
*
* Revision 1.1.2.1  2006/11/21 11:49:48  ddelon
* Wiki et eflore + flux rss
*
* Revision 1.5.2.2  2006/11/10 22:38:15  ddelon
* wiki eflore
*
* Revision 1.5.2.1  2006/09/06 11:46:36  jp_milcent
* Gestion du code du référentiel pour le titre avant de créer le formulaire de recherche.
* Si on le place après, le référentiel est faux!
*
* Revision 1.5  2006/07/20 15:10:40  jp_milcent
* Amélioration de la gestion du wikini : gestion de la creation du nom de la page dans l'action.
* Modification et amélioration des redirections du htaccess.
* Mise en constante du nom du wikini et du chemin vers le dossier bibliotheque de l'intégrateur wikini.
*
* Revision 1.4  2006/07/12 16:02:28  jp_milcent
* Correction bogue titre.
*
* Revision 1.3  2006/07/07 09:26:17  jp_milcent
* Modification selon les remarques de Daniel du 29 juin 2006.
* Changement de nom de classes abstraites.
*
* Revision 1.2  2006/06/17 11:55:25  ddelon
* Bug chemin
*
* Revision 1.1  2006/05/29 13:56:10  ddelon
* Integration wiki dans eflore
*
* Revision 1.2  2006/05/02 10:01:40  jp_milcent
* Corrections diverses de l'interface graphique conformément aux demandes de Daniel.
* Ajout du moteur de recherche en haut de la page synthèse.
*
* Revision 1.1  2006/04/25 16:22:24  jp_milcent
* Ajout d'un onglet "informations" et modification de l'onglet "synonymie" pour afficher des données txt liées au nom sélectionné.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
