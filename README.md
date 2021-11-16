# imaginacms-icommercestripe (PaymentMethod)

## Install
```bash
composer require imagina/icommercestripe-module=v8.x-dev
```
```bash
composer require stripe/stripe-php
```

## Enable the module
```bash
php artisan module:enable Icommercestripe
```

## Seeder

```bash
php artisan module:seed Icommercestripe
```

## Configurations
	- Public Key 
    - Secret Key
    - Account Id
    - Sign Secret (To Webhook Response)
    - Comision Amount (Application Fee Amount) - Connect Transfer
    - Minimun Amount ($0.50 Dollars)

## WebHook URL to Response
    https://mydomain/api/icommercestripe/v1/response

## Account
https://dashboard.stripe.com/login