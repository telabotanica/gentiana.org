<?php

class Composant {

	public static function fabrique($classe, $options = array())
	{
		$classe_nom = implode('', array_map('ucfirst', explode('_', $classe)));
		require_once EF_CHEMIN_COMPOSANT.$classe.DIRECTORY_SEPARATOR.$classe_nom.'.class.php';
		$Composant = new $classe_nom($options);
		return $Composant;
	}
	
}
?>