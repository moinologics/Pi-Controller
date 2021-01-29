<?php

namespace App\Traits;

use Graze\TelnetClient\TelnetClient;

trait Esp12f
{
	private $esp;
	
	public function __construct()
	{
		$dsn = env('ESP_IP').':'.env('ESP_PORT');
		$prompt = 'CMD>';
		$promptError = 'ERR';
		$lineEnding = "\r\n";
		$this->esp = TelnetClient::factory();
		$this->esp->connect($dsn,$prompt,$promptError,$lineEnding);
	}
	
	public function setOutput($pin, $value)
	{
		$cmd = "gpio $pin set $value\n";
		$out = $this->esp->execute($cmd);
		return $out;
	}
}

