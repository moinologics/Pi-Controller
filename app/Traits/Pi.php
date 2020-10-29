<?php

namespace App\Traits;

use Symfony\Component\Process\Process;

trait Pi
{

	function runQuery($params)
	{
		
		$process = new Process(['python', resource_path('scripts/Pi.py'), '-k', 'foo=bar']);
		$process->run();

		return $process->isSuccessful() ? $process->getOutput() : NULL;
	}

	function setOutput($pin, $value)
	{
		return false;
	}


}