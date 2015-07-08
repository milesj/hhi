<?php

namespace HHI\Definition;

use HHI\Type;
use ReflectionParameter;
use Exception;

/**
 * @property \ReflectionParameter $reflection
 */
class ParamDefinition extends AbstractDefinition {

    public function __construct(ReflectionParameter $reflection) {
        $this->reflection = $reflection;
    }

    public function __toString() {
        $param = $this->reflection;

        // Type
        $type = '';

        if ($param->isArray()) {
            $type = 'array';
        } else if ($param->isCallable()) {
            $type = 'callable';
        } else if ($class = $param->getClass()) {
            $type = $class->getName();
        }

        if ($type && $param->allowsNull()) {
            $type = '?' . $type;
        }

        // Name
        $name = '';

        if ($param->isPassedByReference()) {
            $name .= '&';
        }

        if ($param->isVariadic()) {
            $name .= '...';
        }

        $name .= '$' . $param->getName();

        // Default value
        $default = '';

        if ($param->isOptional()) {
            $default = ' = ';

            try {
                if ($value = $param->getDefaultValueConstantName()) {
                    $default .= $value;
                } else {
                    $default .= Type::getLiteralValue($param->getDefaultValue());
                }

            } catch (Exception $e) {
                if ($param->isArray()) {
                    $default .= '[]';
                } else {
                    $default .= 'null';

                    if ($type && $type[0] !== '?') {
                        $type = '?' . $type;
                    }
                }
            }
        }

        return $this->render('{type} {name}{default}', [
            'type' => $type,
            'name' => $name,
            'default' => $default
        ]);
    }

}
