<?php
$menu_page=$this->config["menu_page"];
if (isset($menu_page) and ($menu_page!=""))
    {
    // Ajout Menu de Navigation
    echo '<tr><td class="menu_column">';
    $wikiMenu = $this;
    $wikiMenu->tag=$menu_page;
    $wikiMenu->SetPage($wikiMenu->LoadPage($wikiMenu->tag));
    echo $wikiMenu->Format($wikiMenu->page["body"], "wakka");
    echo '</td>';
    echo '<td class="body_column">';
    }
?>
