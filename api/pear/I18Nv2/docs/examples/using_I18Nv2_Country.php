<?php

/**
* Using I18Nv2_Country
* ====================
*
* I18Nv2 provides translated lists of country names.
* 
* $Id: using_I18Nv2_Country.php,v 1.1 2007-06-25 09:55:25 alexandre_tb Exp $
*/

require_once 'I18Nv2/Country.php';

$country =  new I18Nv2_Country('de', 'iso-8859-1');

echo "German name for United States: ",
    $country->getName('us'), "\n";

echo "German name for Italia:        ",
    $country->getName('it'), "\n";

?>