<?php

namespace HHI\Definition;

use ReflectionFunction;

/**
 * @property \ReflectionFunction $reflection
 */
class FunctionDefinition extends AbstractDefinition {

    public function __construct(ReflectionFunction $reflection) {
        $this->reflection = $reflection;
    }

    public function __toString() {
        $params = array_map(function($param) {
            return new ParamDefinition($param);
        }, $this->reflection->getParameters());

        return $this->render('function {name}({params}) {}', [
            'name' => $this->reflection->getShortName(),
            'params' => new ParamListDefinition(...$params)
        ]);
    }

}
