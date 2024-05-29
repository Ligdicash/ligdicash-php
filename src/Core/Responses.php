<?php

namespace Ligdicash\Core\Responses;

class BaseResponse
{
    public $response_code;
    public $token;
    public $response_text;
    public $description;
    public $custom_data;
    public $wiki;

    public function __construct($response_code, $token, $response_text, $description, $wiki, $custom_data = [])
    {
        $this->response_code = $response_code;
        $this->token = $token;
        $this->response_text = $response_text;
        $this->description = $description;
        $this->wiki = $wiki;
        $this->custom_data = $custom_data;
    }

    public static function fromArray($data)
    {
        return new self(
            $data['response_code'],
            $data['token'],
            $data['response_text'],
            $data['description'],
            $data['wiki'],
            isset($data['custom_data']) ? $data['custom_data'] : []
        );
    }
}

class StatusResponse extends BaseResponse
{
    public $montant;
    public $amount;
    public $status;
    public $operator_id;
    public $operator_name;
    public $external_id;
    public $transaction_id;
    public $date;
    public $customer;
    public $request_id;

    public function __construct(
        $response_code,
        $token,
        $response_text,
        $description,
        $wiki,
        $custom_data,
        $montant,
        $amount,
        $status,
        $operator_id,
        $operator_name,
        $external_id,
        $transaction_id = null,
        $date = null,
        $customer = null,
        $request_id = null
    ) {
        parent::__construct($response_code, $token, $response_text, $description, $wiki, $custom_data);
        $this->montant = $montant;
        $this->amount = $amount;
        $this->status = $status;
        $this->operator_id = $operator_id;
        $this->operator_name = $operator_name;
        $this->external_id = $external_id;
        $this->transaction_id = $transaction_id;
        $this->date = $date;
        $this->customer = $customer;
        $this->request_id = $request_id;
    }

    public static function fromArray($data)
    {
        return new self(
            $data['response_code'],
            $data['token'],
            $data['response_text'],
            $data['description'],
            $data['wiki'],
            isset($data['custom_data']) ? $data['custom_data'] : [],
            $data['montant'],
            $data['amount'],
            $data['status'],
            $data['operator_id'],
            $data['operator_name'],
            $data['external_id'],
            isset($data['transaction_id']) ? $data['transaction_id'] : null,
            isset($data['date']) ? $data['date'] : null,
            isset($data['customer']) ? $data['customer'] : null,
            isset($data['request_id']) ? $data['request_id'] : null
        );
    }
}