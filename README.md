# Consolidare
This tool tries to make merging multiple "things" of any type easy and automated in an (hopefully) less opinionated fashion.

### Install
`composer require Tohmua/Consolidare`

### Use
```PHP
$merge = new Consolidare\Merge();

$merge->addData('{"id": 10}');
$merge->addData(['name' => 'foo', 'email' => 'bar']);
$merge->addData(['email' => 'test@test.com']);

$result = $merge->merge();

$result->retrieve(); // ['id' => 10, 'name' => 'foo', 'email' => 'test@test.com']
```

### Revert Merge
```PHP
$merge = new Consolidare\Merge();

$merge->addData('{"id": 10}');
$merge->addData(['name' => 'foo', 'email' => 'bar']);
$merge->addData(['email' => 'test@test.com']);

$result = $merge->merge();

$revert = $result->revert();
$revert->retrieve(); // ['id' => 10, 'name' => 'foo', 'email' => 'bar']
```

### Custom Merge Strategies
The default merge strategy will always merge over what is already there. Just like doing an `array_merge()`

However this can be over written by specifying a custom merge strategy.

This is added in as an optional parameter when calling `merge()`

```PHP
$merge = new Consolidare\Merge();

$merge->addData(['name' => 'Fr']);
$merge->addData(['name' => 'ank']);

$mergeStrategy = new Consolidare\MergeStrategy\MergeStrategy(
    new Consolidare\MergePatterns\Add
);

$result = $merge->merge($mergeStrategy);
$result->retrieve(); // ['name' => 'Frank']
```

### Types Of Merge Patterns
Any merge pattern can be passed into a `MergeStrategy` there are some provided:

- `Consolidare\MergePatterns\Add` Adds the values together
- `Consolidare\MergePatterns\Concat` Concatenates the values together
- `Consolidare\MergePatterns\Left` Uses the first value supplied for a field
- (default) `Consolidare\MergePatterns\Right` Uses the last value supplied for a field

However you can make your own by implementing the `Consolidare\MergePatterns\MergePattern` interface.

### Field Specific Merge Strategies
Some times you might want to have different merge patterns for different fields. e.g. the Age field you want to add, the name you want to keep the newest value and everything else you want to keep the original.

For this to work you need to specify a filed and the specific merge pattern you would like to apply to it.

```PHP
$merge = new Consolidare\Merge();

$merge->addData([
    'age' => 20,
    'name' => 'Jessica',
    'address' => '1234 Longhall, Northumberland'
]);
$merge->addData([
    'age' => 30,
    'name' => 'Barbra',
    'address' => '1235 Longhall, Northumberland'
]);

$mergeStrategy = new Consolidare\MergeStrategy\MergeStrategy(
    new Consolidare\MergePatterns\Left
);

$mergeStrategy->specific(
    new Consolidare\RecordFields\Field('age'),
    new Consolidare\MergePatterns\Add()
)->specific(
    new Consolidare\RecordFields\Field('name'),
    new Consolidare\MergePatterns\Right()
);

$result = $merge->merge($mergeStrategy);
$result->retrieve(); // ['age' => 50, 'name' => 'Barbra', 'address' => '1234 Longhall, Northumberland']
```

It is recommended that you either extend the `Consolidare\RecordFields\Field` class or implement the `Consolidare\RecordFields\RecordField` interface to better name your field objects.

### Tests
To run: `composer test`

The code coverage report can be found in `tests/_output` however this is git ignored but it will be generated automatically for you when you run the test suite.
