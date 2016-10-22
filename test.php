<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    $merge = new RecordMerge\RecordMerge(RecordMerge\Config\Config::loadConfig());

    $merge->addData([
            'id'    => 10,
            'name'  => 'foo1',
            'email' => 'bar1',
            'monkey'=> 'dave',
        ])->addData('{
            "id": 20,
            "name": "foo2",
            "email": "bar2"
        }')->addMergable(new RecordMerge\Mergable\Type\MergableArray([
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
    $mergeStrategy = new RecordMerge\MergeStrategy\MergeStrategy();
    $mergeStrategy->specific(
        new RecordMerge\RecordFields\Field('id'),
        new RecordMerge\MergePatterns\Add()
    )->specific(
        new RecordMerge\RecordFields\Field('name'),
        new RecordMerge\MergePatterns\Concat()
    );
    $newRecord = $merge->merge($mergeStrategy);
    var_dump($newRecord->retrieve());
} catch (RecordMerge\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    echo 'Revert once: ' . PHP_EOL;
    $back1 = $newRecord->revert();
    var_dump($back1->retrieve());
} catch (RecordMerge\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    echo 'Revert twice: ' . PHP_EOL;
    $back2 = $back1->revert();
    var_dump($back2->retrieve());
} catch (RecordMerge\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    echo 'Revert thrice: ' . PHP_EOL;
    $back3 = $back2->revert();
    var_dump($back3->retrieve());
} catch (RecordMerge\Record\Exception\RecordException $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}

