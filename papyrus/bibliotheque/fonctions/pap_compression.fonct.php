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
// CVS : $Id: pap_compression.fonct.php,v 1.3 2006-03-15 09:30:50 florian Exp $
/**
* Biblioth�que de fonction de compression et d'envoi de donn�es.
*
* Cette biblioth�que contient toutes les fonctions n�cessaires � l'envoi de
* donn�es au navigateur client. Cela consiste donc � v�rifier le support de
* la compression par le navigateur du client et � compresser puis envoyer ces don�es.
*
*@package Papyrus
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.3 $ $Date: 2006-03-15 09:30:50 $
// +------------------------------------------------------------------------------------------------------+
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+


/** Fonction GEN_compresserDonneesZLIB() - Compresse des donn�es si n�cessaire et les retourne.
*
* Si les donn�es sont plus grandes que 2048 caract�res nous compressons et nous les retournons
* compress�es. Si la compression est un echec false est retourn�. Si le nombre de caract�res des
* donn�es � compresser ou que l'extension ZLIB n'est pas pr�sente, la valeur vide est retourn�e.
*
* @param   string donn�es � compresser.
* @param   int    taux de compression � utiliser.
* @param   int    nombre de caract�res minimums que doivent comporter les donn�es pour �tre compress�.
* @return  mixed  donn�es compress�es, "false" si la compression �choue, void s'il n'est pas n�cessaire de compresser.
*/
function GEN_compresserDonneesZLIB($donnees, $taux_compression = 9, $valeur_incompressible = 2048)
{
    // Si les donn�es sont inf�rieures � 2048 nous ne compressons pas.
    if ((strlen($donnees) < $valeur_incompressible) || (! extension_loaded('zlib')) ) {
        return '';
    }
    // Tentative de compression des donn�e
    $donnees_gzip = gzcompress($donnees, $taux_compression);
    if (! $donnees_gzip) {
        return false;
    } else {
        return $donnees_gzip;
    }
}

/** Fonction GEN_decompresserDonneesZLIB() - D�compresse des donn�es si n�cessaire et les retourne.
*
* Nous d�compressons les donn�es. Si la d�compression renvoie faut, nous retournons les donn�es 
* tels qu'elle nous �t� transmises.
*
* @param   mixed   donn�es � d�compresser.
* @return  mixed   donn�es d�compress�es ou "false" si les donn�es n'ont pas pue �tre d�compr�ss�es...
*/
function GEN_decompresserDonneesZLIB($donnees)
{
    $donnees_ungzip = gzuncompress($donnees);
    
    if (! $donnees_ungzip) {
        return false;
    } else {
        return $donnees_ungzip;
    }
}

/** Fonction GEN_retournerTypeCompressionNavigateur() - Retourne le type de compression du navigateur du client.
*
* Si le navigateur supporte la compression nous retournons le type d'encodage support�.
* Dans tous les autres cas, nous retournons une chaine vide.
* Nous utilisons la superglobale $_SERVER permettant d'obtenir "SERVER_PROTOCOL" et "HTTP_ACCEPT_ENCODING".
*
* @return  string  la chaine correspondant au type d'encodage surpport� par le navigateur du client.
*/
function GEN_retournerTypeCompressionNavigateur()
{
    // Si les ent�tes HTTP ont d�j� �t� envoy�s, nous retournons void.
    if (headers_sent()) return '';
    if ($_SERVER['SERVER_PROTOCOL'] != 'HTTP/1.1') return '';
    if (isset ($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return 'x-gzip';
    if (isset ($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')   !== false) return 'gzip';
    
    return '';
}

/** Fonction GEN_envoyerDonneesCompressees() - Envoi les donn�es au navigateur du client.
*
* Si le navigateur supporte la compression nous lui envoyons les donn�es compress�es. Sinon,
* nous lui envoyons les donn�es d�compress�es. Si la d�compression �choue nous n'envoyons rien
* et la fonction retourne false. Si l'envoi est un succ�s la fonction retourne true.
* Cett fonction fait appel aux fonctions GEN_retournerTypeCompressionNavigateur() et
* GEN_decompresserDonneesZLIB().
*
* @param   mixed  donn�es compress�es (ou pas) � envoyer au navigateur.
* @return  bool   bool�en indiquant si l'envoi est un succ�s (true) ou pas (false).
*/
function GEN_envoyerDonneesCompressees($donnees_compressees)
{
    // Le navigateur du client accepte-t-il la compression?
    $type_encodage = GEN_retournerTypeCompressionNavigateur();
    
    // La compression n'est pas support�e.
    if (empty($type_encodage)) {
        $donnees_decompressees = GEN_decompresserDonneesZLIB($donnees_compressees);
        if (! $donnees_decompressees) {
            return false;
        }
        $res = $donnees_decompressees;
        return $res;
    } else {
        // La compression est support�e. Nous envoyons les donn�es compress�es.
        header('Content-Encoding: gzip');
        // Laisser la chaine ci-dessous entre guillemets. Les cotes font planter le programme!
        $res = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        $res .= $donnees_compressees;
    }
    
    return $res;
}

/* +--Fin du code ----------------------------------------------------------------------------------------+
*
* $Log: pap_compression.fonct.php,v $
* Revision 1.3  2006-03-15 09:30:50  florian
* suppression des echos, qui entrainaient des problemes d'affichages
*
* Revision 1.2  2004/06/22 15:27:15  alex
* ajout du test d'existence la variable $_SERVER['HTTP_ENCODING_TYPE'] avant de tester sa valeur
*
* Revision 1.1  2004/06/15 15:09:26  jpm
* Changement de nom et d'arborescence de Genesia en Papyrus.
*
* Revision 1.4  2004/04/22 08:39:05  jpm
* Correction d'une d�claration en tant que global d'une variable superglobale.
*
* Revision 1.3  2004/04/09 16:22:49  jpm
* Envoi d'une page sous forme compress�e si l'extenssion ZLIB existe. Sinon, la page part non compr�ss�e.
*
* Revision 1.2  2004/04/06 15:56:33  jpm
* Changement de l'ordre des fonctions dans le fichier.
*
*
* +-- Fin du code ----------------------------------------------------------------------------------------+
*/
?>