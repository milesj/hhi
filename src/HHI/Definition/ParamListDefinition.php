<?php

namespace HHI\Definition;

use ReflectionParameter;

/**
 * @property \ReflectionParameter[] $reflection
 */
class ParamListDefinition extends AbstractDefinition {

    public function __construct(...$reflections) {
        $this->reflection = $reflections;
    }

    public function __toString() {
        return implode(', ', $this->reflection);
    }

}
