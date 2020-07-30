<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Traits\WebServices\PiService;

class PiController extends Controller
{
	use PiService;



    public function test()
    {

        // $this->updatepinstate(3,['mode'=>'OUT']);
        //return $this->states;

        /*$x = [];

        foreach ($this->pins as $pin)
        {
            if($pin['GPIO']!==FALSE)
                $x[$pin['pin']] = ['mode'=>'UNKNOWN','state'=>0];
        }

        return $x;*/
    }

}
