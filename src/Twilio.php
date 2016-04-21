<?php namespace Lakshmajim\Twilio;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
require('Services/Twilio.php');


/**
 * Twilio - A Twilio package for sending SMS 
 *
 * @package  Twilio
 * @version  1.0.2
 * @author   lakshmaji 
 */

/*
|--------------------------------------------------------------------------
| Twilio package class for implementing sms message features with laravel 
|--------------------------------------------------------------------------
|
*/


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
    /** 
     * destination mobile number
     * @var
     */
    private $dest;
    /** 
     * text message
     * @var
     */
    private $txt;
    /** 
     * return back url
     * @var
     */
    private $returnBackUrl;

    /**
     * set sender mobile number.
     *
     * @access public
     * @param  
     * @return Response
     * @since  1.0.2
     * @author lakshmajim 
     */
    public function setSourceMobile($src)
    {
        $this->src = $src;
    }

    //-------------------------------------------------------------------------


    /**
     * set receiver mobile number.
     *
     * @access public
     * @param  
     * @return Response
     * @since  1.0.2
     * @author lakshmajim 
     */
    public function setDestinationMobile($dest)
    {
        $this->dest = $dest;
    }

    //-------------------------------------------------------------------------


    /**
     * set message that tob sent to destination mobile number.
     *
     * @access public
     * @param  
     * @return Response
     * @since  1.0.2
     * @author lakshmajim 
     */
    public function setMessageTwilio($txt)
    {
        $this->txt = $txt;
    }

    //-------------------------------------------------------------------------


    /**
     * send message using Plivio and Rest api calls.
     * provide authentication id and authentication token of admin
     *
     * @access public
     * @param  
     * @return Response
     * @since  1.0.2
     * @author lakshmajim 
    */
    public function sendMessageTwilio($auth_id,$auth_token)
    {
        $this->auth_id    = $auth_id;
        $this->auth_token = $auth_token;
        return $this->sendMessage($this->auth_id,$this->auth_token);
    }

    //-------------------------------------------------------------------------


    /**
     * send sms and return the status .
     *
     * @access private
     * @param  
     * @return Response
     * @since  1.0.2
     * @author lakshmajim 
     */
    private function sendMessage($auth_id,$auth_token)
    {
        // Set message parameters
        $params = array(
                        'From' => $this->src, 
                        'To'   => $this->dest, 
                        'Body' => $this->txt
                    );

        $client  = new \Services_Twilio($this->auth_id, $this->auth_token); 
        try{
            $message = $client->account->messages->create($params);
            return $message->status;
        }
        catch(Exception $smsException)
        {
            return false;
        }                 
    }

    //-------------------------------------------------------------------------


    /**
     * send Message to specified mobile number with a constant sender number.
     *
     * @access public
     * @param  
     * @return Response
     * @since  1.0.2
     * @author lakshmajim 
     */
    public function sendSMS($userData,$optionalMessage = "You got a message form Ananth ",$sms_type = "SMS") 
    {
        // place twilio credentials here
        $source_mobile = env('TWILIO_SOURCE_NUMBER');
        $auth_id       = env('TWILIO_AUTH_ID');
        $auth_secret   = env('TWILIO_AUTH_SECRET');
        
        // check sms type
        if($sms_type == "OTP")
        {
            $msgTxt = $optionalMessage." ".$userData['otp'];
        }
        else
        {
            // sms contains textual information (not OTP)
            $msgTxt = $optionalMessage;
        }

        $num_string = $userData['mobile_number'];

        // check whether PLUS sign is appended or not
        if (strpos($num_string, '+') !== false) 
        {
            //PLUS SIGN FOUND
            $destination_mobile = $num_string;

        }
        else
        {
            $destination_mobile = "+".$num_string;
        }
        
        Twilio::setSourceMobile($source_mobile);
        Twilio::setDestinationMobile($destination_mobile);
        Twilio::setMessageTwilio($msgTxt);
        // authorize and send sms 
        $smsObject = Twilio::sendMessageTwilio($auth_id,$auth_secret); 

        return $smsObject;
    }

    //-------------------------------------------------------------------------
}
//end of Twilio class
// end of file Twilio.php