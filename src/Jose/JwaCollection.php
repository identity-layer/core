<?php

declare(strict_types=1);

namespace IdentityLayer\Core\Jose;

class JwaCollection implements JwaCollectionInterface
{
    private $items;

    public function items(): array
    {
        // TODO: Implement items() method.
    }

    public function withItem(Jwa $jwa): JwaCollectionInterface
    {
        // TODO: Implement withItem() method.
    }

    public static function fromArray(array $items): JwaCollectionInterface
    {
        // TODO: Implement fromArray() method.
    }
}