<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
</body>
</html>


<?php
// error_reporting(E_ALL);
header("Access-Control-Allow-Origin: http://localhost:88");
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors','On');


    use ElephantIO\Client,
		ElephantIO\Engine\SocketIO\Version1X,
		ElephantIO\Exception\ServerConnectionFailureException;
	
		require __DIR__ . '/vendor/autoload.php';
	
	// var_dump($_POST);
	// echo json_encode($_POST);
	echo "Emitter","\n";

	// $client = new ElephantIO\Client(
	// 	new ElephantIO\Engine\SocketIO\Version1X(
	// 		'https://localhost:3001'
	// 	)
	// );

	// $client = new Client(new Version1X('http://localhost:3001', [
	// 	'headers' => [
	// 		'X-My-Header: websocket rocks',
	// 		'Authorization: Bearer 12b3c4d5e6f7g8h9i'
	// 	]
	// ]));
	// $client = new stdClass();

	// if(isset($_POST['token'])) {
	// $client = new Client(new Version1X('http://192.168.1.26:3001'. '/?token='.$_POST['token']));
	// $token = $_POST['token'];
	// global $client;
	// debug_to_console($_POST['token']);
	// $client = new Client(new Version1X('http://192.168.1.26:3001/?token='.$token));
	// }


	// $client = new Client(new Version1X('http://192.168.1.26:3001/?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJmaXJzdF9uYW1lIjoiSm9obiIsImxhc3RfbmFtZSI6IkRvZSIsImVtYWlsIjoiam9obkBkb2UuY29tIiwiaWF0IjoxNTA0NzgzOTUwfQ.U0C02GFG2s8xgfCaWYfc2AK4eA6gJbCnYiuHflm0Kzw'));

	echo gettype($client), "\n";
	
	// var_dump($client);
	// $client->initialize();
	// $message = array("name"=>"ashik","message"=>"test");
	// $client->emit('new_message',$message);
	// $client->close();

		
	// if(isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['message']) && !empty($_POST['message'])) {
	// 	print_r ($_POST);
	// 	$message = array("name"=>$_POST['name'],"message"=>$_POST['message']);
	// 	// echo $message;
	// 	debug_to_console($message);
	// 	$client->initialize();
	// 	$client->emit('new_message',"test message");
	// 	$client->close();
		
	// }



	if(isset($_POST['name']) && isset($_POST['message'])) {
		global $client;
		$client = new Client(new Version1X('http://192.168.1.26:3001/?token='.$_POST['token']));
		print_r ($_POST);
		$message = array("name"=>$_POST['name'],"message"=>$_POST['message'],"group"=>$_POST['group'],"socketid"=>$_POST['socketid']);
		debug_to_console($message);
		// $client->initialize();
		// $client->emit('new_message',"test message");
		// $client->close();
	try
	{
		$client->initialize();
		$client->emit('new_message',$message);
		$client->close();
	}
	catch (ServerConnectionFailureException $e)
	{
		echo $e;
	}
		
	}


	function debug_to_console( $data ) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);
	
		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}
	// $client = new Client(new Version1X('https://localhost:3001/?token=token', ['context' => ['ssl' => ['verify_peer_name' =>false, 'verify_peer' => false]]]));


	// try
	// {
	// 	$client->initialize();
	// 	echo "client-->";
	// 	$client->emit('new_order', ['foo' => 'bar']);
	// 	$client->close();
	// }
	// catch (ServerConnectionFailureException $e)
	// {
	// 	echo $e;
	// }
?>
