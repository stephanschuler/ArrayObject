<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class FilterOperator extends AbstractOperator
{
    public static function filter(Traversable $data, callable $compare = null): Generator
    {
        foreach ($data as $key => $value) {
            if (!$compare || $compare($value)) {
                yield $key => $value;
            }
        }
    }
}