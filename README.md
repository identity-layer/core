# identity-layer/jose

## Intro
This library provides a simple yet secure implementation of the Javascript Object
Signing and Encryption (JOSE) standard.

It also provides support for claims by providing interfaces and a set of value objects 
you can use within your application as well as a factory for converting claims into a 
collection and providing validation on claims whether they're generated by your application
or parsed.

The library uses OpenSSL for most of its cryptographic functionality and uses secure
algorithms otherwise.

The library keeps external dependencies to a minimum so works well in environments
with complex dependency requirements.

## Supported Algorithms
| Algorithm | Supported |
|-----------|-----------|
| HS256     | ✔ |
| HS384     | ✔ |
| HS512     | ✔ |
| RS256     | ✔ |
| RS384     | ✔ |
| RS512     | ✔ |
| PS256     | ✖ |
| PS384     | ✖ |
| PS512     | ✖ |
| ES256     | ✖ |
| ES384     | ✖ |
| ES512     | ✖ |



