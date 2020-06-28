<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Rsa;

use FG\ASN1\ASNObject;
use IdentityLayer\Jose\Exception\EncodingException;
use IdentityLayer\Jose\JwaFamilyEnum;
use IdentityLayer\Jose\JwaEnum;
use IdentityLayer\Jose\Exception\InvalidAlgorithmException;
use IdentityLayer\Jose\Exception\InvalidArgumentException;
use IdentityLayer\Jose\Exception\SigningException;
use IdentityLayer\Jose\Jwk\SigningKey;
use IdentityLayer\Jose\Jwk\VerificationKey;
use IdentityLayer\Jose\Util\Json;
use ParagonIE\ConstantTime\Base64UrlSafe;

final class PrivateKey implements SigningKey, VerificationKey
{
    /**
     * @var resource
     */
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
        $keyResource = openssl_pkey_get_private($pemEncodedKey);

        if ($keyResource === false) {
            throw new InvalidArgumentException('private key is not valid');
        }

        $details = openssl_pkey_get_details($keyResource);

        if ($details === false) {
            throw new InvalidArgumentException('Key is not an RSA public key');
        }

        $this->keyResource = $keyResource;
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

        return Base64UrlSafe::encodeUnpadded(
            hash('sha256', Json::encode($base), true)
        );
    }

    public function sign(JwaEnum $algorithmName, string $message): string
    {
        $this->validateAlgorithm($algorithmName);

        $signature = null;
        $result = openssl_sign(
            $message,
            $signature,
            $this->keyResource,
            $algorithmName->hashingAlgorithm()
        );

        if ($result === false || $signature === null) {
            throw new SigningException('An unexpected error occured while attempting to sign ' .
                'message with private key.');
        }

        return $signature;
    }

    public function verify(JwaEnum $algorithmName, string $message, string $signature): bool
    {
        return hash_equals($this->sign($algorithmName, $message), $signature);
    }

    public function validateAlgorithm(JwaEnum $algorithm): void
    {
        if (!$algorithm->family()->equals(JwaFamilyEnum::RS())) {
            throw new InvalidAlgorithmException(
                sprintf(
                    '%s is not a valid algorithm for use with an RSA key',
                    $algorithm->getValue()
                )
            );
        }
    }
}
