<?php

namespace HHI\Definition;

use HHI\Type;

class ConstantDefinition extends AbstractDefinition {

    protected $name;

    protected $value;

    public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public function __toString() {
        $value = $this->value;

        return $this->render('const {type} {name} = {value};', [
            'type' => Type::getTypeHint($value),
            'name' => $this->name,
            'value' => ($value === null) ? '""' : Type::getLiteralValue($value)
        ]);
    }

}
