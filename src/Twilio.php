<?php 

namespace Lakshmaji\Twilio;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Services_Twilio;
use Lakshmaji\Twilio\Exception\TwilioException;
use Services_Twilio_RestException;


/**
 * Twilio - A Twilio package for sending SMS 
 *
 * @package  Twilio
 * @version  1.2.2
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
     * Create Twilio Message array and send send request to http://api.twilio.com/
     *
     * Create a new message with the specified parameters. 
     * Authenticates againest the twilio api to send sms .
     *
     *  
     * @access public
     * @param  message_array     array    This contains sender_id, sender_secret, receiver_mobile, otp, media_url 
     *                                    and sender details. Here the sender_id and sender_secret and sender val
     *                                    -ues are fetcehed from ".env" file.
     *                                     
     * @param  optional_message  string   This contains the messsage text i.e, SMSImage resource destination path
     * @param  sms               boolean  If this value set to true message type will be considered as SMS  
     * @param  otp               boolean  If this value set to true message type will be considered as SMS
     * @param  media             boolean  If this value set to true message type will be considered as SMS  
     *
     * @return mixed
     *
     * @since   Method available since Release 1.0.0
     * @version 1.2.2
     * @author  lakshmajim 
     */
    public function message($message_array, $optional_message = "You got a message form Ananth ", $sms = false , $otp = false, $media = false)
    {
        $message_twilio  = array();
        $auth_id         = env($message_array['sender_id']);
        $auth_secret     = env($message_array['sender_secret']);
        $receiver_mobile = $message_array['reciver_mobile'];
        
        try
        {       
            if ($sms && $otp)
            {
                $message_twilio['Body'] = $optional_message." ".$message_array['otp'];
            }
            elseif ($otp && $media) 
            {
                $message_twilio['Body']     = $optional_message." ".$message_array['otp'];
                $message_twilio['MediaUrl'] = $message_array['media_url'];
            }
            elseif ($sms && $media)
            {
                $message_twilio['Body']     = $optional_message;
                $message_twilio['MediaUrl'] = $message_array['media_url'];
            }
            elseif ($sms) 
            {
                $message_twilio['Body'] = $optional_message;
            }
            elseif ($otp) 
            {
                $message_twilio['Body'] = $optional_message." ".$message_array['otp'];
            }
            elseif ($media) 
            {
                $message_twilio['MediaUrl'] = $message_array['media_url'];
            }
            // sms types
            elseif (!$sms && !$otp && !$media)
            {
                // throw exception that none of follwing are defined 
                throw new TwilioException('Not all types are set to false in this package', 16000);            
            }
            elseif ($sms && $otp && $media)
            {
                // throw exception that none of follwing are defined 
                throw new TwilioException('Not all types are set to true in this package', 16001);                
            }

        }
        catch(Exception $e)
        {
            // throw sms types not defined Exception (either sms ,otp ,or media)
            throw new TwilioException('None of sms types are availbe in this package', 16002);                
        }

        $message_twilio['From'] = env($message_array['sender']);

        // check whether PLUS sign is appended or not
        if (strpos($receiver_mobile, '+') !== false) 
        {
            //plus sign found
            $message_twilio['To'] = $receiver_mobile;
        }
        else 
        {
            $message_twilio['To'] = "+".$receiver_mobile;
        }

        $client  = new \Services_Twilio($auth_id, $auth_secret); 
        try
        {

            $message        = $client->account->messages->create($message_twilio);
            $message_status = $message->status;

            $message_possibilities = array('queued', 'sending', 'sent', 'queued', 'accepted', 'delivered');

            if(in_array($message_status, $message_possibilities))
            {
                return true;
            }
            else
            {
                throw new TwilioException('Error while sending message due to package',16003);            
            }
        }
        catch(Services_Twilio_RestException $te)
        {
            throw new TwilioException($te->getMessage(), $te->getCode());            
        }
    }

    //-------------------------------------------------------------------------
}
//end of Twilio class
// end of file Twilio.php