<?php
/*vim: set expandtab tabstop=4 shiftwidth=4: */ 
// +------------------------------------------------------------------------------------------------------+
// | PHP version 4.1                                                                                      |
// +------------------------------------------------------------------------------------------------------+
// | Copyright (C) 2004 Tela Botanica (accueil@tela-botanica.org)                                         |
// +------------------------------------------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or                                        |
// | modify it under the terms of the GNU General Public                                                  |
// | License as published by the Free Software Foundation; either                                         |
// | version 2.1 of the License, or (at your option) any later version.                                   |
// |                                                                                                      |
// | This library is distributed in the hope that it will be useful,                                      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of                                       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU                                    |
// | General Public License for more details.                                                             |
// |                                                                                                      |
// | You should have received a copy of the GNU General Public                                            |
// | License along with this library; if not, write to the Free Software                                  |
// | Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA                            |
// +------------------------------------------------------------------------------------------------------+
// CVS : $Id: HTML_TableFragmenteur.php,v 1.2 2006-04-28 12:41:26 florian Exp $
/**
* Classe qui permet de créer des tables de résultat divisé en page
*
*
*@package projet
//Auteur original :
*@author        Alexandre Granier <alexandre@tela-botanica.org>
//Autres auteurs :
*@author        Aucun
*@copyright     Tela-Botanica 2000-2004
*@version       $Revision: 1.2 $
// +------------------------------------------------------------------------------------------------------+
*/


// +------------------------------------------------------------------------------------------------------+
// |                                            ENTETE du PROGRAMME                                       |
// +------------------------------------------------------------------------------------------------------+


include_once PAP_CHEMIN_API_PEAR.'HTML/Table.php' ;

/**
 * class HTML_Liste
 * 
 */
class HTML_TableFragmenteur extends HTML_Table
{
    /*** Attributes: ***/

    /**
     * 
     * @access protected
     */
    var $pager;
    /**
     * 
     * @access private
     */
    var $_utilise_pager;


    /**
     * 
     *
     * @param bool utilise_pager Si l'on souhaite que les résultats soient divisés en page, on passe true.
     * @return HTML_Liste
     * @access public
     */
    function HTML_Liste( $utilise_pager = false)
    {
        HTML_Table::HTML_Table() ;
        $this->_utilise_pager = $utilise_pager ;
        
    } // end of member function HTML_Liste

    /**
     * 
     *
     * @param Array label_entete Un tableau contenant les labels pour l'entête de la liste.
     * @return void
     * @access public
     */
    function construireEntete( $label_entete )
    {
        $this->addRow ($label_entete, '', 'TH') ;
    } // end of member function construitEntete

    /**
     * 
     *
     * @param Array label_liste Un tableau à double dimension contenant les valeurs de la liste. du type 
     *      0 =>'label', 'label2', 
     *      1 => ...
     * @return void
     * @access public
     */
    function construireListe( $label_liste )
    {
        for ($i = 0; $i < count ($label_liste) ; $i++) {
            $this->addRow ($label_liste[$i]) ;
            //var_dump ($label_liste[$i]) ;
        }
    }
} // end of HTML_Liste


?>
