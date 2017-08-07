<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.3                                                                                    |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of Cartographie.                                                                   |
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
// CVS : $Id: Carto_Couleur.class.php,v 1.2 2005-12-09 14:43:14 jp_milcent Exp $
/**
* Classe Carto_Couleur.
*
* Classe permettant de réaliser des cartes.
*
*@package Cartographie
//Auteur original :
*@author        Nicolas MATHIEU
//Autres auteurs :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.2 $ $Date: 2005-12-09 14:43:14 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

/**
* Classe Carto_Couleur() - Info sur les couleurs.
*
* La classe Carto_Couleur n'est utilisée que par la classe carte.
* C'est une classe privée.
* Elle sert à stocker les informations (RVB et index) sur la couleur d'une 
* zone d'une image.
*/
class Carto_Couleur {
	
	/*** Attributs : ***/
	
	public $id_zone;
	public $rouge;
	public $vert;
	public $bleu;
	public $index;
	
	/*** Constructeur : ***/
	
	/**
	* Constructeur Carto_Couleur()
	*Constructeur initialisant les attributs de la classe Carto_Couleur().
	*/
	function Carto_Couleur($id_zone, $rouge, $vert, $bleu)
	{
		$this->id_zone  = $id_zone;
		$this->rouge    = $rouge;
		$this->vert     = $vert;
		$this->bleu     = $bleu;
		$this->index    = -1;
	}

	/*** Méthodes publiques : ***/

	/**
	* La fonction array couleur_hexadecimalAuRgb(string color) renvoie des valeurs de couleur en RGB.
	* Cette fonction prend une valeur de couleur codée en hexadécimal et retourne les valeurs RGB correspondantes sous
	* forme de tableau. Exemple d'utilisation: $rgb = couleur_hexadecimalAuRgb("fffc49"); echo
	* "<br>couleur_hexadecimalAuRgb de 'fffc49' : ".$rgb['R']." ".$rgb['V']." ".$rgb['B'];
	*
	*@author iubito <sylvain_machefert@yahoo.fr> 
	*@copyright     iubito - http://iubito.free.fr/ - 2003@param string $couleur représente une couleur codée en héxadécimal.
	*@return array tableau associatif contenant les 3 valeurs RGB, avec clé du rouge 'R', du vert 'V' et enfin du bleu
	*'B'.
	*/
	function couleur_hexadecimalAuRgb($couleur_html)
	{
		//gestion du #...
		if (substr($couleur_html, 0, 1) == "#") {
			$couleur_html = substr($couleur_html, 1, 6);
		}
		
		$tablo_rgb['R'] = hexdec(substr($couleur_html, 0, 2));
		$tablo_rgb['V'] = hexdec(substr($couleur_html, 2, 2));
		$tablo_rgb['B'] = hexdec(substr($couleur_html, 4, 2));
		
		return $tablo_rgb;
	}
 

	/**
	* La fonction string couleur_rgbAuHexadecimal(array tablo) renvoie la valeur d'une couleur en héxadécimal.
	*Cette fonction prend un tableau de valeurs d'une couleur codées en RGB et retourne la valeur hexadécimal correspondante
	*sous forme de chaîne. C'est la réciproque exacte de la fonction couleur_hexadecimalAuRgb.
	*
	*@author iubito <sylvain_machefert@yahoo.fr> 
	*@copyright     iubito - http://iubito.free.fr/ - 2003
	@param array $tablo_RGB représente un tableau associatif avec les valeurs RGB d'une couleur.Les trois clés du tableau
	*sont : R pour rouge, V pour vert et B pour bleu.
	@return string chaîne contenant la valeur de la couleur sous forme héxadécimale.
	*/
	function couleur_rgbAuHexadecimal($tablo_rgb)
	{
		//Vérification des bornes...
		foreach($tablo_rgb as $cle => $valeur) {
			$tablo_rgb[$cle] = bornes($tablo_rgb[$cle],0,255);
		}
		//Le str_pad permet de remplir avec des 0
		//parce que sinon couleur_rgbAuHexadecimal(array(0,255,255)) retournerai #0ffff<=manque un 0 !
		return "#".str_pad(dechex(($tablo_rgb['R']<<16)|($tablo_rgb['V']<<8)|$tablo_rgb['B']),6,"0",STR_PAD_LEFT);
	}

	/**
	* La fonction int couleur_bornerNbre(int nb, int min, int max) borne des nombres.
	*Cette fonction permet de borner la valeur d'un nombre entre un minimum $mini et un maximum $maxi.
	*
	*@author iubito <sylvain_machefert@yahoo.fr> 
	*@copyright     iubito - http://iubito.free.fr/ - 2003
	*
	*@param integer $nbre le nombre à borner.
	*@param integer $mini la borne minimum.
	*@param integer $maxi la borne maximum.
	*
	*@return integer le nombre limité aux bornes si nécessaire.
	*/
	function couleur_bornerNbre($nbre, $mini, $maxi)
	{
		if ($nbre < $mini) {
			$nbre = $mini;
		}
		if ($nbre > $maxi) {
			$nbre = $maxi;
		}
		
		return $nbre;
	}
 
}//Fin de la classe Carto_Couleur


/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: Carto_Couleur.class.php,v $
* Revision 1.2  2005-12-09 14:43:14  jp_milcent
* Mise en conformité avec charte et ajout de la porté aux attributs des classes.
*
* Revision 1.1  2005/12/09 11:37:51  jp_milcent
* Simplification du code, renommage des fichiers.
* Début mise en conformité.
*
* Revision 1.1  2005/10/04 16:34:03  jp_milcent
* Début gestion de la chorologie.
* Ajout de la bibliothèque de cartographie (à améliorer!).
*
* Revision 1.2  2005/02/22 16:35:16  jpm
* Mise en forme.
* Utilisation de  constantes pour les chemins d'accès aux fichiers.
* Ajout de commentaires.
*
* Revision 1.1  2005/02/22 12:02:57  jpm
* Ajout des fichiers de la bibliothèque cartographique.
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>