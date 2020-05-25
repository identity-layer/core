<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Jwk\Ecdsa;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwk\Ecdsa\EcdsaPrivateKey;
use IdentityLayer\Jose\Jwk\Ecdsa\EcdsaPublicKey;
use IdentityLayer\Jose\Jwk\Ecdsa\EcsdaP256PrivateKey;
use IdentityLayer\Jose\Jwk\Ecdsa\EcsdaP256PublicKey;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;

class EcdsaTest extends TestCase
{
    private $publicKeyPemEncoded = '-----BEGIN PUBLIC KEY-----
MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEf83OJ3D2xF1Bg8vub9tLe1gHMzV7
6e8Tus9uPHvRVEXH8UTNG72bfocs3+257rn0s2ldbqkLJK2KRiMohYjlrQ==
-----END PUBLIC KEY-----
';

    private $privateKeyPemEncoded = '-----BEGIN EC PRIVATE KEY-----
MCUCAQEEII6bEJ5xkJi/mASH3x9dd+nLKWBuvtImO19XwhPfhPSy
-----END EC PRIVATE KEY-----
';

    public function testSigning()
    {
        $privateKey = EcdsaPrivateKey::fromPrivateKeyPemEncoded($this->privateKeyPemEncoded);

        $message = 'eyJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJqb2UiLA0KICJleHAiOjEzMDA4MTkzODAsDQogImh0dHA6Ly9leGFtcGxlLmNvbS9pc19yb290Ijp0cnVlfQ';
        $expectedSignature = Base64UrlSafe::decode('DtEhU3ljbEg8L38VWAfUAqOyKAM6-Xx-F4GawxaepmXFCgfTjDxw5djxLa8ISlSApmWQxfKTUJqPP3-Kg6NU1Q');
        $signature = $privateKey->sign(JwaEnum::ES256(), $message);
        echo Base64UrlSafe::encodeUnpadded($signature);
        $this->assertEquals(
            $expectedSignature,
            $privateKey->sign(JwaEnum::ES256(), $message)
        );
    }

    public function testVerify()
    {
        $publicKey = EcdsaPublicKey::fromPublicKeyPemEncoded($this->publicKeyPemEncoded);
        $message = 'eyJhbGciOiJFUzI1NiJ9.eyJpc3MiOiJqb2UiLA0KICJleHAiOjEzMDA4MTkzODAsDQogImh0dHA6Ly9leGFtcGxlLmNvbS9pc19yb290Ijp0cnVlfQ';
        $expectedSignature = bin2hex(Base64UrlSafe::decode('DtEhU3ljbEg8L38VWAfUAqOyKAM6-Xx-F4GawxaepmXFCgfTjDxw5djxLa8ISlSApmWQxfKTUJqPP3-Kg6NU1Q'));

        $this->assertTrue($publicKey->verify(JwaEnum::ES256(), $message, $expectedSignature));
    }
}