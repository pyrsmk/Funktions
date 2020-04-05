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

/**
 * Ensure that the passed value will be a generator
 */
function ensure_generator ($maybe_a_generator): Generator
{
    if (!is_a($maybe_a_generator, Generator::class)) {
        yield from [];
        return $maybe_a_generator;
    }
    yield from $maybe_a_generator;
    return $maybe_a_generator->getReturn();
}
