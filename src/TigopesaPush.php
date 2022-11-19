<?php

namespace Tumainimosha\TigopesaPush;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Tumainimosha\TigopesaPush\Exceptions\Exception;
use Tumainimosha\TigopesaPush\Handlers\HttpHandler;
use Tumainimosha\TigopesaPush\Models\TigopesaPushTransaction as Transaction;

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
     * @return TigopesaPush
     */
    public static function instance()
    {
        $instance = new static;

        $instance->setUsername(config('tigopesa-push.username'))
            ->setPassword(config('tigopesa-push.password'))
            ->setBillerMsisdn(config('tigopesa-push.biller_msisdn'))
            ->setTokenUrl(config('tigopesa-push.token_url'))
            ->setBillPayUrl(config('tigopesa-push.bill_pay_url'));

        return $instance;
    }

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

        $customerMsisdn = $this->normalizeMsisdn($customerMsisdn);

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

        $response = (new HttpHandler)->post($this->billPayUrl, $request, $headers, true);

        if (!isset($response['ResponseStatus']) || $response['ResponseStatus'] !== true) {
            throw Exception::billerPayError($response);
        }

        // save transaction to db
        $transaction = Transaction::query()
            ->create([
                'reference' => $txnId,
                'customer_msisdn' => $customerMsisdn,
                'biller_msisdn' => $this->billerMsisdn,
                'amount' => $amount,
            ]);

        return $response;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getToken()
    {
        $objToken = [
            'access_token' => '',
            'expires_in' => '',
            'expires_at' => '',
        ];

        $cacheKey = 'tigopesa-push-token';
        $strTokenContent = Cache::get($cacheKey, null);
        if($strTokenContent) {
            $objToken = json_decode($strTokenContent, true);
        }

        if(Arr::get($objToken, 'expires_at')) {
            $expiresAt = DateTime::createFromFormat(DateTime::ISO8601, $objToken['expires_at']);
            $now = new DateTime();
            if($expiresAt > $now->modify('+30 seconds')) {
                return $objToken;
            }
        }

        $request = [
            'username' => $this->username,
            'password' => $this->password,
            'grant_type' => 'password',
        ];

        $response = (new HttpHandler)->post($this->tokenUrl, $request);

        if (isset($response['access_token'])) {
            $expiresAt = (new DateTime())->modify('+' + $response['expires_in'] + ' seconds');
            
            $objToken = [
                'access_token' => $response['access_token'],
                'expires_in' => $response['access_token'],
                'expires_at' => $expiresAt->format(DateTime::ISO8601),
            ];

            $strTokenContent = json_encode($objToken);

            Cache::put($cacheKey, $strTokenContent, $expiresAt);

            return $objToken;
        }

        throw Exception::authenticationError($response);
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

    /**
     * Ensures customerMsisdn always start with country code 255.
     *
     * @param string $customerMsisdn
     * @return string
     */
    protected function normalizeMsisdn(string $customerMsisdn)
    {
        $str = $customerMsisdn;

        // if number starts with '0' replace with '+255'
        if (Str::startsWith($str, '0')) {
            $str = Str::replaceFirst('0', '255', $str);
        }

        // if number starts with '255' replace with '+255'
        if (Str::startsWith($str, '+255')) {
            $str = Str::replaceFirst('+255', '255', $str);
        }

        return $str;
    }
}
