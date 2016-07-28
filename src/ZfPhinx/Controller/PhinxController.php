<?php

namespace ZfPhinx\Controller;

use Zend\Console\ColorInterface;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use ZfPhinx\Module;
use ZfPhinx\Service\ZfPhinxService;

/**
 * Phinx console controller
 */
class PhinxController extends AbstractConsoleController
{
    /**
     * Phinx service
     *
     * @var ZfPhinxService
     */
    private $phinxService;

    /**
     * @param ZfPhinxService $phinxService
     */
    public function __construct(ZfPhinxService $phinxService)
    {
        $this->phinxService = $phinxService;
    }

    /**
     * Runs 'Test' command
     *
     * @return void
     */
    public function testAction()
    {
        $this->writeModuleInfo();
        $this->getPhinxService()->runTestCommand($this->getArgvArray());
    }

    /**
     * Runs 'Create' command
     *
     * @return void
     */
    public function createAction()
    {
        $this->writeModuleInfo();
        $this->getPhinxService()->runCreateCommand($this->getArgvArray());
    }

    /**
     * Runs 'Migrate' command
     *
     * @return void
     */
    public function migrateAction()
    {
        $this->writeModuleInfo();
        $this->getPhinxService()->runMigrateCommand($this->getArgvArray());
    }

    /**
     * Runs 'Rollback' command
     *
     * @return void
     */
    public function rollbackAction()
    {
        $this->writeModuleInfo();
        $this->getPhinxService()->runRollbackCommand($this->getArgvArray());
    }

    /**
     * Runs 'Status' command
     *
     * @return void
     */
    public function statusAction()
    {
        $this->writeModuleInfo();
        $this->getPhinxService()->runStatusCommand($this->getArgvArray());
    }

    /**
     * Gets Phinx service
     *
     * @return ZfPhinxService
     */
    private function getPhinxService()
    {
        return $this->phinxService;
    }

    /**
     * Get console command arguments
     *
     * @return array
     */
    private function getArgvArray()
    {
        return (array) $this->getRequest()->getContent();
    }

    /**
     * Writes copyright & version into console
     *
     * @return void
     */
    private function writeModuleInfo()
    {
        $console = $this->getConsole();
        $console->write('ZfPhinx by Alexey Buyanov. ', ColorInterface::GREEN);
        $console->write('version: ', ColorInterface::WHITE);
        $console->writeLine(Module::MODULE_VERSION, ColorInterface::YELLOW);
    }
}
