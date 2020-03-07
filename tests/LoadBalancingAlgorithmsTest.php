<?php declare(strict_types=1);

namespace Tests;

use LoadBalancer\Fake\DataStore;
use LoadBalancer\Model\Api\HostInstanceInterface;
use LoadBalancer\RotateStrategy\LowestLoadStrategy;
use LoadBalancer\RotateStrategy\RoundRobinStrategy;
use PHPUnit\Framework\TestCase;

class LoadBalancingAlgorithmsTest extends TestCase
{
    /**
     * @var HostInstanceInterface[]
     */
    protected array $hosts;

    protected function setUp(): void
    {
        $this->hosts[] = $this->generateHost(1, 0.6);
        $this->hosts[] = $this->generateHost(2, 0.8);
        $this->hosts[] = $this->generateHost(3, 0.75);
    }

    public function testRoundRobinAlgorithm(): void
    {
        $strategy = new RoundRobinStrategy(new DataStore());
        $strategy->setHosts($this->hosts);

        $this->assertSame($this->hosts[0], $strategy->getNextHost());
        $this->assertSame($this->hosts[1], $strategy->getNextHost());
        $this->assertSame($this->hosts[2], $strategy->getNextHost());
        $this->assertSame($this->hosts[0], $strategy->getNextHost());
        $this->assertSame($this->hosts[1], $strategy->getNextHost());
    }

    public function testLowestLoadAlgorithm(): void
    {
        $strategy = new LowestLoadStrategy();
        $strategy->setHosts($this->hosts);

        $this->assertSame($this->hosts[0], $strategy->getNextHost());
        $this->assertSame($this->hosts[0], $strategy->getNextHost());
        $this->assertSame($this->hosts[0], $strategy->getNextHost());

        $this->generateHostLowerThan_0_75();
        $strategy->setHosts($this->hosts);
        $this->assertSame($this->hosts[0], $strategy->getNextHost());
        $this->assertSame($this->hosts[0], $strategy->getNextHost());
        $this->assertSame($this->hosts[0], $strategy->getNextHost());

        $this->generateHostsAbove_0_75();
        $strategy->setHosts($this->hosts);
        $this->assertSame($this->hosts[2], $strategy->getNextHost());
        $this->assertSame($this->hosts[2], $strategy->getNextHost());
        $this->assertSame($this->hosts[2], $strategy->getNextHost());
    }

    private function generateHostLowerThan_0_75(): void
    {
        $this->hosts = [];
        $this->hosts[] = $this->generateHost(1, 0.6);
        $this->hosts[] = $this->generateHost(2, 0.5);
        $this->hosts[] = $this->generateHost(3, 0.1);
    }

    private function generateHostsAbove_0_75(): void
    {
        $this->hosts = [];
        $this->hosts[] = $this->generateHost(1, 0.95);
        $this->hosts[] = $this->generateHost(2, 0.8);
        $this->hosts[] = $this->generateHost(3, 0.99);
    }

    private function generateHost(int $uniqueId, float $load)
    {
        $host = $this->getMockBuilder(HostInstanceInterface::class)->getMock();
        $host->method('getUniqueId')->willReturn($uniqueId);
        $host->method('getLoad')->willReturn($load);

        return $host;
    }
}
