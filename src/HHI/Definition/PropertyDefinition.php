<?php

namespace HHI\Definition;

use HHI\Type;
use ReflectionProperty;

/**
 * @property \ReflectionProperty $reflection
 */
class PropertyDefinition extends AbstractDefinition {

    public function __construct(ReflectionProperty $reflection) {
        $this->reflection = $reflection;
    }

    public function __toString() {
        $prop = $this->reflection;
        $name = $prop->getName();

        // Modifiers
        $modifiers = '';

        if ($prop->isPrivate()) {
            $modifiers .= 'private ';
        } else if ($prop->isProtected()) {
            $modifiers .= 'protected ';
        } else {
            $modifiers .= 'public ';
        }

        if ($prop->isStatic()) {
            $modifiers .= 'static ';
        }

        // Default value
        $default = '';
        $propValues = $prop->getDeclaringClass()->getDefaultProperties();

        if (isset($propValues[$name])) {
            $default = ' = ' . Type::getLiteralValue($propValues[$name]);
        }

        return $this->render('{modifiers} ${name}{default};', [
            'modifiers' => $modifiers,
            'name' => $name,
            'default' => $default
        ]);
    }

}
