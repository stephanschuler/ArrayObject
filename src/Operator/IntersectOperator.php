<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class IntersectOperator extends AbstractOperator implements OperatorInterface
{
    public static function intersect(Traversable $data, array $intersectWith = []): Generator
    {
        foreach ($data as $key => $value) {
            if (in_array($value, $intersectWith, true)) {
                yield $key => $value;
            }
        }
    }

    public static function intersectKey(Traversable $data, array $intersectWith = []): Generator
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $intersectWith, true)) {
                yield $key => $value;
            }
        }
    }

    public static function intersectAssoc(Traversable $data, array $intersectWith = []): Generator
    {
        foreach ($data as $key => $value) {
            if (array_search($value, $intersectWith) === $key) {
                yield $key => $value;
            }
        }
    }
}