<?php

namespace HHI\Definition;

use ReflectionClass;
use ReflectionFunction;

class NamespaceDefinition extends AbstractDefinition {

    protected $namespace;

    public function __construct($namespace) {
        $this->namespace = $namespace;
    }

    public function __toString() {
        $classmap = include __DIR__ . '/../../../vendor/composer/autoload_classmap.php';

        foreach ($classmap as $class => $path) {
            if (stripos($class, $this->namespace) === 0 && stripos($class, 'Test') === false) {
                class_exists($class, true);
            }
        }

        return $this->render("namespace {namespace} {\n\n{constants}\n\n{functions}\n\n{classes}\n\n}", [
            'namespace' => $this->namespace,
            'constants' => implode("\n", $this->findConstants()),
            'functions' => implode("\n", $this->findFunctions()),
            'classes' => implode("\n\n", $this->findClasses())
        ]);
    }

    protected function findClasses() {
        $classes = [];
        $namespace = $this->namespace;

        foreach ([get_declared_interfaces(), get_declared_traits(), get_declared_classes()] as $group) {
            foreach ($group as $class) {
                if (stripos($class, $namespace) === 0) {
                    $reflect = new ReflectionClass($class);

                    if ($reflect->getNamespaceName() === $namespace) {
                        $classes[$class] = (new ClassDefinition($reflect))->wrapNamespace(false);
                    }
                }
            }
        }

        ksort($classes);

        return $classes;
    }

    protected function findConstants() {
        $constants = [];
        $namespace = $this->namespace;
        $list = get_defined_constants(true);

        if (empty($list['user'])) {
            return $constants;
        }

        foreach ($list['user'] as $constant => $value) {
            if (stripos($constant, $namespace) === 0) {
                $constants[] = new ConstantDefinition($this->removeNamespace($constant), $value);
            }
        }

        return $constants;
    }

    protected function findFunctions() {
        $functions = [];
        $namespace = $this->namespace;

        foreach (get_defined_functions()['user'] as $function) {
            if (stripos($function, $namespace) === 0) {
                $reflect = new ReflectionFunction($function);

                if ($reflect->getNamespaceName() === $namespace) {
                    $functions[$function] = new FunctionDefinition($reflect);
                }
            }
        }

        ksort($functions);

        return $functions;
    }

    protected function removeNamespace($value) {
        return trim(str_replace(strtolower($this->namespace), '', $value), '\\');
    }

}
