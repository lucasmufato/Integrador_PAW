<?php

class Index_View
{
	protected $templateDir;
	private $userName;

	function __construct($templateDir = null)
	{
		if(! is_null($templateDir)){
			$this->templateDir = $templateDir;
		}
	}

	#verifca que el template exista
	public function render($templateFile){
		if (file_exists($templateFile)){
			include $this->templateDir . $templateFile;
		} else {
			throw new Exception("No existe template $templateFile en el directorio");	
		}
	}

	public function setUserName($userName){
		$this->userName = $userName;
	}

	public function getUserName(){
		return $this->userName;
	}

}







?>