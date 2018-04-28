<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use Generator;
use Iterator;

class FlipOperator extends AbstractOperator
{
    public static function flip(Iterator $data): Generator
    {
        foreach ($data as $key => $value) {
            yield $value => $key;
        }
    }

    public function values(Iterator $data): Generator
    {
        foreach ($data as $value) {
            yield $value;
        }
    }

    public function keys(Iterator $data): Generator
    {
        return self::values(FlipOperator::flip($data));
    }
}