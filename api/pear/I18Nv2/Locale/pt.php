<?php
/**
* $Id: pt.php,v 1.1 2007-06-25 09:55:28 alexandre_tb Exp $
*/

$this->dateFormats = array(
    I18Nv2_DATETIME_SHORT     =>  '%d/%m/%y',
    I18Nv2_DATETIME_DEFAULT   =>  '%d-%b-%Y',
    I18Nv2_DATETIME_MEDIUM    =>  '%d-%b-%Y',
    I18Nv2_DATETIME_LONG      =>  '%d de %B de %Y',
    I18Nv2_DATETIME_FULL      =>  '%A, %d de %B de %Y'
);
$this->timeFormats = array(
    I18Nv2_DATETIME_SHORT     =>  '%H:%M',
    I18Nv2_DATETIME_DEFAULT   =>  '%H:%M:%S',
    I18Nv2_DATETIME_MEDIUM    =>  '%H:%M:%S',
    I18Nv2_DATETIME_LONG      =>  '%H:%M:%S %Z',
    I18Nv2_DATETIME_FULL      =>  '%H:%M %Z'
);
?>