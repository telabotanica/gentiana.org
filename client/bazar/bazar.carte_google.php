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
// CVS : $Id: bazar.carte_google.php,v 1.3 2007-07-04 10:08:41 alexandre_tb Exp $
/**
* 
*@package bazar
//Auteur original :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
//Autres auteurs :
*@copyright     Tela-Botanica 2000-2007
*@version       $Revision: 1.3 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


include_once 'configuration/baz_config.inc.php';
include_once BAZ_CHEMIN_APPLI.'bibliotheque/bazar.fonct.php';
// Inclusion d'une classe personnalise si elle existe

GEN_stockerFichierScript('googleMapScript', 'http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAh5MiVKCtb2JEli5I8GRSIhRbQSKaqiLzq_1FqOv3C6TjQ0qw7BS-0YnGUkxsLmj6a2a1z7YsKC-pYg');

$GLOBALS['_BAZAR_']['id_typeannonce']=$GLOBALS['_GEN_commun']['info_application']->id_nature;

// requete sur le bazar pour recuperer les evenements

$requete = 'select * from bazar_fiche where ';
if ($GLOBALS['_BAZAR_']['id_typeannonce'] != '') $requete .= 'bf_ce_nature='.$GLOBALS['_BAZAR_']['id_typeannonce'] ;
$requete .= ' and bf_date_debut_validite_fiche<=now() and '.
			'bf_date_fin_validite_fiche>=now() and bf_statut_fiche=1';
$resultat = $GLOBALS['_BAZAR_']['db']->query ($requete);

if ($resultat->numRows() != 0) {
	$script_marker = '';
	while ($ligne = $resultat->fetchRow(DB_FETCHMODE_ASSOC)) {
		$id_marker = $ligne['bf_id_fiche'];
		$script_marker .= "\t".'point = new GLatLng('.$ligne['bf_latitude'].','.$ligne['bf_longitude'].');'."\n"
				."\t".'map.addOverlay(createMarker(point, \''.
				preg_replace ('/\n/', '', str_replace ("'", "\'", baz_voir_fiche(0, $ligne['bf_id_fiche']))).'\'));'."\n";
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
    var winW = 630, winH = 460;
    var deltaH = 320;
    var deltaW = 320;
    
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
	  	var marker = new GMarker(point);
	  	GEvent.addListener(marker, "click", function() {
	    	marker.openInfoWindowHtml(chaine);
	  	});
	  	return marker;
	}
    function load() {
    setWinHW();
    if (GBrowserIsCompatible()) {
      map = new GMap2(document.getElementById("map"));
      map.addControl(new GSmallMapControl());
	  map.addControl(new GMapTypeControl());
	  map.addControl(new GScaleControl());
	  map.enableContinuousZoom();
	
	  // On centre la carte sur le languedoc roussillon
	  center = new GLatLng(43.84245116699036, 3.768310546875);
      map.setCenter(center, 7);
	  
      ' .
      $script_marker.'
    }
	};
	// Creates a marker at the given point with the given number label
	
';
GEN_stockerCodeScript($script);

function afficherContenuCorps() {
	
	include_once BAZ_CHEMIN_APPLI.'bibliotheque/bazarTemplate.class.php';
    $modele = new bazarTemplate($GLOBALS['_BAZAR_']['db']);
    $html = $modele->getTemplate(BAZ_TEMPLATE_ACCUEIL_CARTE_GOOGLE, $GLOBALS['_BAZAR_']['langue']);
	$res = str_replace ('{CARTE}', '<div id="map" style="width: 600px; height: 450px"></div>', $html);

	return $res;
}


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: bazar.carte_google.php,v $
* Revision 1.3  2007-07-04 10:08:41  alexandre_tb
* Appel du template carte_google
*
* Revision 1.2  2007-06-13 10:02:47  alexandre_tb
* le carte s adapte a la taille du conteneur
*
* Revision 1.1  2007-06-04 15:26:57  alexandre_tb
* version initiale
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/