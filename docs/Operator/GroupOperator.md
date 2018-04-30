# The Group operators

This operator collection don't actually `group by whatever` like known from databases. That would require
consuming all the data of the incoming `\Traversable`, thus loading all to the memory, before emitting
it again.


## AryO\ArrayObject::groupBatch()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::groupBatch(callable $compare, int $groupSize, int $numberOfGroups = PHP_INT_MAX)
````

The closest thing it gets to `group by whatever` like known from databases.

Groups are created by calculating a common group key via the `$compare` function argument.

This requires consuming the whole input `\Traversable` resulting in a huge memory footprint. To counteract, the
argument `$numberOfGroups` is suggested. The maximum amount of data is `$groupSize * $numberOfGroups`.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

$data = AryO\ArrayObject::fromArray([
        [
            'title' => 'Coca Cola',
            'price' => 6,
            'size' => '6 pack'
        ],
        [
            'title' => 'Coca Cola',
            'price' => 10,
            'size' => '12 pack'
        ],
        [
            'title' => 'Sprite',
            'price' => 10,
            'size' => '12 pack'
        ],
        [
            'title' => 'Coca Cola',
            'price' => 12,
            'size' => '18 pack'
        ]
    ])
    ->groupBatch(function ($product) {
        return $product['title'];
    }, PHP_INT_MAX);

print_r($data->getArrayCopy());
````

Result:

````
Array
(
    [Coca Cola] => Array
        (
            [0] => Array
                (
                    [title] => Coca Cola
                    [price] => 6
                    [size] => 6 pack
                )

            [1] => Array
                (
                    [title] => Coca Cola
                    [price] => 10
                    [size] => 12 pack
                )

            [3] => Array
                (
                    [title] => Coca Cola
                    [price] => 12
                    [size] => 18 pack
                )

        )

    [Sprite] => Array
        (
            [2] => Array
                (
                    [title] => Sprite
                    [price] => 10
                    [size] => 12 pack
                )

        )

)
````


## AryO\ArrayObject::groupSubsequent()

Description:
````php
\StephanSchuler\ArrayObject\ArrayObject \StephanSchuler\ArrayObject\ArrayObject::groupSubsequent(callable $compare, int $groupSize)
````

This one ony creates groups if elements of a single group are next to each other. If elements belonging to the
same group are separated by as little as a single other element, the result will be three different groups: Two
for the elements actually belonging to the same group and another group separating them.

The `$groupSize` argument limits the number of elements per group, which limits the maximum memory footprint.

The key of the result will be the discriminator value calculate by the compare function. So `getArrayCopy()` doesn't
work because it overwrites some value.

Example code:
````php
<?PHP
use StephanSchuler\ArrayObject as AryO;

AryO\Operator\GroupOperator::register();

$data = AryO\ArrayObject::fromArray([
        [
            'title' => 'Coca Cola',
            'price' => 6,
            'size' => '6 pack'
        ],
        [
            'title' => 'Coca Cola',
            'price' => 10,
            'size' => '12 pack'
        ],
        [
            'title' => 'Sprite',
            'price' => 10,
            'size' => '12 pack'
        ],
        [
            'title' => 'Coca Cola',
            'price' => 12,
            'size' => '18 pack'
        ]
    ])
    ->groupSubsequent(function ($product) {
        return $product['title'];
    }, PHP_INT_MAX);

foreach ($data as $key => $value) {
    print_r([$key => $value]);
}
````

Result:

````
Array
(
    [Coca Cola] => Array
        (
            [0] => Array
                (
                    [title] => Coca Cola
                    [price] => 6
                    [size] => 6 pack
                )

            [1] => Array
                (
                    [title] => Coca Cola
                    [price] => 10
                    [size] => 12 pack
                )

        )

)
Array
(
    [Sprite] => Array
        (
            [2] => Array
                (
                    [title] => Sprite
                    [price] => 10
                    [size] => 12 pack
                )

        )

)
Array
(
    [Coca Cola] => Array
        (
            [3] => Array
                (
                    [title] => Coca Cola
                    [price] => 12
                    [size] => 18 pack
                )

        )

)
````