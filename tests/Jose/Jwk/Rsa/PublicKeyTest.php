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

    public function testFromJwk()
    {
        $jwkData = [
            'kty' => 'RSA',
            'use' => 'sig',
            'kid' => 'zFHVsM9dc4OlHIwvEnVqfKzRj1ujqYGsZnXAcgn_CqI',
            'n' => 'nzyis1ZjfNB0bBgKFMSvvkTtwlvBsaJq7S5wA-kzeVOVpVWwkWdVha4s38XM_pa_yr47av7-z3VTmvDRyAHcaT92whREFpLv9cj5lTeJSibyr_Mrm_YtjCZVWgaOYIhwrXwKLqPr_11inWsAkfIytvHWTxZYEcXLgAXFuUuaS3uF9gEiNQwzGTU1v0FqkqTBr4B8nW3HCN47XUu0t8Y0e-lf4s4OxQawWD79J9_5d3Ry0vbV3Am1FtGJiJvOwRsIfVChDpYStTcHTCMqtvWbV6L11BWkpzGXSW4Hv43qa-GSYOD2QU68Mb59oSk2OB-BtOLpJofmbGEGgvmwyCI9Mw',
            'e' => 'AQAB',
        ];

        $publicKey = PublicKey::fromJwkData($jwkData);

        $this->assertEquals($jwkData, json_decode($publicKey->toJwkFormat(), true));
    }
}