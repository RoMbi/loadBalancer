<?php

namespace LoadBalancerBundle\Tests\Unit\LoadBalancer;

use App\Component\Host;
use App\Component\Request;
use App\Entity\Variant;
use App\Dictionary\Variant as VariantDictionary;
use App\Service\LoadBalancer;
use PHPUnit\Framework\TestCase;

/**
 * Test LoadBalancer
 *
 * @codeCoverageIgnore
 */
class LoadBalancerTest extends TestCase
{
    /**
     * @dataProvider halfLoadedHostsDataProvider
     */
    public function testSequentiallyVariantLoad($hosts): void
    {
        $variant = new Variant();
        $variant->setId(VariantDictionary::SEQUENTIALLY);
        $loadBalancer = new LoadBalancer($hosts, $variant);
        /** every Host->handleRequest should be called once (as set in data provider)*/
        foreach ($hosts as $host) {
            $loadBalancer->handleRequest(new Request());
        }
    }

    /**
     * @dataProvider almostThreeFourthLoadedHostsDataProvider
     */
    public function testThreeFourthPercentVariantLoad($hosts): void
    {
        $variant = new Variant();
        $variant->setId(VariantDictionary::LOAD_75_PERCENT);
        $loadBalancer = new LoadBalancer($hosts, $variant);
        /** first one should be handled twice (as set in data provider) - it's below 0.75 */
        foreach ($hosts as $host) {
            $loadBalancer->handleRequest(new Request());
        }
    }

    /**
     * @dataProvider halfLoadedHostsDataProvider
     */
    public function testGetHostsReturnsArray($hosts): void
    {
        $this->expectExceptionMessage('Load balancer - incorrect variant.');

        $variant = new Variant();
        $variant->setId(0);
        $loadBalancer = new LoadBalancer($hosts, $variant);

        $this->assertInternalType('array', $loadBalancer->getHosts());
    }

    public function testNoHosts(): void
    {
        $this->expectExceptionMessage('Load balancer - no hosts to load');

        $variant = new Variant();
        $variant->setId(VariantDictionary::SEQUENTIALLY);
        $loadBalancer = new LoadBalancer(array(), $variant);
        $loadBalancer->handleRequest(new Request());
    }

    /**
     * @dataProvider halfLoadedHostsDataProvider
     */
    public function testBadVariant($hosts): void
    {
        $this->expectExceptionMessage('Load balancer - incorrect variant.');

        $variant = new Variant();
        $variant->setId(0);
        $loadBalancer = new LoadBalancer($hosts, $variant);

        $loadBalancer->handleRequest(new Request());
    }

    public function halfLoadedHostsDataProvider(): array
    {
        for ($i = 0; $i <= 4; $i++) {
            $hostMock = $this->getMockBuilder(Host::class)
                ->getMock();

            $hostMock
                ->expects($this->any())
                ->method('getLoad')
                ->willReturn(0.5);
            $hostMock
                ->expects($this->once())
                ->method('handleRequest')
                ->willReturn(null);
            $hosts[] = $hostMock;
        }
        return [
            [
                $hosts
            ]
        ];
    }

    public function halfAndFullLoadedHostsDataProvider(): array
    {
        $hostMock = $this->getMockBuilder(Host::class)
            ->getMock();

        $hostMock
            ->expects($this->any())
            ->method('getLoad')
            ->willReturn(0.74);
        $hostMock
            ->expects($this->exactly(2))
            ->method('handleRequest')
            ->willReturn(null);
        $hosts[] = $hostMock;

        $hostMock = $this->getMockBuilder(Host::class)
            ->getMock();

        $hostMock
            ->expects($this->any())
            ->method('getLoad')
            ->willReturn(1);
        $hostMock
            ->expects($this->never())
            ->method('handleRequest')
            ->willReturn(null);
        $hosts[] = $hostMock;

        return [
            [
                $hosts
            ]
        ];
    }

    public function almostThreeFourthLoadedHostsDataProvider(): array
    {
        $hostMock = $this->getMockBuilder(Host::class)
            ->getMock();

        $hostMock
            ->expects($this->any())
            ->method('getLoad')
            ->willReturn(0.7);
        $hostMock
            ->expects($this->exactly(2))
            ->method('handleRequest')
            ->willReturn(null);
        $hosts[] = $hostMock;

        $hostMock = $this->getMockBuilder(Host::class)
            ->getMock();

        $hostMock
            ->expects($this->any())
            ->method('getLoad')
            ->willReturn(0.8);
        $hostMock
            ->expects($this->never())
            ->method('handleRequest')
            ->willReturn(null);
        $hosts[] = $hostMock;

        return [
            [
                $hosts
            ]
        ];
    }
}
