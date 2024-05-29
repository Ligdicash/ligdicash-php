<?php

namespace Ligdicash\Core\Providers;

use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

use function Ligdicash\Core\Defaults\get_platform_url;
use function Ligdicash\Core\Wiki\get_wiki_error;

class APIConfig
{
    public static string $api_key;
    public static string $auth_token;
    public static string $base_url;
    public static string $platform;

    public function __construct(string $api_key, string $auth_token, string $platform, ?string $base_url)
    {
        self::$api_key = $api_key;
        self::$auth_token = $auth_token;
        self::$base_url = $base_url ?? get_platform_url($platform);
        self::$platform = $platform;
    }
}

class HTTPProvider
{
    private string $api_key;
    private string $auth_token;
    private string $base_url;
    private string $platform;
    private Client $client;

    public function __construct(APIConfig $config)
    {
        $this->api_key = $config::$api_key;
        $this->auth_token = $config::$auth_token;
        $this->platform = $config::$platform;
        $this->base_url = $config::$base_url;

        $this->client = new Client([
            'base_uri' => $this->base_url,
            'headers' => [
                'Apikey' => $this->api_key,
                'Authorization' => "Bearer {$this->auth_token}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    private function buildUrl(string $url)
    {
        return $this->base_url . $url;
    }

    private function getDataOrRaiseError(ResponseInterface $response, string $feature): array
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode >= 400) {
            throw new Exception("An error occurred while trying to access the API. Please try again later.");
        } else {
            $responseData = json_decode($response->getBody(), true);
            $resCode = $responseData['response_code'];
            $resText = $responseData['response_text'];

            if ($resCode === '00') {
                return $responseData;
            } else {
                preg_match('/\d{2,3}[a-z]?/', $resText, $matches);
                $errorCode = $matches[0] ?? null;
                $error = get_wiki_error($feature, $this->platform, $errorCode);
                throw new $error($errorCode);
            }
        }
    }

    public function post(string $url, array $payload, string $feature): array
    {
        $response = $this->client->post($this->buildUrl($url), [
            'json' => $payload
        ]);
        return $this->getDataOrRaiseError($response, $feature);
    }

    public function get(string $url, string $feature): array
    {
        $response = $this->client->get($this->buildUrl($url));
        return $this->getDataOrRaiseError($response, $feature);
    }
}