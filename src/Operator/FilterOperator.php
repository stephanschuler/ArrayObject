<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class FilterOperator extends AbstractOperator
{
    public static function filter(array $data, callable $callback = null): array
    {
        return array_filter($data, $callback ?: function ($value) {
            return !!$value;
        });
    }
}