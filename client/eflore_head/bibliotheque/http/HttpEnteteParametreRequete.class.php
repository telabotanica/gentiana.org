<?php

class HttpEnteteParametreRequete extends HttpEnteteParametre {

	/*** Attributs : ***/
	private $methode;
	
	private $uri;

	private $query_string = array();
	
	/*** Constructeurs : ***/
		
	public function __construct($meta = null)
	{
		// Instanciation des infos sur la requête
		if (isset($meta['REQUEST_URI']) && isset($meta['REQUEST_METHOD']) && isset($meta['QUERY_STRING'])) {
			$this->setUri($meta['REQUEST_URI']);
			if (!empty($_SERVER['QUERY_STRING'])) {
				$this->setQueryString($_SERVER['QUERY_STRING']);
			}
			$this->setMethode($meta['REQUEST_METHOD']);
		} else {
			trigger_error('eRibo à besoin d\'accéder aux variables suivantes pour fonctionner : REQUEST_URI, REQUEST_METHOD et QUERY_STRING.', E_USER_ERROR);
		}
	}
	
	/*** Accesseurs : ***/

	// Méthode
	public function getMethode()
	{
		return $this->methode;
	}
	public function setMethode( $m )
    {
    	$this->methode = $m;
	}

	// Uri
	public function getUri()
    {
		return $this->uri;
	}
	public function setUri( $u )
    {
    	$this->uri = $u;
	}

	// Query String
	public function getQueryString( $cle = NULL )
    {
    	if (!is_null($cle)) {
			return $this->query_string[$cle];
    	} else {
			return $this->query_string;
    	}
	}
	public function setQueryString( $tab_qs = NULL )
	{
		if (!is_null($tab_qs) && is_array($tab_qs)) {
			foreach ($tab_qs as $cle => $val ) {
				$this->query_string[$cle] = $val;
			}
		} else {
			trigger_error('Vous devez passer un tableau !', E_USER_ERROR);
		}
	}
}
?>