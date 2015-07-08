<?php

namespace HHI\Command;

use HHI\Definition\ClassDefinition;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ReflectionClass;

class ClassCommand extends Command {

    protected function configure() {
        $this
            ->setName('class')
            ->setDescription('Generate a class definition')
            ->addArgument('name', InputArgument::REQUIRED, 'Fully qualified name of the class');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln((string) new ClassDefinition(new ReflectionClass($input->getArgument('name'))));
    }

}
