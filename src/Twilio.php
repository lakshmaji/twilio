<?php namespace Lakshmajim\Twilio;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

require('Services/Twilio.php');


class Twilio 
{




	/**
     * @var 
     */
    private $auth_sid;
    /**
     * @var 
     */
    private $auth_token;
    /** source mobile number
     * @var
     */
    private $src;
    /** destination mobile number
     * @var
     */
    private $dest;
    /** text message
     * @var
     */
    private $txt;
    /** return back url
     * @var
     */
    private $returnBackUrl;

    /**
    * set sender mobile number.
    *
    * @param  $src
    * @return 
    */
    public function setSourceMobile($src)
    {
        $this->src = $src;
    }




    /**
    * set receiver mobile number.
    *
    * @param  $dest
    * @return 
    */
    public function setDestinationMobile($dest)
    {
        $this->dest = $dest;
    }




    /**
    * set message that tob sent to destination mobile number.
    *
    * @param  $txt
    * @return 
    */
    public function setMessageTwilio($txt)
    {
        $this->txt = $txt;
    }



    /**
    * send message using Plivio and Rest api calls.
    * provide authentication id and authentication token of admin
    * @param  $auth_id, $auth_token
    * @return 
    */
    public function sendMessageTwilio($auth_id,$auth_token)
    {
        $this->auth_id=$auth_id;
        $this->auth_token=$auth_token;
        return $this->sendMessage($this->auth_id,$this->auth_token);
    }




    /**
    * send sms and return the status .
    *
    * @param  $auth_id, $auth_token 
    * @return response status
    */
    private function sendMessage($auth_id,$auth_token)
    {
        // Set message parameters
        $params = array(
			            'From' => $this->src, 
			            'To' => $this->dest, 
			            'Body' => $this->txt
                    );

        $client = new \Services_Twilio($this->auth_id, $this->auth_token); 

        $message = $client->account->messages->create($params);

	    echo $message->status;
        
    }

    //
    public function testSample()
    {
    	echo "this twilio development";
    }

}