<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sms_smsportal extends App_sms {

    private $secret_key;
    private $client_id;
    private $requestURL = 'https://rest.smsportal.com/v1';

    public function __construct() {
        parent::__construct();
        
        $this->client_id = $this->get_option('SMSPortal', 'client_id');
        $this->secret_key = $this->get_option('SMSPortal', 'secret_key');

        $this->add_gateway('smsportal', [
            'info' => "<p>SMSPortal SMS integration is one way messaging, means that your customers won't be able to reply to the SMS.</p><hr class='hr-10'>",
            'name' => 'SMSPortal',
            'options' => [
                [
                    'name' => 'client_id',
                    'label' => 'Client Id',
                ],
                [
                    'name' => 'secret_key',
                    'label' => 'Secret Key',
                ],
            ],
        ]);
       
    }

    public function get_token() {
        $url = $this->requestURL . '/Authentication';
        $auth = base64_encode($this->client_id . ":" . $this->secret_key);
        try {
            $response = $this->client->request('GET', $url, [
                'body' => json_encode([
                ]),
                'headers' => [
                    'Authorization' => 'Basic ' . $auth,
                ],
                'version' => CURL_HTTP_VERSION_1_1,
                'decode_content' => [CURLOPT_ENCODING => ''],
            ]);

            $result = json_decode($response->getBody());
            if (isset($result->token)) {
                $data_result['status'] = '1';
                $data_result['token'] = $result->token;
                return json_encode($data_result);
            }
            //$this->set_error($result->message);
            $data_result['status'] = '0';
            $data_result['msg'] = $result['errors'][0]['errorMessage'];
            return json_encode($data_result);
        } catch (\Exception $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            $data_result['status'] = '0';
            $data_result['msg'] = $response['errors'][0]['errorMessage'];
            return json_encode($data_result);
        }

        return false;
    }

    public function check_balance() {


        //get access token api
        $token = $this->get_token();
        $url = $this->requestURL . '/Balance';
        $token = json_decode($token);
        if ($token->status == 1) {
            $access_token = $token->token;
            try {
                $response = $this->client->request('GET', $url, [
                    'body' => json_encode([
                    ]),
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                    ],
                    'version' => CURL_HTTP_VERSION_1_1,
                    'decode_content' => [CURLOPT_ENCODING => ''],
                ]);

                $result = json_decode($response->getBody());
                if (isset($result->token)) {
                    $data_result['status'] = '1';
                    $data_result['balance'] = $result->balance;
                    return json_encode($data_result);
                }
                //$this->set_error($result->message);
                $data_result['status'] = '0';
                $data_result['msg'] = $result['errors'][0]['errorMessage'];
                return json_encode($data_result);
            } catch (\Exception $e) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);
                $data_result['status'] = '0';
                $data_result['msg'] = $response['errors'][0]['errorMessage'];
                return json_encode($data_result);
            }
        }

        return false;
    }

    public function send($number, $message) {
        
        $token = $this->get_token();
        
        $token = json_decode($token);
        $url = $this->requestURL.'/bulkmessages';
        if ($token->status == 1) {
            $access_token = $token->token;
            try {
                $response = $this->client->request('POST', $url, [
                    'body' => json_encode([
                        'Messages' => [
                            ['Content' => urlencode($message), 'Destination' => $number],
                        ],
                    ]),
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                    ],
                    'version' => CURL_HTTP_VERSION_1_1,
                    'decode_content' => [CURLOPT_ENCODING => ''],
                ]);

                $result = json_decode($response->getBody());
                if (isset($result->type) && $result->type == 'success') {
                    log_activity('SMS sent via SMSPortal to ' . $number . ', Message: ' . $message);

                    return true;
                }
                $this->set_error($result->message);
            } catch (\Exception $e) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);
                $this->set_error($response['message']);
            }
        }
        return false;
    }

}
