<?php

include("../../../environment.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Include the SDK using the Composer autoloader
	require 'aws-sdk-php/vendor/autoload.php';

	$queryString = $_SERVER['QUERY_STRING'];

	$bucket = 'challenge.article';
	$s3 = new Aws\S3\S3Client([
	    'version' => 'latest',
	    'region'  => 'us-west-2',
	    'credentials' => [
	        'key'    => AWS_ACCESSKEY,
	        'secret' => AWS_SECRETKEY
	    ]
	]);

	// only jpgs for now :[
	$key = $queryString.'.jpg';
	// get payload
	$string = file_get_contents('php://input');
	// enable decode
	$encodedData = str_replace('data:image/jpeg;base64,', '', $string);
	$decodedData = base64_decode($encodedData);

	$s3->putObject([
	    'Bucket' => $bucket,
	    'Key'    => $key,
	    'Body'   => $decodedData,
	    'ACL'		 => 'public-read'
	]);
	echo $decodedData;
} else {
	header("HTTP/1.0 405 Method Not Allowed");
}

?>
