<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Jwk\Rsa;

use IdentityLayer\Jose\Jwk\Rsa\PublicKey;
use PHPStan\Testing\TestCase;

class PublicKeyTest extends TestCase
{
    /**
     * This test was taken from the RFC7638 example for kid
     * generation with RSA key.
     */
    public function testKidGeneration()
    {
        $publicKey = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0vx7agoebGcQSuuPiLJX
ZptN9nndrQmbXEps2aiAFbWhM78LhWx4cbbfAAtVT86zwu1RK7aPFFxuhDR1L6tS
oc/BJECPebWKRXjBZCiFV4n3oknjhMstn64tZ/2W+5JsGY4Hc5n9yBXArwl93lqt
7/RN5w6Cf0h4QyQ5v+65YGjQR0/FDW2QvzqY368QQMicAtaSqzs8KJZgnYb9c7d0
zgdAZHzu6qMQvRL5hajrn1n91CbOpbISD08qNLyrdkt+bFTWhAI4vMQFh6WeZu0f
M4lFd2NcRwr3XPksINHaQ+G/xBniIqbw0Ls1jF44+csFCur+kEgU8awapJzKnqDK
gwIDAQAB
-----END PUBLIC KEY-----';

        $publicKey = PublicKey::fromPublicKeyPemEncoded($publicKey);

        $this->assertEquals('NzbLsXh8uDCcd-6MNwXF4W_7noWXFZAfHkxZsRGC9Xs', $publicKey->kid());
    }
}