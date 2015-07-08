<?php

namespace HHI\Definition;

use ReflectionClass;

/**
 * @property \ReflectionClass $reflection
 */
class ClassDefinition extends AbstractDefinition {

    protected $wrap = true;

    public function __construct(ReflectionClass $reflection) {
        $this->reflection = $reflection;
    }

    public function __toString() {
        $class = $this->reflection;
        $parent = $class->getParentClass();

        // Modifiers
        $modifiers = '';

        if (!$class->isTrait() && !$class->isInterface()) {
            if ($class->isAbstract()) {
                $modifiers .= 'abstract ';
            } else if ($class->isFinal()) {
                $modifiers .= 'final ';
            }
        }

        if ($class->isTrait()) {
            $modifiers .= 'trait';
        } else if ($class->isInterface()) {
            $modifiers .= 'interface';
        } else {
            $modifiers .= 'class';
        }

        // Extends
        $extends = $parent ? sprintf('extends %s', $parent->getName()) : '';

        // Implements
        $implements = '';

        if ($interfaces = $class->getInterfaceNames()) {
            $interfaces = array_diff($interfaces, $parent ? $parent->getInterfaceNames() : []);

            if ($interfaces) {
                $implements = sprintf(' implements %s', implode(', ', $interfaces));
            }
        }

        // Uses
        $uses = '';

        if ($traits = $class->getTraitNames()) {
            $uses = sprintf("  use %s;\n", implode(', ', $traits));
        }

        // Constants
        $constants = [];

        foreach ($class->getConstants() as $constant => $value) {
            if (!$parent || !$parent->hasConstant($constant)) {
                $constants[$constant] = (new ConstantDefinition($constant, $value))->indent(2);
            }
        }

        // Properties
        $properties = [];

        foreach ($class->getProperties() as $property) {
            if (!$parent || !$parent->hasProperty($property->getName())) {
                $properties[$property->getName()] = (new PropertyDefinition($property))->indent(2);
            }
        }

        ksort($properties);

        // Methods
        $methods = [];

        foreach ($class->getMethods() as $method) {
            if (!$parent || !$parent->hasMethod($method->getName())) {
                $methods[$method->getName()] = (new MethodDefinition($method))->indent(2);
            }
        }

        ksort($methods);

        // Body
        $body = array_filter([
            'uses' => $uses,
            'constants' => implode("\n", $constants),
            'properties' => implode("\n", $properties),
            'methods' => implode("\n", $methods)
        ]);

        return $this->renderNamespace($this->render("{modifiers} {name} {extends} {implements} {\n{body}\n}", [
            'modifiers' => $modifiers,
            'name' => $class->getShortName(),
            'extends' => $extends,
            'implements' => $implements,
            'body' => implode("\n", $body)
        ]));
    }

    public function renderNamespace($body) {
        if ($this->wrap) {

        }

        return $body;
    }

    public function wrapNamespace($status) {
        $this->wrap = (bool) $status;

        return $this;
    }

}
