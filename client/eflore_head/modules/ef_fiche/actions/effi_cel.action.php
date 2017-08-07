<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1.1                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2006 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eFlore-Fiche.                                                                   |
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
* Fichier d'action du module eFlore-Fiche : Cel
*
* Appel Carnet en ligne
* 
*
*@package eFlore
*@subpackage ef_fiche
//Auteur original :
*@author        David Delon <dd@clapas.net>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2006
*@version       $Revision$ $Date$
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+



class ActionCel extends aAction  {
	
	public function executer()
	{
		// Initialisation des variables
		$tab_retour = array();
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Ajout du code du référentiel
		$tab_retour['titre_general_referentiel'] = $_SESSION['cpr'].' v'.$_SESSION['cprv'];
		// Intégration du moteur de recherche par nom latin		
		$une_recherche = new EfRecherche();
		$une_recherche->setFormat($this->getRegistre()->get(EF_LG_URL_FORMAT));
		// Création Formulaire recherche nomenclaturale
		$tab_retour['un_form_nom'] = $une_recherche->executer('form_nom');
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Récupération d'infos générales
		$tab_retour['nn'] = $_SESSION['nn'];
		$tab_retour['nom_retenu_simple'] = $_SESSION['NomRetenu']->formaterNom(NomDeprecie::FORMAT_ULTRA_SIMPLE);
		if (isset($_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']])) {
			$tab_retour['nom_retenu_famille'] = $_SESSION['nom_retenu_famille_'.$_SESSION['nn'].'_'.$_SESSION['nvpn']];
		}
		
		// +-----------------------------------------------------------------------------------------------------------+
		// Récupération des infos sur le taxon courrant et le nom sélectionné
		$tab_retour['nom_retenu'] = $_SESSION['NomRetenu'];
		$tab_retour['nom_selection'] = $_SESSION['NomSelection'];
		
		$tab_retour['contenu_page'] = calcule_repartition();
		
		return $tab_retour;
		
	}
	
}


function calcule_repartition()
{
	require_once EF_CHEMIN_BIBLIO.'jpeg/JPEG.php';
	
	// Lecture commentaires embarqués dans la page
	$src_map = 'france_utm_31.jpg';
	$comment_jpeg=get_jpeg_Comment(get_jpeg_header_data(EF_CHEMIN_CARTE_SRC.$src_map));
	// Solution facile de lecture, mais difficile à maintenir : notamment la notation
	parse_str($comment_jpeg);
	
	// Rappel : Pixel : O,0 en haut gauche
	
	// X Coin inferieur gauche en Pixel
	//$Px_echelle_X1['31T']=0;
	$Px_echelle_X1['31T'] = $X131T;
	// Y Coin inferieur gauche en Pixel
	//$Px_echelle_Y1['31T']=539;
	$Px_echelle_Y1['31T']=$Y131T;
	
	
	// Pour calcul Resolution
	// X Coin inferieur droit en Pixel
	//$Px_echelle_X2['31T']=805;
	$Px_echelle_X2['31T']=$X231T;
	// Y Coin inferieur droit en Pixel
	//$Px_echelle_Y2['31T']=539;
	$Px_echelle_Y2['31T']=$Y231T;
	
	// X Coin inferieur gauche en UTM
	//$M_UTM_X1['31T']=300092;
	$M_UTM_X1['31T']=$X131TUTM;
	// Y Coin inferieur gauche en UTM
	//$M_UTM_Y1['31T']=4536867;
	$M_UTM_Y1['31T']=$Y131TUTM;
	
	// Pour calcul "resolution"
	
	// X Coin inferieur droit en UTM
	//$M_UTM_X2['31T']=105371; //
	$M_UTM_X2['31T']=$X231TUTM;
	// Y Coin inferieur droit en UTM
	//$M_UTM_Y2['31T']=5042332;
	$M_UTM_Y2['31T']=$Y231TUTM;

	// "Resolution"
	$p['31T']=($Px_echelle_X2['31T'] - $Px_echelle_X1['31T']) / ($M_UTM_X2['31T'] - $M_UTM_X1['31T']);
	
	// Fuseau 32T :
	
	// Pixel : O,0 en haut gauche
	
	// X Coin inferieur gauche en Pixel
	//$Px_echelle_X1['32T']=483;
	$Px_echelle_X1['32T']=$X132T;
	
	// Y Coin inferieur gauche en Pixel
	//$Px_echelle_Y1['32T']=536;
	$Px_echelle_Y1['32T']=$Y132T;
	
	// X Coin inferieur droit en Pixel
	//$Px_echelle_X2['32T']=805;
	$Px_echelle_X2['32T']=$X232T;
	// Y Coin inferieur droit en Pixel
	//$Px_echelle_Y2['32T']=536;
	$Px_echelle_Y2['32T']=$Y232T;
	
	
	// X Coin inferieur gauche en UTM
	//$M_UTM_X1['32T']=247615;
	$M_UTM_X1['32T']=$X132TUTM;
	// Y Coin inferieur gauche en UTM
	//$M_UTM_Y1['32T']=4540000;
	$M_UTM_Y1['32T']=$Y132TUTM;
	
	//$angle3132;

	// "Resolution"
	$p['32T']=($Px_echelle_X2['31T'] - $Px_echelle_X1['31T'] ) / ($M_UTM_X2['31T'] - $M_UTM_X1['31T']);
	
	// Fuseau 30T :
	
	// X Coin inferieur gauche en Pixel
	//$Px_echelle_X1['30T']=483;
	$Px_echelle_X1['30T']=$X130T;
	
	// Y Coin inferieur gauche en Pixel
	//$Px_echelle_Y1['30T']=536;
	$Px_echelle_Y1['30T']=$Y130T;
	
	// X Coin inferieur droit en Pixel
	//$Px_echelle_X2['30T']=805;
	$Px_echelle_X2['30T']=$X230T;
	// Y Coin inferieur droit en Pixel
	//$Px_echelle_Y2['30T']=536;
	$Px_echelle_Y2['30T']=$Y230T;
	
	// X Coin inferieur gauche en UTM
	//$M_UTM_X1['30T']=247615;
	$M_UTM_X1['30T']=$X130TUTM;
	// Y Coin inferieur gauche en UTM
	//$M_UTM_Y1['30T']=4540000;
	$M_UTM_Y1['30T']=$Y130TUTM;
	
	// angle
	//$a=356.0; // (-4 degre)
	
	// "Resolution"
	$p['30T']=($Px_echelle_X2['31T'] - $Px_echelle_X1['31T'] ) / ($M_UTM_X2['31T'] - $M_UTM_X1['31T']);

	// Nom du fichier image en sortie
	$dest_map =  'nt'.$_SESSION['nt'].'_'.$src_map; 
	$img = imagecreatefromjpeg(EF_CHEMIN_CARTE_SRC.$src_map);
	$couleur = 'green';
	switch ($couleur) {
		case 'green':
		   $fill = imagecolorallocate($img, 0, 255, 0);
		   break;
		case 'red':
		   $fill = imagecolorallocate($img, 255, 0, 0);
		   break;
		case 'blue':
		   $fill = imagecolorallocate($img, 0, 0, 255);
		   break;
		case 'black':
		   $fill = imagecolorallocate($img, 0, 0, 0);
		   break;
		default:
		   $fill = imagecolorallocate($img, 0, 255, 0);
	}

	$retour.= '<a name="topmap"></a>';

	// Récuperation donnée inventaire
	$dblink = @mysql_connect (EF_BDD_SERVEUR, EF_BDD_UTILISATEUR, EF_BDD_MOT_DE_PASSE);
	if ($dblink) {
    	if (!@mysql_select_db(EF_BDD_NOM_CEL, $dblink)) {
			@mysql_close($dblink);
			$dblink = false;
       }
	}

	$inventories = LoadAll('SELECT location, id_location, date_observation, identifiant FROM cel_inventory WHERE num_taxon = "'.mysql_escape_string($_SESSION['nt']).'" AND transmission = 1 ',$dblink);

	if (is_array($inventories)){
		$i = 0;
		foreach ($inventories as $inventory){
			if ($inventory['id_location']!="null") {
				$utm = LoadSingle("select * from locations where name = '".mysql_escape_string($inventory['location'])."' and code='".mysql_escape_string($inventory['id_location'])."' limit 1",$dblink);
			}
			else {
				$utm = LoadSingle("select * from locations where name = '".mysql_escape_string($inventory['location'])."' limit 1",$dblink);
			}
			
			// Ultime tentative 
			if (!$utm) {
				$utm = LoadSingle("select * from locations where name = '".mysql_escape_string($inventory['location'])."' limit 1",$dblink);
			}
				
			// C'est trouvé !
			if ($utm) {
				// On centre le point au milieu de la maille 10x10 par defaut ...
				$pad = str_repeat ('0' ,(7 - strlen( $utm['x_utm'])));
				$utm['x_utm'] = $pad.$utm['x_utm'];

				$pad = str_repeat ('0' ,(7 - strlen( $utm['y_utm'])));
				$utm['y_utm'] = $pad.$utm['y_utm'];

				$utm['x_utm'] = substr($utm['x_utm'] ,0,3);
				$utm['x_utm'] = $utm['x_utm'].'5000';

				$utm['y_utm'] = substr($utm['y_utm'] ,0,3);
				$utm['y_utm'] =$utm['y_utm'].'5000';
	
				// Fuseau 31 T
				if ($utm['sector']=='31T') {
					$x = (($utm['x_utm'] - $M_UTM_X1['31T']) * $p['31T'] ) + $Px_echelle_X1['31T'];
					$y = $Px_echelle_Y2['31T']-(($utm['y_utm'] - $M_UTM_Y1['31T']) * $p['31T'] );
				} else {
					// Fuseau 32 T : une rotation + translation est appliquée
					if ($utm['sector'] == '32T') {
						$cosa = cos(deg2rad($angle3132));
						$sina = sin(deg2rad($angle3132));
	
						$xp = (($utm['x_utm'] - $M_UTM_X1['32T']) * $cosa) + (($utm['y_utm']- $M_UTM_Y1['32T']) * $sina);
						$yp = (-($utm['x_utm'] - $M_UTM_X1['32T'])* $sina) + (($utm['y_utm'] - $M_UTM_Y1['32T'])* $cosa);
						$x = ($xp * $p['32T'] ) + $Px_echelle_X1['32T'];
						$y = $Px_echelle_Y2['32T']-($yp * $p['32T'] );
					} else {
						// Fuseau 30 T : une rotation + translation est appliquée
						if ($utm['sector'] == '30T') {
							$cosa = cos(deg2rad($angle3031));
							$sina = sin(deg2rad($angle3031));
	
							$xp = (($utm['x_utm'] - $M_UTM_X1['30T']) * $cosa) + (($utm['y_utm']- $M_UTM_Y1['30T']) * $sina);
							$yp = (-($utm['x_utm'] - $M_UTM_X1['30T'])* $sina) + (($utm['y_utm'] - $M_UTM_Y1['30T'])* $cosa);
							$x=($xp * $p['30T'] ) + $Px_echelle_X1['30T'];
							$y=$Px_echelle_Y2['30T']-($yp * $p['30T'] );
						}
					}
				}
				$x = round($x);
				$y = round($y);
				
				$comment = '';	
				$name = utf8_decode($utm['name']);
				
				if ($inventory['date_observation'] != '0000-00-00 00:00:00') {
					list($year,$month,$day) = split ('-',$inventory['date_observation']);
	    	        list($day) = split (' ',$day);
					$comment .= ', le '.$day.'/'.$month.'/'.$year;
				}
				$comment .= ' par '.$inventory['identifiant'];
				
				// On stocke les commentaires pour affichage dans les tooltips
				// Commentaire deja présent ? : on ajoute à la suite
				if ($text[$x.'|'.$y]) {
					$link=$text[$x.'|'.$y]=$text[$x.'|'.$y].'<br>'.$name.$comment;
				} else {
					// Nouveau commentaire
					$text[$x.'|'.$y]=$name.$comment;
				}
	
			}
			$i++;
		}
	
		$usemap = '';
		foreach ($text as $coord => $maptext ) {
			list($x,$y) = explode('|', $coord);
			imagefilledellipse($img, $x, $y, 7, 7, $fill);
			// pas de double quote dans le texte
			$maptext = preg_replace("/'/", "\'", $maptext);
			$maptext = preg_replace("/\"/", "\'", $maptext);
			$usemap = $usemap."<area shape=\"circle\" alt=\"\" coords=\"".$x.",".$y.",5\" onmouseover=\"this.T_BGCOLOR='#E6FFFB';this.T_OFFSETX=-200;this.T_OFFSETY=-150;this.T_STICKY=1;return escape('".$maptext."')\" href=\"".$GLOBALS['REQUEST_URI']."\"/>";
		}
		
		//imageinterlace($img,1);
	    imagejpeg($img, EF_CHEMIN_CARTE_STOCKAGE.$dest_map,95);
		//imagedestroy($img);
		
		$retour.=  "<div id =\"cartowikimap\" style=\"position:relative;\">";
		$retour.=  "<img src=\"".(EF_URL_CARTO_CEL_DST.$dest_map)."\" style=\"border:none; cursor:crosshair\" alt=\"\" usemap=\"#themap\"></img><br />\n";
		$retour.=  "<map name=\"themap\" id=\"themap\">";
		$retour.=  $usemap;
		$retour.=  "</map>";
		$retour.=  "</div>";
				
		$retour.=  "<script language=\"JavaScript\" type=\"text/javascript\" src=\"".EF_URL_JS."wz_tooltip.js\"></script>";
	} else {
		$retour.=  "<map name=\"themap\" id=\"themap\">";
		$retour.=  "<img src=\"".EF_URL_CARTO_CEL_SRC.$src_map."\" style=\"border:none; cursor:crosshair\" alt=\"\"></img><br />\n";
		$retour.=  "</map>";
	}
	return $retour;
}

function Query($query,$dblink)
{
	if (!$result = mysql_query($query, $dblink))
	{
		ob_end_clean();
		die("Query failed: ".$query." (".mysql_error().")");
	}
	return $result;
}
	
function LoadSingle($query,$dblink)
{
	if ($data = LoadAll($query,$dblink)) {
		return $data[0];
	}
}
	
function LoadAll($query,$dblink)
{
	$data=array();
	if ($r = Query($query,$dblink)) {
		while ($row = mysql_fetch_assoc($r)) $data[] = $row;
		mysql_free_result($r);
	}
	return $data;
}	


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log$
* Revision 1.6  2007-06-19 10:32:57  jp_milcent
* Début utilisation de classes par module utilisant l'API 1.1.1.
* Renomage des anciennes classes en "Deprecie".
*
* Revision 1.5  2007-06-11 13:11:41  jp_milcent
* Mise en forme du code.
*
* Revision 1.4  2007-06-11 12:46:27  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.1.2.8  2007-06-07 13:33:43  ddelon
* lien vers page courante
*
* Revision 1.1.2.7  2007-06-04 10:23:58  ddelon
* bug affichage commune ?
*
* Revision 1.1.2.6  2007-06-04 10:03:13  ddelon
* bug affichage commune ?
*
* Revision 1.1.2.5  2007-05-18 21:21:16  ddelon
* Correction carto
*
* Revision 1.1.2.4  2007-05-18 21:18:50  ddelon
* Correction carto
*
* Revision 1.1.2.2  2007-05-13 14:20:30  ddelon
* Action carnet en ligne : maquette
*
* Revision 1.1.2.1  2007-05-09 20:36:53  ddelon
* Action carnet en ligne : maquette
*
*/
?>