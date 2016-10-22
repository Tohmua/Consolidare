<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    $merge = new Consolidare\Merge(Consolidare\Config\Config::loadConfig());

    $merge->addData([
            'id'    => 10,
            'name'  => 'foo1',
            'email' => 'bar1',
            'monkey'=> 'dave',
        ])->addData('{
            "id": 20,
            "name": "foo2",
            "email": "bar2"
        }')->addMergable(new Consolidare\Mergable\Type\MergableArray([
            'id'    => 30,
            'name'  => 'foo3',
            'email' => 'bar3',
            'cow'   => 'phil',
        ]));
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

try {
    $mergeStrategy = new Consolidare\MergeStrategy\MergeStrategy();
    $mergeStrategy->specific(
        new Consolidare\RecordFields\Field('id'),
        new Consolidare\MergePatterns\Add()
    )->specific(
        new Consolidare\RecordFields\Field('name'),
        new Consolidare\MergePatterns\Concat()
    );
    $newRecord = $merge->merge($mergeStrategy);
    var_dump($newRecord->retrieve());
} catch (Consolidare\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    echo 'Revert once: ' . PHP_EOL;
    $back1 = $newRecord->revert();
    var_dump($back1->retrieve());
} catch (Consolidare\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    echo 'Revert twice: ' . PHP_EOL;
    $back2 = $back1->revert();
    var_dump($back2->retrieve());
} catch (Consolidare\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    echo 'Revert thrice: ' . PHP_EOL;
    $back3 = $back2->revert();
    var_dump($back3->retrieve());
} catch (Consolidare\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

