<?php declare(strict_types=1);

namespace LoadBalancer\RotateStrategy;

use LoadBalancer\Fake\DataStore;
use LoadBalancer\Model\Api\HostInstanceInterface;
use LoadBalancer\Model\StrategyInterface;

class RoundRobinStrategy extends AbstractStrategy implements StrategyInterface
{
    private int $lastHost;

    private DataStore $store;

    public function __construct(DataStore $store)
    {
        $this->store = $store;
    }

    public function getNextHost(): HostInstanceInterface
    {
        if(empty($this->hosts)) {
            throw new \LengthException('Empty host lists');
        }

        return $this->getNext();
    }

    private function getNext(): HostInstanceInterface
    {
        $this->loadState();
        $this->lastHost = isset($this->hosts[$this->lastHost+1]) ? $this->lastHost + 1 : 0;
        $this->saveState();

        return $this->hosts[$this->lastHost];
    }

    private function saveState()
    {
        $this->store->save($this->lastHost);
    }

    private function loadState()
    {
        $this->lastHost = $this->store->get();
    }
}