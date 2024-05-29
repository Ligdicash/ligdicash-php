<?php

namespace Ligdicash;

class Ligdicash
{
    private $configs;

    public function __construct(array $params)
    {
        $apiKey = $params["api_key"];
        $authToken = $params["auth_token"];
        $platform = $params["platform"] ?? "test";

        if (!isset($apiKey) || !isset($authToken)) {
            throw new \InvalidArgumentException("API key and auth token are required.");
        }

        if (!in_array($platform, ["test", "live"])) {
            throw new \InvalidArgumentException("Invalid platform. Allowed values are 'test' or 'live'.");
        }

        $configs = new \Ligdicash\Core\Providers\APIConfig(
            $apiKey,
            $authToken,
            $platform,
            null
        );
        $this->configs = $configs;
    }

    public function Withdrawal(array $params): \Ligdicash\Core\Payout\Withdrawal
    {
        $amount = $params["amount"];
        $description = $params["description"] ?? "";
        $customer = $params["customer"] ?? "";

        if (!isset($amount) || !isset($description) || !isset($customer)) {
            throw new \InvalidArgumentException("Amount, description and customer are required.");
        }

        return new \Ligdicash\Core\Payout\Withdrawal(
            $this->configs,
            $amount,
            $description,
            $customer
        );
    }

    public function Invoice(
        array $params
    ): \Ligdicash\Core\Payin\Invoice {
        $currency = $params["currency"];
        $description = $params["description"] ?? "";
        $customer_firstname = $params["customer_firstname"] ?? "";
        $customer_lastname = $params["customer_lastname"] ?? "";
        $customer_email = $params["customer_email"] ?? "";
        $store_name = $params["store_name"] ?? "";
        $store_website_url = $params["store_website_url"] ?? "";

        if (strtolower($currency) !== "xof") {
            throw new \InvalidArgumentException("Invalid currency. Only XOF is allowed.");
        }

        return new \Ligdicash\Core\Payin\Invoice(
            $this->configs,
            $currency,
            $description,
            $customer_firstname,
            $customer_lastname,
            $customer_email,
            $store_name,
            $store_website_url
        );
    }

    public function getTransaction(
        array $params
    ): \Ligdicash\Core\Responses\StatusResponse {
        $token = $params["token"];
        $type = $params["type"] ?? "payin";

        if (!isset($token)) {
            throw new \InvalidArgumentException("Token is required.");
        }

        if (!in_array($type, ["payin", "payout"])) {
            throw new \InvalidArgumentException("Invalid type. Allowed values are 'payin' or 'payout'.");
        }

        return \Ligdicash\Core\Transaction\get_transaction(
            $this->configs,
            $token,
            $type
        );
    }
}