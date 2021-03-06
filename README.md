# Riak Client for PHP

[![Packagist](https://img.shields.io/packagist/v/open-adapter/riak-php-client.svg?maxAge=2592000)](https://packagist.org/packages/start2004/riak-php-client)

**Riak PHP Client** is a library which makes it easy to communicate with [Riak](http://basho.com/riak/), an open source, distributed database that focuses on high availability, horizontal scalability, and *predictable*
latency. This library communicates with Riak's HTTP interface using the cURL extension. If you want to communicate with Riak using the Protocol Buffers interface, use the [Official PHP PB Client](https://github.com/basho/riak-phppb-client). Both Riak and this library are maintained by [Basho Technologies](http://www.basho.com/). 

To see other clients available for use with Riak visit our [Documentation Site](http://docs.basho.com/riak/latest/dev/using/libraries)


1. [Installation](#installation)
1. [Documentation](#documentation)
1. [Contributing](#contributing)
	* [An honest disclaimer](#an-honest-disclaimer)
1. [Roadmap](#roadmap)
1. [License and Authors](#license-and-authors)


## Installation

### Dependencies
- PHP 7.2+
- PHP Extensions: curl, json and openssl [required for security features]
- Riak 2.1+
- [Composer PHP Dependency Manager](https://getcomposer.org/)

### Composer Install

This library has been added to [Packagist](https://packagist.org/packages/basho/) to simplify the installation process. Run the following [composer](https://getcomposer.org/) command:

```console
$ composer require "start2004/riak-php-client": "3.*"
```

Alternately, manually add the following to your `composer.json`, in the `require` section:

```javascript
"require": {
    "start2004/riak-php-client": "3.*"
}
```

And then run `composer update` to ensure the module is installed.

## Documentation

A fully traversable version of the API documentation for this library can be found on [Github Pages](http://basho.github.io/riak-php-client). 

### Example Usage

Below is a short example of using the client. More substantial sample code is available [in examples](/examples).

#### 8087

requires allegro/protobuf: >= 0.12.3, `docker-php-ext-install protobuf`

https://packagist.org/packages/allegro/php-protobuf

https://github.com/allegro/php-protobuf

```php
die("This is a stub file for IDEs, don't use it directly!");

abstract class ProtobufMessage
{
    ...
}
```
##### code

```php
// lib classes are included via the Composer autoloader files
use Start2004\Riak;
use Start2004\Riak\Node;
use Start2004\Riak\Command;

// define the connection info to our Riak nodes
$node = (new Node\Builder)
    ->atHost('riak domain')
    ->onPort(8087)
    ->build();

// instantiate the Riak client
$riak = new Riak([$node], [], new Riak\Api\Pb());
$bucket = new Riak\Bucket("bucket name");

// location
$location = new Riak\Location("key name", $bucket);

// dataObject
$dataObject = new Riak\DataObject("store data");
$dataObject->setContentType("text/html");
$dataObject->setContentEncoding("identity");

// build a command to be executed against Riak
$command = (new Command\Builder\StoreObject($riak))
    ->withObject($dataObject)
    ->atLocation($location);

// store
$store = new Command\DataObject\Store($command);
    
// Receive a response object
$response = $store->execute();



// fetch object
$command = (new Command\Builder\FetchObject($riak))
    ->atLocation($location)
    ->build();
$response = $command->execute();

// data
if($response->getCode() == "200"){
    $dataObject = $response->getDataObject();
    $contentType = $dataObject->getContentType();
    $data = $dataObject->getData();
} else {}



// delete object
$command = (new Command\Builder\DeleteObject($riak))
    ->atLocation($location);
$delete = new Command\DataObject\Delete($command);
$response = $delete->execute();

// delete result
return !($response->getCode() === 404);
```

#### 8098

```php
// lib classes are included via the Composer autoloader files
use Start2004\Riak;
use Start2004\Riak\Node;
use Start2004\Riak\Command;

// define the connection info to our Riak nodes
$node = (new Node\Builder)
    ->atHost('riak domain')
    ->onPort(8098)
    ->build();

// instantiate the Riak client
$riak = new Riak([$node]);
$bucket = new Riak\Bucket("bucket name");

// location
$location = new Riak\Location("key name", $bucket);

// dataObject
$dataObject = new Riak\DataObject("store data");
$dataObject->setContentType("text/html");
$dataObject->setContentEncoding("identity");

// build a command to be executed against Riak
$command = (new Command\Builder\StoreObject($riak))
    ->withObject($dataObject)
    ->atLocation($location)
    ->build();

// Receive a response object
$response = $command->execute();
```

## Contributing

This repo's maintainers are engineers at Basho and we welcome your contribution to the project! You can start by reviewing [CONTRIBUTING.md](CONTRIBUTING.md) for information on everything from testing to coding standards.

### An honest disclaimer

Due to our obsession with stability and our rich ecosystem of users, community updates on this repo may take a little longer to review. 

The most helpful way to contribute is by reporting your experience through issues. Issues may not be updated while we review internally, but they're still incredibly appreciated.

Thank you for being part of the community! We love you for it. 

## Roadmap

* Current develop & master branches contain feature support for Riak version 2.1+
* Add support for Riak TS Q2 2016

## License and Authors
Merge:
* basho/riak-pb (https://packagist.org/packages/basho/riak-pb)
* open-adapter/riak-php-client (https://packagist.org/packages/open-adapter/riak-php-client)

Active:
* Author: Przemyslaw Pastusiak (https://github.com/pastusiak)

Original:
* Author: Christopher Mancini (https://github.com/christophermancini)
* Author: Alex Moore (https://github.com/alexmoore)
* Author: Luke Bakken (https://github.com/lukebakken)

Copyright (c) 2015 Basho Technologies, Inc. Licensed under the Apache License, Version 2.0 (the "License"). For more details, see [License](License).
