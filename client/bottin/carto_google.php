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
// CVS : $Id: carto_google.php,v 1.2 2007-06-25 09:59:03 alexandre_tb Exp $
/**
* Cartographie google du bottin
*
*@package bottin
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision: 1.2 $ $Date: 2007-06-25 09:59:03 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

include_once 'configuration/bottin.config.inc.php';
include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.fonct.php';
// Inclusion d'une classe personnalise si elle existe
if (file_exists (INS_CHEMIN_APPLI.'bibliotheque/inscription.class.local.php')) {
	include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.class.local.php' ;	
} else {
	include_once INS_CHEMIN_APPLI.'bibliotheque/inscription.class.php';
}

$GLOBALS['ins_config']['ic_google_key'] = 'http://maps.google.com/maps?file=api&amp;v=2&amp;key='.INS_GOOGLE_KEY;
GEN_stockerFichierScript('googleMapScript', $GLOBALS['ins_config']['ic_google_key']);



// requete sur l annuaire pour recuperer des coordoonnees

$requete = 'select * from annuaire where a_est_structure=1';
$resultat = $GLOBALS['ins_db']->query ($requete);

if (DB::isError ($resultat)) {
	echo $resultat->getMessage().'<br />'.$resultat->getDebugInfo();
}
/*
if ($resultat->numRows() != 0) {
	$script_marker = '';
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
		$id_marker = $ligne['a_id'];
		$script_marker .= "\t".'point = new GLatLng('.$ligne['a_latitude'].','.$ligne['a_longitude'].');'."\n"
				."\t".'map.addOverlay(createMarker(point, \''.preg_replace ('/\n/', '', info ($ligne['a_id'], 'info')).'\'));'."\n";
				
	}
}*/
$donnees = array();
$script_marker = '';
if ($resultat->numRows() != 0) {
	$script_marker = '';
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
		if ($ligne['a_latitude'] == 0 && $ligne['a_longitude'] == 0) continue;
		$cle = $ligne['a_latitude'].'-'.$ligne['a_longitude'];
		$donnees[$cle][] = $ligne; 
	}
	foreach ($donnees as $valeur) {
		// cas un : une seule entree pour le point de coordonnees
		if (count ($valeur) == 1) {
			$chaine = $valeur[0];
			$script_marker .= "\t".'point = new GLatLng('.$chaine['a_latitude'].','.$chaine['a_longitude'].');'."\n"
				."\t".'map.addOverlay(createMarker(point, \''.
				preg_replace ('/\n/', '', str_replace ("\r\n", '', 
					str_replace ("'", "\'", info($chaine['a_id'], 'info')))).'\'));'."\n";
		} else { // Cas 2 plusieurs entrees
			$tableau_id = array();
			$script_marker .= "\t".'point = new GLatLng('.$val['a_latitude'].','.$val['a_longitude'].');'."\n"
				."\t".'map.addOverlay(createMarker(point, \'';
			foreach ($valeur as $val) {
				$script_marker .= preg_replace ('/\n/', '', str_replace ("\r\n", '', 
					str_replace ("'", "\'", info($val['a_id'], 'info'))));
			}
			$script_marker .= '\'));'."\n";
		}	
	}
} else {
	$script_marker = '';
}

$script = '
    // Variables globales
    var map = null;
	var lat = document.getElementById("latitude");
    var lon = document.getElementById("longitude");
    // Pour gerer la taille  
    var winW = 630, winH = 560;
    var deltaH = 220;
    var deltaW = 300;
        function setWinHW() {
	if (window.innerHeight) {
	    winW = window.innerWidth  - deltaW;
	    winH = window.innerHeight - deltaH;
        } else {
	    winW = document.documentElement.offsetWidth  - 20 - deltaW;
	    winH = document.documentElement.offsetHeight - 20 - deltaH ; 
        }
        
	var me = document.getElementById("map");
	if (me != null) {
	    me.style.width= \'\' + winW + \'px\';
	    me.style.height= \'\' + winH + \'px\';
        }
    }

    window.onresize = function () {
	setWinHW();
	if (map)  map.checkResize();
    }	
    
    function createMarker(point, chaine) {
	  	var icon = new GIcon();
		icon.image = "http://connaisciences.fr/sites/connaisc/fr/images/marker.png";
		icon.shadow = "http://www.google.com/mapfiles/shadow50.png";
		icon.iconSize = new GSize(20, 34);
		icon.shadowSize = new GSize(37, 34);
		icon.iconAnchor = new GPoint(6, 34);
		icon.infoWindowAnchor = new GPoint(5, 1);

	    var marker = new GMarker(point, icon);
	  	GEvent.addListener(marker, "click", function() {
	    	marker.openInfoWindowHtml(chaine);
	  	});
	  	return marker;
	}
    function load() {
    if (GBrowserIsCompatible()) {
      setWinHW();
      map = new GMap2(document.getElementById("map"));
      map.addControl(new GSmallMapControl());
	  map.addControl(new GMapTypeControl());
	  map.addControl(new GScaleControl());
	  map.enableContinuousZoom();
	
	  // On centre la carte sur le languedoc roussillon
	  center = new GLatLng(43.84245116699036, 3.768310546875);
      map.setCenter(center, 7);
	   map.setMapType(G_HYBRID_MAP);
      ' .
      $script_marker.'
    }
	};
	// Creates a marker at the given point with the given number label
	
';
GEN_stockerCodeScript($script);

function afficherContenuCorps() {
	// Appel du template
	include_once INS_CHEMIN_APPLI.'bibliotheque/bottin.class.php';
	$template = inscription::getTemplate(INS_TEMPLATE_CARTO_GOOGLE_ACCUEIL, 1);
	$carte = '<div id="map" style="width: 600px; height: 450px"></div>';
	$res = str_replace ('{CARTE}', $carte, $template);
	
	return $res;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: carto_google.php,v $
* Revision 1.2  2007-06-25 09:59:03  alexandre_tb
* ajout de carte_google, mise en place des templates avec api/formulaire, configuration de multiples inscriptions, ajout de modele pour les mails
*
* Revision 1.1  2007-06-01 13:39:14  alexandre_tb
* version initiale
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/