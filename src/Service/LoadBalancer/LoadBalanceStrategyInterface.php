<?php

namespace App\Service\LoadBalancer;

use App\Component\HostInterface;
use App\Service\LoadBalancer;

interface LoadBalanceStrategyInterface
{
    public function provideLoadHost(LoadBalancer $loadBalancer): HostInterface;
}
