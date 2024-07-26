<?php

namespace Ligdicash\Core\Payout;

use InvalidArgumentException;
use Ligdicash\Core\Providers\APIConfig;
use Ligdicash\Core\Providers\HTTPProvider;
use Ligdicash\Core\Responses\BaseResponse;

class Withdrawal
{
    private int $amount;
    private string $description;
    private string $customer;
    private HTTPProvider $provider;

    public function __construct(APIConfig $configs, int $amount = 100, string $description = "", string $customer = "")
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->customer = $customer;
        $this->provider = new HTTPProvider($configs);
    }

    public function send(array $params): BaseResponse
    {
        $custom_data = $params["custom_data"] ?? [];
        $callback_url = $params["callback_url"] ?? "";
        $to_wallet = $params["to_wallet"] ?? true;
        $type = $params["type"] ?? "client";

        if (gettype($custom_data) !== 'array') {
            throw new \InvalidArgumentException("Custom data must be an array.");
        }

        if (!in_array($type, ["client", "merchant"])) {
            throw new InvalidArgumentException("Invalid type. Allowed values are 'client' or 'merchant'.");
        }

        if ($type === "client" && !isset($to_wallet)) {
            throw new InvalidArgumentException("to_wallet is required for client payout.");
        }

        $command = [
            "amount" => $this->amount,
            "description" => $this->description,
            "customer" => $this->customer,
            "custom_data" => $custom_data,
            "callback_url" => $callback_url,
        ];

        if ($type === "client") {
            $command["top_up_wallet"] = $to_wallet ? 1 : 0;
        }

        $payload = ["commande" => $command];
        $response = $this->provider->post($type === "client" ? "withdrawal/create" : "straight/payout", $payload, $type === "client" ? "client_payout" : "merchant_payout");
        return BaseResponse::fromArray($response);
    }
}