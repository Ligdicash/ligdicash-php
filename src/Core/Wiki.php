<?php

// Définition des erreurs possibles pour le Payout en test ou en live
namespace Ligdicash\Core\Wiki;

const PAYOUT_CLIENT_WIKI = [
    'test' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\MerchantPayoutDisabledError::class,
        '02' => \Ligdicash\Core\Errors\CustomerDoesNotExistError::class,
        '03' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '03a' => \Ligdicash\Core\Errors\NoPendProcPayout24HError::class,
        '03b' => \Ligdicash\Core\Errors\NoDeposit3MError::class,
        '04' => \Ligdicash\Core\Errors\MerchantBalanceLowError::class,
        '05' => \Ligdicash\Core\Errors\AmountOutOfRangeError::class,
        '06' => \Ligdicash\Core\Errors\IpDeniedError::class,
        '07' => \Ligdicash\Core\Errors\TransactionAlreadyExistError::class,
        '08' => \Ligdicash\Core\Errors\ProcessingError::class,
        '09' => \Ligdicash\Core\Errors\DataInputError::class,
        '10' => \Ligdicash\Core\Errors\ApiError::class,
        '13' => \Ligdicash\Core\Errors\NoHashError::class,
        '14' => \Ligdicash\Core\Errors\InvalidHashError::class,
    ],
    'live' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\MerchantPayoutDisabledError::class,
        '02' => \Ligdicash\Core\Errors\CustomerDoesNotExistError::class,
        '03' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '03a' => \Ligdicash\Core\Errors\NoPendProcPayout24HError::class,
        '03b' => \Ligdicash\Core\Errors\NoDeposit3MError::class,
        '04' => \Ligdicash\Core\Errors\MerchantBalanceLowError::class,
        '05' => \Ligdicash\Core\Errors\AmountOutOfRangeError::class,
        '06' => \Ligdicash\Core\Errors\IpDeniedError::class,
        '07' => \Ligdicash\Core\Errors\TransactionAlreadyExistError::class,
        '08' => \Ligdicash\Core\Errors\ProcessingError::class,
        '09' => \Ligdicash\Core\Errors\DataInputError::class,
        '10' => \Ligdicash\Core\Errors\ApiError::class,
        '13' => \Ligdicash\Core\Errors\NoHashError::class,
        '14' => \Ligdicash\Core\Errors\InvalidHashError::class,
    ],
];

// Définition des erreurs possibles pour le Payout marchand en test ou en live
const PAYOUT_MARCHAND_WIKI = [
    'test' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\ApplicationAuthenticationError::class,
        '02' => \Ligdicash\Core\Errors\AmountOutOfRangeError::class,
        '03' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '04' => \Ligdicash\Core\Errors\NoPendProcPayout24HError::class,
        '05' => \Ligdicash\Core\Errors\RecipientOperatorNotIdentifiedError::class,
        '06' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '07' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '08' => \Ligdicash\Core\Errors\MerchantBalanceLowError::class,
        '09' => \Ligdicash\Core\Errors\ProcessingError::class,
        '10' => \Ligdicash\Core\Errors\ApiError::class,
        '11' => \Ligdicash\Core\Errors\NoHashError::class,
        '12' => \Ligdicash\Core\Errors\InvalidHashError::class,
        '13' => \Ligdicash\Core\Errors\UnauthorizedCurrencyConversionError::class,
        '14' => \Ligdicash\Core\Errors\IpDeniedError::class,
    ],
    'live' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\ApplicationAuthenticationError::class,
        '02' => \Ligdicash\Core\Errors\AmountOutOfRangeError::class,
        '03' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '04' => \Ligdicash\Core\Errors\NoPendProcPayout24HError::class,
        '05' => \Ligdicash\Core\Errors\RecipientOperatorNotIdentifiedError::class,
        '06' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '07' => \Ligdicash\Core\Errors\MerchantAccountDoesNotExistError::class,
        '08' => \Ligdicash\Core\Errors\MerchantBalanceLowError::class,
        '09' => \Ligdicash\Core\Errors\ProcessingError::class,
        '10' => \Ligdicash\Core\Errors\ApiError::class,
        '11' => \Ligdicash\Core\Errors\NoHashError::class,
        '12' => \Ligdicash\Core\Errors\InvalidHashError::class,
        '13' => \Ligdicash\Core\Errors\UnauthorizedCurrencyConversionError::class,
        '14' => \Ligdicash\Core\Errors\IpDeniedError::class,
    ],
];

// Définition des erreurs possibles pour le Payin en test ou en live
const PAYIN_WIKI = [
    'test' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\ApplicationAuthenticationError::class,
        '02' => \Ligdicash\Core\Errors\InvalidAmountError::class,
        '03' => \Ligdicash\Core\Errors\IpDeniedError::class,
        '04' => \Ligdicash\Core\Errors\ProcessingError::class,
    ],
    'live' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\MerchantPayinDisabledError::class,
        '02' => \Ligdicash\Core\Errors\InvalidAmountError::class,
        '03' => \Ligdicash\Core\Errors\IpDeniedError::class,
        '04' => \Ligdicash\Core\Errors\ProcessingError::class,
        '05' => \Ligdicash\Core\Errors\SendingError::class,
        '06' => \Ligdicash\Core\Errors\SendingError::class,
        '07' => \Ligdicash\Core\Errors\NoNetworkAccessConfigurationError::class,
        '08' => \Ligdicash\Core\Errors\DataInputError::class,
        '09' => \Ligdicash\Core\Errors\ApiError::class,
        '10' => \Ligdicash\Core\Errors\NoHashError::class,
        '11' => \Ligdicash\Core\Errors\InvalidHashError::class,
        '12' => \Ligdicash\Core\Errors\InvalidMethodError::class,
        '13' => \Ligdicash\Core\Errors\UnauthorizedMethodError::class,
    ],
];

// Définition des erreurs possibles pour le statut d'une transaction en test ou en live
const STATUS_WIKI = [
    'test' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\ApplicationAuthenticationError::class,
        '02' => \Ligdicash\Core\Errors\InvoiceNotFoundError::class,
        '03' => \Ligdicash\Core\Errors\ProcessingError::class,
    ],
    'live' => [
        '00' => \Ligdicash\Core\Errors\AuthenticationError::class,
        '01' => \Ligdicash\Core\Errors\MerchantPayinDisabledError::class,
        '02' => \Ligdicash\Core\Errors\InvoiceNotFoundError::class,
        '03' => \Ligdicash\Core\Errors\ProcessingError::class,
        '04' => \Ligdicash\Core\Errors\DataInputError::class,
    ],
];

// Définition des wiki Payin, Payout et Status
const WIKI = [
    'payin' => PAYIN_WIKI,
    'client_payout' => PAYOUT_CLIENT_WIKI,
    'merchant_payout' => PAYOUT_MARCHAND_WIKI,
    'status' => STATUS_WIKI,
];

/**
 * Fonction qui retourne l'erreur correspondant au nom de wiki et au code d'erreur donnés et à la plateforme actuelle
 *
 * @param string $wiki_name Nom du wiki
 * @param string $error_code Code d'erreur
 * @return string Nom de la classe de l'exception correspondante
 */
function get_wiki_error(string $wiki_name, string $platform, string $error_code)
{
    if (isset(WIKI[$wiki_name][$platform][$error_code])) {
        return WIKI[$wiki_name][$platform][$error_code];
    }
    return \Ligdicash\Core\Errors\ApiError::class;
}