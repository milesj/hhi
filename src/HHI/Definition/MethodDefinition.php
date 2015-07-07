<?php

namespace HHI\Definition;

use ReflectionMethod;

/**
 * @property \ReflectionMethod $reflection
 */
class MethodDefinition extends AbstractDefinition {

    public function __construct(ReflectionMethod $reflection) {
        $this->reflection = $reflection;
    }

    public function __toString() {
        $method = $this->reflection;
        $class = $method->getDeclaringClass();

        // Modifiers
        $modifiers = '';

        if (!$class->isInterface()) {
            if ($method->isFinal()) {
                $modifiers .= 'final ';
            } else if ($method->isAbstract()) {
                $modifiers .= 'abstract ';
            }
        }

        if ($method->isPrivate()) {
            $modifiers .= 'private ';
        } else if ($method->isProtected()) {
            $modifiers .= 'protected ';
        } else {
            $modifiers .= 'public ';
        }

        if ($method->isStatic()) {
            $modifiers .= 'static ';
        }

        // Parameters
        $params = array_map(function($param) {
            return new ParamDefinition($param);
        }, $method->getParameters());

        // Body
        if ($method->isAbstract() || $class->isInterface()) {
            $body = ';';
        } else {
            $body = ' {}';
        }

        return $this->render('{modifiers} function {name}({params}){body}', [
            'modifiers' => $modifiers,
            'name' => $method->getName(),
            'params' => new ParamListDefinition(...$params),
            'body' => $body
        ]);
    }

}
