<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Traversable;

class FlipOperator extends AbstractOperator implements OperatorInterface
{
    public static function flip(Traversable $data): Generator
    {
        foreach ($data as $key => $value) {
            yield $value => $key;
        }
    }

    public function values(Traversable $data): Generator
    {
        foreach ($data as $value) {
            yield $value;
        }
    }

    public function keys(Traversable $data): Generator
    {
        return self::values(FlipOperator::flip($data));
    }
}