<?php

namespace leafTracker\Helpers;

class Arr {

    public static function getHash(array $input) {
        array_multisort($input);

        return md5(json_encode($input));
    }

    public static function arrayMapRecursive(callable $func, array $array) {
        return filter_var($array, \FILTER_CALLBACK, ['options' => $func]);
    }

    public static function isAssoc(array $array) {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    public static function get(array $array, $key, $default = NULL) {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    public static function extract($array, array $keys, $default = NULL) {
        return array_filter($array, function ($item) use ($keys) {
                return in_array($item, $keys);
            }, ARRAY_FILTER_USE_KEY) + array_fill_keys($keys, $default);
    }

    public static function sortByColumn(array &$input, $column) {
        $sort = array_column($input, $column);

        array_multisort($sort, SORT_DESC, $input);
    }
}