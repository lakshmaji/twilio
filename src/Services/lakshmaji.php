<?php


require('Twilio.php');

$account_sid = 'AC5f0d5a51944ddbf821ea00c2bfd8a04e'; 
$auth_token = 'a0fb1706748dc12ccbb9501b5b904a74'; 


$client = new Services_Twilio($account_sid, $auth_token); 
 
$message=$client->account->messages->create(array( 
    'To' => "+918179278096", 
    'From' => "+44 7481 338931", 
    'Body' => "Hey testing messages", 
));


print $message->sid;
?>