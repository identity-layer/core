<?php

declare(strict_types=1);

namespace IdentityLayer\Jose;

use AlvinChevolleaux\Collection\Exception\InvalidTypeException;
use AlvinChevolleaux\Collection\ImmutableSet;

class JwaCollection extends ImmutableSet
{
    public static function T(): string
    {
        return Jwa::class;
    }

    public static function itemsEqual(object $item1, object $item2): bool
    {
        if (!$item1 instanceof Jwa || !$item2 instanceof Jwa) {
            throw new InvalidTypeException(
                sprintf('Both comparators must be of type %s', Jwa::class)
            );
        }

        return $item1->kid() === $item2->kid();
    }
}