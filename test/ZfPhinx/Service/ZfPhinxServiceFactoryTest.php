<?php

namespace ZfPhinx\Service;

use Interop\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Driver\ConnectionInterface;
use Zend\Db\Adapter\Driver\DriverInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfPhinx\Service\Exception\RuntimeException;

/**
 * Service factory unit test
 */
class ZfPhinxServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests main logic of __invoke method
     *
     * @return void
     */
    public function testInvoke()
    {
        $dbConnectionMock = $this
            ->getMockBuilder(ConnectionInterface::class)
            ->setMethods([])
            ->getMock();

        $dbDriverMock = $this
            ->getMockBuilder(DriverInterface::class)
            ->setMethods([])
            ->getMock();

        $dbDriverMock
            ->expects($this->once())
            ->method('getConnection')
            ->will($this->returnValue($dbConnectionMock));

        $dbAdapterMock = $this
            ->getMockBuilder(AdapterInterface::class)
            ->setMethods(['getDriver', 'getPlatform'])
            ->getMock();

        $dbAdapterMock
            ->expects($this->once())
            ->method('getDriver')
            ->will($this->returnValue($dbDriverMock));

        $containerMock = $this->getContainerMock();

        $containerMock
            ->expects($this->exactly(2))
            ->method('get')
            ->will(
                $this->returnValueMap(
                    [
                        ['Config', ['ZfPhinx' => ['environments' => ['test' => ['db_adapter' => 'AdapterName']]]]],
                        ['AdapterName', $dbAdapterMock],
                    ]
                )
            );

        $containerMock
            ->expects($this->once())
            ->method('has')
            ->with('AdapterName')
            ->will($this->returnValue(true));

        $factory = new ZfPhinxServiceFactory();

        $this->assertInstanceOf(ZfPhinxService::class, $factory($containerMock));
    }

    /**
     * Tests module config is not found exception
     *
     * @return void
     */
    public function testInvokeConfigNotFoundException()
    {
        $containerMock = $this->getContainerMock();

        $containerMock
            ->expects($this->once())
            ->method('get')
            ->with('Config')
            ->willReturn($this->anything());

        $this->setExpectedException(
            RuntimeException::class,
            'ZfPhinx config is not found'
        );

        $factory = new ZfPhinxServiceFactory();
        $factory($containerMock);
    }

    /**
     * Tests environment is not found in config exception
     *
     * @return void
     */
    public function testInvokeEnvironmentConfigNotFoundException()
    {
        $containerMock = $this->getContainerMock();

        $containerMock
            ->expects($this->once())
            ->method('get')
            ->with('Config')
            ->willReturn(['ZfPhinx' => []]);

        $this->setExpectedException(
            RuntimeException::class,
            'ZfPhinx environment config is not found'
        );

        $factory = new ZfPhinxServiceFactory();
        $factory($containerMock);
    }

    /**
     * Tests incorrect DB adapter in config exception
     *
     * @return void
     */
    public function testInvokeEnvironmentAdapterNotFoundException()
    {
        $containerMock = $this->getContainerMock();

        $containerMock
            ->expects($this->once())
            ->method('get')
            ->with('Config')
            ->willReturn(['ZfPhinx' => ['environments' => ['test' => ['db_adapter' => $this->anything()]]]]);

        $this->setExpectedException(
            RuntimeException::class,
            'Adapter for environment test is not found'
        );

        $factory = new ZfPhinxServiceFactory();
        $factory($containerMock);
    }

    /**
     * Tests DB Adapter is not implement interface exception
     *
     * @return void
     */
    public function testInvokeEnvironmentAdapterIsNotInstanceOfAdapterInterfaceException()
    {
        $containerMock = $this->getContainerMock();

        $containerMock
            ->expects($this->exactly(2))
            ->method('get')
            ->will(
                $this->returnValueMap(
                    [
                        ['Config', ['ZfPhinx' => ['environments' => ['test' => ['db_adapter' => 'AdapterName']]]]],
                        ['AdapterName', $this->anything()],
                    ]
                )
            );

        $containerMock
            ->expects($this->once())
            ->method('has')
            ->with('AdapterName')
            ->will($this->returnValue(true));

        $this->setExpectedException(
            RuntimeException::class,
            'Adapter for environment test must implement Zend\Db\Adapter\AdapterInterface; PHPUnit_Framework_Constraint_IsAnything given'
        );

        $factory = new ZfPhinxServiceFactory();
        $factory($containerMock);
    }

    /**
     * Gets service locator mock
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getContainerMock()
    {
        return $this
            ->getMockBuilder(ContainerInterface::class)
            ->setMethods(['has', 'get'])
            ->getMock();
    }
}
