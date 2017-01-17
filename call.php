<?php
	require_once "vendor/autoload.php";
	use Nexmo\Calls\Call;
	/*
	 *  Set the parameters to run this script
	 */
	 $nexmo_key = "1a6e5a9d";
	 $nexmo_secret = "082c72489ca55c4f";

	//Leave blank unless you have already created an application
	$application_id = "b9291d87-5441-45bb-b1ba-885779ec30ff";
	//If you add an application ID here, add the private key in a file with the
	//same name as the application ID in  the same directory as this script.

	//Change this to your phone number
	$phone_number_to_call = "8618665710088";

	//And the phone number you are calling from
	//This does not have to be a real phone number, just in the correct format
	$virtual_number = "441632960961";
	//
  //$web_answer = "https://nexmo-community.github.io/ncco-examples/first_call_talk.json";
  $web_answer = "https://github.com/gzdemon/nexmo/blob/master/call_talk.json";
  $web_event = "https://example.com/event";

	if(empty($application_id)){
			$base_url = 'https://api.nexmo.com' ;
			$version = '/v1';
			$action = '';
			$action = '/applications/?';
			$url = $base_url . $version . $action . http_build_query([
					'api_key' =>  $nexmo_key,
					'api_secret' => $nexmo_secret,
					'name' => 'First Voice API Call',
					'type' => 'voice',
					'answer_url' => $web_answer,
					'event_url' => $web_event,
			]);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Length: 0" ));
			curl_setopt($ch, CURLOPT_HEADER, 1);
			$response = curl_exec($ch);

			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($response, 0, $header_size);
			$body = substr($response, $header_size);

			$application = json_decode($body, true);
			if (! isset ($application['type'])){
			echo("Application \"" . $application['name']
			. "\" has an ID of:" . $application['id'] . "<br><br>" ) ;
				$application_id = $application['id'];
			}
			echo ("Saving your private key to a local file.<br><br>");
			$private_key = preg_replace( "/RSA PRIVATE KEY/", "PRIVATE KEY", $application['keys']['private_key']);
			file_put_contents($application_id, $private_key );
	}

	$basic  = new \Nexmo\Client\Credentials\Basic($nexmo_key, $nexmo_secret);
	$keypair = new \Nexmo\Client\Credentials\Keypair(file_get_contents(__DIR__ . '/'.$application_id), $application_id);

	$client = new \Nexmo\Client(new \Nexmo\Client\Credentials\Container($basic, $keypair));

	$call = new Call();
	$call->setTo($phone_number_to_call)
	   ->setFrom($virtual_number)
	   ->setWebhook(Call::WEBHOOK_ANSWER, $web_answer)
	   ->setWebhook(Call::WEBHOOK_EVENT, $web_event);
	$message = $client->calls()->create($call);
  //echo "Sent message to " . $message['to'] . ". Balance is now " . $message['remaining-balance'] . PHP_EOL;
  var_dump($message);
?>
