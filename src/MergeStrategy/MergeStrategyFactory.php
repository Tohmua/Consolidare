<?php

namespace Consolidare\MergeStrategy;

use Consolidare\MergePatterns\Right;
use Consolidare\MergeStrategy\MergeStrategy;
use Consolidare\RecordFields\Field;

class MergeStrategyFactory
{
    public static function basic()
    {
        return new MergeStrategy(new Right);
    }

    /**
     * $config = [
     *     'fields' => [
     *         'field_1' => Consolidare\MergePatterns\Right::class,
     *         'field_2' => Consolidare\MergePatterns\Right::class,
     *         'field_3' => self::createFromArray([
     *             'fields' => [
     *                 'field_1' => Consolidare\MergePatterns\Right::class,
     *                 'field_2' => Consolidare\MergePatterns\Right::class,
     *             ],
     *             'default' =>  Consolidare\MergePatterns\Right::class,
     *         ]),
     *     ],
     *     'default' =>  Consolidare\MergePatterns\Right::class,
     * ];
     * @param  array  $config [description]
     * @return [type]         [description]
     */
    public static function fromArray(array $config)
    {
        if (static::validateConfigArray($config)) {
            throw new InvalidConfigArrayException();
        }

        $mergeStrategy = new MergeStrategy(
            isset($config['default']) ? new $config['default'] : NULL
        );

        array_walk($config['fields'], function ($pattern, $field) use ($mergeStrategy) {
            if (!$pattern instanceof MergeStrategy) {
                $pattern = new $pattern;
            }

            $mergeStrategy->specific(
                new Field($field),
                $pattern
            );
        });

        return $mergeStrategy;
    }

    private static function validateConfigArray(array $config)
    {
        if (isset($config['default']) && !$config['default'] instanceof MergeStrategy) {
            return false;
        }

        array_walk($config['fields'], function ($pattern, $field) {
            if (!$pattern instanceof MergeStrategy) {
                return false;
            }
        });

        return true;
    }
}
