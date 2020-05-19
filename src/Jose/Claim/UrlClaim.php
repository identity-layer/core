<?php

declare(strict_types=1);

namespace IdentityLayer\Jose\Claim;

use IdentityLayer\Jose\Claim;
use IdentityLayer\Jose\Exception\InvalidArgumentException;

class UrlClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $url)
    {
        if (parse_url($url) === false) {
            throw new InvalidArgumentException(
                sprintf('%s is not a valid Url', $url)
            );
        }

        $this->key = $key;
        $this->value = $url;
    }

    public static function fromKeyValue(string $key, $value): Claim
    {
        return new static($key, $value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return (string) $this->value;
    }

    public function jsonSerialize()
    {
        return [
            $this->key => $this->value
        ];
    }
}