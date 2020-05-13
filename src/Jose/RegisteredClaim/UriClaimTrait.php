<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose\RegisteredClaim;

use DateTimeImmutable;
use IdentityLayer\Core\Jose\RegisteredClaimEnum;
use Psr\Http\Message\UriInterface;

trait UriClaimTrait
{
    private RegisteredClaimEnum $type;
    private UriInterface $uri;

    private function __construct(RegisteredClaimEnum $type, UriInterface $uri)
    {
        $this->type = $type;

        try {
            $this->value = new Uri($timestamp);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Invalid timestamp.');
        }
    }

    public function getKey(): string
    {
        return $this->type->getValue();
    }

    public function getValue()
    {
        return (string) $this->uri;
    }

    public function type(): RegisteredClaimEnum
    {
        return $this->type;
    }
}