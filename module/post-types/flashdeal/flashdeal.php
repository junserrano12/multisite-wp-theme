<?php

class Flashdeal  {

	public $options;
	public $labels;
	public $args;
	public $posttype;

	function __construct() { 

		 $this->posttype = strtolower( __CLASS__ );
		 $this->options = include('config.options.php');
	}

	function load()
	{	
		 foreach($this->options as $key => $val){

		 	$this->labels = include('config.labels.php');
		 	$this->args = include('config.args.php'); 
		 	$this->register( $this->posttype , $this->args );
		 	
		 }
	}	

	function register( $posttype, $args )
	{
		register_post_type( $posttype, $args );
	}

}  
?>