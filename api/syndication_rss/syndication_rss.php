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
// CVS : $Id$
/**
*
* Fonctions du module rss de papyrus
* 
*
*@package syndication_rss
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
*@author        Florian Schmitt <florian@ecole-et-nature.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision$
// +------------------------------------------------------------------------------------------------------+
*/

define('MAGPIE_DIR', GEN_CHEMIN_API.'syndication_rss/magpierss/');
define('MAGPIE_CACHE_DIR', MAGPIE_DIR.'tmp/magpie_cache');
define('OUVRIR_LIEN_RSS_NOUVELLE_FENETRE', 1);
define('FORMAT_DATE', 'jma');
require_once(MAGPIE_DIR.'rss_fetch.inc');

function voir_rss($titre='', $url='', $nb=0, $nouvelle_fenetre=OUVRIR_LIEN_RSS_NOUVELLE_FENETRE, $formatdate=FORMAT_DATE, $template = "") {
	$res= '';
	if ( $url!='' ) {
		$rss = fetch_rss( $url );
		
		if ($template != "") {
			$i = 0 ;
			foreach ($rss->items as $item) {
				// Le test suivant pour savoir s il faut reduire l excendent de description
				// Si {all} est present dans le template on ne reduit pas
				if (preg_match ('/{all}/', $template)) {
					$template = str_replace('{all}', '', $template);
					$all = true ;
				} else {
					$all = false;
				}
				if (strlen($item['description']) > 200 && !$all) {
					$item['description'] = substr ($item['description'] , 0, 300).'... <a href="'.$item['link'].'">Lire la suite</a>';
				}
				if (!isset($item['pubdate'])) $item['pubdate'] = date('dmY');
				
				// Le code ci-apres est pour rattraper les dates du type 01012005 parsees par magpie
				// lorsque les flux donne des dates au format iso
				if (preg_match('/^([0-3][0-9])([0-1][0-9])([0-9][0-9][0-9][0-9])$/', $item['pubdate'], $match)) {
					$item['pubdate'] = $match[3].'-'.$match[2].'-'.$match[1];
					//echo $item['pubdate'];
				}
				$res .= str_replace ('{num}', ++$i, 
						str_replace ('{item}', '<a href="'.$item['link'].'" target="_top">'.$item['title'].'</a>', 
						str_replace ('{date}', strftime('%d.%m.%Y',strtotime($item['pubdate'])),
						str_replace ('{description}', $item['description'], $template)))) ;
				$res .= "\n";
				if ($i > $nb) break;
				
			}
			return $res ;
		}
		if ( $titre=='' ) {$res .= '<h2>'.$rss->channel['title'].'</h2>'."\n";}
		elseif ( $titre!='0' ) {$res .= '<h2>'.$titre.'</h2>'."\n";}
		$res .= '<ul class="liste_rss">'."\n";
		$i=0;
        $nb_item=count($rss->items);
		if (($nb==0)or($nb_item<=$nb)) {
			foreach ($rss->items as $item) {
				$href = $item['link'];
				$title = $item['title'];	
				$res .= '<li class="titre_rss">'."\n";
				if (isset($item['pubdate'])) $date=$item['pubdate'];
				elseif ((!isset($item['pubdate']))and(isset($item['date_timestamp']))) $date=$item['date_timestamp'];
				else $formatdate='';
				if ($formatdate=='jm') {$res .= strftime('%d.%m',strtotime($date)).': ';}
				if ($formatdate=='jma') {$res .= strftime('%d.%m.%Y',strtotime($date)).': ';}
				if ($formatdate=='jmh') {$res .= strftime('%d.%m %H:%M',strtotime($date)).': ';}
				if ($formatdate=='jmah') {$res .= strftime('%d.%m.%Y %H:%M',strtotime($date)).': ';}
                $res .= '<a class="lien_rss" href="'.$href;
        	               	if ($nouvelle_fenetre==1) $res .=  '" onclick="window.open(this.href); return false;';
				$res .= '">'.$title.'</a></li>'."\n";
			}
		}
		else {
			$i=0;
			foreach ($rss->items as $item) {
				$href = $item['link'];
				$title = $item['title'];	
				$res .= '<li class="titre_rss">'."\n";
				if (isset($item['pubdate'])) $date=$item['pubdate'];
				elseif ((!isset($item['pubdate']))and(isset($item['date_timestamp']))) $date=$item['date_timestamp'];
				else $formatdate='';
				if ($formatdate=='jm') {$res .= strftime('%d.%m',strtotime($date)).': ';}
				if ($formatdate=='jma') {$res .= strftime('%d.%m.%Y',strtotime($date)).': ';}
				if ($formatdate=='jmh') {$res .= strftime('%d.%m %H:%M',strtotime($date)).': ';}
				if ($formatdate=='jmah') {$res .= strftime('%d.%m.%Y %H:%M',strtotime($date)).': ';}
                $res .= '<a class="lien_rss" href="'.$href;
        	               	if ($nouvelle_fenetre==1) $res .=  '" onclick="window.open(this.href); return false;';
				$res .= '">'.$title.'</a></li>'."\n";
				$i++;
				if ($i>=$nb) break;
			}
		}
		$res .= '</ul>'."\n";
	}
        //echo '<pre>'.var_dump($rss->items).'</pre><br /><br />';
	return $res;
}
?>
