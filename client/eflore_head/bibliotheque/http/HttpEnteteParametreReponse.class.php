<?php

class HttpEnteteParametreReponse extends HttpEnteteParametre {
	
	/*** Attributs : ***/
	
	private $code;
	
	/*** Constructeurs : ***/
		
	public function __construct($meta = null)
	{
		$this->setCode(200);
		parent::__construct($meta);
	}
		
	/*** Accesseurs : ***/
	
	// Code
	public function getCode()
	{
		return $this->code;
	}	
	public function setCode( $c )
	{
    	switch ($c) {
    		case 200 :
    			$this->code = '200 OK';
    			break;
    		case 201 :
    			$this->code = '201 Created';
    			break;
    		case 204 :
    			$this->code = '204 No Content';
    			break;
    		case 400 :
    			$this->code = '400 Bad Request';
    			break;
    		case 401 :
    			$this->code = '401 Unauthorized';
    			break;
    		case 404 :
    			$this->code = '404 Not Found';
    			break;
    		case 405 :
    			$this->code = '405 Method Not Allowed';
    			break;
    		case 406 :
    			$this->code = '406 Not Acceptable';
    			break;
    		case 411 :
    			$this->code = '411 Length Required';
    			break;
    		case 500 :
    			$this->code = '500 Internal Server Error';
    			break;
    	}
	}
	
	/*** Méthodes : ***/
	
	public function genererEntete()
	{
		header($this->getProtocol().'/'.$this->getVersion().' '.$this->getCode());
	}
	
}
?>