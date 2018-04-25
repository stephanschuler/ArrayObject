<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

class IntersectOperator extends AbstractOperator
{
    public static function intersect(array $data, array $intersectWith = []): array
    {
        return array_intersect($data, $intersectWith);
    }

    public static function intersectKey(array $data, array $intersectWith = [], callable $compare = null): array
    {
        return $compare
            ? array_intersect_ukey($data, $intersectWith, $compare)
            : array_intersect_key($data, $intersectWith);
    }

    public static function intersectAssoc(array $data, array $intersectWith = [], callable $compare = null): array
    {
        return $compare
            ? array_intersect_uassoc($data, $intersectWith, $compare)
            : array_intersect_assoc($data, $intersectWith);
    }
}