<?php


function validate_response($errors)
{
	return response()->json([
		'success'   => false,
		'errors'    => $errors
	]);
}



function success_response($data, string $message = "", int $code = 200)
{
	$test = [
		'success'   => true,
		'data'      => $data,
	];
	if ($message !== "") {
	   $test['message'] = $message;
	}
	return response()->json([$data,$code,$message]);
}


function error_response( string $message = "", int $code = 401)
{
	$test = [
     	'success'  => false,
		'message'   => $message
	];

	if ($message !== "") {
	   $test['message'] = $message;
	}

	return response()->json([$code,$message]);
}