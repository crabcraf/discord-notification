<?php
$obj_DiscordBot = new DiscordBot();
$obj_DiscordBotMSG = new Discord_Generate_Message();
$error_message = $obj_DiscordBotMSG->my_message();
list($flg_SendMsg, $flg_result) = $obj_DiscordBot->send_message($error_message);

class DiscordBot
{
    private $botToken = 'your key';
    private $api_url = "https://discordapp.com/api/webhooks/";
    private $curl_timeout = '60';

    function send_message($message)
    {
        try {
            $current_filename = 'filename=' . basename($_SERVER["SCRIPT_FILENAME"]);
            $message = $message ."\n\n". ":page_facing_up: " . $current_filename;
            $params = [
                "content" => $message,
                "username" => "notif tori"
            ];
            $ch = curl_init($this->api_url . $this->botToken);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip");
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // logs
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('curl_debug_file.txt', 'a');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
            // result
            $output = curl_exec($ch);
            $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($response == '200') {
                return array(true, '');
            } else {
                return array(false, 'response code:' . $response);
            }
        } catch (Exception $e) {
            return array(false, 'discord catch: '.$e->getMessage());
        }
    }
}

class Discord_Generate_Message
{
    public function my_message(){
        $message=":no_entry: ".'hello';
        return $message;
    }
}
