<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class CountOperator extends AbstractOperator
{
    public static function count(array $data): array
    {
        return [count($data)];
    }

    public static function countValues(array $data): array
    {
        return array_count_values($data);
    }
}