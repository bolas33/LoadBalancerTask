<?php declare(strict_types=1);

namespace LoadBalancer;

use LoadBalancer\Fake\Request;
use LoadBalancer\Model\Api\HostInstanceInterface;
use LoadBalancer\Model\StrategyInterface;

class LoadBalancer
{
    /**
     * @var HostInstanceInterface[]
     */
    private array $hostInstances;

    private StrategyInterface $strategy;

    /**
     * @param HostInstanceInterface[] $hostInstances
     */
    public function __construct(array $hostInstances, StrategyInterface $strategy)
    {
        $this->hostInstances = $hostInstances;
        $this->strategy = $strategy;
    }

    public function handleRequest(Request $request): void
    {
        $this->strategy->setHosts($this->hostInstances);
        $host = $this->strategy->getNextHost();
        $host->handleRequest($request);
    }
}