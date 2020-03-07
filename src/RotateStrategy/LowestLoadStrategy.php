<?php declare(strict_types=1);

namespace LoadBalancer\RotateStrategy;

use LoadBalancer\Model\Api\HostInstanceInterface;
use LoadBalancer\Model\StrategyInterface;

class LowestLoadStrategy extends AbstractStrategy implements StrategyInterface
{
    private const HIGH_LOAD = 0.75;

    public function getNextHost(): HostInstanceInterface
    {
        if(empty($this->hosts)) {
            throw new \LengthException('Empty host lists');
        }

        return $this->getNext();
    }

    private function getNext(): HostInstanceInterface
    {
        $isHostsOnHighLoad = empty(
            array_filter(
                $this->hosts,
                fn (HostInstanceInterface $hostInstance) => $hostInstance->getLoad() > self::HIGH_LOAD
            )
        );

        if($isHostsOnHighLoad) {
            return $this->getLowestLoad();
        }

        return $this->getFirstUnder75percentLoad();
    }

    private function getLowestLoad(): HostInstanceInterface
    {
        $lowestLoadPosition = 0;
        $this->sortHostFromLowestToHighestLoad();

        return $this->hosts[$lowestLoadPosition];
    }

    private function getFirstUnder75percentLoad(): HostInstanceInterface
    {
        foreach($this->hosts as $host) {
            if($host->getLoad() < self::HIGH_LOAD) {
                return $host;
            }
        }

        throw new \LogicException('Unexpected hosts, nothing to return');
    }

    private function sortHostFromLowestToHighestLoad(): void
    {
        usort($this->hosts, function(HostInstanceInterface $host1, HostInstanceInterface $host2) {
            return ($host1->getLoad() < $host2->getLoad()) ? -1 : 1 ;
        });
    }
}