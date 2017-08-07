<?php
// needed to really load the alternate db-config in common.php
define("PHORUM_WRAPPER",1);

// set the Phorum install dir
$PHORUM_DIR="/home/florian/Applications/lampp/htdocs/papyrus/client/phorum";

// set the databse settings for this Phorum Install
$PHORUM_ALT_DBCONFIG=array(

   "type"          =>  "mysql",
   "name"          =>  "papyrus",
   "server"        =>  "localhost",
   "user"          =>  "root",
   "password"      =>  "fs1980",
   "table_prefix"  =>  "phorum"

);

// We have to alter the urls a little
function phorum_custom_get_url ($page, $query_items, $suffix)
{
    $PHORUM=$GLOBALS["PHORUM"];

    $url = "$PHORUM[http_path]/phorum.php?$page";

    if(count($query_items)) $url.=",".implode(",", $query_items);

    if(!empty($suffix)) $url.=$suffix;

    return $url;
}

?>