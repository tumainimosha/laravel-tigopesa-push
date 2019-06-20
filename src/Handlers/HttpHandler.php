<?php

namespace Tumainimosha\TigopesaPush\Handlers;

use GuzzleHttp\Client;

class HttpHandler
{
    public function post(string $url, array $request, array $headers = []): array
    {
        $options = [
            'json' => $request,
        ];

        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        $client = new Client();
        $responseObj = $client->post($url, $options);

        $content = $responseObj->getBody()->getContents();

        return json_decode($content, true);
    }
}
