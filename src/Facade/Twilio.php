<?php 

namespace Lakshmaji\Twilio\Facade;
 
use Illuminate\Support\Facades\Facade;
 
/**
 * Twilio - Facade to support integration with Laravel framework 
 *
 * @package  Twilio
 * @version  1.2.2
 * @author   lakshmaji 
 */ 
class Twilio extends Facade {
 
    protected static function getFacadeAccessor() { return 'twilio'; }
 
}
// end of class Twilio
// end of file Twilio.php