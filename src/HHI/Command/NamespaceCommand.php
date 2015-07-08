<?php

namespace HHI\Command;

use HHI\Definition\NamespaceDefinition;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NamespaceCommand extends Command {

    protected function configure() {
        $this
            ->setName('namespace')
            ->setDescription('Generate constant, function, and class definitions from within a namespace')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the namespace');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln((string) new NamespaceDefinition($input->getArgument('name')));
    }

}
