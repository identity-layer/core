<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Jwk\Hmac;

use IdentityLayer\Jose\Exception\InvalidArgumentException;

final class Hmac256 extends HmacKeyAbstract
{
    protected function __construct(string $kid, string $key)
    {
        if (strlen($key) < 32) {
            throw new InvalidArgumentException('HMAC key must be at least 256bits');
        }

        parent::__construct($kid, $key);
    }
}