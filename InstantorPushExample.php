<?php

    require_once __DIR__ . '/instantor-api-php/src/Instantor/Report/Decrypt.php';
  	require_once __DIR__ . '/instantor-api-php/vendor/autoload.php';

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

  	$source = "lukatest8.dk";
  	$api_key = "45I4%P9ZRwbL3CanxD;.ziVj";

  	echo (new Test($source, $api_key))->runTest();

  	exit(0);

?>