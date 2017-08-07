<?php

class HttpEntite {
	
	/*** Attributs : ***/
	private $entete;
	
	private $contenu;

    /*** Constructeurs : ***/
  
	public function __construct($meta = null) {
		$this->setEntete(new HttpEnteteEntite($meta));
		
		if ($this->getEntete()->getContentLength() > 0) {
			$this->setContenu('');
			$http_content = fopen('php://input', 'r');
			while ($donnee = fread( $http_content, 1024 )) {
				$this->setContenu( $donnee );
			}
			fclose($http_content);
		}
	}
	
	/*** Accesseurs : ***/

	// Entête
	public function setEntete( $e )
	{
		$this->entete = $e;
	}
	public function getEntete()
	{
		return $this->entete;
	}

	// Contenu
	public function setContenu( $c )
	{
		$this->getEntete()->getContentLength(strlen($c));
		$this->contenu .= $c;
	}
	public function getContenu()
	{
		return $this->contenu;
	}

	/*** Méthodes : ***/

	public function genererEntite()
	{
		$this->getEntete()->genererEntete();
		echo $this->getContenu();
	}

}
?>