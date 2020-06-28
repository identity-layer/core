<?php

declare(strict_types=1);

namespace IdentityLayer\Tests\Jose\Jwa;

use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Jwa\RS;
use IdentityLayer\Jose\Jwk\Rsa\PrivateKey;
use IdentityLayer\Jose\Jwk\Rsa\PublicKey;
use ParagonIE\ConstantTime\Base64UrlSafe;
use PHPUnit\Framework\TestCase;

/**
 * These tests were generated using expected results for a number of algorithms with
 * the private and public keys below.
 */
class RSTest extends TestCase
{
    private string $privateKeyPem;
    private string $publicKeyPem;
    private string $message256;
    private string $message384;
    private string $message512;
    private string $signature256;
    private string $signature384;
    private string $signature512;

    public function setUp(): void
    {
        $this->privateKeyPem = file_get_contents(__DIR__ . '/private.pem');
        $this->publicKeyPem = file_get_contents(__DIR__ . '/public.pem');
        $this->message256 = file_get_contents(__DIR__ . '/message256');
        $this->message384 = file_get_contents(__DIR__ . '/message384');
        $this->message512 = file_get_contents(__DIR__ . '/message512');
        $this->signature256 = file_get_contents(__DIR__ . '/signature256');
        $this->signature384 = file_get_contents(__DIR__ . '/signature384');
        $this->signature512 = file_get_contents(__DIR__ . '/signature512');
    }

    public function testSigning(): void
    {
        $privateKey = PrivateKey::fromPrivateKeyPemEncoded($this->privateKeyPem);

        $rs256 = new RS(JwaEnum::RS256());
        $rs256Signature = Base64UrlSafe::decode($this->signature256);

        $this->assertEquals($rs256Signature, $rs256->sign($privateKey, $this->message256));

        $rs384 = new RS(JwaEnum::RS384());
        $rs384Signature = Base64UrlSafe::decode($this->signature384);

        $this->assertEquals($rs384Signature, $rs384->sign($privateKey, $this->message384));

        $rs512 = new RS(JwaEnum::RS512());
        $rs512Signature = Base64UrlSafe::decode($this->signature512);

        $this->assertEquals($rs512Signature, $rs512->sign($privateKey, $this->message512));
    }

    public function testVerify(): void
    {
        $privateKey = PrivateKey::fromPrivateKeyPemEncoded($this->privateKeyPem);
        $publicKey = PublicKey::fromPublicKeyPemEncoded($this->publicKeyPem);

        $rs256 = new RS(JwaEnum::RS256());
        $rs256Signature = Base64UrlSafe::decode($this->signature256);

        $this->assertTrue(
            $rs256->verify($privateKey, $this->message256, $rs256Signature),
            'Failed to verify valid RS256 signature with private key'
        );
        $this->assertTrue(
            $rs256->verify($publicKey, $this->message256, $rs256Signature),
            'Failed to verify valid RS256 signature with public key'
        );

        $rs384 = new RS(JwaEnum::RS384());
        $rs384Signature = Base64UrlSafe::decode($this->signature384);

        $this->assertTrue(
            $rs384->verify($privateKey, $this->message384, $rs384Signature),
            'Failed to verify valid RS384 signature with private key'
        );
        $this->assertTrue(
            $rs384->verify($publicKey, $this->message384, $rs384Signature),
            'Failed to verify valid RS384 signature with public key'
        );

        $rs512 = new RS(JwaEnum::RS512());
        $rs512Signature = Base64UrlSafe::decode($this->signature512);

        $this->assertTrue(
            $rs512->verify($privateKey, $this->message512, $rs512Signature),
            'Failed to verify valid RS512 signature with private key'
        );
        $this->assertTrue(
            $rs512->verify($publicKey, $this->message512, $rs512Signature),
            'Failed to verify valid RS512 signature with public key'
        );
    }
}
