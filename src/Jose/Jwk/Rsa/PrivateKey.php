<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Rsa;

use IdentityLayer\Core\Jose\Jwa\RS;
use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Jwk\KeyPair;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;
use ParagonIE\ConstantTime\Base64UrlSafe;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;

class PrivateKey implements KeyPair
{
    private RSA $privateKey;
    private RSA $publicKey;

    private function __construct(RSA $privateKey, RSA $publicKey = null)
    {
        if (empty($privateKey->primes) || count($privateKey->primes) != 2) {
            throw new InvalidArgumentException('The private key provided is not a valid.');
        }

        $privateKey->setSignatureMode(RSA::SIGNATURE_PKCS1);

        if ($publicKey === null) {
            $publicKeyPemEncoded = $privateKey->getPublicKey();
            if ($publicKeyPemEncoded === false) {
                throw new InvalidArgumentException(
                    sprintf('The private key provided is invalid. Could not extract public key.')
                );
            }

            $publicKey = new RSA();
            $result = $publicKey->loadKey($publicKeyPemEncoded);
            if ($result !== true) {
                throw new InvalidArgumentException('Could not extract public key from provided private key.');
            }
        }

        if (!$publicKey->modulus instanceof BigInteger || !$publicKey->exponent instanceof BigInteger) {
            throw new InvalidArgumentException('The public key provided is not valid.');
        }

        $this->privateKey = clone $privateKey;
        $this->publicKey = clone $publicKey;
    }

    public static function fromPrivateKeyPemEncoded(string $privateKeyPemEncoded): PrivateKey
    {
        $privateKey = new RSA();
        $result = $privateKey->loadKey($privateKeyPemEncoded);

        if ($result !== true) {
            throw new InvalidArgumentException('Not a valid PEM encoded RSA PKCS1 private key');
        }

        return new PrivateKey($privateKey);
    }

    public function toJwkFormat(): string
    {
        /**
         * @var BigInteger $p
         * @var BigInteger $q
         */
        list($p, $q) = $this->privateKey->primes;

        /**
         * @var BigInteger $dp
         * @var BigInteger $dq
         */
        list($dp, $dq) = $this->privateKey->exponents;

        /** @var BigInteger $qi */
        $qi = $this->privateKey->coefficients[0];

        return json_encode([
            'kty' => 'RSA',
            'kid' => $this->kid(),
            'use' => 'enc',
            'n' => Base64UrlSafe::encodeUnpadded($this->privateKey->modulus->toBytes()),
            'e' => Base64UrlSafe::encodeUnpadded($this->privateKey->publicExponent->toBytes()),
            'd' => Base64UrlSafe::encodeUnpadded($this->privateKey->exponent->toBytes()),
            'p' => Base64UrlSafe::encodeUnpadded($p->toBytes()),
            'q' => Base64UrlSafe::encodeUnpadded($q->toBytes()),
            'dp' => Base64UrlSafe::encodeUnpadded($dp->toBytes()),
            'dq' => Base64UrlSafe::encodeUnpadded($dq->toBytes()),
            'qi' => Base64UrlSafe::encodeUnpadded($qi->toBytes()),
        ]);
    }

    public function kid(): string
    {
        $base = [
            'e' => Base64UrlSafe::encodeUnpadded($this->privateKey->publicExponent->toBytes()),
            'kty' => 'RSA',
            'n' => Base64UrlSafe::encodeUnpadded($this->privateKey->modulus->toBytes()),
        ];

        $baseJsonEncoded = json_encode($base);

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', $baseJsonEncoded, true)
        );
    }

    public function getVerificationKey(): VerificationKey
    {
        return PublicKey::fromPublicKeyPemEncoded((string) $this->publicKey);
    }

    public function sign(AlgorithmName $algorithmName, string $message): string
    {
        $this->privateKey->setHash($algorithmName->hashingAlgorithm());

        return $this->privateKey->sign($message);
    }

    public function verify(AlgorithmName $algorithmName, string $message, string $signature): bool
    {
        $this->privateKey->setHash($algorithmName->hashingAlgorithm());

        return $this->privateKey->sign($message) === $signature;
    }
}