<?php
if ($this->HasAccess("write") && $this->HasAccess("read"))
{
	// preview?
	if ($_POST["submit"] == "Aper�u")
	{
		// Rien
	}
	else
	{
		$ACbuttonsBar = "
		<div id=\"toolbar\"> 
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'**','**');\" src=\"tools/aceditor/ACEdImages/bold.gif\" title=\"Passe le texte s�lectionn� en gras  ( Ctrl-Maj-b )\" alt=\"Gras\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'//','//');\" src=\"tools/aceditor/ACEdImages/italic.gif\" title=\"Passe le texte s�lectionn� en italique ( Ctrl-Maj-t )\" alt=\"Italique\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'__','__');\" src=\"tools/aceditor/ACEdImages/underline.gif\" title=\"Souligne le texte s�lectionn� ( Ctrl-Maj-u )\" alt=\"Soulign�\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'@@','@@');\" src=\"tools/aceditor/ACEdImages/strike.gif\" title=\"Barre le texte s�lectionn�\" alt=\"Barre\"></img>
		    
		<img class=\"buttons\"  src=\"tools/aceditor/ACEdImages/separator.gif\" alt=\"\" ></img>
		    
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'======','======\\n');\" src=\"tools/aceditor/ACEdImages/t1.gif\" title=\" En-t�te �norme\" alt=\"\">    </img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'=====','=====\\n');\" src=\"tools/aceditor/ACEdImages/t2.gif\" title=\"  En-t�te tr�s gros\" alt=\"\"> </img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'====','====\\n');\" src=\"tools/aceditor/ACEdImages/t3.gif\" title=\"  En-t�te gros\" alt=\"\">    </img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'===','===\\n');\" src=\"tools/aceditor/ACEdImages/t4.gif\" title=\"  En-t�te normal\" alt=\"\">    </img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'==','==');\" src=\"tools/aceditor/ACEdImages/t5.gif\" title=\"  Petit en-t�te\" alt=\"\">        </img>
		<img class=\"buttons\"  src=\"tools/aceditor/ACEdImages/separator.gif\" alt=\"\" ></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionWithLink(thisForm.body);\" src=\"tools/aceditor/ACEdImages/link.gif\" title=\"Ajoute un lien au texte s�lectionn�\" alt=\"\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'\\t-&nbsp;','');\" src=\"tools/aceditor/ACEdImages/listepuce.gif\" title=\"Liste\" alt=\"\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'\\t1)&nbsp;','');\" src=\"tools/aceditor/ACEdImages/listenum.gif\" title=\"Liste num�rique\" alt=\"\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'\\ta)&nbsp;','');\" src=\"tools/aceditor/ACEdImages/listealpha.gif\" title=\"Liste alphab�thique\" alt=\"\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionBis(thisForm.body,'\\n---','');\" src=\"tools/aceditor/ACEdImages/crlf.gif\" title=\"Ins�re un retour chariot\" alt=\"\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionBis(thisForm.body,'\\n------','');\" src=\"tools/aceditor/ACEdImages/hr.gif\" title=\"Ins�re une ligne horizontale\" alt=\"\"> </img>
		
		
		<img class=\"buttons\"  src=\"tools/aceditor/ACEdImages/separator.gif\" alt=\"\" ></img>
		      
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'%%','%%');\" src=\"tools/aceditor/ACEdImages/code.gif\" title=\"Code\" alt=\"\"></img>
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelection(thisForm.body,'%%(php)','%%');\" src=\"tools/aceditor/ACEdImages/php.gif\" title=\"Code PHP\" alt=\"\"></img>
		</div>
		<div id=\"toolbar_suite\">   
		   
		<img class=\"buttons\" onmouseover=\"mouseover(this);\" onmouseout=\"mouseout(this);\" onmousedown=\"mousedown(this);\" onmouseup=\"mouseup(this);\" onclick=\"wrapSelectionWithImage(thisForm.body);\" src=\"tools/aceditor/ACEdImages/image.gif\"    title=\"ins�re un tag image \" alt=\"\">  </img>
		
		<span class=\"texteChampsImage\">
		&nbsp;&nbsp;Fichier&nbsp;<input type=\"text\" name=\"filename\" class=\"ACsearchbox\" size=\"10\"/>&nbsp;&nbsp;Description&nbsp;<input type=\"text\" name=\"description\" class=\"ACsearchbox\" size=\"10\"/>
		&nbsp;&nbsp;Alignement&nbsp;<select id=\"alignment\" class=\"ACsearchbox\">
		<option value=\"left\">Gauche</option>
		<option value=\"center\">Centr�</option>
		<option value=\"right\">Droite</option>
		</select>
		</span>
		</div>";
		$plugin_output_new=preg_replace ('/\<textarea onkeydown/',
		$ACbuttonsBar.
		'<textarea onkeydown',
		$plugin_output_new);
	}
}