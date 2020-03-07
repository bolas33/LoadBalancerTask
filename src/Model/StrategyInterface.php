<?php declare(strict_types=1);

namespace LoadBalancer\Model;

use LoadBalancer\Model\Api\HostInstanceInterface;

interface StrategyInterface
{
    /**
     * @param HostInstanceInterface[] $hostInstances
     */
    public function setHosts(array $hostInstances): void;
    public function getNextHost(): HostInstanceInterface;
}