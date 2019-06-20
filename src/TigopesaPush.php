<?php

namespace Tumainimosha\TigopesaPush;

use Tumainimosha\TigopesaPush\Exceptions\Exception;
use Tumainimosha\TigopesaPush\Handlers\HttpHandler;

class TigopesaPush
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $billerMsisdn;

    /**
     * @var string
     */
    protected $tokenUrl;

    /**
     * @var string
     */
    protected $billPayUrl;

    /**
     * @param string $customerMsisdn
     * @param int $amount
     * @param string $txnId
     * @param string $remarks
     *
     * @return array
     *
     * @throws Exception
     */
    public function postRequest(string $customerMsisdn, int $amount, string $txnId, $remarks = '')
    {
        $token = $this->getToken();

        $headers = [
            'Authorization' => 'Bearer ' . $token['access_token'],
            'Username' => $this->username,
            'Password' => $this->password,
        ];

        $request = [
            'BillerMSISDN' => $this->billerMsisdn,
            'CustomerMSISDN' => $customerMsisdn,
            'Amount' => $amount,
            'ReferenceID' => $txnId,
            'Remarks' => $remarks,
        ];

        $response = (new HttpHandler)->post($this->billPayUrl, $request, $headers);

        if (!isset($response['ResponseStatus']) || $response['ResponseStatus'] !== true) {
            throw Exception::billerPayError($response);
        }

        return $response;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getToken()
    {
        $request = [
            'username' => $this->username,
            'password' => $this->password,
            'grant_type' => 'password',
        ];

        $response = (new HttpHandler)->post($this->tokenUrl, $request);

        if (isset($response['access_token'])) {
            return $response;
        }

        throw Exception::authenticationError($response);
    }

    protected function pay()
    {
        $response = (new HttpHandler)->pay();
    }

    /**
     * @param string $username
     * @return TigopesaPush
     */
    public function setUsername(string $username): TigopesaPush
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $password
     * @return TigopesaPush
     */
    public function setPassword(string $password): TigopesaPush
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $billerMsisdn
     * @return TigopesaPush
     */
    public function setBillerMsisdn(string $billerMsisdn): TigopesaPush
    {
        $this->billerMsisdn = $billerMsisdn;

        return $this;
    }

    /**
     * @param string $tokenUrl
     * @return TigopesaPush
     */
    public function setTokenUrl(string $tokenUrl): TigopesaPush
    {
        $this->tokenUrl = $tokenUrl;

        return $this;
    }

    /**
     * @param string $billPayUrl
     * @return TigopesaPush
     */
    public function setBillPayUrl(string $billPayUrl): TigopesaPush
    {
        $this->billPayUrl = $billPayUrl;

        return $this;
    }
}
