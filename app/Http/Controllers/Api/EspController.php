<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Traits\Esp12f;


class EspController extends Controller
{
	use Esp12f;
	public function test()
	{
		return $this->setOutput(1,'low');
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

    function python_processes()
    {
    		$cmd = "ps aux | grep python | awk '{print $2,$12}'";
    		exec($cmd,$output);
    		return $output;
    }

}
