<?php declare(strict_types=1);

namespace LoadBalancer\Model\Api;

use LoadBalancer\Fake\Request;

interface HostInstanceInterface
{
    public function getUniqueId(): int;
    public function getLoad(): float;
    public function handleRequest(Request $request): void;
}