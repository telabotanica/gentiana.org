<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of papyrus_bp.                                                                     |
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
// CVS : $Id: syndication.php,v 1.7.2.3 2007-12-13 14:09:02 alexandre_tb Exp $
/**
* papyrus_bp - syndication.php
*
* Description :
*
*@package papyrus_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.7.2.3 $ $Date: 2007-12-13 14:09:02 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTï¿½TE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
$GLOBALS['_GEN_commun']['info_applette_nom_fonction'] = 'afficherSyndication';
$GLOBALS['_GEN_commun']['info_applette_balise'] = 	'\{\{[Ss]yndication'.
													'(?:\s*'.
														'(?:'.
															'(url="[^"]*")|'.
															'(titre="[^"]*")|'.
															'(nb="?\d+"?)|'.
															'(nouvellefenetre="?(?:0|1)"?)|'.
															'(formatdate="[^"]*")|'.
															'(formatdatepro="[^"]*")|'.
															'(template=".*")|'.
														')'.
													')+'.
													'\s*\}\}';
// +------------------------------------------------------------------------------------------------------+
/** Inclusion du fichier de configuration de cette application.*/
require_once GEN_CHEMIN_APPLETTE.'syndication'.GEN_SEP.'configuration'.GEN_SEP.'synd_configuration.inc.php';

// Inclusion des fichiers de traduction de l'applette SYND de Papyrus
if (file_exists(SYND_CHEMIN_LANGUE.'synd_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php')) {
    /** Inclusion du fichier de traduction suite à la transaction avec le navigateur.*/
    require_once SYND_CHEMIN_LANGUE.'synd_langue_'.$GLOBALS['_GEN_commun']['i18n'].'.inc.php';
} else {
    /** Inclusion du fichier de traduction par défaut.*/
    require_once SYND_CHEMIN_LANGUE.'synd_langue_'.SYND_I18N_DEFAUT.'.inc.php';
}
/** Inclusion du fichier de la bibliotheque permettant de manipuler les flux RSS.*/
//require_once(MAGPIE_DIR.'rss_fetch.inc');
require_once PAP_CHEMIN_API_PEAR.'XML/Feed/Parser.php';
// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
/** Fonction afficherSyndication() - Retourne la liste des pages des sites syndiquï¿½s.
*
* Cette fonction retourne la liste des pages des sites syndiquï¿½s.
*
* @param  array contient les arguments de la fonction.
* @param  array  tableau global de Papyrus.
* @return string XHTML la liste des pages.
*/
function afficherSyndication($tab_applette_arguments, $_GEN_commun)
{
	// Initialisation des variables
    $sortie = '';
	$GLOBALS['_SYNDICATION_']['erreurs'] = array();
	$GLOBALS['_SYNDICATION_']['informations'] = array();
	$GLOBALS['_SYNDICATION_']['sites'] = array();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Gestion des arguments
	$balise = $tab_applette_arguments[0];
    $tab_arguments = $tab_applette_arguments;
	unset($tab_arguments[0]);
    foreach($tab_arguments as $argument) {
    	if ($argument != '') {
	    	$tab_parametres = explode('=', $argument, 2);
	    	$options[$tab_parametres[0]] = trim($tab_parametres[1], '"');
    	}
    }
	
	//+----------------------------------------------------------------------------------------------------------------+
    // Gestion des erreurs de paramï¿½trage
	if (!isset($options['url'])) {
		$GLOBALS['_SYNDICATION_']['erreurs'][] = sprintf(SYND_LG_ERREUR_URL, $balise);
	}
	if (!isset($options['titre'])) {
		$options['titre'] = '';
	}
	if (!isset($options['nb'])) {
		$options['nb'] = SYND_NOMBRE;
	}
    if (!isset($options['nouvellefenetre'])) {
		$options['nouvellefenetre'] = SYND_OUVRIR_LIEN_RSS_NOUVELLE_FENETRE;
	}
	if (!isset($options['formatdate'])) {
		$options['formatdate'] = SYND_FORMAT_DATE;
	}
	if (!isset($options['formatdatepro'])) {
		$options['formatdatepro'] = false;
	}
	if (!isset($options['template'])) {
		$options['template'] = SYND_CHEMIN_SQUELETTE.SYND_SQUELETTE_LISTE;
	} else {
		if (file_exists(SYND_CHEMIN_SQUELETTE.$options['template'])) {
			$options['template'] = SYND_CHEMIN_SQUELETTE.$options['template'];
		}
	}
	
    //+----------------------------------------------------------------------------------------------------------------+
    // Recuperation des donnees
    if (count($GLOBALS['_SYNDICATION_']['erreurs']) == 0) {
		$tab_url = array_map('trim', explode(',', $options['url']));
        foreach ($tab_url as $cle => $url) {
			if ($url != '') {
				$aso_site = array();
				// Liste des encodages acceptés pour les flux
				$encodages = 'UTF-8, ISO-8859-1, ISO-8859-15';
				try {
					$feed = new XML_Feed_Parser(file_get_contents($url));
				} catch (XML_Feed_Parser_Exception $e) {
					return('Le flux RSS est invalide : ' . $e->getMessage());
				}
				
				if ($options['template'] != '' && !file_exists($options['template'])) {
					$i = 0 ;
					$res= '';
					foreach ($feed as $item) {
						// Le test suivant pour savoir s il faut reduire l excendent de description
						// Si {all} est present dans le template on ne reduit pas
						if (preg_match ('/{all}/', $options['template'])) {
							$template = str_replace('{all}', '', $options['template']);
							$all = true ;
						} else {
							$all = false;
						}
						if (isset($item->summary)) {
							$item->description = mb_convert_encoding($item->summary, 'HTML-ENTITIES', $encodages); 
						} else {
							if (strlen($item->description) > 200 && !$all) {
								$item->description = 	substr(mb_convert_encoding($item->description, 'HTML-ENTITIES', $encodages), 0, 300).
														'... <a href="'.htmlentities($item->link).'">Lire la suite</a>';
							}
						}
						if (!isset($item->pubdate)) {
							$item->pubdate = date('dmY');
						}
						// Le code ci-apres est pour rattraper les dates du type 01012005 parsees par magpie
						// lorsque les flux donne des dates au format iso
						if (preg_match('/^([0-3][0-9])([0-1][0-9])([0-9][0-9][0-9][0-9])$/', $item->pubdate, $match)) {
							$item->pubdate = $match[3].'-'.$match[2].'-'.$match[1];
							//echo $item['pubdate'];
						}
						$res .= str_replace ('{num}', ++$i, 
								str_replace ('{item}', '<a href="'.htmlentities($item->link).'" target="_top">'.mb_convert_encoding($item->title, 'HTML-ENTITIES', $encodages).'</a>', 
								str_replace ('{date}', strftime('%d.%m.%Y',strtotime($item->pubdate)),
								str_replace ('{description}', mb_convert_encoding($item->description, 'HTML-ENTITIES', $encodages), $options['template'])))) ;
						$res .= "\n";
						if ($i > $options['nb']) {
							break;
						}
					}
					return $res;
				}
				// Gestion du titre
				if ( $options['titre'] == '' ) {
					$aso_site['titre'] = mb_convert_encoding($feed->title, 'HTML-ENTITIES', $encodages);
				} else if ( $options['titre'] != '0' ) {
					$aso_site['titre'] = $options['titre'];
				}
				// Gestion de l'url du site
				$aso_site['url'] = htmlentities($feed->link);

				// Ouverture du lien dans une nouvelle fenetre
				$aso_site['ext'] = false;
				if ($options['nouvellefenetre'] == 1) {
					$aso_site['ext'] = true;
				}
				// Gestion des pages syndiquees
				$i = 0;
			    $nb_item = $feed->numberEntries;
				foreach ($feed as $item) {
					//echo '<pre>'.print_r($item, true).'</pre>';
					if ($options['nb'] != 0 && $nb_item >= $options['nb'] && $i >= $options['nb']) {
						break;
					}
					$i++;
					$aso_page = array();
					$aso_page['site'] = $aso_site;
					$aso_page['url'] = htmlentities($item->link);
					$aso_page['titre'] = mb_convert_encoding($item->title, 'HTML-ENTITIES', $encodages);
					$aso_page['date'] = $item->pubDate;	
					if ($options['formatdatepro']) {
						switch ($options['formatdatepro']) {
							case 'jm' :
								$aso_page['date'] = strftime('%d.%m', $aso_page['date']);
								break;
							case 'jma' :
								$aso_page['date'] = strftime('%d.%m.%Y', $aso_page['date']);
								break;
							case 'jmh' :
								$aso_page['date'] = strftime('%d.%m %H:%M', $aso_page['date']);
								break;
							case 'jmah' :
								$aso_page['date'] = strftime('%d.%m.%Y %H:%M', $aso_page['date']);
								break;
							default :
								$aso_page['date'] = strftime('%d.%m.%Y %H:%M', $aso_page['date']);
						}
					} else {
						switch ($options['formatdate']) {
							case 'jm' :
								$aso_page['date'] = strftime('%d.%m', $aso_page['date']);
								break;
							case 'jma' :
								$aso_page['date'] = strftime('%d.%m.%Y', $aso_page['date']);
								break;
							case 'jmh' :
								$aso_page['date'] = strftime('%d.%m %H:%M', $aso_page['date']);
								break;
							case 'jmah' :
								$aso_page['date'] = strftime('%d.%m.%Y %H:%M', $aso_page['date']);
								break;
							default :
								$aso_page['date'] = strftime('%d.%m.%Y %H:%M', $aso_page['date']);
						}
					}
					$aso_site['pages'][] = $aso_page;
					$GLOBALS['_SYNDICATION_']['pages'][strtotime($aso_page['date'])] = $aso_page;
				}
				$GLOBALS['_SYNDICATION_']['sites'][] = $aso_site;
			}
        }
    }
	// Trie des pages par date
	//var_dump($GLOBALS['_SYNDICATION_']['pages']);
	krsort($GLOBALS['_SYNDICATION_']['pages']);
	 
	//+----------------------------------------------------------------------------------------------------------------+
    // Extrait les variables et les ajoutes a l'espace de noms local
	// Gestion des squelettes
	extract($GLOBALS['_SYNDICATION_']);
	// Demarre le buffer
	ob_start();
	// Inclusion du fichier
	include($options['template']);
	// Recuperer le  contenu du buffer
	$sortie = ob_get_contents();
	// Arrete et detruit le buffer
	ob_end_clean();
	
	//+----------------------------------------------------------------------------------------------------------------+
	// Sortie
    return $sortie;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: syndication.php,v $
* Revision 1.7.2.3  2007-12-13 14:09:02  alexandre_tb
* remplacement d un die en return
*
* Revision 1.7.2.2  2007-12-03 14:52:21  jp_milcent
* Correction bogue : & dans les urls.
*
* Revision 1.7.2.1  2007-11-30 14:15:02  jp_milcent
* Amélioration du décodage utf8.
*
* Revision 1.7  2007-07-25 15:09:44  jp_milcent
* Fusion avec la livraison Narmer.
*
* Revision 1.5.2.4  2007-07-25 15:07:52  jp_milcent
* Correction problème url.
*
* Revision 1.5.2.3  2007-07-25 14:50:21  jp_milcent
* Corrections, meilleure utilisation de XML_Feed_Parser.
*
* Revision 1.5.2.2  2007-07-25 09:45:07  jp_milcent
* Utilisation de XML_Feed_Parser de Pear pour l'applette Syndication.
*
* Revision 1.6  2007-06-25 12:15:07  alexandre_tb
* merge from narmer
*
* Revision 1.5.2.1  2007-06-06 15:24:37  jp_milcent
* Amélioration de la compatibilité avec les anciennes version des balises de l'applette syndication.
*
* Revision 1.5  2007-04-20 12:50:18  florian
* correction bugs suite au merge
*
* Revision 1.4  2007/03/28 15:53:27  florian
* correction pb date, encodage utf-8
*
* Revision 1.3  2007/01/23 14:17:19  alexandre_tb
* backport : hack pour rattraper les dates du type 01012005 parsees par magpie
* lorsque les flux donne des dates au format iso
*
* Revision 1.2  2006/12/13 17:20:51  jp_milcent
* Correction bogue : paramï¿½tre nb non pris en compte
*
* Revision 1.1  2006/12/13 17:06:36  jp_milcent
* Ajout de l'applette Syndication.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>