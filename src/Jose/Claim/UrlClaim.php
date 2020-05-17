<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\Claim;

use IdentityLayer\Core\Jose\Claim;

class UrlClaim implements Claim
{
    private string $key;
    private string $value;

    private function __construct(string $key, string $url)
    {
        if (parse_url($uri) === false) {
            throw new \InvalidArgumentException(
                sprintf('%s is not a valid Url', $uri)
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