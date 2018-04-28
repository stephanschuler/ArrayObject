<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Iterator;

class IntersectOperator extends AbstractOperator
{
    public static function intersect(Iterator $data, array $intersectWith = []): Generator
    {
        foreach ($data as $key => $value) {
            if (in_array($value, $intersectWith, true)) {
                yield $key => $value;
            }
        }
    }

    public static function intersectKey(Iterator $data, array $intersectWith = []): Generator
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $intersectWith, true)) {
                yield $key => $value;
            }
        }
    }

    public static function intersectAssoc(Iterator $data, array $intersectWith = []): Generator
    {
        foreach ($data as $key => $value) {
            if (array_search($value, $intersectWith) === $key) {
                yield $key => $value;
            }
        }
    }
}