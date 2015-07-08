<?php

namespace HHI\Command;

use HHI\Definition\ExtensionDefinition;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ReflectionExtension;

class ExtensionCommand extends Command {

    protected function configure() {
        $this
            ->setName('extension')
            ->setDescription('Generate constant, function, and class definitions from an extension')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the extension');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln((string) new ExtensionDefinition(new ReflectionExtension($input->getArgument('name'))));
    }

}
