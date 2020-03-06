<?php declare(strict_types=1);

namespace Tests;

use LoadBalancer\Fake\Request;
use LoadBalancer\LoadBalancerService;
use LoadBalancer\Model\StrategyInterface;
use PHPUnit\Framework\TestCase;

class LoadBalancerServiceTest extends TestCase
{
    public function testCanBeCreatedFromValidData(): void
    {
        $hosts = [];
        $loadBalancingAlgorithm = $this->getMockBuilder(StrategyInterface::class)->getMock();

        $this->assertInstanceOf(
            LoadBalancerService::class,
            new LoadBalancerService($hosts, $loadBalancingAlgorithm)
        );
    }

    public function testCanHandleRequest(): void
    {
        $hosts = [];
        $loadBalancingAlgorithm = $this->getMockBuilder(StrategyInterface::class)->getMock();
        $loadBalancer = new LoadBalancerService($hosts, $loadBalancingAlgorithm);
        $request = new Request();

        try {
            $loadBalancer->handleRequest($request);
        } catch ( \Exception $exception) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}
