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
// CVS : $Id: pap_meta.fonct.php,v 1.5 2006-10-10 12:05:52 jp_milcent Exp $
/**
* Bibliothèque de fonctions permettant d'inclure des balises META.
*
* Cet ensemble de fonctions permet de manipuler les balise meta à intégrer dans l'entête
* des pages html. Cela peut être très pratique pour les applications voulant définir précisément
* ces informations.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.5 $ $Date: 2006-10-10 12:05:52 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+


/** Fonction GEN_stockerMetaHttpEquiv() - Permet de stocker des informations Http-Equiv.
*
* Papyrus permet à une application donnée de stocker les balises meta contenant l'attribut http-equiv
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que stocker les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  la clé du tableau des meta http-equiv, l'information présente dans l'attribut http-equiv.
* @param    string  le contenu présent dans l'attribut content.
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_stockerMetaHttpEquiv($id_http_equiv, $content)
{
    if (empty($GLOBALS['_GEN_commun']['meta_http_equiv'][$id_http_equiv])) {
        $GLOBALS['_GEN_commun']['meta_http_equiv'][$id_http_equiv] = $content;
    } else {
        die('ERREUR Papyrus : cette balise meta à déjà été enregistré par GEN_stockerMetaHttpEquiv(). <br />'.
            'Identifiant : '. $id_http_equiv .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/** Fonction GEN_modifierMetaHttpEquiv() - Permet de modifier les informations d'une balise http-equiv.
*
* Papyrus permet à une application donnée de modifier les balises meta contenant l'attribut http-equiv
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que modifier les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  la clé du tableau des meta http-equiv, l'information présente dans l'attribut http-equiv.
* @param    string  le contenu présent dans l'attribut content.
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_modifierMetaHttpEquiv($id_http_equiv, $content)
{
    if ($content != '') {
        $GLOBALS['_GEN_commun']['meta_http_equiv'][$id_http_equiv] = $content;
    } else {
        die('ERREUR Papyrus : cette balise ne peut avoir un contenu vide. <br />'.
            'Contenu : '. $content .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}


/**
 * Stocke une <meta> du type <meta property="truc" content="chose">
 * @param string $id
 * @param string $property
 * @param string $content
 */
function GEN_stockerMetaProperty($id, $content)
{
    if (empty($GLOBALS['_GEN_commun']['meta_property'][$id])) {
        $GLOBALS['_GEN_commun']['meta_property'][$id] = $content;
    } else {
        die('ERREUR Papyrus : cette balise meta Ã  dÃ©jÃ  Ã©tÃ© enregistrÃ©e par GEN_stockerMetaProperty(). <br />'.
            'Identifiant : '. $id .'<br />'.
            'Ligne nÂ° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/**
 * Modifie une <meta> du type <meta property="truc" content="chose">
 * @param string $id
 * @param string $property
 * @param string $content
 */
function GEN_modifierMetaProperty($id, $content)
{
    if ($content != '') {
        $GLOBALS['_GEN_commun']['meta_property'][$id] = $content;
    } else {
        die('ERREUR Papyrus : cette balise ne peut avoir un contenu vide. <br />'.
            'Contenu : '. $content .'<br />'.
            'Ligne nÂ° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/** Fonction GEN_stockerMetaName() - Permet de stocker des informations pour la balise meta.
*
* Papyrus permet à une application donnée de stocker les balises meta contenant l'attribut name
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que stocker les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  la clé du tableau des meta name, l'information présente dans l'attribut name.
* @param    string  le contenu présent dans l'attribut content.
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_stockerMetaName($id_name, $content)
{
    if (empty($GLOBALS['_GEN_commun']['meta_name'][$id_name])) {
        $GLOBALS['_GEN_commun']['meta_name'][$id_name] = $content;
    } else {
        die('ERREUR Papyrus : cette balise meta à déjà été enregistré par GEN_stockerMetaName(). <br />'.
            'Identifiant : '. $id_name .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/** Fonction GEN_modifierMetaName() - Permet de modifier les informations d'une balise meta.
*
* Papyrus permet à une application donnée de modifier les balises meta contenant l'attribut name
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que modifier les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  la clé du tableau des meta name, l'information présente dans l'attribut name.
* @param    string  le contenu présent dans l'attribut content.
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_modifierMetaName($id_name, $content)
{
    if ($content != '') {
        $GLOBALS['_GEN_commun']['meta_name'][$id_name] = $content;
    } else {
        die('ERREUR Papyrus : cette balise ne peut avoir un contenu vide. <br />'.
            'Contenu : '. $content .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/** Fonction GEN_stockerMetaNameDC() - Permet de stocker des informations Dublin Core pour la balise meta.
*
* Papyrus permet à une application donnée de stocker des informations Dublin Core pour les balises meta
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que stocker les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  la clé du tableau des meta name, l'information présente dans l'attribut name.
* @param    string  le contenu présent dans l'attribut content.
* @param    string  le contenu présent dans l'attribut lang.
* @param    string  le contenu présent dans l'attribut scheme.
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_stockerMetaNameDC($id_name, $content, $lang = '', $scheme = '')
{
    if (empty($GLOBALS['_GEN_commun']['meta_name_dc'][$id_name])) {
        $GLOBALS['_GEN_commun']['meta_name_dc'][$id_name]['contenu'] = $content;
        $GLOBALS['_GEN_commun']['meta_name_dc'][$id_name]['langue'] = $lang;
        $GLOBALS['_GEN_commun']['meta_name_dc'][$id_name]['scheme'] = $scheme;
    } else {
        die('ERREUR Papyrus : cette balise meta à déjà été enregistré par GEN_stockerMetaNameDC(). <br />'.
            'Identifiant : '. $id_name .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/** Fonction GEN_modifierMetaNameDC() - Permet de modifier les informations d'une balise meta DC.
*
* Papyrus permet à une application donnée de modifier les balises meta DC contenant l'attribut name
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que modifier les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  la clé du tableau des meta name DC, l'information présente dans l'attribut name.
* @param    string  le contenu présent dans l'attribut content.
* @param    string  le contenu présent dans l'attribut lang.
* @param    string  le contenu présent dans l'attribut scheme.
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_modifierMetaNameDC($id_name, $content, $lang = '', $scheme = '')
{
    if ($content != '') {
        $GLOBALS['_GEN_commun']['meta_name_dc'][$id_name]['contenu'] = $content;
        $GLOBALS['_GEN_commun']['meta_name_dc'][$id_name]['langue'] = $lang;
        $GLOBALS['_GEN_commun']['meta_name_dc'][$id_name]['scheme'] = $scheme;
    } else {
        die('ERREUR Papyrus : cette balise ne peut avoir un contenu vide. <br />'.
            'Contenu : '. $content .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/** Fonction GEN_afficherMeta() - Permet d'afficher les meta informations.
*
* Cette fonction affiche les meta informations Http-Equiv, Meta ou DC stockées
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  le type de balise meta à afficher (http-equiv, name ou dc).
* @return   void    les informations sont stockées dans une variable (tableau associatif) globale.
*/
function GEN_afficherMeta($type = 'name')
{
    $sortie = '';
    
    if ($type == 'http-equiv' && isset($GLOBALS['_GEN_commun']['meta_http_equiv'])) {
        while (list($cle, $valeur) = each($GLOBALS['_GEN_commun']['meta_http_equiv'])) {
            $sortie .= str_repeat(' ', 8).'<meta http-equiv="'.$cle.'" content="'.$valeur.'" />'."\n";
        }
        if (empty($sortie)) {
            $sortie .= '<!-- Aucune balise meta http-equiv -->'."\n";
        }
    } else if ($type == 'name' && isset($GLOBALS['_GEN_commun']['meta_name'])) {
        while (list($cle, $valeur) = each($GLOBALS['_GEN_commun']['meta_name'])) {
            if (! empty($valeur['contenu'])) {
                $sortie .= str_repeat(' ', 8).'<meta name="'.$cle.'" content="'.$valeur.'" />'."\n";
            }
        }
        if (empty($sortie)) {
            $sortie .= '<!-- Aucune balise meta name -->'."\n";
        }
    } else if ($type == 'property' && isset($GLOBALS['_GEN_commun']['meta_property'])) {
        while (list($cle, $valeur) = each($GLOBALS['_GEN_commun']['meta_property'])) {
            if (! empty($valeur)) {
                $sortie .= '<meta property="'.$cle.'" content="'.$valeur.'" />'."\n";
            }
        }
        if (empty($sortie)) {
            $sortie .= '<!-- Aucune balise meta property -->'."\n";
        }
    } else if ($type == 'dc' && isset($GLOBALS['_GEN_commun']['meta_name_dc'])) {
        while (list($cle, $valeur) = each($GLOBALS['_GEN_commun']['meta_name_dc'])) {
            if (! empty($valeur['contenu'])) {
                $sortie .= str_repeat(' ', 8).'<meta name="'.$cle.'" ';
                if (! empty($valeur['langue'])) {
                    $sortie .= 'lang="'.$valeur['langue'].'" ';
                }
                if (! empty($valeur['scheme'])) {
                    $sortie .= 'scheme="'.$valeur['scheme'].'" ';
                }
                $sortie .= 'content="'.$valeur['contenu'].'" />'."\n";
            }
        }
        // Ajout du schéma du Dublin Core si on affiche des informations DC
        if (! empty($sortie)) {
            $tmp = $sortie;
            $sortie = str_repeat(' ', 8).'<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />'."\n";
            $sortie .= $tmp;
        } else {
            $sortie .= '<!-- Aucune balise meta name Dublin Core -->'."\n";
        }
    }
    
    return $sortie;
}

/** Fonction GEN_viderMeta() - Permet de vider les informations d'un type de balise meta.
*
* Papyrus permet à une application donnée de modifier les balises meta contenant l'attribut name
* à intégrer dans l'entête de la page.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que modifier les informations 
* dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @param    string  le type de balise meta à vider (http-equiv, name ou dc).
* @return   void    la variable (tableau associatif) globale contenant les infos meta est vidée.
*/
function GEN_viderMeta($type)
{
    if ($type == 'http-equiv') {
        if (count($GLOBALS['_GEN_commun']['meta_http_equiv']) > 0) {
        	foreach ($GLOBALS['_GEN_commun']['meta_http_equiv'] as $cle => $val) {
            	$GLOBALS['_GEN_commun']['meta_http_equiv'][$cle] = null;
        	}
        }
    } else if ($type == 'meta') {
        if (count($GLOBALS['_GEN_commun']['meta']) > 0) {
        	foreach ($GLOBALS['_GEN_commun']['meta'] as $cle => $val) {
            	$GLOBALS['_GEN_commun']['meta'][$cle] = null;
        	}
        }
    } else if ($type == 'property') {
        if (count($GLOBALS['_GEN_commun']['meta_property']) > 0) {
        	foreach ($GLOBALS['_GEN_commun']['meta_property'] as $cle => $val) {
            	$GLOBALS['_GEN_commun']['meta_property'][$cle] = null;
        	}
        }
    } else if ($type == 'dc') {
        if (count($GLOBALS['_GEN_commun']['meta_name_dc']) > 0) {
        	foreach ($GLOBALS['_GEN_commun']['meta_name_dc'] as $cle => $val) {
            	$GLOBALS['_GEN_commun']['meta_name_dc'][$cle] = null;
        	}
        }
    } else {
        die('ERREUR Papyrus : le type de balise est incorrect. <br />'.
            'Contenu : <br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__);
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_meta.fonct.php,v $
* Revision 1.5  2006-10-10 12:05:52  jp_milcent
* Ajout de tests à la fonction GEN_viderMeta pour éviter les warning quand les tableaux sont vides.
*
* Revision 1.4  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.3  2004/12/06 19:45:45  jpm
* Ajout d'une fonction permettant de vider les tableaux des meta.
*
* Revision 1.2  2004/12/06 17:58:02  jpm
* Ajout de fonctions permettant de modifier le contenu des balises meta : http-equiv, name et name DC.
*
* Revision 1.1  2004/06/15 15:12:12  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.1  2004/04/20 15:24:54  jpm
* Ajout de la bibliotheque de fonctions gérant les meta.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>
