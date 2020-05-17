<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use AlvinChevolleaux\Collection\Exception\InvalidTypeException;
use AlvinChevolleaux\Collection\ImmutableSet;

class ClaimCollection extends ImmutableSet
{
    public static function T(): string
    {
        return Claim::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof Claim || !$item2 instanceof Claim) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', User::class)
            );
        }

        return ($item1->getKey() === $item2->getKey() && $item1->getValue() === $item2->getValue());
    }
}