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
    public function testKidGeneration(): void
    {
        $publicKey = file_get_contents(__DIR__ . '/public.pem');

        $publicKey = PublicKey::fromPublicKeyPemEncoded($publicKey);

        $this->assertEquals(
            'NzbLsXh8uDCcd-6MNwXF4W_7noWXFZAfHkxZsRGC9Xs',
            $publicKey->kid()
        );
    }

    public function testFromJwk(): void
    {
        $jwkData = [
            'kty' => 'RSA',
            'use' => 'sig',
            'kid' => 'zFHVsM9dc4OlHIwvEnVqfKzRj1ujqYGsZnXAcgn_CqI',
            'n' => file_get_contents(__DIR__ . '/modulus'),
            'e' => 'AQAB',
        ];

        $publicKey = PublicKey::fromJwkData($jwkData);

        $this->assertEquals($jwkData, json_decode($publicKey->toJwkFormat(), true));
    }
}
