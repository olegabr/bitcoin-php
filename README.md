  
## Bitcoin

[![CI](https://github.com/olegabr/bitcoin-php/actions/workflows/ci.yml/badge.svg)](https://github.com/olegabr/bitcoin-php/actions/workflows/ci.yml)

This repository contains an implementation of Bitcoin using mostly pure PHP.

This is the EthereumICO fork ([olegabr/bitcoin-php](https://github.com/olegabr/bitcoin-php))
of [Bit-Wasp/bitcoin-php](https://github.com/Bit-Wasp/bitcoin-php): it keeps the
`BitWasp\Bitcoin` namespace and adds PHP 8.x support (paragonie/ecc,
SplFixedArray-free collection mutators, and a test suite that runs on PHPUnit 9).

*Warning*: This library does not support 32-bit installs of PHP. Please also note that composer is the only supported installation method.

## Installation

You can install this library via Composer. The fork is not published on Packagist,
so point Composer at the repository:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/olegabr/bitcoin-php" }
    ],
    "require": {
        "olegabr/bitcoin": "^1.0"
    }
}
```

## Contributing

All contributions are welcome. Please see [[this page](https://github.com/olegabr/bitcoin-php/blob/master/CONTRIBUTING.md)] before you get started

## Documentation

 Check out the beginnings of the documentation for the library: [[Introduction](doc/documentation/Introduction.md)]

## Presently supported:

 - Blocks, headers, and merkle blocks and bloom filters
 - P2SH & Segregated witness scripts
 - An adaptable elliptic-curve library, using [[PhpEcc](https://github.com/mdanter/phpecc)] by default, or libsecp256k1 if the bindings are found
 - Support for building, parsing, signing/validating transactions
 - Deterministic signatures (RFC6979)
 - BIP32 and electrum (older type I) deterministic key algorithms
 - BIP39, and the older electrum seed format.
 - ScriptFactory for common input/output types, parser, interpreter, and classifiers
 - Supports bindings to libbitcoinconsensus
 - Bindings to Stratum (electrum) servers

# Other projects

 - [buffertools-php](https://github.com/olegabr/buffertools-php) - Toolkit for working with binary data in PHP (our fork)
 - [ext-secp256k1](https://github.com/Bit-Wasp/secp256k1-php) - PHP bindings to libsecp256k1
 - [ext-bitcoinconsensus](https://github.com/Bit-Wasp/bitcoinconsensus-php) - PHP bindings to libbitcoinconsensus
 - [bitcoin-p2p-php](https://github.com/Bit-Wasp/bitcoin-p2p-php) - PHP implementation of bitcoin P2P messaging using reactphp
 - [stratum-php](https://github.com/Bit-Wasp/stratum-php) - PHP implementation of the stratum protocol using reactphp
 - [electrum-discovery-php](https://github.com/Bit-Wasp/electrum-discovery-php) - Electrum server discovery (over IRC) using reactphp
 - [node-php](https://github.com/Bit-Wasp/node-php) - A toy project (really just for fun) a full node using bitcoin-p2p-php
 - [bip70-php](https://github.com/bip70/bip70-php) - A BIP70 (payment requests) implementation for PHP

## Supporters

This library is a 100% open source project. We do not receive any funding from the industry, nor provide paid support or development of features. That said, we are grateful for our supporters who provide free access for open source projects:

[![JetBrains](https://avatars0.githubusercontent.com/u/878437?s=200&v=4)](https://www.jetbrains.com/)

Thanks to [JetBrains](https://www.jetbrains.com/) for supporting the project through sponsoring some [All Products Packs](https://www.jetbrains.com/products.html) within their [Free Open Source License](https://www.jetbrains.com/buy/opensource/) program.
