<?php namespace Lakshmajim\Twilio\Facade;
 
use Illuminate\Support\Facades\Facade;
 
class Twilio extends Facade {
 
    protected static function getFacadeAccessor() { return 'twilio'; }
 
}