<?php

namespace ZfPhinx\Service;

use Phinx\Config\Config;
use Phinx\Console\Command\AbstractCommand;
use Phinx\Console\Command\Create;
use Phinx\Console\Command\Migrate;
use Phinx\Console\Command\Rollback;
use Phinx\Console\Command\Status;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use ZfPhinx\Command\Test;

/**
 * Phinx service
 */
class ZfPhinxService
{
    /**
     * Phinx application
     *
     * @var PhinxApplication
     */
    private $phinxApplication;

    /**
     * Phinx application config
     *
     * @var Config
     */
    private $config;

    /**
     * @param PhinxApplication $phinxApplication
     * @param Config           $config
     */
    public function __construct(PhinxApplication $phinxApplication, Config $config)
    {
        $this->phinxApplication = $phinxApplication;
        $this->config           = $config;
    }

    /**
     * Executes 'Test' command
     *
     * @param  array $argv
     * @return void
     */
    public function runTestCommand(array $argv)
    {
        $this->runNamedCommand(new Test(), $argv);
    }

    /**
     * Executes 'Crete' command
     *
     * @param  array $argv
     * @return void
     */
    public function runCreateCommand(array $argv)
    {
        $this->runNamedCommand(new Create(), $argv);
    }

    /**
     * Executes 'Migrate' command
     *
     * @param  array $argv
     * @return void
     */
    public function runMigrateCommand(array $argv)
    {
        $this->runNamedCommand(new Migrate(), $argv);
    }

    /**
     * Executes 'Rollback' command
     *
     * @param  array $argv
     * @return void
     */
    public function runRollbackCommand(array $argv)
    {
        $this->runNamedCommand(new Rollback(), $argv);
    }

    /**
     * Executes 'Status' command
     *
     * @param  array $argv
     * @return void
     */
    public function runStatusCommand(array $argv)
    {
        $this->runNamedCommand(new Status(), $argv);
    }

    /**
     * Executes given Phinx command
     *
     * @param  AbstractCommand $command
     * @param  array           $argv
     * @return void
     */
    private function runNamedCommand(AbstractCommand $command, array $argv)
    {
        $command->setConfig($this->config);

        $application = $this->getPhinxApplication();
        $application->add($command);
        $application->run(new ArgvInput($argv), new ConsoleOutput());
    }

    /**
     * Gets Phinx application
     *
     * @return PhinxApplication
     */
    private function getPhinxApplication()
    {
        return clone $this->phinxApplication;
    }
}
