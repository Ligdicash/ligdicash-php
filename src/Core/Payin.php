<?php

namespace Ligdicash\Core\Payin;

use Ligdicash\Core\Providers\APIConfig;
use Ligdicash\Core\Providers\HTTPProvider;
use Ligdicash\Core\Responses\BaseResponse;

class InvoiceItem
{
    private $name;
    private $description;
    private $quantity;
    private $unit_price;
    private $total_price;

    public function __construct($name, $description, $quantity, $unit_price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
        $this->total_price = $unit_price * $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    public function setQuantity($new_quantity)
    {
        $this->quantity = $new_quantity;
        $this->total_price = $this->unit_price * $new_quantity;
    }

    public function setUnitPrice($new_unit_price)
    {
        $this->unit_price = $new_unit_price;
        $this->total_price = $new_unit_price * $this->quantity;
    }

    public function toArray()
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "quantity" => $this->quantity,
            "unit_price" => $this->unit_price,
            "total_price" => $this->total_price,
        ];
    }
}

class Invoice
{
    /**
     * @var InvoiceItem[]
     */
    private array $items;
    private string $currency;
    private string $description;
    private string $customer_firstname;
    private string $customer_lastname;
    private string $customer_email;
    private string $store_name;
    private string $store_website_url;
    private string $external_id;
    private string $otp;
    private HTTPProvider $provider;
    private int $total_amount;

    public function __construct(
        APIConfig $configs,
        string $currency = 'xof',
        string $description = '',
        string $customer_firstname = '',
        string $customer_lastname = '',
        string $customer_email = '',
        string $store_name = '',
        string $store_website_url = ''
    ) {

        if (strtolower($currency) !== "xof") {
            throw new \InvalidArgumentException("Invalid currency. Only XOF is allowed.");
        }

        $this->items = [];
        $this->currency = $currency;
        $this->description = $description;
        $this->customer_firstname = $customer_firstname;
        $this->customer_lastname = $customer_lastname;
        $this->customer_email = $customer_email;
        $this->store_name = $store_name;
        $this->store_website_url = $store_website_url;
        $this->external_id = '';
        $this->otp = '';

        $this->provider = new HTTPProvider($configs);
    }

    public function toArray($customer = '')
    {
        $items = array_map(function ($item) {
            return $item->toArray();
        }, $this->items);

        return [
            "items" => $items,
            "total_amount" => $this->total_amount,
            "devise" => $this->currency,
            "description" => $this->description,
            "customer" => $customer,
            "customer_firstname" => $this->customer_firstname,
            "customer_lastname" => $this->customer_lastname,
            "customer_email" => $this->customer_email,
            "external_id" => $this->external_id,
            "otp" => $this->otp,
        ];
    }

    public function setItemsTotal()
    {
        $this->total_amount = array_reduce($this->items, function ($carry, $item) {
            return $carry + $item->toArray()['total_price'];
        }, 0);
    }

    public function addItem(array $params)
    {
        $name = $params['name'];
        $description = $params['description'];
        $quantity = $params['quantity'];
        $unit_price = $params['unit_price'];

        if (!isset($name) || !isset($description) || !isset($quantity) || !isset($unit_price)) {
            throw new \InvalidArgumentException("Name, description, quantity and unit_price are required.");
        }

        $new_item = new InvoiceItem($name, $description, $quantity, $unit_price);
        $this->items[] = $new_item;
        $this->setItemsTotal();
    }

    public function payWithRedirection(array $params): BaseResponse
    {
        $cancel_url = $params['cancel_url'] ?? '';
        $return_url = $params['return_url'] ?? '';
        $callback_url = $params['callback_url'] ?? '';
        $custom_data = $params['custom_data'] ?? [];

        if (gettype($custom_data) !== 'array') {
            throw new \InvalidArgumentException("Custom data must be an array.");
        }

        $payload = [
            "commande" => [
                "invoice" => $this->toArray(),
                "store" => [
                    "name" => $this->store_name,
                    "website_url" => $this->store_website_url,
                ],
                "actions" => [
                    "cancel_url" => $cancel_url,
                    "return_url" => $return_url,
                    "callback_url" => $callback_url,
                ],
                "custom_data" => $custom_data,
            ]
        ];

        $response = $this->provider->post('redirect/checkout-invoice/create', $payload, 'payin');
        return BaseResponse::fromArray($response);
    }

    public function payWithoutRedirection(array $params): ?BaseResponse
    {
        $otp = $params['otp'] ?? '';
        $customer = $params['customer'] ?? '';
        $callback_url = $params['callback_url'] ?? '';
        $custom_data = $params['custom_data'] ?? [];

        if (gettype($custom_data) !== 'array') {
            throw new \InvalidArgumentException("Custom data must be an array.");
        }

        if (!isset($customer)) {
            throw new \InvalidArgumentException("Customer is required.");
        }

        $this->otp = $otp;
        $payload = [
            "commande" => [
                "invoice" => $this->toArray($customer),
                "store" => [
                    "name" => $this->store_name,
                    "website_url" => $this->store_website_url,
                ],
                "actions" => [
                    "callback_url" => $callback_url,
                ],
                "custom_data" => $custom_data,
            ]
        ];

        $response = $this->provider->post('straight/checkout-invoice/create', $payload, 'payin');
        return BaseResponse::fromArray($response);
    }
}