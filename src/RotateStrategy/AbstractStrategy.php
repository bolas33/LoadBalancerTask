<?php declare(strict_types=1);

namespace LoadBalancer\RotateStrategy;

use LoadBalancer\Model\Api\HostInstanceInterface;

abstract class AbstractStrategy
{
    /**
     * @var HostInstanceInterface[]
     */
    protected array $hosts;

    /**
     * @param HostInstanceInterface[] $hosts
     */
    public function setHosts(array $hosts): void
    {
        $this->hosts = $hosts;
    }

    public function addHost(HostInstanceInterface $host): void
    {
        $this->hosts[] = $host;
    }

    public function removeHost(HostInstanceInterface $host): void
    {
        foreach($this->hosts as $hostInstance) {
            if ($hostInstance->getUniqueId() === $host->getUniqueId()) {
                unset($this->hosts[$host->getUniqueId()]);
            }
        }
    }
}