<?php

namespace ZfPhinx\Controller;

use Interop\Container\ContainerInterface;
use ZfPhinx\Service\ZfPhinxService;

class PhinxControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $serviceMock = $this->getMockBuilder(ZfPhinxService::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        $containerMock = $this->getMockBuilder(ContainerInterface::class)
            ->setMethods(['has', 'get'])
            ->getMock();

        $containerMock
            ->expects($this->once())
            ->method('get')
            ->with(ZfPhinxService::class)
            ->will($this->returnValue($serviceMock));

        $factory = new PhinxControllerFactory();

        $this->assertInstanceOf(PhinxController::class, $factory($containerMock));
    }
}
