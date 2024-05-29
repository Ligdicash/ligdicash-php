<?php

namespace Ligdicash\Core\Errors;

use Exception;

// Définition de la classe de base LigdicashError
class LigdicashError extends Exception
{
    /**
     * Code d'erreur associé à l'exception.
     *
     * @var string
     */
    protected $code;

    /**
     * Message d'erreur associé à l'exception.
     *
     * @var string
     */
    protected $message;

    /**
     * Constructeur de la classe LigdicashError.
     *
     * @param string $code Le code d'erreur.
     * @param string $message Le message d'erreur.
     */
    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
        parent::__construct($message);
    }
}

// Définition des classes d'erreurs spécifiques

class AuthenticationError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "api_key or auth_token is invalid");
    }
}

class ApplicationAuthenticationError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Unable to authenticate your application");
    }
}

class MerchantBalanceLowError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Merchant balance low");
    }
}

class MerchantPayoutDisabledError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Payout is disabled for this Merchant");
    }
}

class MerchantPayinDisabledError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Merchant Payin feature is not activated");
    }
}

class CustomerDoesNotExistError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "This customer is not registered on the platform");
    }
}

class TransactionAlreadyExistError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Transaction already exists");
    }
}

class InvoiceNotFoundError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Invoice not found");
    }
}

class InvalidAmountError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Invalid amount. It should fall within the range of 20 to 1000000.");
    }
}

class InvalidTokenError extends LigdicashError
{
    public function __construct()
    {
        parent::__construct("invalidtoken", "Invalid token");
    }
}

class MerchantAccountDoesNotExistError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "No merchant account on the specified network");
    }
}

class NoPendProcPayout24HError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "No pending or processed payout within the last 24 hours");
    }
}

class NoDeposit3MError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "No deposit within the last 3 months");
    }
}

class RecipientOperatorNotIdentifiedError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Recipient operator not identified");
    }
}

class UnauthorizedCurrencyConversionError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Unauthorized currency conversion");
    }
}

class NoDeposit24HError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "No deposit within the last 24 hours");
    }
}

class AmountOutOfRangeError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Request amount is out of range [20;1000000]");
    }
}

class IpDeniedError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "IP denied");
    }
}

class ProcessingError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "An error occurred while processing");
    }
}

class SendingError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "An error occurred while sending");
    }
}

class DataInputError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Data Input error");
    }
}

class ApiError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Api error");
    }
}

class NoHashError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "No hash provided");
    }
}

class InvalidHashError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Invalid hash");
    }
}

class NoNetworkAccessConfigurationError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "No network access configured");
    }
}

class UnauthorizedMethodError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Unauthorized method");
    }
}

class InvalidMethodError extends LigdicashError
{
    public function __construct(string $code)
    {
        parent::__construct($code, "Invalid method");
    }
}

class FeatureNotTestableError extends LigdicashError
{
    public function __construct(string $feature_name)
    {
        parent::__construct("featurenottestable", "{$feature_name} feature can't be used on test platform");
    }
}