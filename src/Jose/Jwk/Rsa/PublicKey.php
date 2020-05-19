<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Rsa;

use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Jwk\VerificationKey;
use ParagonIE\ConstantTime\Base64UrlSafe;
use phpseclib\Crypt\RSA;
use IdentityLayer\Jose\Exception\InvalidArgumentException;

class PublicKey implements VerificationKey
{
    private RSA $publicKey;

    private function __construct(RSA $publicKey)
    {
        if ($publicKey->modulus === null || $publicKey->publicExponent === null) {
            throw new InvalidArgumentException('public key is not valid');
        }

        $publicKey->setSignatureMode(RSA::SIGNATURE_PKCS1);

        $this->publicKey = clone $publicKey;
    }

    public static function fromPublicKeyPemEncoded(string $publicKeyPemEncoded): PublicKey
    {
        $publicKey = new RSA();
        $result = $publicKey->loadKey($publicKeyPemEncoded);

        if ($result !== true) {
            throw new InvalidArgumentException('Could not extract public key from provided private key');
        }

        return new PublicKey($publicKey);
    }

    public function verify(
        AlgorithmName $algorithmName,
        string $message,
        string $signature
    ): bool {
        $this->publicKey->setHash($algorithmName->hashingAlgorithm());

        return $this->publicKey->verify($message, $signature);
    }

    public function kid(): string
    {
        $publicBytes = $this->publicKey->modulus->toBytes() . $this->publicKey->publicExponent->toBytes();

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', $publicBytes)
        );
    }

    public function toJwkFormat(): string
    {
        return json_encode([
            'kty' => 'RSA',
            'use' => 'sig',
            'kid' => $this->kid(),
            'n' => Base64UrlSafe::encodeUnpadded($this->publicKey->modulus->toBytes()),
            'e' => Base64UrlSafe::encodeUnpadded($this->publicKey->exponent->toBytes()),
        ]);
    }
}