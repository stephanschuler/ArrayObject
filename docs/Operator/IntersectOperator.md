# The Intersect operators


## AryO\ArrayObject::intersect()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::intersect(array $intersectWith = [])
````

Returns only those data of the input stream found in the values of the `$intersectWith` array.

Example code:
````php
AryO\Operator\IntersectOperator::register();

$data = AryO\ArrayObject::fromArray(['a' =>'b', 'c' => 'd', 'e' => 'f'])
    ->intersect(['b', 'f']);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [a] => b
    [e] => f
)
````


## AryO\ArrayObject::intersectKey()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::intersectKey(array $intersectWith = [])
````

Returns only those data of the input stream whose keys are found in the values of the `$intersectWith` array.

Example code:
````php
AryO\Operator\IntersectOperator::register();

$data = AryO\ArrayObject::fromArray(['a' =>'b', 'c' => 'd', 'e' => 'f'])
    ->intersectKey(['c', 'a']);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [a] => b
    [c] => d
)
````


## AryO\ArrayObject::intersectAssoc()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::intersectAssoc(array $intersectWith = [])
````

Returns only those data of the input stream whose values are found in the values of the `$intersectWith` array
at the exact same key position.

Example code:
````php
AryO\Operator\IntersectOperator::register();

$data = AryO\ArrayObject::fromArray(['a' =>'b', 'c' => 'd', 'e' => 'f'])
    ->intersectAssoc(['c' => 'd', 'foo' => 'b']);

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [c] => d
)
````