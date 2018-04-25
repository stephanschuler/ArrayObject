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

    public static function toCountable(array $data): array
    {
        return array_map(function($value) {
            return is_string($value) || is_numeric($value) ? $value : (string)$value;
        }, $data);

    }
}