# Atrium-PHP
A PHP wrapper for the [MX Atrium API](https://atrium.mx.com). In order to make requests, you will need to [sign up for the MX Atrium API](https://atrium.mx.com/developers/sign_up) and get a `MX-API-KEY` and a  `MX-CLIENT-ID`.

### Installation

Use Composer or Yarn to add the library to your application:

```
composer install nateritter/atrium-php
```
or
```
yarn add nateritter/atrium-php
```

### Usage

Use the `atrium` module in your source code with the following
```php
use NateRitter\AtriumPHP\AtriumClient
```

Then configure your instance with the following. (The `ENVIRONMENT` will be either `vestibule.mx.com` for the development environment or `atrium.mx.com` for the production environment.)
```php
$atriumClient = new AtriumClient('ENVIRONMENT', 'YOUR_MX_API_KEY', 'YOUR_MX_CLIENT_ID')
```

Then start using class methods to make calls to the Atrium API for data. See the full [Atrium documentation](https://atrium.mx.com/documentation) for more details.

```php
# use AtriumClient wrapper class
use NateRitter\AtriumPHP\AtriumClient

# Configure AtriumClient
$atriumClient = new AtriumClient('ENVIRONMENT', 'YOUR_MX_API_KEY', 'YOUR_MX_CLIENT_ID')

# Now begin making Atrium calls
$atriumClient->createUser(['identifier' => 'UniqueID']) # Create a user, etc...
```

### Examples

The `/examples` directory contains various workflows and code snippets. You will first need to modify the line shown below in each example with the environment, YOUR-MX-API-KEY, and YOUR-MX-CLIENT-ID before running.
```php
$atriumClient = new AtriumClient('ENVIRONMENT', 'YOUR_MX_API_KEY', 'YOUR_MX_CLIENT_ID')
```
