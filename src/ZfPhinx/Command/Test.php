<?php

namespace ZfPhinx\Command;

use Phinx\Console\Command\Test as TestPrototype;
use Phinx\Migration\Manager\Environment;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 'Test' command implementation
 */
class Test extends TestPrototype
{
    /**
     * Verify configuration file
     *
     * @param  InputInterface            $input
     * @param  OutputInterface           $output
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->loadManager($input, $output);

        $this->verifyMigrationDirectory($this->getConfig()->getMigrationPath());

        $envName = $input->getOption('environment');
        if ($envName) {
            if (!$this->getConfig()->hasEnvironment($envName)) {
                throw new \InvalidArgumentException(sprintf(
                    'The environment "%s" does not exist',
                    $envName
                ));
            }

            $output->writeln(sprintf('<info>validating environment</info> %s', $envName));
            $environment = new Environment(
                $envName,
                $this->getConfig()->getEnvironment($envName)
            );
            // validate environment connection
            $environment->getAdapter()->connect();
        }

        $output->writeln('<info>success!</info>');
    }
}
