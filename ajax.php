<?php

	// header('Content-Type:text/json');
	session_start();

	if(!isset($_REQUEST['opr'])) die(json_encode(['status'=>0,'msg'=>'opreation?']));

	$opr = $_REQUEST['opr'];


	// require '../dbconf.php';
	require 'curl.class.php';

    $http = new CurlHttp();


	if($opr=='getgpiolist')
    {
        $res = $http->get('http://pi4api.loc/getgpios');

        if($http->getError()['code'] == 0)
        {
            echo $res;
        }
        else
        {
            echo json_encode(['status'=>0,'msg'=>$http->getError()['msg']]);
        }
    }

    if($opr=='setpinmode')
    {
        $pin = $_REQUEST['pin'];
        $mode = $_REQUEST['mode'];

        $res = $http->get("http://pi4api.loc/pinsetup?pin=$pin&mode=$mode");

        if($http->getError()['code'] == 0)
        {
            echo $res;
        }
        else
        {
            echo json_encode(['status'=>0,'msg'=>$http->getError()['msg']]);
        }
    }

    if($opr=='setpinvalue')
    {
        $pin = $_REQUEST['pin'];
        $value = $_REQUEST['value'];

        $res = $http->get("http://pi4api.loc/setoutput?pin=$pin&value=$value");

        if($http->getError()['code'] == 0)
        {
            echo $res;
        }
        else
        {
            echo json_encode(['status'=>0,'msg'=>$http->getError()['msg']]);
        }
    }