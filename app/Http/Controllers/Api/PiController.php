<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Traits\Pi;


class PiController extends Controller
{
//	use Pi;



    public function test()
    {
    		
//		print_r($this->setOutput(35,0));
		//print_r($this->getInput(37));
    }

    public function tank_percent(Request $request)
    {
    		$percent = Storage::disk('resources')->get('7-segment-percent-number.txt');
    		if($request->exists('getpercent'))
    		{
    			return $percent;
    		}
    		return view('tank-percent',['percent'=>$percent]);
    }

}
