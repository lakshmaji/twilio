<?php


// Download the library and copy into the folder containing this file.
require('Twilio.php');

/*$account_sid = "ACfe7caf15f8654f3fd7bff1fac3072522"; // Your Twilio account sid
$auth_token = "40c9bd7e51119633516609775d1a902b"; // Your Twilio auth token

*/

// (865) 240-2850===========================================================
// Your new Phone Number is +18652402850






$client = new Services_Twilio($account_sid, $auth_token); 
 
$message=$client->account->messages->create(array( 
    'To' => "+918179278096", 
    'From' => "+18652402850", 
    'Body' => "Hey Jenny! Good luck on the bar exam!", 
    'MediaUrl' => "http://farm2.static.flickr.com/1075/1404618563_3ed9a44a3a.jpg",  
));
/*$client = new Services_Twilio($account_sid, $auth_token);
$message = $client->account->messages->sendMessage(
  '+6143003772 ', // From a Twilio number in your account
  '+918179278096', // Text any number
  "Hello monkey!"
);

print $message->sid;

*/

print $message->sid;
?>