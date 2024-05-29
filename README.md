# Librairie PHP LigdiCash

Ce projet est un SDK PHP qui permet de manipuler l'API de LigdiCash.
Vous pourrez éffectuer des Payins, Payouts, des vérifications de transactions et des retraits.

Vous retrouverez la documentation de l'API de LigdiCash sur [https://developers.ligdicash.com/](https://developers.ligdicash.com/).

## Installation

```bash
composer require ligdicash/ligdicash
```

## Initialisation

L'initialisation de la librairie LigdiCash nécessite une clé API et un jeton d'authentification.
Vous pouvez obtenir ces informations en créant un projet API sur la plateforme LigdiCash.

```php
use Ligdicash\Ligdicash;

$client = new Ligdicash([
    "api_key" => "REV...I4O",
    "auth_token" => "eyJ0eXAiO...ep6BJuAY",
    "platform" => "live"
]);
```

## Payin

Le Payin est une transaction qui permet à un client de payer pour un produit ou un service.
Il existe deux types de Payin : avec rédirection et sans rédirection.

### Remplir la facture

```php
// Décrire la facture et le client
$invoice = $client->Invoice([
    "currency" => "XOF",
    "description" => "Payment for goods",
    "customer_firstname" => "John",
    "customer_lastname" => "Doe",
    "customer_email" => "jonh@doe.com",
    "store_name" => "My Store",
    "store_website_url" => "https://mystore.com"
]);

# Ajouter des éléments(produit, service, etc) à la facture
$invoice->addItem([
    "name" => "Premier produit",
    "description" => "__description_du_produit__",
    "quantity" => 3,
    "unit_price" => 3500
]);

$invoice->addItem([
    "name" => "Deuxieme produit",
    "description" => "__description_du_produit__",
    "quantity" => 1,
    "unit_price" => 5000
]);

$invoice->addItem([
    "name" => "TVA",
    "description" => "__description_du_produit__",
    "quantity" => 1,
    "unit_price" => 1000
]);
```

### Payin avec rédirection

Le Payin avec rédirection permet de rediriger le client vers une page de paiement sécurisée, conçue par LigdiCash.

```php
$response = $invoice->payWithRedirection([
    "return_url" => "https://masuperboutique.com/success",
    "cancel_url" => "https://masuperboutique.com/cancel",
    "callback_url" => "https://backend.masuperboutique.com/callback",
    "custom_data" => [
        "order_id" => "ORD-1234567890",
        "customer_id" => "CUST-1234567890"
    ]
]);

$payment_url = response.response_text;
header("Location: $payment_url");
```

### Payin sans rédirection

Le Payin sans rédirection permet de payer directement sur la page de la boutique, sans être redirigé vers une page de paiement.

```php
$response = $invoice->payWithoutRedirection([
    "otp" => "XXXXXX",
    "customer" => "226XXXXXXXX",
    "callback_url" => "https://backend.masuperboutique.com/callback",
    "custom_data" => [
        "product_id" => "PR025632545",
    ]
]);

const token = response.token;
check_payment_status(token);
```

## Payout

Le Payout est une transaction qui permet à un marchand de rembourser un client ou de lui envoyer de l'argent.

```php
$invoice = $client->Withdrawal([
    "amount" => 100,
    "description" => "Remboursement de la commande ORD-123456",
    "customer" => "226XXXXXXXX"
]);

$transaction = $withdrawal->send([
    "type" => "client"
    "to_wallet" => true, #true si l'argent doit rester dans le wallet du client, false si l'argent doit être envoyé sur son compte mobile money
    "custom_data" => [
        "refund_id" => "123456",
    ],
    "callback_url" => "https://backend.masuperboutique.com/callback-payout",
]);

$token = transaction.token;
check_payment_status(token);
```

## Vérification de transaction

La vérification de transaction permet de vérifier l'état d'une transaction.
Vous devez toujours vérifier l'état d'une transaction avant de livrer un produit ou de valider une commande.

Pour obtenir une transaction, vous devez fournir le token de la transaction.

```php
$transaction_token = "eyJ0eXAiOiJ...pZCI6IjY"

$transaction = $client->getTransaction([
    "token" => $token,
    "type" => "payout" # "payin" ou "payout"
]);

$status = $transaction->status;
if ($status === "completed") {
    // La transaction a été effectuée avec succès
} elseif ($status === "pending") {
    // La transaction est en cours de traitement
} else {
    // La transaction a échouée
}
```