# The Map operators


## AryO\ArrayObject::map()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::map(callable $transform)
````

Returns only those data of the input stream found in the values of the `$intersectWith` array.

Example code:
````php
AryO\Operator\MapOperator::register();

$data = AryO\ArrayObject::fromArray([1, 2, 3, 4, 5, 6, 7])
    ->map(function($element) {
        return $element * $element;
    });

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => 1
    [1] => 4
    [2] => 9
    [3] => 16
    [4] => 25
    [5] => 36
    [6] => 49
)
````


## AryO\ArrayObject::column()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::column($column, $indexKey = null)
````

Maps every incoming data to one of its array properties.

Example code:
````php
AryO\Operator\MapOperator::register();

$data = AryO\ArrayObject::fromArray([
        [
            'id' => '#1',
            'name' => 'foo',
        ],
        [
            'id' => '#2',
            'name' => 'bar',
        ],
        [
            'id' => '#3',
            'name' => 'baz',
        ]
    ])
    ->column('name', 'id');

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [#1] => foo
    [#2] => bar
    [#3] => baz
)
````


## AryO\ArrayObject::toString()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::toString()
````

Shorthand for:
````php
$arrayObject->map(function($data) {
    return (string)$data;
});
````


## AryO\ArrayObject::toInt()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::toInt()
````

Shorthand for:
````php
$arrayObject->map(function($data) {
    return (int)$data;
});
````


## AryO\ArrayObject::toBool()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::toBool()
````

Shorthand for:
````php
$arrayObject->map(function($data) {
    return (bool)$data;
});
````


## AryO\ArrayObject::negate()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::negate()
````

Shorthand for:
````php
$arrayObject->map(function($data) {
    return !$data;
});
````