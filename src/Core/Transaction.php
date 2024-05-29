<?php

namespace Ligdicash\Core\Transaction;

use Ligdicash\Core\Errors\InvalidTokenError;
use Ligdicash\Core\Providers\APIConfig;
use Ligdicash\Core\Providers\HTTPProvider;
use Ligdicash\Core\Responses\StatusResponse;

function get_transaction(
    APIConfig $configs,
    $token = null,
    $type = "payin"
): StatusResponse {
    // Si le token n'est pas fourni ou est vide, on lance une exception
    if (empty($token)) {
        throw new InvalidTokenError();
    }

    // Création d'une instance de HTTPProvider
    $provider = new HTTPProvider($configs);

    // Construction de l'URL en fonction du type de transaction
    $url = ($type == "payin") ? "redirect/checkout-invoice/confirm/?invoiceToken=$token" : "withdrawal/confirm/?withdrawalToken=$token";

    // Envoi de la requête GET à l'API
    $response = $provider->get($url, "status");

    // Conversion de la réponse en objet StatusResponse
    $response_data = StatusResponse::fromArray($response);

    return $response_data;
}