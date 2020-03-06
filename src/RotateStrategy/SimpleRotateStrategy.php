<?php declare(strict_types=1);

namespace LoadBalancer\RotateStrategy;

use LoadBalancer\Model\Api\HostInstanceInterface;
use LoadBalancer\Model\StrategyInterface;

class SimpleRotateStrategy extends AbstractStrategy implements StrategyInterface
{
    public function __construct()
    {
    }

    public function getNextHost(): HostInstanceInterface
    {
        // TODO: Implement getNextHost() method.
    }

    private function getNext(): HostInstanceInterface
    {

    }

    private function getCurrentPostion()
    {
        $currentPostion = 'SOME_VALUE';
        //get data;
        return $currentPostion;
    }
}