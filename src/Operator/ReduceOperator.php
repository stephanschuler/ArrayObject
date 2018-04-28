<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Iterator;

class ReduceOperator extends AbstractOperator
{
    public static function reduce(Iterator $data, callable $transform, $initial = null): Generator
    {
        $carry = $initial;
        foreach ($data as $key => $value) {
            $carry = $transform($carry, $value);
        }
        yield $carry;
    }
}