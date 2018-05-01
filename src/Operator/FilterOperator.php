<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class FilterOperator extends AbstractOperator implements OperatorInterface
{
    public static function filter(Traversable $data, callable $compare = null): Generator
    {
        foreach ($data as $key => $value) {
            if (!$compare || $compare($value)) {
                yield $key => $value;
            }
        }
    }

    public static function distinctUntilChanged(Traversable $data, callable $compare = null): Generator
    {
        $lastItem = null;
        foreach ($data as $key => $value) {
            $comparable = $compare ? ($compare)($value) : $value;
            if ($comparable !== $lastItem) {
                yield $key => $value;
            }
            $lastItem = $comparable;
        }
    }
}