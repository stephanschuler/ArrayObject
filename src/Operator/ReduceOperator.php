<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class ReduceOperator extends AbstractOperator
{
    public static function reduce(array $array, callable $transformation = null, $initial = null): array
    {
        return array_reduce($array, $transformation, $initial);
    }
}