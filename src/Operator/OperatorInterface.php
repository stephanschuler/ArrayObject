<?php
declare(strict_types=1);

namespace StephanSchuler\ArrayObject\Operator;

use StephanSchuler\ArrayObject\Exception\RedeclareMethodException;

interface OperatorInterface
{
    /**
     * Makes a certain Operator known to the ArrayObject in order to have
     * all the Operators methods being available as operator methods.
     *
     * @throws RedeclareMethodException
     */
    public static function register();
}