<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_bp.                                                                         |
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
// CVS : $Id: ef_photoflora.php,v 1.6 2007-06-25 16:37:54 jp_milcent Exp $
/**
* eflore_bp - ef_photoflora.php
*
* Description :
*
*@package eflore_bp
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2006
*@version       $Revision: 1.6 $ $Date: 2007-06-25 16:37:54 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+
// Contient les paramêtres de connection
require_once 'Connections/PF.php';

define('EFPH_URL_PHOTO', 'http://www.tela-botanica.org/~photoflo/photos/%s/max/%s');
define('EFPH_BDD_NOM', $database_PF);
define('EFPH_BDD_HOTE', $hostname_PF);
define('EFPH_BDD_UTILISATEUR', $username_PF);
define('EFPH_BDD_MDP', $password_PF); 

$GLOBALS['_EFLORE_PHOTOFLORA_']['bdd_connection'] = mysql_connect(EFPH_BDD_HOTE, EFPH_BDD_UTILISATEUR, EFPH_BDD_MDP) or die(mysql_error());


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// Récupération des informations
mysql_select_db(EFPH_BDD_NOM, $GLOBALS['_EFLORE_PHOTOFLORA_']['bdd_connection']);
$requetes_taxon = 	'SELECT photos.*, taxons.Combinaison, photographes.Nom, photographes.Prenom, photographes.Initiales, photographes.Mail '.
					'FROM photos, photographes, taxons '.
					'WHERE photos.NumTaxon = '.$_GET['nt'].' '.
					'AND photos.Auteur = photographes.ID '.
					'AND photos.NumTaxon = taxons.NumTaxon '.
					'ORDER BY photos.support';
$resultats = mysql_query($requetes_taxon, $GLOBALS['_EFLORE_PHOTOFLORA_']['bdd_connection']) or die(mysql_error());

// Formatage du xml
$xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";
$xml .= '<rdf:RDF'."\n";
$xml .= '	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"'."\n";
$xml .= '	xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n";
$xml .= '	xmlns:dcterms="http://purl.org/dc/terms">'."\n";
while ($aso_photo = mysql_fetch_assoc($resultats)) {
	$xml .= '	<rdf:Description about="'.sprintf(EFPH_URL_PHOTO, $aso_photo['Initiales'], $aso_photo['NumPhoto']).'"'."\n";
	$xml .= '		dc:identifier="'.preg_replace('/\.\w+$/', '', $aso_photo['NumPhoto']).'"'."\n";
	$xml .= '		dc:title="'.$aso_photo['Combinaison'].'"'."\n";
	$xml .= '		dc:description="'.$aso_photo['Objet'].'"'."\n";
	$xml .= '		dc:creator="'.$aso_photo['Prenom'].' '.$aso_photo['Nom'].'"'."\n";
//	$xml .= '		dc:contributor="Daniel MATHIEU (Détermination)"'."\n";
	$xml .= '		dc:publisher="Photoflora"'."\n";
	$xml .= '		dc:type="'.donnerTxtSupport($aso_photo['Support']).'"'."\n";
	$xml .= '		dc:format="'.donnerTypeMime($aso_photo['NumPhoto']).'"'."\n";
	$xml .= '		dcterms:spatial="'.$aso_photo['lieu'].'"'."\n";
	$xml .= '		dcterms:created="'.$aso_photo['Date'].'"'."\n";
//	$xml .= '		dcterms:dateSubmitted="2006-10-18 08:32:00"'."\n";
	$xml .= '		dcterms:licence=" Utilisation des photos non autorisée sans accord avec le gestionnaire du site et sous certaines conditions - Tous droits réservés - All rights reserved"/>'."\n";
}
$xml .= '</rdf:RDF>'."\n";

// Envoi du xml au navigateur
header("Content-Type: text/xml");
echo utf8_encode(html_entity_decode(str_replace(' & ', ' &#38; ', $xml)));

// +------------------------------------------------------------------------------------------------------+
// |                                        FONCTIONS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

/**
 * Fonction fournissant les intitulés des types de support des images
 * 
 * @param integer identifiant du support
 * @return string le texte correspondant au type de support
 */
function donnerTxtSupport($support)
{
	switch ($support) {
		case "0":
			$support = "Photographie num&#233;rique (6 mégapixels)";
			break;
		case "1":
			$support = "Diapositive (sensia 100)";
			break;
		case "2":
			$support = "Photographie num&#233;rique (5 mégapixels)";
			break;
		case "10":
			$support = "Scan de la flore de Coste";
			break;
		case "11":
			$support = "Scan";
			break;
		default:
			$support = "Erreur : pr&#233;venir jpm@tela-botanica.org";
	}
	return $support;
}
/**
 * Fonction fournissant les types MIME des fichiers images
 * 
 * @param string le nom du fichier
 * @return string le texte du type MIME du fichier
 */
function donnerTypeMime($fichier)
{
	if (preg_match('/\.(\w+)$/', $fichier, $match)) {
		switch (strtolower($match[1])) {
			case "jpeg":
			case "jpg":
				$type = "image/jpeg";
				break;
			case "png":
				$type = "image/png";
				break;
			default:
				$type = "Erreur : prévenir jpm@tela-botanica.org";
		}
	} else {
		$type = "Erreur : prévenir jpm@tela-botanica.org";
	}
	return $type;
}
/**
 * Fonction fournissant une date au format Mysql
 * 
 * @param string la date composé du nom du mois en français et de l'année sous 4 chiffres
 * @return string la date dans le format Mysql
 */
function donnerDate($chaine)
{
	if (preg_match('/^(\w+) (\d{4})$/',$chaine, $match)) {
		$mois = $match[1];
		$annee = $match[2];
		switch (strtolower($mois)) {
			case 'janvier' :
				$mois_sortie = '01';
				break;
			case 'février' :
				$mois_sortie = '02';
				break;
			case 'mars' :
				$mois_sortie = '03';
				break;
			case 'avril' :
				$mois_sortie = '04';
				break;
			case 'mai' :
				$mois_sortie = '05';
				break;
			case 'juin' :
				$mois_sortie = '06';
				break;
			case 'juillet' :
				$mois_sortie = '07';
				break;
			case 'aout' :
			case 'août' :
				$mois_sortie = '08';
				break;
			case 'septembre' :
				$mois_sortie = '09';
				break;
			case 'octobre' :
				$mois_sortie = '10';
				break;
			case 'novembre' :
				$mois_sortie = '11';
				break;
			case 'decembre' :
				$mois_sortie = '12';
				break;
		}
		return $annee.'-'.$mois_sortie.'-01 01:01:01';
	} else {
		return '1970-01-01 01:01:01';
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: ef_photoflora.php,v $
* Revision 1.6  2007-06-25 16:37:54  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.5  2007-01-17 17:54:27  jp_milcent
* Fusion avec la livraison Passy avant nouvelle livraison.
*
* Revision 1.4.2.1  2006/11/29 09:51:41  jp_milcent
* Suppression de l'id de la photo qui n'est pas un numéro fixe.
*
* Revision 1.4  2006/11/15 15:53:00  jp_milcent
* Correction bogue présence de & dans le xml.
*
* Revision 1.3  2006/11/15 10:52:12  jp_milcent
* Correction problème d'accent et longueur de termes.
*
* Revision 1.2  2006/11/14 20:39:18  jp_milcent
* Service XML de type image eFlore (utilisation du Dublin Core dans du RDF) spécifique à Photoflora.
*
* Revision 1.1  2006/11/14 19:01:34  jp_milcent
* Fichier créant un service xml de type eFlore pour Photoflora.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>