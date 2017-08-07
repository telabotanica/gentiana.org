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
// CVS : $Id: instal_installation.fonct.php,v 1.7 2007-01-04 17:06:03 alexandre_tb Exp $
/**
* Bibliothèque des fonctions de l'application Installateur de Papyrus.
*
* Ce sous-paquetage contient les fonctions de l'application Installateur de Papyrus. Cette application gère 
* l'installation de Papyrus (base de données).
*
*@package Installateur
*@subpackage Fonctions
//Auteur original :
*@author        Jean-Pascal MILCENT <jpm@tela-botanica.org>
//Autres auteurs :
*@author        aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.7 $ $Date: 2007-01-04 17:06:03 $
*/

// +------------------------------------------------------------------------------------------------------+
// |                                           LISTE de FONCTIONS                                         |
// +------------------------------------------------------------------------------------------------------+


/**Fonction donnerUrlCourante() - Retourne la base de l'url courante.
*
* Cette fonction renvoie la base de l'url courante.
* Origine : fonction provenant du fichier header.php de Wikini version 0.4.1
* Licence : la même que celle figurant dans l'entête du fichier header.php de Wikini version 0.4.1
* ou le fichier install_defaut.inc.php de cette application.
* Auteurs : Hendrik MANS, David DELON, Patrick PAUL, Jean-Pascal MILCENT
*
* @return string l'url courante.
*/
function donnerUrlCourante()
{
    list($url, ) = explode('?', $_SERVER['REQUEST_URI']);
    return $url;
}

/**Fonction testerConfig() - Retourne un message en fonction du résultat du test.
*
* Cette fonction retourne un message en fonction du résultat du test.
* Origine : fonction provenant du fichier header.php de Wikini version 0.4.1
* Licence : la même que celle figurant dans l'entête du fichier header.php de Wikini version 0.4.1
* ou le fichier install_defaut.inc.php de cette application.
* Auteurs : Hendrik MANS, David DELON, Patrick PAUL, Jean-Pascal MILCENT
*
* @return string l'url courante.
*/
function testerConfig(&$sortie, $texte, $test, $texte_erreur = '', $stop_erreur = 1, $erreur) {
    if ($erreur == 2) {
        return 2;
    }
    $sortie .= $texte.' ';
    if ($test) {
        $sortie .= '<span class="ok">&nbsp;OK&nbsp;</span><br />'."\n";
        return 0;
    } else {
        $sortie .= '<span class="failed">&nbsp;ECHEC&nbsp;</span>';
        if ($texte_erreur) {
            $sortie .= '<p class="erreur">'.$texte_erreur.'</p>';
        }
        $sortie .= '<br />'."\n" ;
        if ($stop_erreur == 1) {
            return 2;
        } else {
            return 1;
        }
    }
}
/**
 * Removes comment lines and splits up large sql files into individual queries
 *
 * Last revision: September 23, 2001 - gandon
 * Origine : fonction provenant de PhpMyAdmin version 2.6.0-pl1
 * Licence : GNU
 * Auteurs : voir le fichier Documentation.txt ou Documentation.html de PhpMyAdmin.
 *
 * @param   array    the splitted sql commands
 * @param   string   the sql commands
 * @param   integer  the MySQL release number (because certains php3 versions
 *                   can't get the value of a constant from within a function)
 *
 * @return  boolean  always true
 *
 * @access  public
 */
function PMA_splitSqlFile(&$ret, $sql, $release)
{
    // do not trim, see bug #1030644
    //$sql          = trim($sql);
    $sql          = rtrim($sql, "\n\r");
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $nothing      = TRUE;
    $time0        = time();

    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i];

        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i         = strpos($sql, $string_start, $i);
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    $tab_info = retournerInfoRequete($sql);
                    $ret[] = array('query' => $sql, 'table_nom' => $tab_info['table_nom'], 'type' => $tab_info['type']);
                    return TRUE;
                }
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                else if ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    // ... else loop
                    else {
                        $i++;
                    }
                } // end if...elseif...else
            } // end for
        } // end if (in string)
       
        // lets skip comments (/*, -- and #)
        else if (($char == '-' && $sql_len > $i + 2 && $sql[$i + 1] == '-' && $sql[$i + 2] <= ' ') || $char == '#' || ($char == '/' && $sql_len > $i + 1 && $sql[$i + 1] == '*')) {
            $i = strpos($sql, $char == '/' ? '*/' : "\n", $i);
            // didn't we hit end of string?
            if ($i === FALSE) {
                break;
            }
            if ($char == '/') $i++;
        }

        // We are not in a string, first check for delimiter...
        else if ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            $retour_sql = substr($sql, 0, $i);
            $tab_info = retournerInfoRequete($retour_sql);
            $ret[]      = array('query' => $retour_sql, 'empty' => $nothing, 'table_nom' => $tab_info['table_nom'], 'type' => $tab_info['type']);
            $nothing    = TRUE;
            $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len    = strlen($sql);
            if ($sql_len) {
                $i      = -1;
            } else {
                // The submited statement(s) end(s) here
                return TRUE;
            }
        } // end else if (is delimiter)

        // ... then check for start of a string,...
        else if (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string    = TRUE;
            $nothing      = FALSE;
            $string_start = $char;
        } // end else if (is start of string)

        elseif ($nothing) {
            $nothing = FALSE;
        }

        // loic1: send a fake header each 30 sec. to bypass browser timeout
        $time1     = time();
        if ($time1 >= $time0 + 30) {
            $time0 = $time1;
            header('X-pmaPing: Pong');
        } // end if
    } // end for

    // add any rest to the returned array
    if (!empty($sql) && preg_match('@[^[:space:]]+@', $sql)) {
        $tab_info = retournerInfoRequete($sql);
        $ret[] = array('query' => $sql, 'empty' => $nothing, 'table_nom' => $tab_info['table_nom'], 'type' => $tab_info['type']);
    }

    return TRUE;
}

/**Fonction retournerInfoRequete() - Retourne le type de requête sql et le nom de la table touchée.
*
* Cette fonction retourne un tableau associatif contenant en clé 'table_nom' le nom de la table touchée
* et en clé 'type' le type de requête (create, alter, insert, update...).
* Licence : la même que celle figurant dans l'entête de ce fichier
* Auteurs : Jean-Pascal MILCENT
*
* @author Jean-Pascal MILCENT <jpm@tela-botanica.org>
* @return string l'url courante.
*/
function retournerInfoRequete($sql)
{
    $requete = array();
    $resultat='';
    if (preg_match('/(?i:CREATE TABLE) +(.+) +\(/', $sql, $resultat)) {
        if (isset($resultat[1])) {
            $requete['table_nom'] = $resultat[1];
        }
        $requete['type'] = 'create';
    } else if (preg_match('/(?i:ALTER TABLE) +(.+) +/', $sql, $resultat)) {
        if (isset($resultat[1])) {
            $requete['table_nom'] = $resultat[1];
        }
        $requete['type'] = 'alter';
    } else if (preg_match('/(?i:INSERT INTO) +(.+) +(?i:\(|VALUES +\()/', $sql, $resultat)) {
        if (isset($resultat[1])) {
            $requete['table_nom'] = $resultat[1];
        }
        $requete['type'] = 'insert';
    } else if (preg_match('/(?i:UPDATE) +(.+) +(?i:SET)/', $sql, $resultat)) {
        if (isset($resultat[1])) {
            $requete['table_nom'] = $resultat[1];
        }
        $requete['type'] = 'update';
    }
    return $requete;
}
/**
 * Reads (and decompresses) a (compressed) file into a string
 *
 * Origine : fonction provenant de PhpMyAdmin version 2.6.0-pl1
 * Licence : GNU
 * Auteurs : voir le fichier Documentation.txt ou Documentation.html de PhpMyAdmin.
 *
 * @param   string   the path to the file
 * @param   string   the MIME type of the file, if empty MIME type is autodetected
 *
 * @global  array    the phpMyAdmin configuration
 *
 * @return  string   the content of the file or
 *          boolean  FALSE in case of an error.
 */
function PMA_readFile($path, $mime = '')
{
    global $cfg;

    if (!file_exists($path)) {
        return FALSE;
    }
    switch ($mime) {
        case '':
            $file = @fopen($path, 'rb');
            if (!$file) {
                return FALSE;
            }
            $test = fread($file, 3);
            fclose($file);
            if ($test[0] == chr(31) && $test[1] == chr(139)) return PMA_readFile($path, 'application/x-gzip');
            if ($test == 'BZh') return PMA_readFile($path, 'application/x-bzip');
            return PMA_readFile($path, 'text/plain');
        case 'text/plain':
            $file = @fopen($path, 'rb');
            if (!$file) {
                return FALSE;
            }
            $content = fread($file, filesize($path));
            fclose($file);
            break;
        case 'application/x-gzip':
            if ($cfg['GZipDump'] && @function_exists('gzopen')) {
                $file = @gzopen($path, 'rb');
                if (!$file) {
                    return FALSE;
                }
                $content = '';
                while (!gzeof($file)) {
                    $content .= gzgetc($file);
                }
                gzclose($file);
            } else {
                return FALSE;
            }
           break;
        case 'application/x-bzip':
            if ($cfg['BZipDump'] && @function_exists('bzdecompress')) {
                $file = @fopen($path, 'rb');
                if (!$file) {
                    return FALSE;
                }
                $content = fread($file, filesize($path));
                fclose($file);
                $content = bzdecompress($content);
            } else {
                return FALSE;
            }
           break;
        default:
           return FALSE;
    }
    return $content;
}
/* +--Fin du code ---------------------------------------------------------------------------------------+
*
* $Log: instal_installation.fonct.php,v $
* Revision 1.7  2007-01-04 17:06:03  alexandre_tb
* modif mineure
*
* Revision 1.6  2006/04/28 12:41:49  florian
* corrections erreurs chemin
*
* Revision 1.5  2005/09/23 14:20:23  florian
* nouvel habillage installateur, plus correction de quelques bugs
*
* Revision 1.4  2004/10/25 16:26:56  jpm
* Ajout de la gestion des requêtes de type alter et update.
*
* Revision 1.3  2004/10/19 16:47:06  jpm
* Modification de la gestion du texte de sortie dans la fonction testerConfig().
*
* Revision 1.2  2004/10/15 18:28:44  jpm
* Ajout de fonction utilisée pour l'installation de Papyrus.
*
* Revision 1.1  2004/06/16 14:34:12  jpm
* Changement de nom de Génésia en Papyrus.
* Changement de l'arborescence.
*
* +--Fin du code ----------------------------------------------------------------------------------------+
*/
?>