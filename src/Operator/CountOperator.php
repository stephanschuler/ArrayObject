<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class CountOperator extends AbstractOperator implements OperatorInterface
{
    public static function countValues(Traversable $data): Generator
    {
        $distinct = [];
        foreach ($data as $key => $value) {
            if (!isset($distinct[$value])) {
                $distinct[$value] = 0;
            }
            $distinct[$value]++;
        }
        yield from $distinct;

    }
}