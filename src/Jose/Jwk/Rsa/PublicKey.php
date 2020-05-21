<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Rsa;

use IdentityLayer\Jose\AlgorithmFamily;
use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Jwk\JwkSerialisable;
use IdentityLayer\Jose\Jwk\VerificationKey;
use ParagonIE\ConstantTime\Base64UrlSafe;

final class PublicKey implements VerificationKey, JwkSerialisable
{
    private $keyResource;
    private string $publicExponent;
    private string $modulus;

    private function __construct(string $pemEncodedKey)
    {
        $resource = openssl_pkey_get_public($pemEncodedKey);

        if ($resource === false) {
            throw new InvalidArgumentException('public key is not valid');
        }

        $details = openssl_pkey_get_details($resource);

        if ($details === false) {
            throw new InvalidArgumentException('Key is not an RSA public key');
        }

        $this->keyResource = $resource;
        $this->modulus = $details['rsa']['n'];
        $this->publicExponent = $details['rsa']['e'];
    }

    public static function fromPublicKeyPemEncoded(string $publicKeyPemEncoded): PublicKey
    {
        return new PublicKey($publicKeyPemEncoded);
    }

    public function verify(
        AlgorithmName $algorithmName,
        string $message,
        string $signature
    ): bool {

        if (!$algorithmName->algorithmFamily()->equals(AlgorithmFamily::RS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a valid algorithm for use with an RSA key',
                    $algorithmName->getValue()
                )
            );
        }

        return openssl_verify(
            $message,
            $signature,
            $this->keyResource,
            "RSA-{$algorithmName->hashingAlgorithm()}"
        ) === 1;
    }

    public function kid(): string
    {
        $base = [
            'e' => Base64UrlSafe::encodeUnpadded($this->publicExponent),
            'kty' => 'RSA',
            'n' => Base64UrlSafe::encodeUnpadded($this->modulus),
        ];

        $baseJsonEncoded = json_encode($base);

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', $baseJsonEncoded, true)
        );
    }

    public function toJwkFormat(): string
    {
        return json_encode([
            'kty' => 'RSA',
            'use' => 'sig',
            'kid' => $this->kid(),
            'n' => Base64UrlSafe::encodeUnpadded($this->modulus),
            'e' => Base64UrlSafe::encodeUnpadded($this->publicExponent),
        ]);
    }
}