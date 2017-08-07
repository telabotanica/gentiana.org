<?php
// +--------------------------------------------------------------------------------+
// | fonctions.php 				                             						|
// +--------------------------------------------------------------------------------+
// | Copyright (c) 2002 Tela Botanica		   							        	|
// +--------------------------------------------------------------------------------+
// | Fonctions diverses                                                             |
// +--------------------------------------------------------------------------------+
// | Auteur : Alexandre Granier <alexandre@tela-botanica.org> 		  		        |
// +--------------------------------------------------------------------------------+
//
// $Id: fonctions.php,v 1.1 2005/09/22 14:02:49 ddelon Exp $

// effectue une requete sur un colonne unique et renvoie le resultat sous la forme
// d'un tableau

function get($query) {
	$tableau = array() ;
	$query = "SELECT " . $query;
	$result = mysql_query($query) or die ("Echec de la requ&ecirc;te sur AGORA");
	while ($row = mysql_fetch_row($result)) {
		array_push ($tableau,$row[0]);
	}

return $tableau ;
}

function textecourt($texte, $taille) {
	if (strlen($texte) > $taille) return substr($texte, 0, $taille-3)."...";
	return $texte;
}

 // formulaire, prend en parametre les valeurs par defaut
 
function formulaire($titre="",$description="", $abreviation="", $internet="", $selectedForums="", $selectedProjet="",$origine="NOUVEAU") {
	global $baseURL, $forums, $projets, $projetAb ;
	$forums = get("AGO_A_ALIAS FROM agora") ;
	$IDforums = get ("AGO_A_ID FROM agora");
	$projets = get("TITRE FROM PROJET_PROJET ORDER BY ABREVIATION");
	$projetAb = get("ABREVIATION FROM PROJET_PROJET ORDER BY ABREVIATION") ;
	if ($selectedForums == "") $selectedForums = array() ;
	if ($selectedProjet == "") $selectedProjet = array() ;
	$res ="<table>\n";
	if ($origine == "NOUVEAU") {
	$res .="<form action=\"$baseURL&menuProjet=projetadm&action=2\" method=\"post\">\n";
	} else {
		$res .="<form action=\"$baseURL&menuProjet=projetgest&projet=$abreviation&action=2\" method=\"post\">\n";
	}	
	$res .="<tr class=\"text\"><td style=\"text-align:right;font-weight:bold;\">Titre :</td><td><input type=\"text\" 
			class=\"insInputForm\" name=\"titre\" size=\"60\" value=\"$titre\"></td></tr>\n";
	$res .="<tr class=\"text\"><td valign=\"top\" style=\"text-align:right;font-weight:bold;\">Description :</td><td><textarea name=\"description\" 
			class=\"insInputForm\" cols=\"60\" rows=\"20\">$description</textarea></td></tr>\n";
	if ($origine == "NOUVEAU") {
	$res .="<tr class=\"text\"><td style=\"text-align:right;font-weight:bold;\">Abr&eacute;viation :</td>\n";
	$res .="<td><input class=\"insInputForm\" type=\"text\" name=\"abreviation\" size=\"5\" value=\"$abreviation\">&nbsp;&nbsp;";
	$res .="&nbsp;&nbsp;Au maximum 5 caract&egrave;res, de pr&eacute;f&eacute;rence en majuscule.</td></tr>\n";
	}
	$res .="<tr class=\"text\"><td style=\"text-align:right;font-weight:bold;\">Espace Internet :</td>\n";
	$res .="<td><input class=\"insInputForm\" type=\"text\" name=\"internet\" size=\"60\" value=\"$internet\"></td></tr>\n";
	$res .="<tr class=\"text\"><td valign=\"top\" style=\"text-align:right;font-weight:bold;\">Forums associ&eacute;s :</td><td><select class=\"insInputForm\" name=forumsS[] size=\"";
	$res .=count($forums);
	$res .="\" multiple>\n";
	for ($i = 0 ; $i < count($forums) ; $i++) {
		$res .="<option value=\"$IDforums[$i]\"";
		if (in_array($forums[$i],$selectedForums)) $res .=" selected";
		$res .=">";
		$res .=$forums[$i];
		$res .="</option>\n";
	}
	$res .="</select>\n";
	$res .="<tr class=\"text\"><td valign=\"top\" style=\"text-align:right;font-weight:bold;\">Projets associ&eacute;s :</td>\n<td><select class=\"insInputForm\" name=projetsS[] size=\"";
	$res .=count($projets);
	$res .="\" multiple>\n";
	for ($i = 0 ; $i < count($projets) ; $i++) {
		$res .="<option value=\"";
		$res .=$projetAb[$i];
		$res .="\"";
		if (in_array($projetAb[$i],$selectedProjet)) $res .=" selected";
		$res .=">";
		$res .=$projets[$i];
		$res .="</option>\n";
	}
	$res .="</select></td></tr>\n";
	$res .="<tr><td colspan=\"2\" align=\"center\">\n";
	if ($origine != "NOUVEAU") $res .="<input style=\"background-color:#FFFFFF\" type=\"button\" onclick=\"Javascript:history.go(-1);\" value=\"Annuler\">\n" ;
	$res .="<input style=\"background-color:#FFFFFF\" type=\"submit\"";
	
	if ($origine == "NOUVEAU") {
	$res .=" value=\"Cr&eacute;er\">";
	} else { $res .=" value=\"Valider\">";
		}
	$res .="</td></tr>\n";
	$res .="</form>\n";
	$res .="</table>\n";
	return $res ;
}

function getExtension($filename) {
	$extension = explode (".",$filename) ;
	return $extension[1] ;
}

#--------------------------------------------------------------
#	Insere $num espace insecable
#--------------------------------------------------------------

function insert_spaces($num) {
	$res = "" ;
	for ($i = 0; $i < $num; $i++) $res .= "&nbsp;";
	return $res ;
}

function getEnumSet($text) {
	$resultat = explode("'", $text) ;
	$retour = array() ; $j = 0 ;
	for ($i = 1 ; $i < count ($resultat)-1 ; $i = $i + 2) {
	$retour[$j] = $resultat[$i] ;
	$j++ ;
	}
	return $retour ;
}

$jour = array("lundi","mardi", "mercredi", "jeudi", "vendredi", "samedi","dimanche");
$moi = array("janvier","f&eacute;vrier","mars","avril","mai","juin","juillet","septembre","octobre","novembre","d&eacute;cembre") ;

function parcourrirAnnu($event) {
	global $baseURL, $lettre, $menuProjet ;
	$outputText = "" ;
	$outputText .= "<tr><td>&nbsp;</td></tr>\n";
	$outputText .= "<tr><td><table align=\"center\">";
	$outputText .= "<tr class=\"texte_tb\">";
	// ecrire toutes les lettres avec un lien
	for ($i = 65 ; $i <91 ; $i++) {
	$outputText .= "\t<td><a style=\"font-size:15px;\" href=\"$baseURL&amp;menuProjet=$menuProjet&amp;action=$event&amp;lettre=";
	$outputText .= chr($i) ;
	$outputText .= "\">";
	$outputText .= chr($i) ;
	$outputText .= "</a></td>\n";
	}
	$outputText .= "<td>&nbsp;&nbsp;<a href=\"$baseURL&amp;menuProjet=$menuProjet&amp;action=$event&amp;lettre=tous\">Tous</a></td>\n" ;
	$outputText .= "</tr></table></td></tr>\n";
	
	// si une lettre est selectionne
	if (!empty($lettre)) {	
		$query = "SELECT annuaire_tela.U_NAME,annuaire_tela.U_SURNAME,annuaire_tela.U_MAIL,annuaire_tela.U_CITY,
						annuaire_tela.U_ZIP_CODE,gen_COUNTRY.GC_NAME FROM annuaire_tela,gen_COUNTRY WHERE";
		if ($lettre != "tous") $query .= " U_NAME LIKE \"$lettre%\" AND" ;
		$query .= " annuaire_tela.U_COUNTRY=gen_COUNTRY.GC_ID AND gen_COUNTRY.GC_LOCALE=\"fr\"
						AND U_NAME<>\"\" and U_SHOW=3 ORDER BY U_NAME" ;
		$result = mysql_query($query) or die ("Echec de la requ&ecirc;te sur annuaire_tela...");
		if (mysql_num_rows($result) != 0) {
			// pour chaque nom, on inscrit les infos
			$outputText .= "<tr><td>&nbsp;</td></tr>\n";
			$outputText .= "<tr class=\"insTitle1\"><td>Liste des inscrits &agrave; la lettre : $lettre</td></tr>\n";
			$outputText .= "<tr><td><table width=\"100%\">";
			$outputText .= "<tr class=\"insTitle1\"><td>Nom</td>";
			$outputText .= "<td>Pr&eacute;nom</td><td align=\"center\">E-mail</td>\n";
			$outputText .= "<td align=\"center\">Code postal</td><td>Pays</td></tr>\n";
			$pair = true ;
			while ($row = mysql_fetch_object($result)) {
				$outputText .= "<tr class=\"texte_tb2\"";
				if ($pair) {
					$outputText .= " bgcolor=\"#E8FFE5\"";
					$pair = false ;
					} else {
					$pair = true ;
					}
				$outputText .= "><td>$row->U_NAME</td><td>$row->U_SURNAME</td>\n";
				$outputText .= "<td align=\"left\"><a href=\"mailto:$row->U_MAIL\">$row->U_MAIL</a></td>\n";
				$outputText .= "<td align=\"center\">$row->U_ZIP_CODE</td>\n";
				$outputText .= "<td>$row->GC_NAME</td>\n" ;
				$outputText .= "</tr>\n";
			}
			$outputText .= "</table></td></tr>\n";
		} else {
		$outputText .= "<tr><td>&nbsp;</td></tr>\n";
		$outputText .= "<tr class=\"texte_tb\"><td>Pas d'inscrit</td></tr>\n";
		}
	}
	return $outputText ;
	
}
function formRep($nom="", $description="", $origine="NOUVEAU", $visibilite="") {
	global $baseURL, $projet, $repcourant, $id ;
	if ($origine == "NOUVEAU") {
		$res = "<form action=$baseURL&action=20\" method=\"post\">\n" ;
		} else {
		$res = "<form action=$baseURL&action=19\" method=\"post\"\n>" ;
		}
	$res .= "\t<table align=\"center\">\n\t" ;
	$res .= "<tr class=\"texte_tb\"><td colspan=\"2\">N'utilisez pas d'accents, ni d'espace pour le nom du r&eacute;pertoire.</td></tr>\n";
	$res .= "<tr class=\"text\"><td style=\"font-weight:bold;text-align:right\">" ;
	$res .= "Nom : </td><td><input class=\"insInputForm\" type=\"text\" name=\"nom\" size=\"80\" value=\"$nom\"></td></tr>\n" ;
	$res .= "<tr class=\"text\"><td style=\"font-weight:bold;text-align:right;vertical-align:top\">Description : </td>\n" ;
	$res .= "<td><textarea class=\"insInputForm\" name=\"description\" cols=\"81\">$description</textarea></td></tr>\n" ;
	$res .= "<tr class=\"text\"><td align=\"right\"><b>Visibilit&eacute; :</b></td>\n";
	$res .= "<td align=\"left\">\n";
	$res .= "<input style=\"background-color:#FFFFFF;\" type=\"radio\" name=\"visible\" value=\"public\"" ;
	if ($visibilite == "public" or $visibilite == "") $res .= " checked" ;
	$res .= ">Tout public&nbsp;&nbsp;&nbsp;&nbsp;";
	$res .= "<input style=\"background-color:#FFFFFF;\" type=\"radio\" name=\"visible\" value=\"prive\"" ;
	if ($visibilite == "prive") $res.= " checked" ;
	$res .= ">Projet seulement</td></tr>\n";
	$res .= "<tr class=\"text\"><td><input type=\"hidden\" name=\"repcourant\" value=\"$repcourant\"</td><td>\n" ;
	$res .= "<input type=\"hidden\" name=\"id\" value=\"$id\">" ;
	$res .= "<input type=\"submit\" style=\"background-color:#FFFFFF;\"" ;
	if ($origine == "NOUVEAU") { $res.= "value=\"Valider\"" ; } else { $res .= "value=\"Modifier\"" ; }
	$res .= "></td></tr></table></form>\n" ;
	return $res ;
}

// renvoie le chemin complet depuis la racine de l'application
// on indique en argument l'identifiant du repertoire en cour
// la fonction remonte d'etage en etage jusqu'a ce que gen_voiraussi.PERE soit NULL
function getPath($ID_rep) {
	$path = "" ;
	$query = "SELECT PERE,NOM FROM gen_repertoire WHERE ID='$ID_rep'" ;
	$result = mysql_query($query) or die ("Echec de la requ&ecirc;te dans gen_voiraussi, au cours de la recherche
							du chemin des repertoire") ;
	$row = mysql_fetch_object($result) ;
	
	if ($row->PERE != NULL) {
		$path .= getPath($row->PERE)."/".$row->NOM  ;
		}
	return $path ;
}


// renvoie le chemin avec les tag <a href

function getHTMLPath($ID_rep) {
	global $baseURL ;
	$query = "SELECT PERE,NOM FROM gen_repertoire WHERE ID='$ID_rep'" ;
	$result = mysql_query($query) or die ("Echec de la requ&ecirc;te dans gen_voiraussi, au cours de la recherche
							du chemin des repertoire") ;
	$row = mysql_fetch_object($result) ;
	
	if ($row->PERE != NULL) {
		$path .= " <b>&gt;</b><a href=\"$baseURL&amp;repcourant=$ID_rep\">" ;
		$path .= $row->NOM  ;
		$path .= "</a>\n" ;
		$path = getHTMLPath($row->PERE).$path ;		
		}
	return $path ;
}

function nettoieAccent(&$texte) {

// un peu barbare
	$texte = ereg_replace("é","e",$texte) ;
	$texte = ereg_replace("è","e",$texte) ;
	$texte = ereg_replace("ê","e",$texte) ;
	$texte = ereg_replace("à","a",$texte) ;
	$texte = ereg_replace("ù","u",$texte) ;
	$texte = ereg_replace("â","a",$texte) ;
	$texte = ereg_replace("ä","a",$texte) ;
	$texte = ereg_replace("ë","e",$texte) ;
	$texte = ereg_replace("î","i",$texte) ;
	$texte = ereg_replace("ô","o",$texte) ;
	$texte = ereg_replace("û","u",$texte) ;
	$texte = ereg_replace("ö","o",$texte) ;
	$texte = ereg_replace("ü","u",$texte) ;

	return $texte ;
}

?>