<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Rsa;

use IdentityLayer\Core\Jose\Jwa\RS;
use IdentityLayer\Jose\AlgorithmName;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Exception\SigningException;
use IdentityLayer\Jose\Jwk\KeyPair;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;
use ParagonIE\ConstantTime\Base64UrlSafe;
use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;

class PrivateKey implements KeyPair
{
    private $keyResource;
    private string $modulus;
    private string $publicExponent;
    private string $privateExponent;
    private string $prime1;
    private string $prime2;
    private string $dmp1;
    private string $dmq1;
    private string $iqmp;

    private function __construct(string $pemEncodedKey)
    {
        $resource = openssl_pkey_get_private($pemEncodedKey);

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
        $this->privateExponent = $details['rsa']['d'];
        $this->prime1 = $details['rsa']['p'];
        $this->prime2 = $details['rsa']['q'];
        $this->dmp1 = $details['rsa']['dmp1'];
        $this->dmq1 = $details['rsa']['dmq1'];
        $this->iqmp = $details['rsa']['iqmp'];
    }

    public static function fromPrivateKeyPemEncoded(string $privateKeyPemEncoded): PrivateKey
    {
        return new PrivateKey($privateKeyPemEncoded);
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

    public function getVerificationKey(): VerificationKey
    {
        return PublicKey::fromPublicKeyPemEncoded();
    }

    public function sign(AlgorithmName $algorithmName, string $message): string
    {
        $signature = null;
        $result = openssl_sign(
            $message,
            $signature,
            $this->keyResource,
            "RSA-{$algorithmName->hashingAlgorithm()}"
        );

        if ($result === false || $signature === null) {
            throw new SigningException('An unexpected error occured while attempting to sign ' .
                'message with private key.');
        }

        return $signature;
    }

    public function verify(AlgorithmName $algorithmName, string $message, string $signature): bool
    {
        return $this->sign($algorithmName, $message) === $signature;
    }
}