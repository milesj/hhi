<?php

namespace HHI\Definition;

use ReflectionExtension;

/**
 * @property \ReflectionExtension $reflection
 */
class ExtensionDefinition extends AbstractDefinition {

    public function __construct(ReflectionExtension $reflection) {
        $this->reflection = $reflection;
    }

    public function __toString() {
        $ext = $this->reflection;

        // Constants
        $constants = [];

        foreach ($ext->getConstants() as $constant => $value) {
            $constants[] = new ConstantDefinition($constant, $value);
        }

        // Functions
        $functions = [];

        foreach ($ext->getFunctions() as $name => $function) {
            $functions[$name] = new FunctionDefinition($function);
        }

        ksort($functions);

        // Classes
        $classes = [];

        foreach ($ext->getClasses() as $class) {
            $classes[$class->getName()] = new ClassDefinition($class);
        }

        ksort($classes);

        return $this->render("{constants}\n\n{functions}\n\n{classes}", [
            'constants' => implode("\n", $constants),
            'functions' => implode("\n", $functions),
            'classes' => implode("\n\n", $classes)
        ]);
    }

}
