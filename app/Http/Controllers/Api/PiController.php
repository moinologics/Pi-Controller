<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



//use App\Traits\WebServices\PiService;

use App\Traits\Pi;

class PiController extends Controller
{
	use Pi;



    public function test()
    {
//		print_r($this->setOutput(35,0));
		print_r($this->getInput(37));
    }

}
