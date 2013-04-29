NonceUtil-PHP
=============

A tiny NONCE generator with variable time-outs and individual salts, no database required.


## Usage

Generate a NONCE with one minute lifetime:

    $nonce = NonceUtil::generate('mySecretString', 60);


Validate the NONCE:

    $valid = NonceUtil::check('mySecretString', $nonce);


You have to define a secret on the server side and pass it to the `generate()` and `check()` methods as the first argument. The secret string must be at least 10 characters long. 

The seconds argument to `generate()` defines the lifetime of the NONCE in seconds. There are no restrictions on the lifetime. 



## Background

The generated NONCE is technically a NONCE-word, because it consists of a long string, rather than a number. Let's have a look at a generated NONCE:

    MAQNvfiCxe,1367231553,feeacd0821438c00fc04174278f8209577678e44

Each NONCE consists of three parts, separated by a `,`. The first part is a salt, which is randomly created for each NONCE. The second part is the UNIX time at which the NONCE expires. The third part is a SHA1 hash of the salt, secret, and the time of expiration combined. 

In order to validate the NONCE, we recalculate the hash and compare it to the hash in the NONCE. If the hash is valid, we are sure that the NONCE originates from us and was not tampered with, and we can simply check if NONCE is expired.

## Examples


See `examples.php`. 

