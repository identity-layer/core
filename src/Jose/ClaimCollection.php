<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Collection\Exception\InvalidTypeException;
use IdentityLayer\Collection\ImmutableSet;
use JsonSerializable;

class ClaimCollection extends ImmutableSet implements JsonSerializable
{
    public static function t(): string
    {
        return Claim::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof Claim || !$item2 instanceof Claim) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', Claim::class)
            );
        }

        return ($item1->getKey() === $item2->getKey() && $item1->getValue() === $item2->getValue());
    }

    public function jsonSerialize(): array
    {
        return $this->reduce(function ($carry, Claim $claim) {
            if ($carry === null) {
                $carry = [];
            }

            return array_merge($carry, $claim->jsonSerialize());
        });
    }
}
