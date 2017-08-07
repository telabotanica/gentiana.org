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
// CVS : $Id: pap_cache.inc.php,v 1.4 2007-04-13 09:41:09 neiluj Exp $
/**
* Gestion de la suppression et de la recherche dans le cache.
*
* Ce fichier n'est utilisé que si le site utilise la gestion du cache proposée
* par Papyrus.
* Il commence par supprimer les pages en cache trop anciennes et recherche en suite
* la présence de la page demandée dans le cache. Si elle est trouvée la page est renvoyée
* directement et le programme s'arrête ici. Si elle n'est pas trouvée, le programme de rendu
* la reconstruit et le programme d'envoi la sotcke dans le cache.
*
*@package Papyrus
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Laurent COUDOUNEAU <lc@gsite.org>
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.4 $ $Date: 2007-04-13 09:41:09 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                            ENTÊTE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+

/** <BR> Inclusion de la bibliothèque de fonctions de gestion du cache.*/
include_once './bibliotheque/fonctions/pap_cache.fonct.php';

/** <BR> Inclusion de la bibliothèque de fonctions de compression des données à envoyer.*/
include_once './bibliotheque/fonctions/pap_compression.fonct.php';

// +------------------------------------------------------------------------------------------------------+
// |                                            CORPS du PROGRAMME                                        |
// +------------------------------------------------------------------------------------------------------+

// +------------------------------------------------------------------------------------------------------+
// Gestion de la recherche dans le cache de la page demandée.

/*
// Utilisons nous le cache ?
if (! $GS_ARGUMENTS['cachectrl']) {
    //header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    //header ("Pragma: no-cache");                         // HTTP/1.0
}
*/

// Nous supprimons les pages en cache dont le délai de mise en cache est dépassé.
$duree_cache = $_GEN_commun['application_info']->cache_duree * 3600;
if ($duree_cache > 0) {
    $requete =  'DELETE FROM gen_page_cache '.
                'WHERE gpc_ce_site = '.$_GEN_commun['site_info']->gsi_id_site.' '.
                'AND gpc_ce_i18n = "'.$_GEN_commun['site_info']->gsi_id_i18n.'" '.
                'AND gpc_date_heure + '.$duree_cache.' < NOW()';
    
    $resultat = $db->query($requete);
    (DB::isError($resultat))
        ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
        : '';
}

// Vérification de la présence de la page demandée dans le cache.
$requete =  'SELECT * '.
            'FROM gen_page_cache '.
            'WHERE gpc_ce_site = '.$_GEN_commun['site_info']->gsi_id_site.' '.
            'AND gpc_ce_i18n = "'.$_GEN_commun['site_info']->gsi_id_i18n.'" '.
            'AND gpc_id_md5_url = "'.GEN_donnerMD5UriPostSession().'"';

$resultat = $db->query($requete);
(DB::isError($resultat))
    ? die(BOG_afficherErreurSql(__FILE__, __LINE__, $resultat->getMessage(), $requete))
    : '';

$ligne = $resultat->fetchRow(DB_FETCHMODE_OBJECT) ;
$resultat->free();

// Nous avons trouvé la page. Nous essayons de la renvoyer.
if ($ligne == true) {
    if ( GEN_envoyerDonneesCompressees($ligne->gpc_corps) ) {
        // Si l'envoie des données à réussi nous arrétons le script ICI.
        exit();
    }
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_cache.inc.php,v $
* Revision 1.4  2007-04-13 09:41:09  neiluj
* rÃ©parration cvs
*
* Revision 1.3  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.2  2005/02/28 11:20:42  jpm
* Modification des auteurs.
*
* Revision 1.1  2004/06/16 08:11:01  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* Revision 1.2  2004/04/22 08:29:55  jpm
* Transformation de $GS_GLOBAL en $_GEN_commun.
*
* Revision 1.1  2004/04/09 16:19:15  jpm
* Ajout du fichier indépendant du cache avec gestion des tables i18n.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>