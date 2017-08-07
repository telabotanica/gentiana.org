<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */
// +------------------------------------------------------------------------------------------------------+
// | PHP version 5.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 1999-2006 Tela Botanica (accueil@tela-botanica.org)                                    |
// +------------------------------------------------------------------------------------------------------+
// | This file is part of eflore_li.                                                                         |
// |                                                                                                      |
// | eflore_li is free software; you can redistribute it and/or modify                                       |
// | it under the terms of the GNU General Public License as published by                                 |
// | the Free Software Foundation; either version 2 of the License, or                                    |
// | (at your option) any later version.                                                                  |
// |                                                                                                      |
// | eflore_li is distributed in the hope that it will be useful,                                            |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                                        |
// | GNU General Public License for more details.                                                         |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public License                                    |
// | along with Foobar; if not, write to the Free Software                                                |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: EfloreEncodage.class.php,v 1.6 2007-07-13 18:06:59 jp_milcent Exp $
/**
* eflore_li - EfloreEncodage.php
*
* Description :
*
*@package eflore_li
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 1999-2007
*@version       $Revision: 1.6 $ $Date: 2007-07-13 18:06:59 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+
class EfloreEncodage {
	
	/**
	* Cette fonction remplace l'esperluette par &amp;
	*
	*@param string la chaîne html à parsser.
	*@return string contient la chaîne html avec les entités intégrées.
	*/
	public static function remplacerEsperluette($texte)
	{
		$texte_retour = '';
		$tab_entites[' & '] = ' &amp; ';
		return strtr($texte, $tab_entites);
	}
	
	public static function transformerIso_8859_15VersEntitees(&$chaine)
	{
		$chaine = preg_replace('/¼/', "&#338;", $chaine);
		$chaine = preg_replace('/½/', "&#339;", $chaine);
		$chaine = preg_replace('/¤/', "&#8364;", $chaine);
		$chaine = preg_replace('/¦/', "&#352;", $chaine);
		$chaine = preg_replace('/¨/', "&#353;", $chaine);
		$chaine = preg_replace('/´/', "&#381;", $chaine);
		$chaine = preg_replace('/¸/', "&#382;", $chaine);
		$chaine = preg_replace('/¾/', "&#376;", $chaine);
		//return $chaine;	
	}
	
	public static function transformerEntiteesIso_8859_15VersUtf8(&$chaine)
	{
		$convmap = array(0x0, 0x10000, 0, 0xfffff);
		$chaine = mb_decode_numericentity($chaine, $convmap, 'UTF-8');
		//return $chaine;	
	}
	
	public static function enleverAccents($mot) {
		$chaine = strtr(	html_entity_decode($mot),
							"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
							"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
		return $chaine;
	}
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: EfloreEncodage.class.php,v $
* Revision 1.6  2007-07-13 18:06:59  jp_milcent
* Mise en static de la méthode remplacerEsperluette()
*
* Revision 1.5  2007-07-13 11:34:44  jp_milcent
* Ajout d'une suprression des enités html.
*
* Revision 1.4  2007-07-12 16:16:17  jp_milcent
* Ajout d'une méthode remplaçant les caractères accentués.
*
* Revision 1.3  2007-06-25 16:37:06  jp_milcent
* Suppression du saut de ligne en fin de fichier.
*
* Revision 1.2  2007-06-11 12:44:52  jp_milcent
* Fusion correction provenant de la livraison Moquin-Tandon : 11 juin 2007
*
* Revision 1.1.2.1  2007-06-11 10:11:25  jp_milcent
* Résolution de l'ensemble des problèmes d'encodage.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>