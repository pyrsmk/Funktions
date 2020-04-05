<?php

declare(strict_types=1);

namespace Funktions\GeneratorFuncs;

use Generator;

/**
 * Convert an array to a generator
 */
function array_to_generator (array $items): Generator
{
    yield from $items;
}

