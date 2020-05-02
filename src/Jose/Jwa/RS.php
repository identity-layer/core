<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\Jwa;

use IdentityLayer\Core\Jose\AlgorithmFamily;
use IdentityLayer\Core\Jose\AlgorithmName;
use IdentityLayer\Core\Jose\Jwa;
use InvalidArgumentException;
use ParagonIE\ConstantTime\Base64UrlSafe;
use phpseclib\Crypt\RSA;

class RS implements Jwa
{
    private RSA $privateKey;
    private RSA $publicKey;
    private AlgorithmName $algorithm;

    private function __construct(RSA $privateKey, AlgorithmName $algorithm)
    {
        if (empty($privateKey->primes) || count($privateKey->primes) != 2) {
            throw new InvalidArgumentException('Provided RSA key is not a valid private key');
        }


        $publicKeyPemEncoded = $privateKey->getPublicKey();
        if ($publicKeyPemEncoded === false) {
            throw new InvalidArgumentException(
                sprintf('The private key provided is invalid. Could not extract public key.')
            );
        }

        $publicKey = new RSA();
        $result = $publicKey->loadKey($publicKeyPemEncoded);

        if ($result !== true) {
            throw new InvalidArgumentException('Could not extract public key from provided private key');
        }

        $this->privateKey = clone $privateKey;
        $this->publicKey = $publicKey;
        $this->algorithm = $algorithm;

        foreach ([$this->publicKey, $this->privateKey] as $key) {
            $key->setHash($algorithm->hashingAlgorithm());
            $key->setSignatureMode(RSA::SIGNATURE_PKCS1);
        }
    }

    public static function fromPrivateKeyPemEncoded(string $privateKeyPemEncoded, AlgorithmName $algorithm)
    {
        if (!AlgorithmFamily::RS()->equals($algorithm->algorithmType())) {
            throw new InvalidArgumentException(
                sprintf('%s is not a valid RSA algorithm', $algorithm->getValue())
            );
        }

        $privateKey = new RSA();
        $result = $privateKey->loadKey($privateKeyPemEncoded);

        if ($result !== true) {
            throw new InvalidArgumentException('Not a valid PEM encoded RSA PKCS1 private key');
        }

        return new RS($privateKey, $algorithm);
    }

    public function kid(): string
    {
        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', (string) $this->publicKey)
        );
    }

    public function type(): AlgorithmFamily
    {
        return AlgorithmFamily::RS();
    }

    public function name(): AlgorithmName
    {
        return $this->algorithm;
    }

    public function sign($message): string
    {
        return $this->privateKey->sign($message);
    }

    public function verify(string $message, string $signature): bool
    {
        return $this->privateKey->sign($message) === $signature;
    }

    public function toPublicJwkFormat(): array
    {
        return [
            'kty' => 'RSA',
            'alg' => $this->algorithm->getValue(),
            'kid' => static::kid((string) $this->publicKey),
            'use' => 'sig',
            'e' => Base64UrlSafe::encodeUnpadded($publicKey->exponent->toBytes()),
            'n' => Base64UrlSafe::encodeUnpadded($publicKey->modulus->toBytes()),
        ];
    }
}