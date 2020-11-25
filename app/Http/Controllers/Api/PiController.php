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

    public function tank_meter(Request $request)
    {
    		$home = Storage::disk('resources')->get('home.json');
    		$home = json_decode($home,TRUE);
    		if($request->exists('getpercent'))
    		{
    			return $home['tank'];
    		}
    		return view('tank-meter',['percent'=>$home['tank']['filled_percentage']]);
    }

}
