<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;

trait Utilities
{
	function _Validate(array $inputs, array $vRules)
	{
		$validator = Validator::make($inputs,$vRules);

        if ($validator->fails()) {
            return ['status'=>0,'msg'=>$validator->messages()->first()];
        }

        return ['status'=>1,'msg'=>'Validations Passed!'];
	}

}