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
// CVS : $Id: pap_script.fonct.php,v 1.4.2.1 2008-04-16 12:46:38 alexandre_tb Exp $
/**
* Les fonctions permettant d'inclure des scripts.
*
* Ces fonctions permettent d'inclure des scripts, éxécuté côté client, directement dans les pages
* des applications. Elles peuvent donc être appelées par les applications 
* intégrées à Génésia. Par défaut, c'est le Javascript qui est conscidéré commé utilisé.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Alexandre GRANIER <alexandre@tela-botanica.org>
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4.2.1 $ $Date: 2008-04-16 12:46:38 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+

/** Fonction GEN_modifierTypeScript() - Permet de stocker le type des scripts.
*
* Papyrus permet à une application donnée d'intégrer du code de scripts, exécuté côté client,
* directement dans l'entête de la page. Cette fonction définit le type Mime du langage de script utilisé.
* En XHTML strict, cette fonction ne devrait pas être utilisé car les scripts devraient être
* stocké dans des fichiers séparés.
*
* @deprecated déprécier dans le cadre d'application XHTML.
* @global   string  "script_type" : utilisé pour stocker le type des scripts intégrés.
* @param    string  le code à insérer.
* @return   void    le code est stocké dans une variable globale.
*/
function GEN_modifierTypeScript($type = 'text/javascript')
{
    global $_GEN_commun;
    
    $_GEN_commun['script_type'] .= $type;
}

/** Fonction GEN_stockerCodeScript() - Permet de stocker le code d'un script côté client utilisé par une application.
*
* Papyrus permet à une application donnée de stocker du code de script, exécuté côté client, qui sera
* envoyer directement dans l'entête de la page. En XHTML strict, l'utilisation de cette 
* fonction est déconseillée. Utiliser plutôt une fichier de scripts séparé qui 
* sera appelé par l'entête. Cette fonction peut être appelé plusieurs fois. Elle ne
* fait que stocker le code dans une variable globale utilisée par Génésia.
*
* @deprecated déprécier dans le cadre d'application XHTML.
* @global   string  "script_code" : utilisé pour stocker le code des scripts.
* @param    string  le code à insérer.
* @return   void    le code est stocké dans une variable globale.
*/
function GEN_stockerCodeScript($bloc_code)
{
    global $_GEN_commun;
    
    $_GEN_commun['script_code'] .= $bloc_code;
}

/** Fonction GEN_stockerFonctionScript() - Permet de stocker des fonctions Javascript.
*
* Papyrus permet à une application donnée de stocker des fonctions dans un langage de script donné
* qui seront envoyer directement dans l'entête de la page. En XHTML strict, l'utilisation de cette 
* fonction est déconseillée. Utiliser plutôt une fichier de scripts séparé qui 
* sera appelé par l'entête. Cette fonction peut être appelé plusieurs fois. Elle ne
* fait que stocker les fonctions dans une variable (tableau associatif) globale utilisée
* par Génésia.
*
* @deprecated déprécier dans le cadre d'application XHTML.
* @global   array   "script_fonction" : utilisé pour stocker le code des fontions du script.
* @param    string  la clé du tableau de fontion, par exemple le nom de la fonction à insérer.
* @param    string  le code complet de la fonction à insérer.
* @return   void    la fonction est stockée dans une variable (tableau associatif) globale.
*/
function GEN_stockerFonctionScript($id_fonction, $code_fonction)
{
    global $_GEN_commun;
    
    if (empty($_GEN_commun['script_fonction'][$id_fonction])) {
        $_GEN_commun['script_fonction'][$id_fonction] = $code_fonction;
    } else {
        if (GEN_DEBOGAGE) {
            $_GEN_commun['debogage_info'] .=
            'ERREUR Papyrus : cet identifiant de fonction à déjà été enregistré par GEN_stockerFonctionJavascript(). <br />'.
            'Identifiant : '. $id_fonction .'<br />'.
            'Ligne n° : '. __LINE__ .'<br />'.
            'Fichier : '. __FILE__;
        }
    }
}

/** Fonction GEN_stockerFichierScript() - Permet de stocker des fichiers de scripts.
*
* Papyrus permet à une application donnée de stocker des fichiers de script qui seront
* appelés depuis l'entête de la page. En XHTML strict, l'utilisation de cette 
* fonction est conseillée.
* Cette fonction peut être appelé plusieurs fois. Elle ne fait que stocker les chemin des
* fichiers dans une variable (tableau associatif) globale utilisée par Papyrus.
*
* @global   array   "script_fichier" : utilisé pour stocker les chemins des scripts.
* @param    string  la clé du tableau de fichiers, par exemple le nom du fichier à insérer.
* @param    string  le chemin complet du fichier à insérer.
* @param    string  le type MIME du langage de script utilisé dans le fichier à insérer.
* @return   void    le chemin du fichier est stocké dans une variable (tableau associatif) globale.
*/
function GEN_stockerFichierScript($id_fichier, $chemin_fichier, $type_fichier = 'text/javascript', $attributs = array())
{
    global $_GEN_commun;
    
    if (empty($_GEN_commun['script_fichier'][$id_fichier])) {
        $_GEN_commun['script_fichier'][$id_fichier]['type']   = $type_fichier;
        $_GEN_commun['script_fichier'][$id_fichier]['chemin'] = $chemin_fichier;
        $_GEN_commun['script_fichier'][$id_fichier]['attributs'] = $attributs;
    } else {
        if (GEN_DEBOGAGE) {
            $_GEN_commun['debogage_info'] .=
                    'ERREUR Papyrus : cet identifiant de fichier à déjà été enregistré par GEN_stockerFichierJavascript(). <br />'.
                    'Identifiant : '. $id_fichier .'<br />'.
                    'Ligne n° : '. __LINE__ .'<br />'.
                    'Fichier : '. __FILE__;
        }
    }
}

/** Fonction GEN_afficherScript() - Permet de renvoyer les scripts.
*
* Cette fonction récupère les scripts stockés dans les variables globales de Papyrus
* et le retourne formaté pour l'affichage dans l'entête du squelette du site.
* C'est la balise Papyrus <!-- SCRIPTS --> qui permet de situer l'endroit où afficher
* les script.
*
* @global   array   "script_fichier" : utilisé pour stocker les chemins des scripts, 
* "script_fonction" : utilisé pour stocker le code des fontions et "script_code" : 
* utilisé pour stocker le code des script.
* @return string le code XHTML contenant les scripts à insérer dans l'entête.
*/
function GEN_afficherScript()
{
    global $_GEN_commun;
    $sortie = '';
    
    $fichiers = '';
    if (isset($_GEN_commun['script_fichier'])) {
        while (list($cle, $valeur) = each($_GEN_commun['script_fichier'])) {
            $fichiers .= str_repeat(' ', 8).'<script type="'.$valeur['type'].'" src="'.$valeur['chemin'].'"';
            if (is_array ($valeur['attributs'])) foreach ($valeur['attributs'] as $attr => $val) $fichiers .= ' '.$attr.'="'.$val.'"';
            $fichiers .=  '></script>'."\n"; 
        } 
        $sortie .= $fichiers;
    } else {
        $sortie .= '<!-- Aucun script externe -->'."\n";
    }
    
    
    $fonctions = '';
    while (list($cle, $valeur) = each($_GEN_commun['script_fonction'])) {
        $fonctions .= $valeur;
    }
    
    $code = '';
    $code = $_GEN_commun['script_code'];
    
    if ($fonctions != '' || $code != '') {
        $sortie .= "\n";
        $sortie .= str_repeat(' ', 8).'<script type="'.$_GEN_commun['script_type'].'">'."\n";
        $sortie .= str_repeat(' ', 12).'<!--/*--><![CDATA[//><!--'."\n";
        $sortie .=      $fonctions."\n";
        $sortie .=      $code."\n";
        $sortie .= str_repeat(' ', 12).'//--><!]]>'."\n";
        $sortie .= str_repeat(' ', 8).'</script>';
    } else {
        $sortie .= '<!-- Aucun script intégré -->'."\n";
    }
    
    return $sortie;
}


/*
 * Ajout ou suppression des attributs de la balise BODY 
 * (ex: pour Google MAPS)
 * - 
 * pour supprimer un attribut, appeler la fonction avec un seul parametre.
 */
function GEN_AttributsBody($nomAttribut, $valeurAttribut = NULL)
{
	global $_GEN_commun;
	
	$_GEN_commun['attributs_body'][$nomAttribut] = $valeurAttribut;
	 
	if($valeurAttribut == NULL && isset($_GEN_commun['attributs_body'][$nomAttribut]))
		unset($_GEN_commun['attributs_body'][$nomAttribut]);
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_script.fonct.php,v $
* Revision 1.4.2.1  2008-04-16 12:46:38  alexandre_tb
* ajout du parametre attributs dans la fonction GEN_stockerFichierScript
*
* Revision 1.4  2007-09-06 14:45:06  neiluj
* ajout de la balise PAPYRUS_BODY_ATTRIBUTS
*
* Revision 1.3  2005/02/28 11:12:03  jpm
* Modification des auteurs.
*
* Revision 1.2  2004/09/10 16:40:41  jpm
* Ajout de messages d'erreurs dans les infos de débogage.
*
* Revision 1.1  2004/06/15 15:13:07  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.6  2004/04/30 16:18:56  jpm
* Correction d'un bogue dans les fonctions de gestion des scripts.
*
* Revision 1.5  2004/04/20 15:25:58  jpm
* Ajout de commentaire html à la place d'une chaine vide lors du remplacement de balise Genesia.
*
* Revision 1.4  2004/04/20 12:18:03  jpm
* Ajout d'une fonction permettant de modifier le type de scripts intégrés à une page.
*
* Revision 1.3  2004/04/20 10:46:58  jpm
* Modification des commentaires.
*
* Revision 1.2  2004/04/05 16:37:08  jpm
* Correction de bogues concernant les variables globales javascript.
*
* Revision 1.1  2004/04/05 12:35:09  jpm
* Ajout du fichier contenant les fonctions permettant d'inclure le Javascript dans l'entete des pages générées par Génésia.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>