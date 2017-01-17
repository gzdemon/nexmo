<?php
		require_once "vendor/autoload.php";
		define('API_KEY', '1a6e5a9d');
		define('API_SECRET', '082c72489ca55c4f');
		define('NEXMO_TO', '8618665710088');
		define('NEXMO_FROM', 'NEXMO');
/*echo http_build_query(
    [
      'api_key' =>  API_KEY,
      'api_secret' => API_SECRET,
      'to' => NEXMO_TO,
      'from' => NEXMO_FROM,
      'text' => 'Hello from Nexmo'
    ]);*/
/*$url = 'https://rest.nexmo.com/sms/json?' . http_build_query(
    [
      'api_key' =>  API_KEY,
      'api_secret' => API_SECRET,
      'to' => NEXMO_TO,
      'from' => NEXMO_FROM,
      'text' => 'Hello from Nexmo'
    ]
);
//var_dump(openssl_get_cert_locations());
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
$response = curl_exec($ch);


//Decode the json object you retrieved when you ran the request.
  $decoded_response = json_decode($response, true);

  error_log('You sent ' . $decoded_response['message-count'] . ' messages.');

  foreach ( $decoded_response['messages'] as $message ) {
      if ($message['status'] == 0) {
          error_log("Success " . $message['message-id']);
      } else {
          error_log("Error {$message['status']} {$message['error-text']}");
      }
  }*/
		$client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic(API_KEY, API_SECRET));
		//send message using simple api params
		$message = $client->message()->send([
		    'to' => NEXMO_TO,
		    'from' => NEXMO_FROM,
		    'text' => 'Test message from the Nexmo PHP Client'
		]);

		//array access provides response data
		echo "Sent message to " . $message['to'] . ". Balance is now " . $message['remaining-balance'] . PHP_EOL;

?>
