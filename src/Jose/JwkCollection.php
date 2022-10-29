<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use IdentityLayer\Collection\Exception\InvalidTypeException;
use IdentityLayer\Collection\ImmutableSet;

class JwkCollection extends ImmutableSet
{
    public static function t(): string
    {
        return Jwk::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof Jwk || !$item2 instanceof Jwk) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', Jwk::class)
            );
        }

        return $item1->kid() === $item2->kid() && get_class($item1) === get_class($item2);
    }
}
