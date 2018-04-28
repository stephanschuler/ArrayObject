<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Iterator;

class FilterOperator extends AbstractOperator
{
    public static function filter(Iterator $data, callable $compare = null): Generator
    {
        foreach ($data as $key => $value) {
            if (!$compare || $compare($value)) {
                yield $key => $value;
            }
        }
    }
}