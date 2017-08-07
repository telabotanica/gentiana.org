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
// CVS : $Id: pap_style.fonct.php,v 1.3 2005-10-12 17:20:33 ddelon Exp $
/**
* Les fonctions permettant d'inclure des styles CSS.
*
* Ces fonctions permettent d'inclure des CSS directement dans les pages
* des applications. Elles peuvent donc être appelées par les applications 
* intégrées à Papyrus.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2005-10-12 17:20:33 $
// +------------------------------------------------------------------------------------------------------+
*/
// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction GEN_modifierTypeStyle() - Permet de stocker le type des styles intégrés.
*
* Papyrus permet à une application donnée d'intégrer des styles directement dans 
* l'entête de la page. Cette fonction définit le type Mime des styles utilisés.
* En XHTML strict, cette fonction ne devrait pas être utilisé car les styles devraient être
* stockés dans des fichiers séparés.
*
* @deprecated déprécier dans le cadre d'application XHTML.
* @global   string  "style_type" : utilisé pour stocker le type des styles intégrés dans l'entête de la page.
* @param    string  le type des styles intégrés.
* @return   void    le type des styles intégrés est stocké dans une variable globale.
*/
function GEN_modifierTypeStyle($type = 'text/css')
{
    global $_GEN_commun;
    
    $_GEN_commun['style_type'] .= $type;
}

/** Fonction GEN_stockerStyleIntegree() - Permet de stocker un style utilisé par une application.
*
* Papyrus permet à une application donnée de stocker des styles intégrés
* directement dans l'entête de la page. En XHTML strict, l'utilisation de cette 
* fonction est déconseillée. Utiliser plutôt une feuille de styles externes qui 
* sera appelé par l'entête. Cette fonction peut être appelé plusieurs fois. Elle ne
* fait que stocker les styles dans une variable globale utilisée par Génésia.
*
* @deprecated déprécier dans le cadre d'application XHTML.
* @global   string  "style_integree" : utilisé pour stocker les styles intégrés.
* @param    string  le style à insérer.
* @return   void    le style est stocké dans une variable globale.
*/
function GEN_stockerStyleIntegree($style_integree)
{
    global $_GEN_commun;
    
    $_GEN_commun['style_integree'] .= $style_integree;
}

/** Fonction GEN_stockerStyleExterne() - Permet de stocker des fichiers de styles externes.
*
* Papyrus permet à une application donnée de stocker des feuilles de styles externes qui seront
* appelés depuis l'entête de la page. En XHTML strict, l'utilisation de cette 
* fonction est conseillée.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que stocker les chemin des
* feuilles de styles externes dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @global   array   "style_fichier" : utilisé pour stocker les chemins des feuilles de styles externes.
* @param    string  la clé du tableau de fichiers, par exemple le nom de la feuille de styles externes à insérer.
* @param    string  le chemin complet du fichier de styles à insérer.
* @param    string  le titre de la feuille de styles externes.
* @param    string  la relation de la feuille de style (stylesheet, alternate stylesheet, ...).
* @param    string  le type MIME des styles (text/css, ...).
* @param    string  le type de média concerné par la feuille de styles (screen, print, aural, ...).
* @return   void    le chemin du fichier CSS est stocké dans une variable (tableau associatif) globale.
*/
function GEN_stockerStyleExterne($id_fichier, $chemin_fichier, $titre = '', $rel = 'stylesheet', $type = 'text/css', $media = 'screen')
{
    global $_GEN_commun;
    
    if (empty($_GEN_commun['style_externe'][$id_fichier])) {
        $_GEN_commun['style_externe'][$id_fichier]['rel'] = $rel;
        $_GEN_commun['style_externe'][$id_fichier]['type'] = $type;
        $_GEN_commun['style_externe'][$id_fichier]['media'] = $media;
        $_GEN_commun['style_externe'][$id_fichier]['titre'] = $titre;
        $_GEN_commun['style_externe'][$id_fichier]['chemin'] = $chemin_fichier;
    } 
}

/** Fonction GEN_afficherStyle() - Permet de renvoyer les styles dans l'entete.
*
* Cette fonction récupère les feuilles de styles stockés dans les variables globales de Papyrus
* et les retourne formatés pour l'affichage dans l'entête du squelette du site.
* C'est la balise Génésia <!-- STYLES --> qui permet de situer l'endroit où afficher
* les CSS.
*
* @global   array   "style_externe" : utilisé pour stocker les chemins des feuilles de styles externes et 
* "style_integree" : utilisé pour stocker les styles intégrés directement dans l'entête.
* @return string le code XHTML contenant les styles à insérer dans l'entête.
*/
function GEN_afficherStyle()
{
    global $_GEN_commun;
    $sortie = '';
    
    $styles_externes = '';
    if (isset($_GEN_commun['style_externe'])) {
       foreach ($_GEN_commun['style_externe'] as $cle => $valeur) {
            $styles_externes .= str_repeat(' ', 8).
                                '<link rel="'.$valeur['rel'].'" '.
                                    'type="'.$valeur['type'].'" '.
                                    'media="'.$valeur['media'].'" '.
                                    'title="'.$valeur['titre'].'" '.
                                    'href="'.$valeur['chemin'].'" />'."\n";
        }
        $sortie .= $styles_externes;
    } else {
        $sortie .= '<!-- Aucun style externe -->'."\n";
    }
    
    $styles_integrees = '';
    $styles_integrees = $_GEN_commun['style_integree'];
    if ($styles_integrees != '') {
        $sortie .= "\n";
        $sortie .= str_repeat(' ', 8).'<style type="'.$_GEN_commun['style_type'].'">'."\n";
        $sortie .= str_repeat(' ', 12).'<!--/*--><![CDATA[//><!--'."\n";
        $sortie .=                        $styles_integrees."\n";
        $sortie .= str_repeat(' ', 12).'//--><!]]>'."\n";
        $sortie .= str_repeat(' ', 8).'</style>';
    } else {
        $sortie .= '<!-- Aucun style intégré -->'."\n";
    }
        
    return $sortie;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_style.fonct.php,v $
* Revision 1.3  2005-10-12 17:20:33  ddelon
* Reorganisation calendrier + applette
*
* Revision 1.2  2004/12/06 17:53:32  jpm
* Correction Génésia en Papyrus.
*
* Revision 1.1  2004/06/15 15:14:32  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.3  2004/04/20 15:25:58  jpm
* Ajout de commentaire html à la place d'une chaine vide lors du remplacement de balise Genesia.
*
* Revision 1.1  2004/04/20 10:46:43  jpm
* Ajout de la bibliothèque gérant les styles.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>