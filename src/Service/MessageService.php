<?php

namespace App\Service;

define("EMPTY_ACCESS_TO_BE_COMPLETED", "");

class MessageService
{

    private static function is_windows()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        } else {
            return false;
        }
    }

    public static function sendMessageByOrange(String $message, String $phone):bool
    {
        /**
         * Send SMS through the Orange Developer API
         */ 
        try {
            $script_path = dirname(getcwd()) . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR;
            $lang = "python ";
            if (!MessageService::is_windows()) {
                putenv('HOME=/home/marketo');
                $lang = "python3 ";
            }
            $sender = "repliable";
            $last = " --sender $sender";
            
            $command = escapeshellcmd($lang . $script_path . "bulksms.py --auth ". EMPTY_ACCESS_TO_BE_COMPLETED . " --message \"$message\" --phone $phone" . $last);
            exec($command);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
