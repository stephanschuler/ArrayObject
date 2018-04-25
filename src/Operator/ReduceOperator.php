<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class ReduceOperator extends AbstractOperator
{
    public static function reduce(array $data, callable $transformation = null, $initial = null): array
    {
        return array_reduce($data, $transformation, $initial);
    }
}