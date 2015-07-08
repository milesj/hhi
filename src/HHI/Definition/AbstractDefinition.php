<?php

namespace HHI\Definition;

class AbstractDefinition {

    protected $indent = 0;

    protected $reflection;

    public function getReflection() {
        return $this->reflection;
    }

    public function indent($amount) {
        $this->indent = (int) $amount;

        return $this;
    }

    public function render($format, array $args) {
        foreach ($args as $key => $arg) {
            $format = str_replace('{' . $key . '}', (string) $arg, $format);
        }

        $format = preg_replace("/(?<!\n) {2,}/", ' ', $format);
        $format = preg_replace("/\n{3,}/", "\n\n", $format);

        return str_repeat(' ', $this->indent) . trim($format);
    }

}
