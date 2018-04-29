# The Sort operators


Sorting is pretty bad on data streams. It requires consuming the whole data set, thus loading it in memory
as a whole. So sorting should be avoided if possible.

Since sorting internally works on an `\ArrayIterator`, having multiple items with the same key is not supported.

See: http://php.net/manual/en/arrayiterator.natsort.php


## AryO\ArrayObject::natsort()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::natsort()
````

Natural sorting.

Example code:
````php
AryO\Operator\SortOperator::register();

$data = AryO\ArrayObject::fromArray(['100 banans', '5 apples', '40 kiwis'])
    ->natsort();

print_r($data->getArrayCopy());
````

Result:
````
Array
(
    [1] => 5 apples
    [2] => 40 kiwis
    [0] => 100 banans
)
````


## AryO\ArrayObject::asort()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::asort()
````

Regular sorting by value.

See: http://php.net/manual/en/arrayiterator.asort.php


## AryO\ArrayObject::ksort()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::ksort()
````

Sort by key.

See: http://php.net/manual/en/arrayiterator.ksort.php


## AryO\ArrayObject::uasort()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::uasort(callable $compare)
````

Sort by value according to `$compare` function.

See: http://php.net/manual/en/arrayiterator.uasort.php


## AryO\ArrayObject::uksort()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::uksort(callable $compare)
````

Sort by key according to `$compare` function.

See: http://php.net/manual/en/arrayiterator.uksort.php