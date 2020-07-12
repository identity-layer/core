<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Jwt;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\ClaimFactory;
use IdentityLayer\Jose\Jwa\RS;
use IdentityLayer\Jose\Jwk\Rsa\PrivateKey;
use IdentityLayer\Jose\Jwk\Rsa\PublicKey;
use IdentityLayer\Jose\Jwt\Jws;
use PHPUnit\Framework\TestCase;

class JwsTest extends TestCase
{
    private string $privateKeyPem;

    public function setUp(): void
    {
        $this->privateKeyPem = file_get_contents(__DIR__ . '/private.pem');
    }

    public function testToCompactSerialisedFormat(): void
    {
        $privateKey = PrivateKey::fromPrivateKeyPemEncoded($this->privateKeyPem);
        $rs256 = new RS(JwaEnum::RS256());

        $header = [
            'alg' => JwaEnum::RS256()->getValue(),
            'typ' => 'JWT',
        ];

        $claims = ClaimFactory::createClaims([
            'sub' => '1234567890',
            'name' => 'John Doe',
            'admin' => true,
            'iat' => 1516239022,
        ]);

        $expectedToken = file_get_contents(__DIR__ . '/token');

        $jws = new Jws($claims, $header);

        $this->assertEquals($expectedToken, $jws->toCompactSerialisedFormat(
            $rs256,
            $privateKey
        ));
    }

    public function testFromCompactSerialisedFormat(): void
    {
        $token = file_get_contents(__DIR__ . '/token');

        $signingToken = PublicKey::fromPublicKeyPemEncoded(
            file_get_contents(__DIR__ . '/public.key')
        );

        $jws = Jws::fromCompactSerialisedFormat($signingToken, $token);

        $this->assertEquals([
            'sub' => '1234567890',
            'name' => 'John Doe',
            'admin' => true,
            'iat' => 1516239022,
        ], $jws->getClaims()->jsonSerialize());
    }
}
