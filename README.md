[![Build Status](https://travis-ci.org/Tohmua/Consolidare.svg?branch=master)](https://travis-ci.org/Tohmua/Consolidare)

# Consolidare
This tool tries to make merging multiple "things" of any type easy and automated in an (hopefully) less opinionated fashion.

### Install
`composer require tohmua/consolidare`

### Use
```PHP
$merge = new Consolidare\Merge();

$merge->data('{"id": 10}');
$merge->data(['name' => 'foo', 'email' => 'bar']);
$merge->data(['email' => 'test@test.com']);

$result = $merge->merge(Consolidare\MergeStrategy\MergeStrategyFactory::basic());

$result->retrieve(new Consolidare\ReturnType\Type\ToArray);
// ['id' => 10, 'name' => 'foo', 'email' => 'test@test.com']
```

### Wiki
More info is available in the [Wiki](https://github.com/Tohmua/Consolidare/wiki)

### Tests
To run: `composer test`

The code coverage report can be found in `tests/_output` however this is git ignored but it will be generated automatically for you when you run the test suite.
