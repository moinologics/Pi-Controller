<?php

namespace App\Traits;

use Symfony\Component\Process\Process;
//use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Support\Facades\Storage;
use App\Traits\Utilities;

trait Pi
{
	use Utilities;
	private $disk,$pins,$states;

    	public function __construct()
    	{
        	$this->disk = Storage::disk('resources');
        	$this->pins = json_decode($this->disk->get('pi/pins.json'),true);
        	$this->states = json_decode($this->disk->get('pi/pins-state.json'),true);
    	}

    	public function __destruct()
    	{
    		
        	$this->states = json_encode($this->states,JSON_PRETTY_PRINT);
        	echo $this->disk->put('pi/pins-state.json',$this->states);
    	}

	public function runQuery($params)
	{
		$cmd = array_merge(['python', resource_path('scripts/Pi.py'), '-k'], $params);
		$process = new Process($cmd);
		$process->run();

		// executes after the command finishes
		if ($process->isSuccessful()) 
		{
		    return $process->getOutput();
		}

		//throw new ProcessFailedException($process);
		return "{'status': 0, 'error': ".$process->getErrorOutput()."}";
	}

	function getInput($pin)
	{
		$valid = $this->_Validate(['pin'=>$pin],[

	    		'pin'=>'required|in:'.implode(',',array_keys($this->states))
    		]);

		if(!$valid['status']) return $valid;

		$result = $this->runQuery(["opr=getPinInput", "pin=$pin"]);

		$result = json_decode($result, true);

		if($result['status'])
		{
			$this->states["$pin"] = ['mode' => 'IN', 'state' => $result['msg']];
		}

		return $result;
	}

	function setOutput($pin, $value)
	{
		$valid = $this->_Validate(['pin'=>$pin,'value'=>$value],[

	    		'pin'=>'required|in:'.implode(',',array_keys($this->states)),
	    		'value'=>'required|in:0,1'
    		]);

		if(!$valid['status']) return $valid;

		$result = $this->runQuery(["opr=setPinOutput", "pin=$pin", "value=$value"]);
    		
		$result = json_decode($result, true);

		if($result['status'])
		{
			$this->states["$pin"] = ['mode' => 'OUT', 'state' => $value];
		}

//		print_r($this->states);

		return $result;
	}


}