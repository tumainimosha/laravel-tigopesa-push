<?php

namespace Tumainimosha\TigopesaPush\Handlers;

use GuzzleHttp\Client;

class HttpHandler
{
    /**
     * @param string $url
     * @param array $request
     * @param array $headers
     * @param bool $json Send request as json instead of form-url-encoded
     * @return array
     */
    public function post(string $url, array $request, array $headers = [], bool $json = false): array
    {
        $options = [];

        if ($json) {
            $options['json'] = $request;
        } else {
            $options['form_params'] = $request;
        }

        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        $client = new Client();
        $responseObj = $client->post($url, $options);

        $content = $responseObj->getBody()->getContents();

        return json_decode($content, true);
    }
}
