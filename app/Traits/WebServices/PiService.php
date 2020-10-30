<?php

namespace App\Traits\WebServices;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

use App\Traits\Utilities;

trait PiService
{
	use Utilities;
	private $endpoint,$disk,$pins,$states;

    public function __construct()
    {
        $this->endpoint = 'http://pi4api.loc';
        $this->disk = Storage::disk('resources');
        $this->pins = json_decode($this->disk->get('pi/pins.json'),true);
        $this->states = json_decode($this->disk->get('pi/pins-state.json'),true);
    }

    public function __destruct()
    {
        $this->states = json_encode($this->states,JSON_PRETTY_PRINT);
        $this->disk->put('pi/pins-state.json',$this->states);
    }

    private function updatepinstate($pin,$props)
    {
        foreach($props as $prop => $val)
        {
            $this->states[$pin][$prop] = $val;
        }
    }

    public function pinlist()
    {
        return $this->pins;
    }

    public function BoardMode($mode=NULL)
    {
        
        if($mode!==NULL)    //set mode as $mode
        {
        	return ['status'=>0,'msg'=>'Not Implemented Yet.'];
        }
        else{   //get mode
            $url = $this->endpoint.'/getboardmode';
            try{
                $resp = Http::get($url);
            }catch(Exception $e){
                return ['status'=>0,'msg'=>'Api Server Error.','debug'=>$e->getMessage()];
            }
        }

        if($resp->ok())
        {
            $result = $resp->json();
        }
        else{
            $result = ['status'=>0,'msg'=>$resp->body()];
        }

        return $result;
    }

    public function PinMode($pin,$mode=NULL)
    {
    	$valid = $this->_Validate(['pin'=>$pin,'mode'=>$mode],[

    		'pin'=>'required|in:'.implode(',',array_keys($this->states)),
    		'mode'=>'nullable|in:IN,in,OUT,out'
    	]);

    	if(!$valid['status']) return $valid;

        if($mode!==NULL)    //set mode as $mode
        {
            $url = $this->endpoint.'/setpinmode';
            $mode = strtoupper($mode);
            try{
                $resp = Http::post($url,['pin'=>$pin,'mode'=>$mode]);
            }catch(Exception $e){
                return ['status'=>0,'msg'=>'Api Server Error.','debug'=>$e->getMessage()];
            }

            if($resp->ok())
            {
                $result = $resp->json();
                $this->updatepinstate($pin,['mode'=>$mode]);
            }
            else{
                $result = ['status'=>0,'msg'=>$resp->body()];
            }
        }
        else{   //get mode
            $result = ['status'=>1,'mode'=>$this->states[$pin]['mode']];
        }

        return $result;
    }

    public function PinState($pin,$value=NULL)
    {
        
        $valid = $this->_Validate(['pin'=>$pin,'value'=>$value],[

    		'pin'=>'required|in:'.implode(',',array_keys($this->states)),
    		'value'=>'nullable|in:0,1,on,off,On,Off,ON,OFF'
    	]);

    	if(!$valid['status']) return $valid;

        if($value!==NULL)    //set output as $value
        {
            $url = $this->endpoint.'/setpinoutput';
            
            $value = (strtoupper($value)=='ON' || $value=='1') ? 1 : 0;
            try{
                $resp = Http::post($url,['pin'=>$pin,'value'=>$value]);
            }catch(Exception $e){
                return ['status'=>0,'msg'=>'Api Server Error.','debug'=>$e->getMessage()];
            }

            if($resp->ok())
            {
                $result = $resp->json();
                $this->updatepinstate($pin,['state'=>(int)$value]);
            }
            else{
                $result = ['status'=>0,'msg'=>$resp->body()];
            }
        }
        else{   
            $result = ['status'=>1,'pinvalue'=>$this->states[$pin]['state']];
        }

        return $result;
    }

}