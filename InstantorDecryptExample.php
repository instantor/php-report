<?php

  	require_once 'vendor/autoload.php';

  	use Instantor\Report\Decrypt;

  	class Test
  	{
  		private $source;
  		private $api_key;

  		public function __construct($source, $api_key)
  		{
  			$this->source = $source;
  			$this->api_key = $api_key;
  		}

  		public function runTest()
  		{
  			return Decrypt::receivePostRequest($this->source, $this->api_key, $payload);
  		}
  	}

  	$source = ""; // use product name
  	$api_key = ""; // use your api_key

  	echo (new Test($source, $api_key))->runTest();

  	exit(0);

?>