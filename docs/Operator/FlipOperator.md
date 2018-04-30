# The Flip operators

This operator collection is deals with keys and values.


## AryO\ArrayObject::flip()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::flip()
````

Swaps key and value for every element.

In contrast to the PHP build in "array_flip" operation, this does allow for multiple elements have the same key. So
flipping does not reduce the number of elements of the stream by reusing keys.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\FlipOperator::register();

$data = AryO\ArrayObject::fromArray(['a', 'b', 'b', 'b', 'c', 'b', 'b'])
    ->flip();

foreach ($data as $key => $value) {
    print_r(['key' => $key, 'value' => $value]);
}
````

Result:
````
Array
(
    [key] => a
    [value] => 0
)
Array
(
    [key] => b
    [value] => 1
)
Array
(
    [key] => b
    [value] => 2
)
Array
(
    [key] => b
    [value] => 3
)
Array
(
    [key] => c
    [value] => 4
)
Array
(
    [key] => b
    [value] => 5
)
Array
(
    [key] => b
    [value] => 6
)
````


## AryO\ArrayObject::values()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::values()
````

Returns only the values of the input data but reassigns new integer based indexes starting at 0.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\FlipOperator::register();

$data = AryO\ArrayObject::fromArray(['a' => 'b', 'c' => 'd', 'e' => 'f', 'g' => 'h'])
    ->values();

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => b
    [1] => d
    [2] => f
    [3] => b
)
````


## AryO\ArrayObject::keys()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::keys()
````

Returns only the keys of the input data as new value and reassigns keys based on integers starting at 0.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\FlipOperator::register();

$data = AryO\ArrayObject::fromArray(['a' => 'b', 'c' => 'd', 'e' => 'f', 'g' => 'h'])
    ->keys();

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [0] => a
    [1] => c
    [2] => e
    [3] => g
)
````