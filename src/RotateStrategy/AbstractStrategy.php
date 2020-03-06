<?php declare(strict_types=1);

namespace LoadBalancer\RotateStrategy;

use LoadBalancer\Model\Api\HostInstanceInterface;

abstract class AbstractStrategy
{
    /**
     * @var HostInstanceInterface[]
     */
    protected array $hostInstances;

    /**
     * @param HostInstanceInterface[] $hostInstances
     */
    public function setHosts(array $hostInstances): void
    {
        $this->hostInstances = $hostInstances;
    }

    public function addHost(HostInstanceInterface $hostInstance): void
    {
        $this->hostInstances[] = $hostInstance;
    }

    public function removeHost(HostInstanceInterface $hostInstance): void
    {
        foreach($this->hostInstances as $host) {
            if ($host->getUniqueId() === $hostInstance->getUniqueId()) {
                unset($this->hostInstances[$hostInstance->getUniqueId()]);
            }
        }
    }
}