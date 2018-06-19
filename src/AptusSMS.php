<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 3/13/18
 * Time: 12:09 AM
 */

namespace CraftedSystems\Aptus;

use Unirest\Request;

class AptusSMS
{
    /**
     * Base URL.
     *
     * @var string
     */
    const BASE_URL = 'https://www.sms.co.tz/api.php';

    /**
     * settings .
     *
     * @var array.
     */
    protected $settings;

    /**
     * MicroMobileSMS constructor.
     * @param $settings
     * @throws \Exception
     */
    public function __construct($settings)
    {
        $this->settings = (object)$settings;

        if (
            empty($this->settings->username) ||
            empty($this->settings->password) ||
            empty($this->settings->senderid)
        ) {
            throw new \Exception('Please ensure that all APtus SMS configuration variables have been set.');
        }
    }

    /**
     * @param $recipient
     * @param $message
     * @return mixed
     * @throws \Exception
     */
    public function send($recipient, $message)
    {
        if (!is_string($message)) {

            throw new \Exception('The Message Should be a string');
        }

        if (!is_string($recipient)) {
            throw new \Exception('The Phone number should be a string');
        }


        $url_request = 'https://www.sms.co.tz/api.php?do=sms&username=' . $this->settings->username . '&password=' . $this->settings->password . '&senderid=' . $this->settings->senderid . '&dest=' . $recipient . '
        &msg=' . $message;

        $response = Request::get($url_request);

        return $response->body;

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getDeliveryReports(\Illuminate\Http\Request $request)
    {
        return json_decode($request->getContent());
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        $req = 'https://www.sms.co.tz/api.php?do=balance&username=' . $this->settings->username . '&password=' . $this->settings->password;

        $response = Request::get($req);

        $d = explode(",", $response->body);

        if ($d[0] == 'OK') {

            return $d[1];

        } else {

            return 0;
        }

    }

}