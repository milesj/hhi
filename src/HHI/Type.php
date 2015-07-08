<?php

namespace HHI;

use RuntimeException;

class Type {

    public static function getTypeHint($value) {
        if (is_float($value)) {
            return 'float';

        } else if (is_bool($value)) {
            return 'bool';

        } else if (is_int($value)) {
            return 'int';

        } else if (is_array($value)) {
            return 'array';

        } else if (is_object($value)) {
            return get_class($value);

        } else if (!is_null($value) && !is_string($value)) {
            throw new RuntimeException('Unknown type [%s]', $value);
        }

        return 'string';
    }

    public static function getLiteralValue($value) {
        if (is_int($value) || is_float($value)) {
            return $value;

        } else if (is_bool($value)) {
            return $value ? 'true' : 'false';

        } else if (is_null($value)) {
            return 'null';

        } else if (is_array($value)) {
            return '[]';
        }

        return sprintf('"%s"', $value);
    }

}
