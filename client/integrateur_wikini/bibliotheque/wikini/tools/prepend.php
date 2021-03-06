<?php

// Vérification de sécurité
if (!defined("WIKINI_VERSION"))
{
        die ("acc&egrave;s direct interdit");
}


// Meme nom : remplace
// _Meme nom : avant
// Meme nom : _apres


require_once('libs/class.plugins.php');


Class WikiTools extends Wiki {
	function Format($text, $formatter = "wakka") {
		return $this->IncludeBuffered($formatter.".php", "<i>Impossible de trouver le formateur \"$formatter\"</i>", compact("text"),$this->config['formatter_path']); 
		
	}
	
	function IncludeBuffered($filename, $notfoundText = "", $vars = "", $path = "") {
		if ($path) $dirs = explode(":", $path);
		else $dirs = array("");
		
		$included['before']=array();
		$included['new']=array();
		$included['after']=array();
	
		foreach($dirs as $dir) {
			if ($dir) $dir .= "/";
			$fullfilename = $dir.$filename;
			if (strstr($filename,'page/')) {
				list($file,$extension) = explode("page/", $filename);
				$beforefullfilename = $dir.$file.'page/__'.$extension;
			}
			else {
				$beforefullfilename = $dir.'__'.$filename;
			}
			
			
			list($file,$extension) = explode(".", $filename);
			$afterfullfilename = $dir.$file.'__.'.$extension;
			
			if (file_exists($beforefullfilename)) {
				$included['before'][]=$beforefullfilename;
			}
			
			if (file_exists($fullfilename)) {
				$included['new'][]=$fullfilename;
			}
			
			if (file_exists($afterfullfilename)) {
				$included['after'][]=$afterfullfilename;
			}
		}

		$plugin_output_before='';
		$plugin_output_new='';
		$plugin_output_after='';
		$found=0;
		
		if (is_array($vars)) extract($vars);
		
		foreach ($included['before'] as $before) {
				$found=1;
				ob_start();
				include($before);
				$plugin_output_before.= ob_get_contents();
				ob_end_clean();
		}
		foreach ($included['new'] as $new) {
				$found=1;
				ob_start();
				require($new);
				$plugin_output_new = ob_get_contents();
				ob_end_clean();
				break;
		}
		foreach ($included['after'] as $after) {
				$found=1;
				ob_start();
				include($after);
				$plugin_output_after.= ob_get_contents();
				ob_end_clean();
		}
		if ($found) return $plugin_output_before.$plugin_output_new.$plugin_output_after;
		if ($notfoundText) return $notfoundText;
		else return false;
	}
	
}

$plugins_root = 'tools/';

$objPlugins = new plugins($plugins_root);
$objPlugins->getPlugins(true);
$plugins_list = $objPlugins->getPluginsList();

$wakkaConfig['formatter_path']='formatters';
$wikiClasses [] = 'WikiTools';
$wikiClassesContent [] = '';

foreach ($plugins_list as $k => $v) {
	if (file_exists($plugins_root.$k.'/wiki.php')) {
		include($plugins_root.$k.'/wiki.php');
	}
	if (file_exists($plugins_root.$k.'/actions')) {
		$wakkaConfig['action_path']=$plugins_root.$k.'/actions/'.':'.$wakkaConfig['action_path'];
	}
	if (file_exists($plugins_root.$k.'/handlers')) {
		$wakkaConfig['handler_path']=$plugins_root.$k.'/handlers/'.':'.$wakkaConfig['handler_path'];
	}
	if (file_exists($plugins_root.$k.'/formatters')) {
		$wakkaConfig['formatter_path']=$plugins_root.$k.'/formatters/'.':'.$wakkaConfig['formatter_path'];
	}
}

for ($iw=0;$iw<count($wikiClasses);$iw++) {
	if ($wikiClasses[$iw]!='WikiTools') {	
		eval('Class '. $wikiClasses[$iw] .' extends '. $wikiClasses[$iw-1] . ' { '.$wikiClassesContent[$iw].' }; ');
	}
}

//$wiki  = new WikiTools($wakkaConfig);
eval ('$wiki  = new '.$wikiClasses[count($wikiClasses)-1]. '($wakkaConfig);');

?>