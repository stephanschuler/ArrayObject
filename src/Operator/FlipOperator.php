<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class FlipOperator extends AbstractOperator
{
    public static function flip(array $data): array
    {
        return array_flip($data);
    }
}